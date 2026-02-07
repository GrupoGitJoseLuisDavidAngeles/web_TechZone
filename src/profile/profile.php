<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de usuario</title>
    <link rel="stylesheet" href="./profile.css">
    <script type="module" src="profile.js"></script>
    <link rel="icon" type="image/png" href="/assets/logo_techzone.png">

</head>

<body>
    <header>
        <div></div>
        <a href="/public/index.php">
            <div class="tLogo"></div>
        </a>
        <a href="/cart/cart.php">Carrito</a>
    </header>

    <aside class="aside-left"></aside>

    <main>
        <h1 class="profile-title">Perfil de <span id="tTitleUsername">Pepito Pérez</span></h1>
        <img src="/assets/avatar.png" alt="Foto de perfil del usuario" class="profile-avatar">
        <div class="profile-data-card">
            <div>
                <p class="data-type">Nombre</p>
                <p class="data-element">Pepito Pérez</p>
            </div>
            <div>

                <p class="data-type">Email</p>
                <p class="data-element">peperez@mail.com</p>
            </div>
        </div>

        <button class="end-session">Cerrar sesión</button>
        <div class="profile-orders">
            <h2>Pedidos</h2>
            <div id="pedidosContainer" class="pedidos-container"></div>
        </div>
    </main>

    <aside class="aside-right"></aside>

    <footer>
        <nav>
            <ul class="listFooter">
                <li>Contacto</li>
                <li>Sobre nosotros</li>
                <li>Comunidad</li>
            </ul>
        </nav>
        <p class="pCopyright">© 2025 TechZone. Todos los derechos reservados.</p>
    </footer>

</body>

</html>
