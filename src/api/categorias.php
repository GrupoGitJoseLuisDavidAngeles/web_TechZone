<?php
require_once __DIR__ . '/../config/database.php';

$stmt = $pdo->query("
    SELECT
        id,
        nombre,
        descripcion
    FROM categorias
");

$categorias = $stmt->fetchAll();

header('Content-Type: application/json; charset=utf-8');
echo json_encode($categorias, JSON_UNESCAPED_UNICODE);

?>