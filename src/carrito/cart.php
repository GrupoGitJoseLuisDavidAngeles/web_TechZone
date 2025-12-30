<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="stylesheet" href="./cart.css">
</head>

<body>
    <header>
        <div class="tLogo"></div>

        <div class="divBusqueda">
            <input class="inputBusqueda" type="text" name="" id="" placeholder="Busque un producto">
            <span class="imagenLupa"></span>
        </div>

        <span>Iniciar sesión</span>
    </header>

    <aside class="asideLeft"></aside>

    <main>
        <div class="cart">
            <h1>Carrito de la compra</h1>
            <p id="productsQuantity">x <span>productos</span></p>

            <div class="productsContainer">

                <div class="product">
                    <div class="productImage1"></div>
    
                    <div class="productInformation">
                        <p>Teclado mecánico</p>
                        <p class="deliveryDay">Recíbelo del 6 al 9 de enero</p>
                        <button class="btnDelete">-</button>
                        <span class="productQuantity" id="itemQuantity">5</span>
                        <button class="btnAdd">+</button>
                        <a href="" class="deleteProduct">Eliminar producto</a>
                    </div>
                    <p class="price">50 €</p>
                </div>

                <div class="product">
                    <div class="productImage2"></div>
    
                    <div class="productInformation">
                        <p>Ratón gaming</p>
                        <p class="deliveryDay">Recibelo el 2 de enero</p>
                        <button class="btnDelete">-</button>
                        <span class="productQuantity" id="productQuantity">2</span>
                        <button class="btnAdd">+</button>
                        <a href="" class="deleteProduct">Eliminar producto</a>
                    </div>
                    <p class="price">25 €</p>
                </div>
                
                <div class="product">
                    <div class="productImage3"></div>
                    
                    <div class="productInformation">
                        <p>Monitor FHD</p>
                        <p class="deliveryDay">Recibelo mañana</p>
                        <button class="btnDelete">-</button>
                        <span class="productQuantity" id="productQuantity">1</span>
                        <button class="btnAdd">+</button>
                        <a href="" class="deleteProduct">Eliminar producto</a>
                    </div>
                    <p class="price">285 €</p>
                </div>      


                <div class="product">
                    <div class="productImage3"></div>
                    
                    <div class="productInformation">
                        <p>Monitor FHD</p>
                        <p class="deliveryDay">Recibelo mañana</p>
                        <button class="btnDelete">-</button>
                        <span class="productQuantity" id="productQuantity">1</span>
                        <button class="btnAdd">+</button>
                        <a href="" class="deleteProduct">Eliminar producto</a>
                    </div>
                    <p class="price">285 €</p>
                </div> 

            </div>
        </div>

        <div class="order">
            <h2>Resumen del pedido</h2>
            <div class="orderSummary">
                <p>Precio de los productos <span class="subtotal">1000€</span></p>
                <p>IVA <span class="iva">100€</span></p>
                <p>Gastos de envío</p>
            </div>
            <div class="total">
                <span class="totalLabel">
                    Total <span class="textIva">(IVA incluido)</span>
                </span>
                <span class="totalPrice" id="finallPrice">1100 €</span>
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