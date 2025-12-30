<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechZone</title>
    <link rel="stylesheet" href="./index.css">
    <script type="module" src="index.js"></script>
</head>

<body>
    <header>
        <div class="tLogo"></div>

        <div>
            <label for="">Categorías</label>
            <select name="" id="tSelectCategory" class="selectCategories">
                <option value="all" selected>Todas las categorías</option>
                <option value="Portátiles">Portátiles</option>
                <option value="Sobremesa">Sobremesa</option>
                <option value="Componentes">Componentes</option>
                <option value="Periféricos">Periféricos</option>
            </select>
        </div>

        <div class="divSearchBar">
            <input class="inputSearchBar" type="text" name="" id="" placeholder="Busque un producto">
            <span class="iconSearchBar"></span>
        </div>

        <a href="../auth/login.php">Iniciar sesión</a>
        <a href="../carrito/index.php">Carrito</a>
    </header>

    <aside class="aside-left"></aside>

    <main>
        <h1>Productos destacados</h1>
        <div id="tFeaturedProducts" class="featured-products">
        </div>

        <h1>Productos en oferta</h1>
        <div>
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