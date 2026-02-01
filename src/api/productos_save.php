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

if (!$payload || ($payload['rol'] ?? '') !== 'admin') {
    http_response_code(403);
    echo json_encode([
        'ok' => false,
        'message' => 'Permisos insuficientes'
    ]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$productoId  = isset($data['productoId']) ? (int)$data['productoId'] : null;
$nombre      = trim($data['nombre'] ?? '');
$precio      = $data['precio'] ?? null;
$descripcion = trim($data['descripcion'] ?? '');
$categoriaId = (int)($data['categoria'] ?? 0);

if ($nombre === '') {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'message' => 'El nombre no puede estar vacío'
    ]);
    exit;
}

if (!is_numeric($precio) || $precio <= 0) {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'message' => 'Precio inválido'
    ]);
    exit;
}

$imagenes = [
    1 => 'laptop.png',
    2 => 'desktop.png',
    3 => 'component.png',
    4 => 'peripheral.png'
];

if (!isset($imagenes[$categoriaId])) {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'message' => 'Categoría inválida'
    ]);
    exit;
}

$imagen = $imagenes[$categoriaId];

$stmt = $pdo->prepare("SELECT id FROM categorias WHERE id = ?");
$stmt->execute([$categoriaId]);

if (!$stmt->fetch()) {
    http_response_code(404);
    echo json_encode([
        'ok' => false,
        'message' => 'La categoría no existe'
    ]);
    exit;
}

if ($productoId) {

    $stmt = $pdo->prepare("SELECT id FROM productos WHERE id = ?");
    $stmt->execute([$productoId]);

    if (!$stmt->fetch()) {
        http_response_code(404);
        echo json_encode([
            'ok' => false,
            'message' => 'Producto no encontrado'
        ]);
        exit;
    }

    $stmt = $pdo->prepare("
        UPDATE productos
        SET nombre = ?, descripcion = ?, precio = ?, categoria_id = ?, imagen = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $nombre,
        $descripcion,
        $precio,
        $categoriaId,
        $imagen,
        $productoId
    ]);

    echo json_encode([
        'ok' => true,
        'message' => 'Producto actualizado correctamente'
    ]);
    exit;
}

$stmt = $pdo->prepare("
    INSERT INTO productos
    (nombre, descripcion, precio, stock, categoria_id, imagen)
    VALUES (?, ?, ?, 0, ?, ?)
");

$stmt->execute([
    $nombre,
    $descripcion,
    $precio,
    $categoriaId,
    $imagen
]);

echo json_encode([
    'ok' => true,
    'message' => 'Producto creado correctamente',
    'productoId' => $pdo->lastInsertId()
]);
?>