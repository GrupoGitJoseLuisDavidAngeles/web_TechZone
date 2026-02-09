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

if (($payload['rol'] ?? '') !== 'admin') {
    http_response_code(403);
    echo json_encode([
        'ok' => false,
        'message' => 'No tienes permisos para eliminar productos'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$productoId = (int)($data['productoId'] ?? 0);

if ($productoId <= 0) {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'message' => 'ID de producto inválido'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("SELECT id FROM productos WHERE id = ?");
    $stmt->execute([$productoId]);

    if (!$stmt->fetch()) {
        throw new Exception('El producto no existe');
    }

    $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->execute([$productoId]);

    $pdo->commit();

    echo json_encode([
        'ok' => true,
        'message' => 'Producto eliminado correctamente'
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    $pdo->rollBack();

    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'message' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>