<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechZone</title>
    <link rel="stylesheet" href="./index.css">
    <script type="module" src="index.js"></script>
    <link rel="icon" type="image/png" href="../assets/logo_techzone.png">

</head>

<body>
    <header>
        <a href="/public/index.php">
            <div class="tLogo">
            </div>
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

        <a href="../auth/login.php" id="tLnkLogin">Iniciar sesión</a>
        <a href="../cart/cart.php">Carrito</a>
    </header>

    <aside class="aside-left"></aside>

    <main>
        <h1><span id="tTitleOffers">Productos</span> en oferta</h1>
        <div id="tProductsOnOffer" class="featured-products">
            (Usando la base de datos)
        </div>

        <h1>Otros <span id="tTitleFeatured">productos</span></h1>
        <div id="tFeaturedProducts" class="featured-products">
            (Usando la base de datos)
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