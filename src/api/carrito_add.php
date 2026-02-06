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

$headers = getallheaders();

$headers = array_change_key_case(getallheaders(), CASE_LOWER);

if (!isset($headers['authorization'])) {
    http_response_code(401);
    echo json_encode([
        'ok' => false,
        'message' => 'Token no proporcionado'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$authHeader = $headers['authorization'];
$token = str_replace('Bearer ', '', $authHeader);

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
$productoId = (int)$data['productoId'] ?? null;

if (!$productoId || !is_numeric($productoId)) {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'message' => 'ID de producto inválido'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$stmt = $pdo->prepare("SELECT id, stock FROM productos WHERE id = ?");
$stmt->execute([$productoId]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$producto) {
    http_response_code(404);
    echo json_encode([
        'ok' => false,
        'message' => 'Producto no encontrado'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($producto['stock'] <= 0) {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'message' => 'Producto sin stock disponible'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$stmt = $pdo->prepare("SELECT id FROM carritos WHERE usuario_id = ?");
$stmt->execute([$usuarioId]);
$carrito = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$carrito) {
    $stmt = $pdo->prepare("INSERT INTO carritos (usuario_id) VALUES (?)");
    $stmt->execute([$usuarioId]);
    $carritoId = $pdo->lastInsertId();
} else {
    $carritoId = $carrito['id'];
}

$stmt = $pdo->prepare("
    SELECT id, cantidad 
    FROM carrito_productos 
    WHERE carrito_id = ? AND producto_id = ?
");
$stmt->execute([$carritoId, $productoId]);
$linea = $stmt->fetch(PDO::FETCH_ASSOC);

if ($linea) {
    $nuevaCantidad = $linea['cantidad'] + 1;
    if ($nuevaCantidad > $producto['stock']) {
        http_response_code(400);
        echo json_encode([
            'ok' => false,
            'message' => "No hay suficiente stock. Stock disponible: {$producto['stock']}"
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $stmt = $pdo->prepare("
        UPDATE carrito_productos 
        SET cantidad = cantidad + 1 
        WHERE id = ?
    ");
    $stmt->execute([$linea['id']]);
} else {
    $stmt = $pdo->prepare("
        INSERT INTO carrito_productos (carrito_id, producto_id, cantidad)
        VALUES (?, ?, 1)
    ");
    $stmt->execute([$carritoId, $productoId]);
}

echo json_encode([
    'ok' => true,
    'message' => 'Producto añadido al carrito'
], JSON_UNESCAPED_UNICODE);
?>