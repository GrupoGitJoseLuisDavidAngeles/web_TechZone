<?php
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json; charset=utf-8');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $stmt = $pdo->prepare("
        SELECT
            p.id,
            p.nombre,
            p.descripcion,
            p.precio,
            p.stock,
            p.imagen,
            c.id AS categoria_id,
            c.nombre AS categoria
        FROM productos p
        JOIN categorias c ON p.categoria_id = c.id
        WHERE p.id = ?
        LIMIT 1
    ");
    $stmt->execute([$_GET['id']]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        http_response_code(404);
        echo json_encode([
            'ok' => false,
            'message' => 'Producto no encontrado'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    echo json_encode([
        'ok' => true,
        'producto' => $producto
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if (isset($_GET['nombre']) && trim($_GET['nombre']) !== '') {

    $nombre = '%' . trim($_GET['nombre']) . '%';

    $stmt = $pdo->prepare("
        SELECT
            p.id,
            p.nombre,
            p.descripcion,
            p.precio,
            p.stock,
            p.imagen,
            c.id AS categoria_id,
            c.nombre AS categoria
        FROM productos p
        JOIN categorias c ON p.categoria_id = c.id
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