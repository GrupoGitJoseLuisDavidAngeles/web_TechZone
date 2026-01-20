<?php
require_once __DIR__ . '/../config/Database.php';

$pdo = Database::getInstance();
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