<?php
require_once __DIR__ . '/../config/database.php';

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['user'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    if ($usuario === '' || $email === '' || $password === '' || $confirmPassword === '') {
        $errores[] = 'Todos los campos son obligatorios';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'El email no es válido';
    } elseif (strlen($password) < 6) {
        $errores[] = 'La contraseña debe tener al menos 6 caracteres';
    } elseif ($password !== $confirmPassword) {
        $errores[] = 'Las contraseñas no coinciden';
    }

    if (empty($errores)) {
        $stmt = $pdo->prepare("SELECT email, nombre FROM usuarios WHERE email = ? OR nombre = ?");
        $stmt->execute([$email, $usuario]);
        $existente = $stmt->fetch();

        if ($existente) {
            if ($existente['email'] === $email) {
                $errores[] = 'El email ya está registrado';
            }
            if ($existente['nombre'] === $usuario) {
                $errores[] = 'El nombre de usuario ya está en uso';
            }
        }
    }

    if (empty($errores)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("
            INSERT INTO usuarios (nombre, email, password)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$usuario, $email, $hash]);

        header('Location: login.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="./register.css">
</head>

<body>
    <div class="tLogo"></div>
    <main>
        <h2>Registro</h2>
        <?php if (!empty($errores)): ?>
            <div class="errors">
                <?= htmlspecialchars($errores[0]) ?>
            </div>
        <?php endif; ?>

        <form method="post" class="registerForm">

            <label for="tUsuario">Usuario:</label>
            <input type="text" name="user" id="tUsuario" autocomplete="username">

            <label for="tEmail">Email:</label>
            <input type="text" name="email" id="tEmail" autocomplete="email">
        
            <label for="tPassword">Contraseña:</label>
            <input type="password" name="password" id="tPassword" autocomplete="new-password">
        
            <label for="tConfirmPassword">Confirmar contraseña:</label>
            <input type="password" name="confirmPassword" id="tConfirmPassword" autocomplete="new-password">
            
            <button type="submit">Registrarse</button>
        </form>
    </main>
</body>

</html>