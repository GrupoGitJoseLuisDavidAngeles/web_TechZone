<?php
require_once __DIR__ . '/../config/Database.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $pdo = Database::getInstance();

    $stmt = $pdo->query("
        SELECT
            id,
            nombre,
            descripcion
        FROM categorias
    ");

    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'ok' => true,
        'categorias' => $categorias
    ], JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'message' => 'Error al obtener las categorías'
    ], JSON_UNESCAPED_UNICODE);
}