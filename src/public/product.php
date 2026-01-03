<!-- desde indice la id por la url -->
<!-- http://localhost:8081/api/categoria.php?id=2 -->
<!-- productos individuales, ofertas, principal (mostrando algunos), barra de busqueda, panel de admin -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="stylesheet" href="./product.css">
</head>
<body>
    <header>
        <div class="tLogo"></div>

        <div class="divSearch">
            <input class="inputSearch" type="text" name="" id="" placeholder="Busque un producto">
            <span class="searchIcon"></span>
        </div>

        <span class="login">Iniciar sesión</span>
        <a href="../carrito/cart.php">Carrito</a>
    </header>

    <aside class="asideLeft"></aside>
    <!-- fecha fin -->
    <main>
        <div class="product">
            <div class="productImage"></div>
            <div class="productInformation">
                <h2 class="productName">Teclado mecánico</h2>
                <p class="category">categoria</p>
            </div>
            <div class="prices">
                <p class="oldPrice"><span class="oldAmount">40</span> €</p>
                <p class="newPrice"><span class="newAmount">30</span> €</p>
            </div>
        </div>
        <button class="btnAdd" type="submit">Añadir a la cesta</button>

        <details class="productDescription">
            <summary>Descripción del producto</summary>
            <p>
                Teclado mecánico con switches rojos, retroiluminación RGB y estructura de aluminio.
            </p>
        </details> 
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