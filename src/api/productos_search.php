<?php
require_once __DIR__ . '/../config/Database.php';

header('Content-Type: application/json; charset=utf-8');

$pdo = Database::getInstance();

$conditions = [];
$params = [];

if (isset($_GET['name']) && trim($_GET['name']) !== '') {
    $conditions[] = 'p.nombre LIKE ?';
    $params[] = '%' . trim($_GET['name']) . '%';
}

if (isset($_GET['category']) && is_numeric($_GET['category'])) {
    $conditions[] = 'p.categoria_id = ?';
    $params[] = (int)$_GET['category'];
}

if (empty($conditions)) {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'message' => 'Debes indicar al menos un filtro'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$sql = "
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
    WHERE " . implode(' AND ', $conditions);

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    'ok' => true,
    'productos' => $productos
], JSON_UNESCAPED_UNICODE);