<?php
require_once __DIR__ . '/../config/database.php';

session_start();
$mensajeExito = $_SESSION['success_message'] ?? null;
unset($_SESSION['success_message']);

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identificador = trim($_POST['identifier'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($identificador === '' || $password === '') {
        $errores[] = 'Todos los campos son obligatorios';
    } else {
        $stmt = $pdo->prepare("
            SELECT id, nombre, password
            FROM usuarios
            WHERE email = ? OR nombre = ?
            LIMIT 1
        ");
        $stmt->execute([$identificador, $identificador]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($password, $usuario['password'])) {
            session_regenerate_id(true);

            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];

            header('Location: ../public/index.php');
            exit;
        } else {
            $errores[] = 'Usuario o contraseña incorrectos';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <div class="tLogo"></div>
    <main>
        <h2> Inicio de sesión </h2>
        <?php if ($mensajeExito): ?>
            <div class="success">
                <?= htmlspecialchars($mensajeExito) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($errores)): ?>
            <div class="errors">
                <?= htmlspecialchars($errores[0]) ?>
            </div>
        <?php endif; ?>

        <form method="post" class="loginForm">
            <label for="tIdentifier">Identificador de usuario:</label>
            <input type="text" name="identifier" id="tIdentifier" autocomplete="username">
            <label for="tPassword">Contraseña: </label>
            <input type="password" name="password" id="tPassword" autocomplete="current-password">
            <button type="submit">Iniciar sesión</button>
            <label for="" class="register-link"><a href="register.php">Si no tienes cuenta, registrate</a></label>
        </form>

    </main>
</body>

</html>