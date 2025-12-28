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
            p.ruta_imagen,
            c.nombre AS categoria
        FROM productos p
        JOIN categorias c ON p.categoria_id = c.id
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
            p.ruta_imagen,
            c.nombre AS categoria
        FROM productos p
        JOIN categorias c ON p.categoria_id = c.id
    ");
}

$productos = $stmt->fetchAll();

header('Content-Type: application/json; charset=utf-8');
echo json_encode($productos);
?>