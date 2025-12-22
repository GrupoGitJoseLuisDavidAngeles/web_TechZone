<?php

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <style>
        body {
            margin: 0;
            height: 100dvh;
            display: grid;
            place-content: center;
            position: inherit;

            /* grid-template-columns: 1fr; */
        }
        
        main {
            display: grid;
            /* height: 100%; */
            h2{
                text-align: center;
            }
        }

        .loginform {
            width: 80%;
            align-self: center;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;

            label {
                text-align: left;
            }

            input{
                align-self: end;
                width: 150%;
            }
            button {
                justify-self: center;
                width: 90px;
            }
        }
    </style>
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