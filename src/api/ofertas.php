<?php
require_once __DIR__ . '/../config/database.php';

$stmt = $pdo->prepare("
    SELECT 
        p.id AS producto_id,
        p.nombre AS nombre,
        p.categoria_id,
        p.precio AS precio_original,
        o.precio_oferta AS precio_nuevo,
        o.fecha_inicio,
        o.fecha_fin
    FROM ofertas o
    JOIN productos p ON o.producto_id = p.id
    WHERE o.activa = 1
");

$stmt->execute();
$ofertas = $stmt->fetchAll();

header('Content-Type: application/json; charset=utf-8');
echo json_encode($ofertas, JSON_UNESCAPED_UNICODE);
?>