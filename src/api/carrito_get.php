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

$stmt = $pdo->prepare("SELECT id FROM carritos WHERE usuario_id = ?");
$stmt->execute([$usuarioId]);
$carrito = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$carrito) {
    echo json_encode([
        'ok' => true,
        'productos' => []
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$carritoId = $carrito['id'];

$stmt = $pdo->prepare("
    SELECT 
    cp.id AS lineaId,
    cp.cantidad,
    p.id AS productoId,
    p.nombre,
    p.precio,
    p.imagen,
    c.nombre AS categoria
    FROM carrito_productos cp
    JOIN productos p ON cp.producto_id = p.id
    JOIN categorias c ON p.categoria_id = c.id
    WHERE cp.carrito_id = ?
    ORDER BY cp.id ASC;
");
$stmt->execute([$carritoId]);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    'ok' => true,
    'productos' => $productos
], JSON_UNESCAPED_UNICODE);
?>
