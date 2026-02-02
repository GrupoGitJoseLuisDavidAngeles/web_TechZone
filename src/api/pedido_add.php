<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../libs/jwt.utils.php';

header('Content-Type: application/json; charset=utf-8');

$CLAVE_JWT = 'CLAVE_SECRETA';
$pdo = Database::getInstance();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'ok' => false,
        'message' => 'Método no permitido'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$headers = array_change_key_case(getallheaders(), CASE_LOWER);

if (!isset($headers['authorization'])) {
    http_response_code(401);
    echo json_encode([
        'ok' => false,
        'message' => 'Token no proporcionado'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$token = str_replace('Bearer ', '', $headers['authorization']);
$payload = validateJWT($token, $CLAVE_JWT);

if (!$payload) {
    http_response_code(401);
    echo json_encode([
        'ok' => false,
        'message' => 'Token inválido o expirado'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$usuarioId = $payload['sub'];

$data = json_decode(file_get_contents('php://input'), true);
$productos = $data['productos'] ?? null;

if (!is_array($productos) || empty($productos)) {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'message' => 'Lista de productos inválida'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$conteo = array_count_values($productos);

const IVA_PORCENTAJE = 0.21;
const GASTOS_ENVIO = 5;
const UMBRAL_ENVIO_GRATIS = 200;

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
        INSERT INTO pedidos (usuario_id, total)
        VALUES (?, 0)
    ");
    $stmt->execute([$usuarioId]);
    $pedidoId = $pdo->lastInsertId();

    $subtotal = 0;

    foreach ($conteo as $productoId => $cantidad) {

        if (!is_numeric($productoId) || $cantidad <= 0) {
            continue;
        }

        $stmt = $pdo->prepare("
        SELECT 
            p.precio AS precio_original,
            p.stock,
            p.nombre,
            o.precio_oferta
        FROM productos p
        LEFT JOIN ofertas o ON 
            o.producto_id = p.id
            AND o.activa = 1
            AND NOW() BETWEEN o.fecha_inicio AND o.fecha_fin
        WHERE p.id = ?
        ");
        
        $stmt->execute([$productoId]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$producto) {
            throw new Exception("El producto $productoId no existe");
        }

        if ($producto['stock'] < $cantidad) {
            throw new Exception("Stock insuficiente para el producto '{$producto['nombre']}'. Stock disponible: {$producto['stock']}, solicitado: {$cantidad}");
        }

        $precioUnitario = $producto['precio_oferta'] ?? $producto['precio_original'];
        $subtotalProducto = $precioUnitario * $cantidad;
        $subtotal += $subtotalProducto;

        $stmt = $pdo->prepare("
        INSERT INTO pedido_productos
        (pedido_id, producto_id, cantidad, precio_unitario)
        VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([
            $pedidoId,
            $productoId,
            $cantidad,
            $precioUnitario
        ]);

        $stmt = $pdo->prepare("
        UPDATE productos 
        SET stock = stock - ? 
        WHERE id = ?
        ");
        $stmt->execute([$cantidad, $productoId]);
    }

    $iva = $subtotal * IVA_PORCENTAJE;
    $subtotalConIva = $subtotal + $iva;

    $gastosEnvio = ($subtotalConIva < UMBRAL_ENVIO_GRATIS) ? GASTOS_ENVIO : 0;

    $total = $subtotalConIva + $gastosEnvio;

    $stmt = $pdo->prepare("
        UPDATE pedidos
        SET total = ?
        WHERE id = ?
    ");
    $stmt->execute([$total, $pedidoId]);

    $pdo->commit();

    echo json_encode([
        'ok' => true,
        'message' => 'Pedido creado correctamente',
        'pedidoId' => $pedidoId,
        'desglose' => [
            'subtotal' => round($subtotal, 2),
            'iva' => round($iva, 2),
            'subtotal_con_iva' => round($subtotalConIva, 2),
            'gastos_envio' => round($gastosEnvio, 2),
            'total' => round($total, 2)
        ]
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    $pdo->rollBack();

    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'message' => 'Error creando el pedido',
        'error' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
