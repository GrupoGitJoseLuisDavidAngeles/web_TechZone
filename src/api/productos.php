<?php
require_once __DIR__ . '/../config/database.php';

if (isset($_GET['categoria']) && is_numeric($_GET['categoria'])) {

    $stmt = $pdo->prepare("
        SELECT 
            p.id,
            p.nombre,
            p.descripcion,
            p.precio,
            p.stock,
            p.imagen,
            p.categoria_id
        FROM productos p
        WHERE p.categoria_id = ?
    ");

    $stmt->execute([$_GET['categoria']]);

} else {

    $stmt = $pdo->query("
        SELECT 
            p.id,
            p.nombre,
            p.descripcion,
            p.precio,
            p.stock,
            p.imagen,
            p.categoria_id
        FROM productos p
    ");
}

$productos = $stmt->fetchAll();

header('Content-Type: application/json; charset=utf-8');
echo json_encode($productos, JSON_UNESCAPED_UNICODE);
?>