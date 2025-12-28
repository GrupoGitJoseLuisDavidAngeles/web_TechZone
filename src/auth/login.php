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
    <header>
        <div class="logo"></div>

        <div>
            <label for="">Categorías</label>
            <select name="" id="" class="selectCategorias">
                <option value="">Portátiles</option>
                <option value="">Sobremesa</option>
                <option value="">Componentes</option>
                <option value="">Periféricos</option>
            </select>
        </div>

        <div class="divBusqueda">
            <input class="inputBusqueda" type="text" name="" id="" placeholder="Busque un producto">
            <span class="imagenLupa"></span>
        </div>

        <span>Iniciar sesión</span>
        <span>Carrito</span>
    </header>

    <aside class="asideIzquierdo"></aside>
    <aside class="asideDerecho"></aside>

    <main>
        <div class="container-form">

            <h2> Inicia sesión </h2>
            <form method="post" class="loginform">
                <label for="tEmail">Cuenta de correo:</label>
                <input type="email" name="email" id="tEmail">
                <label for="tPassword">Contraseña: </label>
                <input type="password" name="password" id="tPassword">
                <button type="submit">Iniciar sesión</button>
                <button type="button">Registrase</button>
            </form>
        </div>
    </main>
    <footer>
        <nav>
            <ul class="listaFooter">
                <li>Contacto</li>
                <li>Sobre nosotros</li>
                <li>Comunidad</li>
            </ul>
        </nav>
        <p class="pCopyright">Copyright</p>

</body>

</html>