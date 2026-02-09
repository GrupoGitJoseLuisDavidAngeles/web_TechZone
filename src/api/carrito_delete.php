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
$productoId = (int)($data['productoId'] ?? 0);

if ($productoId <= 0) {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'message' => 'ID de producto inválido'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

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
        SELECT id, cantidad
        FROM carrito_productos
        WHERE carrito_id = ? AND producto_id = ?
    ");
    $stmt->execute([$carritoId, $productoId]);
    $linea = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$linea) {
        throw new Exception('El producto no está en el carrito');
    }

    if ($linea['cantidad'] > 1) {
        $stmt = $pdo->prepare("
            UPDATE carrito_productos
            SET cantidad = cantidad - 1
            WHERE id = ?
        ");
        $stmt->execute([$linea['id']]);
    } else {
        $stmt = $pdo->prepare("
            DELETE FROM carrito_productos
            WHERE id = ?
        ");
        $stmt->execute([$linea['id']]);
    }

    $pdo->commit();

    echo json_encode([
        'ok' => true,
        'message' => 'Producto eliminado del carrito'
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(404);
    echo json_encode([
        'ok' => false,
        'message' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>