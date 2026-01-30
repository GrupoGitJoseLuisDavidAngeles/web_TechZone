<?php
require_once __DIR__ . '/../config/Database.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $pdo = Database::getInstance();

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
        WHERE o.activa = 1 AND NOW() BETWEEN o.fecha_inicio AND o.fecha_fin
    ");

    $stmt->execute();
    $ofertas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'ok' => true,
        'ofertas' => $ofertas
    ], JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'message' => 'Error al obtener las ofertas'
    ], JSON_UNESCAPED_UNICODE);
}
?>