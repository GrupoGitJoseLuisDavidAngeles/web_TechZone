import CarritoService from "../services/carrito.service.js";

setup();

async function setup() {
    const token = window.localStorage.getItem("token");

    if(token){
        const service = new CarritoService();
        const cartProducts = await service.getCart(token);

        fillFeaturedContainer(cartProducts);
        showNumberOfProducts();
        updateOrderSummary();
    }else{
        alert("Para realizar la compra debes iniciar sesión");
        window.location = "../auth/login.php";
        return;
    }

}

function fillFeaturedContainer(cartProducts){
    const nProductsContainer = document.querySelector(".productsContainer");

    cartProducts.forEach(product => {
        const nProduct = document.createElement("div");
        nProductsContainer.appendChild(nProduct);
        nProduct.setAttribute("class", `product`);

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
        nButtonDelete.addEventListener("click", () => {
            let quantity = parseInt(nQuantity.textContent);
            if(quantity > 1){
                nQuantity.textContent = quantity - 1;
                updateOrderSummary();
                showNumberOfProducts();
            }
        });

        const nQuantity = document.createElement("span");
        nControls.appendChild(nQuantity);
        nQuantity.setAttribute("class", "productQuantity");
        nQuantity.setAttribute("id", "itemQuantity");
        nQuantity.textContent = product.cantidad;

        const nButtonAdd = document.createElement("button");
        nControls.appendChild(nButtonAdd);
        nButtonAdd.setAttribute("class", "btnAdd");
        nButtonAdd.textContent = "+";
        nButtonAdd.addEventListener("click", () => {
            nQuantity.textContent = parseInt(nQuantity.textContent) + 1
            updateOrderSummary();
            showNumberOfProducts();
        });

        const nDeleteLink = document.createElement("a");
        nInformation.appendChild(nDeleteLink);
        nDeleteLink.setAttribute("class", "deleteProduct");
        nDeleteLink.setAttribute("href", "#");
        nDeleteLink.textContent = "Eliminar producto";
        nDeleteLink.addEventListener("click", (e) => {
            e.preventDefault();
            nProduct.remove();
            updateOrderSummary();
            showNumberOfProducts()
        });

        const nPrice = document.createElement("p");
        nProduct.appendChild(nPrice);
        nPrice.setAttribute("class", "price");
        
        const nAmount = document.createElement("span");
        nPrice.appendChild(nAmount);
        nAmount.setAttribute("class", "amount");
        nAmount.textContent = product.precio;
        nPrice.append(" €");
    });
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
    const texto = cantidad === 1 ? "producto" : "productos";

    document.querySelector("#productsQuantity").textContent = 
        `${cantidad} ${texto}`;
}
