<?php
require_once __DIR__ . '/../config/database.php';

session_start();
$mensajeExito = $_SESSION['success_message'] ?? null;
unset($_SESSION['success_message']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="login.css">
    <script type="module" src="./login.js"></script>
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

        <div id="tDivErrors"></div>

        <form class="loginForm">
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