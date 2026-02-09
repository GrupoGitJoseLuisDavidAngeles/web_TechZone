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

$stmt = $pdo->prepare("SELECT id FROM carritos WHERE usuario_id = ?");
$stmt->execute([$usuarioId]);
$carrito = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$carrito) {
    http_response_code(404);
    echo json_encode([
        'ok' => false,
        'message' => 'Carrito no encontrado'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$carritoId = $carrito['id'];

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
        DELETE FROM carrito_productos
        WHERE carrito_id = ?
    ");
    $stmt->execute([$carritoId]);

    $pdo->commit();

    echo json_encode([
        'ok' => true,
        'message' => 'Carrito vaciado correctamente'
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'message' => 'Error al vaciar el carrito'
    ], JSON_UNESCAPED_UNICODE);
}
?>