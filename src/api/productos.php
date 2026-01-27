<?php
require_once __DIR__ . '/../config/Database.php';

header('Content-Type: application/json; charset=utf-8');

$pdo = Database::getInstance();

if (isset($_GET['id'])) {

    if (!is_numeric($_GET['id'])) {
        http_response_code(400);
        echo json_encode([
            'ok' => false,
            'message' => 'ID de producto inválido'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $stmt = $pdo->prepare("
        SELECT 
            id,
            nombre,
            descripcion,
            precio,
            stock,
            imagen,
            categoria_id
        FROM productos
        WHERE id = ?
    ");

    $stmt->execute([$_GET['id']]);
    $producto = $stmt->fetch();

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

$stmt = $pdo->query("
    SELECT 
        id,
        nombre,
        descripcion,
        precio,
        stock,
        imagen,
        categoria_id
    FROM productos
");

$productos = $stmt->fetchAll();

echo json_encode([
    'ok' => true,
    'productos' => $productos
], JSON_UNESCAPED_UNICODE);
?>