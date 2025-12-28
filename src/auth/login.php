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
        <h2> Inicia sesión </h2>
        <form method="post" class="loginform">
            <label for="tEmail">Cuenta de correo:</label>
            <input type="email" name="email" id="tEmail">
            <label for="tPassword">Contraseña: </label>
            <input type="password" name="password" id="tPassword">
            <button type="submit">Inicia sesión</button>
            <button type="button">Registrase</button>
        </form>
    </main>
</body>

</html>