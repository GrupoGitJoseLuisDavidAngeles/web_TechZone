<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../libs/jwt.utils.php';

header('Content-Type: application/json; charset=utf-8');

$CLAVE_JWT = 'CLAVE_SECRETA';
$pdo = Database::getInstance();

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode([
        'ok' => false,
        'message' => 'Método no permitido'
    ]);
    exit;
}

$headers = array_change_key_case(getallheaders(), CASE_LOWER);

if (!isset($headers['authorization'])) {
    http_response_code(401);
    echo json_encode([
        'ok' => false,
        'message' => 'Token no proporcionado'
    ]);
    exit;
}

$token = str_replace('Bearer ', '', $headers['authorization']);
$payload = validateJWT($token, $CLAVE_JWT);

if (!$payload) {
    http_response_code(401);
    echo json_encode([
        'ok' => false,
        'message' => 'Token inválido o expirado'
    ]);
    exit;
}

$usuarioId = $payload['sub'];

$stmt = $pdo->prepare("
    SELECT id, total
    FROM pedidos
    WHERE usuario_id = ?
    ORDER BY id DESC
");

$stmt->execute([$usuarioId]);

$pedidosDB = $stmt->fetchAll();

$pedidos = [];

foreach ($pedidosDB as $pedido) {

    $stmt = $pdo->prepare("
        SELECT 
            p.nombre,
            pp.precio_unitario AS precio,
            pp.cantidad
        FROM pedido_productos pp
        JOIN productos p ON p.id = pp.producto_id
        WHERE pp.pedido_id = ?
    ");

    $stmt->execute([$pedido['id']]);

    $productos = $stmt->fetchAll();

    $cantidadTotal = 0;

    foreach ($productos as $prod) {
        $cantidadTotal += $prod['cantidad'];
    }

    $pedidos[] = [
        'id' => $pedido['id'],
        'total' => $pedido['total'],
        'cantidad_productos' => $cantidadTotal,
        'productos' => $productos
    ];
}

echo json_encode([
    'ok' => true,
    'pedidos' => $pedidos
], JSON_UNESCAPED_UNICODE);
?>