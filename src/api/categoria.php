<?php
require_once __DIR__ . '/../config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID de categoría inválido'], JSON_UNESCAPED_UNICODE);
    exit;
}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("
    SELECT id, nombre, descripcion
    FROM categorias
    WHERE id = ?
");

$stmt->execute([$id]);
$categoria = $stmt->fetch();

if (!$categoria) {
    http_response_code(404);
    echo json_encode(['error' => 'Categoría no encontrada'], JSON_UNESCAPED_UNICODE);
    exit;
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($categoria, JSON_UNESCAPED_UNICODE);
?>