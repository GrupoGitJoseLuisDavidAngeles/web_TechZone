<?php
require_once __DIR__ . '/../config/Database.php';

header('Content-Type: application/json; charset=utf-8');

$pdo = Database::getInstance();

if (isset($_GET['nombre']) && trim($_GET['nombre']) !== '') {

    $nombre = '%' . trim($_GET['nombre']) . '%';

    $stmt = $pdo->prepare("
        SELECT
            p.id,
            p.nombre,
            p.descripcion,
            p.precio,
            p.imagen,
        FROM productos p
        WHERE p.nombre LIKE ?
    ");

    $stmt->execute([$nombre]);

    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'ok' => true,
        'productos' => $productos
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

http_response_code(400);

echo json_encode([
    'ok' => false,
    'message' => 'Parámetros insuficientes'
], JSON_UNESCAPED_UNICODE);
?>