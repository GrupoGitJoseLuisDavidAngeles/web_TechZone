<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="./register.css">
</head>

<body>
    <main>
        <h2>Registro</h2>

        <form method="post" class="registerForm">

            <label for="tUsuario">Usuario:</label>
            <input type="text" name="text" id="tUsuario">


            <label for="tEmail">Email:</label>
            <input type="email" name="email" id="tEmail">
        
            <label for="tPassword">Contraseña:</label>
            <input type="password" name="password" id="tPassword">
        
            <label for="tConfirmPassword">Confirmar contraseña:</label>
            <input type="password" name="confirmPassword" id="tConfirmPassword">
            
            <button type="submit">Registrarse</button>
        </form>
    </main>
</body>

</html>