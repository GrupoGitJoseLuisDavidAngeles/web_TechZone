<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechZone</title>
    <link rel="stylesheet" href="./profile.css">
    <script type="module" src="profile.js"></script>
    <link rel="icon" type="image/png" href="./images/favicon.png">

</head>

<body>
    <header>
        <div class="tLogo"></div>
        <a href="../auth/login.php">Iniciar sesión</a>
        <a href="../carrito/index.php">Carrito</a>
    </header>

    <aside class="aside-left"></aside>

    <main>
        <h1 class="profile-title">Perfil de <span id="tTitleUsername">Pepito Pérez</span></h1>
        <img src="./images/avatar.png" alt="Foto de perfil del usuario" class="profile-avatar">
        <div class="profile-data-card">
            <div>
                <p class="data-type">Nombre</p>
                <p class="data-element">Pepito Pérez</p>
            </div>
            <div>

                <p class="data-type">Email</p>
                <p class="data-element">peperez@mail.com</p>
            </div>
            <button type="button">Editar perfil</button>
        </div>

        <!-- Resumen rápido -->
        <button class="end-session">Cerrar sesión</button>
        <div class="profile-orders">
            <h2>Pedidos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Cantidad de items</th>
                        <th>Precio</th>
                        <th>Items</th>
                    </tr>
                </thead>
                <tbody id="tTablePedidos"></tbody>
            </table>
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