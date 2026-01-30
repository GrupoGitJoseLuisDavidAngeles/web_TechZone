<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="stylesheet" href="./cart.css">
    <script type="module" src="./cart.js"></script>
    <link rel="icon" type="image/png" href="../assets/logo_techzone.png">
</head>

<body>
    <header>
        <a href="../public/index.php">
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

        <span class="../auth/login.php" id="tLnkLogin">Iniciar sesión</span>
        <a href="../carrito/cart.php">Carrito</a>
    </header>

    <aside class="asideLeft"></aside>

    <main>
        <div class="cart">
            <h1>Carrito de la compra</h1>

            <p id="productsQuantity">x</p>

            <div id="freeShippingAlert" class="freeShippingNotice">
                ¡Felicidades! Tu compra supera los 200€, los gastos de envío son gratis.
            </div>

            <div class="productsContainer">
            </div>

        <div class="order">
            <h2>Resumen del pedido</h2>
            <div class="orderSummary">
                <p>Precio de los productos 
                    <span class="subtotal"><span class="amount"></span></span>
                </p>
                <p>IVA 
                    <span class="iva"><span class="amount"></span></span>
                </p>
                <p>Gastos de envío
                    <span class="shippingCosts"><span class="amountDiscount"></span></span>
                </p>
            </div>
            <div class="total">
                <span class="totalLabel">
                    Total <span class="textIva">(IVA incluido)</span>
                </span>
                <span class="totalPrice" id="finalPrice"></span>
            </div>
            <button class="btnComprar">Finalizar compra</button> 
        </div>
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