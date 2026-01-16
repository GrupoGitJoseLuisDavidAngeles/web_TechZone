<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechZone</title>
    <link rel="stylesheet" href="./index.css">
    <script type="module" src="index.js"></script>
    <link rel="icon" type="image/png" href="./images/favicon.png">

</head>

<body>
    <header>
        <div class="tLogo"></div>



        <!-- <a href="../auth/login.php">Iniciar sesión</a>
        <a href="../carrito/index.php">Carrito</a> -->
    </header>

    <aside class="aside-left"></aside>

    <main>
        <h1>Perfil de <span id="tTitleUsername">Pepito Pérez</span></h1>
        <div class="profile-data-card">
            <img src="./images/avatar.jpg" alt="Foto de perfil del usuario" class="profile-avatar">
            <p class="data-type">Nombre</p>
            <p class="data-element">Pepito Pérez</p>
            <p class="data-type">Email</p>
            <p class="data-element">peperez@mail.com</p>  
            <button type="button">Editar perfil</button>
        </div>

        <!-- Resumen rápido -->
        <section class="profile-summary">
            <article>
                <h2>Pedidos</h2>
                <p>12 realizados</p>
            </article>
            <article>
                <h2>Direcciones</h2>
                <p>3 guardadas</p>
            </article>
            <article>
                <h2>Métodos de pago</h2>
                <p>2 registrados</p>
            </article>
        </section>

        <section class="profile-orders">
            <h2>Mis pedidos recientes</h2>
            <ul>
                <li>
                    <span>#12345</span>
                    <span>Entregado</span>
                    <span>$49.99</span>
                </li>
                <li>
                    <span>#12312</span>
                    <span>En camino</span>
                    <span>$89.50</span>
                </li>
            </ul>
        </section>

       <button>Cerrar sesión</button>

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