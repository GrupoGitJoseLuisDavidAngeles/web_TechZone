import productosService from "../services/productos.service.js";
setup();

async function setup() {
    const service = new productosService();
    const products = await service.getProducts();
    fillFeaturedContainer(products);
    updateOrderSummary();
}

const categoryMap = {
    1: "Portátiles",
    2: "PC de escritorio",
    3: "Componentes",
    4: "Periféricos"
};

function fillFeaturedContainer(products) {
    const nContainer = document.querySelector('.productsContainer');
    nContainer.innerHTML = ''; 

    products.forEach(product => {
        const nProduct = document.createElement('div');
        nContainer.appendChild(nProduct);
        nProduct.classList.add('product');

        const nImage = document.createElement('div');
        nProduct.appendChild(nImage);
        nImage.classList.add('productImage'); 
        nImage.style.backgroundImage = `url('http://localhost:8081/assets/${product.imagen}')`;
        nImage.style.backgroundPositionX = "center";

        const nInfo = document.createElement('div');
        nProduct.appendChild(nInfo);
        nInfo.classList.add('productInformation');

        const nName = document.createElement('p');
        nInfo.appendChild(nName);
        nName.classList.add('productName');
        nName.textContent = product.nombre;

        const nCategory = document.createElement('p');
        nInfo.appendChild(nCategory);
        nCategory.classList.add('category');
        nCategory.textContent = categoryMap[product.categoria_id] || "Sin categoría";

        const nDelivery = document.createElement('p');
        nInfo.appendChild(nDelivery);
        nDelivery.classList.add('deliveryDay');
        nDelivery.textContent = "Recíbelo pronto";

        const nQuantityDiv = document.createElement('div');
        nInfo.appendChild(nQuantityDiv);
        nQuantityDiv.classList.add('quantityControls');

        const btnDelete = document.createElement('button');
        nQuantityDiv.appendChild(btnDelete);
        btnDelete.classList.add('btnDelete');
        btnDelete.textContent = "-";

        const nQuantity = document.createElement('span');
        nQuantity.classList.add('productQuantity');
        nQuantity.textContent = "1";
        nQuantityDiv.appendChild(nQuantity);

        const btnAdd = document.createElement('button');
        nQuantityDiv.appendChild(btnAdd);
        btnAdd.classList.add('btnAdd');
        btnAdd.textContent = "+";

        const nDeleteLink = document.createElement('a');
        nInfo.appendChild(nDeleteLink);
        nDeleteLink.classList.add('deleteProduct');
        nDeleteLink.href = "#";
        nDeleteLink.textContent = "Eliminar producto";

        const nPrice = document.createElement('p');
        nProduct.appendChild(nPrice);
        nPrice.classList.add('price');

        const nAmount = document.createElement("span");
        nPrice.appendChild(nAmount);
        nAmount.classList.add("amount");
        nAmount.textContent = product.precio;
        nPrice.append(" €");
    });

    nContainer.addEventListener('click', (e) => {
        const target = e.target;

        if (target.classList.contains('btnAdd')) {
            const quantityEl = target.parentElement.querySelector('.productQuantity');
            quantityEl.textContent = parseInt(quantityEl.textContent) + 1;
            updateOrderSummary();
        }

        if (target.classList.contains('btnDelete')) {
            const quantityEl = target.parentElement.querySelector('.productQuantity');
            let qty = parseInt(quantityEl.textContent);
            if (qty > 1) {
                quantityEl.textContent = qty - 1;
                updateOrderSummary();
            }
        }

        if (target.classList.contains('deleteProduct')) {
            e.preventDefault();
            target.closest('.product').remove();
            updateOrderSummary();
        }
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
    const total = subtotal + iva;

    document.querySelector('.subtotal .amount').textContent = subtotal.toFixed(2);
    document.querySelector('.iva .amount').textContent = iva.toFixed(2);
    document.querySelector('#finalPrice').textContent = total.toFixed(2) + " €";
}
