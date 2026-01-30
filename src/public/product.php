<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="stylesheet" href="./product.css">
    <script type="module" src="./product.js"></script>
</head>
<body>
    <header>
        <a href="/public/index.php" class="tAIndex">
            <div class="tLogo"></div>
        </a>

        <div>
            <label for="">Categorías</label>
            <select name="" id="tSelectCategory" class="selectCategories">
                <option value="all" selected>Todas las categorías</option>
            </select>
        </div>


        <div class="divSearchBar">
            <input class="inputSearchBar" type="text" name="" id="tInputSearch" placeholder="Buscar...">
            <span class="iconSearchBar" id="tSpnSearch"></span>
        </div>

        <span class="../auth/login.php" id="tLnkLogin">Iniciar sesión</span>
        <a href="../carrito/cart.php">Carrito</a>
    </header>

    <aside class="asideLeft"></aside>

    <main id="mainContainer">
    </main>

    <aside class="asideRight"></aside>

    <footer>
        <nav>
            <ul class="listaFooter">
                <li>Contacto</li>
                <li>Sobre nosotros</li>
                <li>Comunidad</li>
            </ul>
        </nav>
        <p class="pCopyright">© 2025 TechZone. Todos los derechos reservados.</p>
    </footer>

</body>
</html>