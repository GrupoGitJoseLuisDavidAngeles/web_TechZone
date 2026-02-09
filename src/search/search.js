import { fillCategorySelect, redirectToSearchPage } from "../libs/search.utils.js";
import { checkTokenAndChangeLoginButton } from "../libs/token.utils.js";
import productosService from "../services/productos.service.js";

setup();

async function setup() {
    const token = window.localStorage.getItem('token');
    await checkTokenAndChangeLoginButton(token);
    
    fillCategorySelect();

    const searchBtn = document.querySelector("#tSpnSearch");
    searchBtn.addEventListener("click", redirectToSearchPage);

    const params = new URLSearchParams(window.location.search);
    
    const name = params.get('name') ?? "";
    const category = params.get('category') ?? "";

    const service = new productosService();
    const products = await service.searchProducts(name, category);
    const offers = await service.getOffers();

    setupCategorySelect(category);
    await loadFoundProducts(products, offers);
}

function redirectToProductPage(event) {
    const productId = event.currentTarget.dataset.id;
    window.location = `/products/product.php?id=${productId}`;
}

function setupCategorySelect(categoryId) {
    if (categoryId == "") return;
    const categorySelect = document.querySelector("#tSelectCategory");
    categorySelect.value = categoryId;
}

async function loadFoundProducts(products, offers) {
    const productsContainer = document.querySelector("#tDivProductContainer");
    productsContainer.innerHTML = "";

    products.forEach(product => {
        let productCard = document.createElement("div");
        productCard.classList.add("product-card");
        productCard.setAttribute("data-id", product.id);
        productCard.addEventListener("click", redirectToProductPage);
        productsContainer.appendChild(productCard);

        let productImage = document.createElement("img");
        productImage.setAttribute("src", `/assets/${product.imagen}`);
        productImage.classList.add("product-image");
        productCard.appendChild(productImage);

        let productName = document.createElement("p");
        productName.textContent = product.nombre;
        productName.classList.add("product-name");
        productCard.appendChild(productName);

        let divPrice = document.createElement("div");
        divPrice.classList.add("product-price");
        productCard.appendChild(divPrice);

        const offer = offers.find(offer => offer.producto_id === product.id);

        if (offer) {
            let oldPrice = document.createElement("p");
            oldPrice.textContent = offer.precio_original + " €";
            oldPrice.classList.add("price-old");
            divPrice.appendChild(oldPrice);

            let newPrice = document.createElement("p");
            newPrice.textContent = offer.precio_nuevo + " €";
            newPrice.classList.add("price-new");
            divPrice.appendChild(newPrice);
        } else {
            let price = document.createElement("p");
            price.textContent = product.precio + " €";
            price.classList.add("price-new");
            divPrice.appendChild(price);
        }
        let productDescription = document.createElement("p");
        productDescription.textContent = product.descripcion;
        productDescription.classList.add("product-description");
        productCard.appendChild(productDescription);
    });
}