<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../libs/jwt.utils.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'ok' => false,
        'message' => 'Método no permitido'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$identifier = trim($data['identifier'] ?? '');
$password   = $data['password'] ?? '';

if ($identifier === '' || $password === '') {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'message' => 'Todos los campos son obligatorios'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$stmt = $pdo->prepare("
    SELECT id, nombre, password, rol
    FROM usuarios
    WHERE email = ? OR nombre = ?
    LIMIT 1
");

$stmt->execute([$identifier, $identifier]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario || !password_verify($password, $usuario['password'])) {
    http_response_code(401);
    echo json_encode([
        'ok' => false,
        'message' => 'Usuario o contraseña incorrectos'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$clave = 'CLAVE_SECRETA';
$payload = [
    'sub' => $usuario['id'],
    'nombre' => $usuario['nombre'],
    'rol' => $usuario['rol'],
    'iat' => time(),
    'exp' => time() + 3600 * 2
];

$jwt = generateJWT($payload, $clave);

echo json_encode([
    'ok' => true,
    'token' => $jwt
]);
?>