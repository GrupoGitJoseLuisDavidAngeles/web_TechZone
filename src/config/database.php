<?php
$host = 'mysql';
$db   = 'tienda_online';
$user = 'admin';
$pass = 'admin';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Error en la conexión con la base de datos: " . $e->getMessage());
}
?>