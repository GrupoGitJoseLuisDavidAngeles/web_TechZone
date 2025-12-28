<?php

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
    <main>
            <h2> Inicio de sesión </h2>
            <form method="post" class="loginForm">
                <label for="tEmail">Identificador de usuario:</label>
                <input type="email" name="email" id="tEmail">
                <label for="tPassword">Contraseña: </label>
                <input type="password" name="password" id="tPassword">
                <button type="submit">Iniciar sesión</button>
                <label for="" class="register-link"><a href="register.php">Si no tienes cuenta, registrate</a></label>
                <!-- <button type="button"></button> -->
            </form>

    </main>
</body>

</html>