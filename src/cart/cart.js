import CarritoService from "../services/carrito.service.js";
import PedidosService from "../services/pedidos.service.js";
import productosService from "../services/productos.service.js";
import { checkTokenAndChangeLoginButton } from "../libs/token.utils.js";
import { redirectToSearchPage, fillCategorySelect } from "../libs/search.utils.js";

setup();

async function setup() {
    const token = window.localStorage.getItem("token");
    await checkTokenAndChangeLoginButton(token);

    fillCategorySelect();
    
    const searchBtn = document.querySelector("#tSpnSearch");
    searchBtn.addEventListener("click", redirectToSearchPage);

    if(token){
        const service = new CarritoService();
        const productService = new productosService();

        const cartProducts = await service.getCart(token);
        const offers = await productService.getOffers();

        fillFeaturedContainer(cartProducts, offers);
        showNumberOfProducts();
        updateOrderSummary();
    }else{
        alert("Para realizar la compra debes iniciar sesión");
        window.location = "../auth/login.php";
        return;
    }

    const orderBtn = document.querySelector("#tBtnComprar");
    orderBtn.addEventListener("click", addOrder);
}

async function addOrder() {
    const products = document.querySelectorAll('.product');
    const token = window.localStorage.getItem("token");
    const pedidoService = new PedidosService();
    const carritoService = new CarritoService();
    const productsIds = [];

    if (products.length === 0) {
        alert("El carrito está vacío. No se puede realizar el pedido.");
        return;
    }

    products.forEach(product => {
        let cantidad = product.dataset.productCantidad;
        let id = product.dataset.productId;

        for (let i = 0; i < cantidad; i++) {
            productsIds.push(id);
        }
    });

    try {
        await pedidoService.addPedido(productsIds, token);
        await carritoService.clearCart(token);
        alert("Pedido realizado con éxito.");
        window.location = "/cart/cart.php";
    } catch (error) {
        alert("Error al realizar el pedido: " + error.message);
    }
}

function fillFeaturedContainer(cartProducts, offers){
    const nProductsContainer = document.querySelector(".productsContainer");

    cartProducts.forEach(product => {
        const nProduct = document.createElement("div");
        nProductsContainer.appendChild(nProduct);
        nProduct.setAttribute("class", `product`);
        nProduct.setAttribute("data-product-id", product.productoId);
        nProduct.setAttribute("data-product-cantidad", product.cantidad);

        const nImage = document.createElement("div");
        nProduct.appendChild(nImage);
        nImage.setAttribute("class", "productImage");
        nImage.style.backgroundImage = `url('../assets/${product.imagen}')`;
        nImage.style.backgroundPositionX = "center";

        const nInformation = document.createElement("div");
        nProduct.appendChild(nInformation);
        nInformation.setAttribute("class", "productInformation");

        const nName = document.createElement("p");
        nInformation.appendChild(nName);
        nName.setAttribute("class", "productName");
        nName.textContent = product.nombre;

        const nCategory = document.createElement("p");
        nInformation.appendChild(nCategory);
        nCategory.setAttribute("class", "category");
        nCategory.textContent = product.categoria;

        const nDelivery = document.createElement("p");
        nInformation.appendChild(nDelivery);
        nDelivery.setAttribute("class", "deliveryDay");
        nDelivery.textContent = "Recíbelo pronto";

        const nControls = document.createElement("div");
        nInformation.appendChild(nControls);
        nControls.setAttribute("class", "quantityControls");

        const nButtonDelete = document.createElement("button");
        nControls.appendChild(nButtonDelete);
        nButtonDelete.setAttribute("class", "btnDelete");
        nButtonDelete.textContent = "-";
        nButtonDelete.addEventListener("click", deleteFromCart);
        
        const nQuantity = document.createElement("span");
        nControls.appendChild(nQuantity);
        nQuantity.setAttribute("class", "productQuantity");
        nQuantity.setAttribute("id", "itemQuantity");
        nQuantity.textContent = product.cantidad;

        const nButtonAdd = document.createElement("button");
        nControls.appendChild(nButtonAdd);
        nButtonAdd.setAttribute("class", "btnAdd");
        nButtonAdd.textContent = "+";
        nButtonAdd.addEventListener("click", addToCart);

        const nPrice = document.createElement("div");
        nProduct.appendChild(nPrice);
        nPrice.setAttribute("class", "price");
        
        const offer = offers.find(offer => offer.producto_id === product.productoId);

        if (offer) {
            let nAmount = document.createElement("span");
            nPrice.appendChild(nAmount);
            nAmount.setAttribute("class", "old-amount");
            nAmount.textContent = offer.precio_original;

            nAmount = document.createElement("span");
            nPrice.appendChild(nAmount);
            nAmount.setAttribute("class", "amount");
            nAmount.textContent = offer.precio_nuevo + " €";
        } else {
            let nAmount = document.createElement("span");
            nPrice.appendChild(nAmount);
            nAmount.setAttribute("class", "amount");
            nAmount.textContent = product.precio + " €";
        }

    });
}

async function deleteFromCart(e) {
    const token = window.localStorage.getItem("token");
    const productElement = e.target.closest(".product");
    const productId = productElement.getAttribute("data-product-id");

    console.log(`Eliminar producto con ID: ${productId}`);
    const service = new CarritoService();

    try {
        await service.deleteFromCart(productId, token);
        window.location = "/cart/cart.php";
    } catch (error) {
        console.error("Error al eliminar el producto del carrito:", error);
    }
}

async function addToCart(e) {
    const token = window.localStorage.getItem("token");
    const productElement = e.target.closest(".product");
    const productId = productElement.getAttribute("data-product-id");

    console.log(`Añadir producto con ID: ${productId}`);
    const service = new CarritoService();

    try {
        await service.addToCart(productId, token);
        window.location = "/cart/cart.php";
    } catch (error) {
        console.error("Error al añadir el producto al carrito:", error);
    }
}

function updateOrderSummary() {
    const products = document.querySelectorAll('.product');
    let subtotal = 0;

    products.forEach(product => {
        const price = parseFloat(product.querySelector('.price .amount').textContent);
        const quantity = parseInt(product.querySelector('.productQuantity').textContent);
        subtotal += price * quantity;
    });

    const iva = subtotal * 0.21; 
    let shipping = 0;

    const nCartAlert = document.querySelector("#freeShippingAlert");

    if (subtotal > 0 && subtotal < 200) {
        shipping = 5; 
        nCartAlert.style.display = "none"; 
    } else if (subtotal >= 200) {
        shipping = 0; 
        nCartAlert.style.display = "block";
    } else {
        shipping = 0;
        nCartAlert.style.display = "none";
    }

    const total = subtotal + iva + shipping;

    document.querySelector('.subtotal .amount').textContent = subtotal.toFixed(2) + " €";
    document.querySelector('.iva .amount').textContent = iva.toFixed(2) + " €";
    document.querySelector('.shippingCosts .amountDiscount').textContent = shipping.toFixed(2) + " €";
    document.querySelector('#finalPrice').textContent = total.toFixed(2) + " €";
}

function showNumberOfProducts(){
    const products = document.querySelectorAll(".product");
    const cantidad = products.length;
    const texto = cantidad === 1 ? "tipo de producto" : "tipos de productos";

    document.querySelector("#productsQuantity").textContent = 
        `${cantidad} ${texto}`;
}
