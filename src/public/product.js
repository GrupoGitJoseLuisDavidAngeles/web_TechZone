import CarritoService from "../services/carrito.service.js";
import productosService from "../services/productos.service.js";

setup();

async function setup() {
    const service = new productosService();

    const products = await service.getProducts();
    const categories = await service.getCategories();
    const offerts = await service.getOffers();

    const productId = getIdFromUrl();
    if (!productId) return;

    fillProductWithData(products, offerts, categories, productId);
}

function getIdFromUrl() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get("id");
}

function getToken(){
    return window.localStorage.getItem("token");
}

/**
 * Devuelve la oferta de un producto si existe, o null si no.
 * @param {Object} product 
 * @param {Array} offerts 
 * @returns {Object|null}
 */
function obtenerOferta(product, offerts) {
    const oferta = offerts.find(o => o.producto_id == product.id);
    if (!oferta) return null;

    return {
        precioOriginal: parseFloat(oferta.precio_original),
        precioNuevo: parseFloat(oferta.precio_nuevo),
        fechaFin: oferta.fecha_fin
    };
}

async function addProductToCartHandler(event){
    const token = getToken();
    const id=getIdFromUrl();

    const service = new CarritoService();
    await service.addToCart(id, token);
}


function fillProductWithData(products, offerts, categories, productId) {
    const product = products.find(p => p.id == productId);
    const nMain = document.querySelector("#mainContainer");

    if (!product) {
        const mensaje = document.createElement("p");
        mensaje.textContent = "Producto no encontrado";
        nMain.appendChild(mensaje);
        return;
    }

    const oferta = obtenerOferta(product, offerts); 
    
    const nDivProduct = document.createElement("div");
    nDivProduct.setAttribute("class", "product");
    nDivProduct.setAttribute("id", "productContainer");
    nMain.appendChild(nDivProduct);

    
    const nDivImage = document.createElement("div");
    nDivImage.setAttribute("class", "productImage");
    nDivImage.setAttribute("id", "productImageContainer");
    nDivProduct.appendChild(nDivImage);

    const img = document.createElement("img");
    img.setAttribute("src", `../assets/${product.imagen}`);
    img.setAttribute("alt", product.nombre);
    img.style.width = "95%";
    img.style.height = "auto";
    nDivImage.appendChild(img);


    const nDivInfo = document.createElement("div");
    nDivInfo.setAttribute("class", "productInformation");
    nDivInfo.setAttribute("id", "productInformationContainer");
    nDivProduct.appendChild(nDivInfo);

    const nTitle = document.createElement("h2");
    nTitle.setAttribute("class", "productName");
    nTitle.setAttribute("id", "productTitle");
    nTitle.textContent = product.nombre;
    nDivInfo.appendChild(nTitle);

    const nCategory = document.createElement("p");
    nCategory.setAttribute("class", "category");
    nCategory.setAttribute("id", "productCategory");
    const category = categories.find(c => c.id === product.categoria_id);
    nCategory.textContent = category ? category.nombre : "Sin categoría";
    nDivInfo.appendChild(nCategory);


    const nDivPrices = document.createElement("div");
    nDivPrices.setAttribute("class", "prices");
    nDivPrices.setAttribute("id", "priceContainer");
    nDivProduct.appendChild(nDivPrices);

    if (oferta) {
        const nOldPrice = document.createElement("p");
        nOldPrice.setAttribute("class", "oldPrice");
        nOldPrice.setAttribute("id", "oldPriceText");
        nOldPrice.style.textDecoration = "line-through";

        const nOldAmount = document.createElement("span");
        nOldAmount.setAttribute("class", "oldAmount");
        nOldAmount.setAttribute("id", "oldPriceAmount");
        nOldAmount.textContent = oferta.precioOriginal.toFixed(2);

        nOldPrice.appendChild(nOldAmount);
        nOldPrice.appendChild(document.createTextNode(" €"));
        nDivPrices.appendChild(nOldPrice);
    }


    const nNewPrice = document.createElement("p");
    nNewPrice.setAttribute("class", "newPrice");
    nNewPrice.setAttribute("id", "newPriceText");
    const nNewAmount = document.createElement("span");
    nNewAmount.setAttribute("class", "newAmount");
    nNewAmount.setAttribute("id", "newPriceAmount");
    nNewAmount.textContent = oferta ? oferta.precioNuevo.toFixed(2) : product.precio;

    nNewPrice.appendChild(nNewAmount);
    nNewPrice.appendChild(document.createTextNode(" €"));
    nDivPrices.appendChild(nNewPrice);


    if (oferta && oferta.fechaFin) {
        const nDate = document.createElement("p");
        nDate.setAttribute("class", "date");
        nDate.setAttribute("id", "dateContainer");
        nDate.appendChild(document.createTextNode("Hasta "));

        const nEndDate = document.createElement("span");
        nEndDate.setAttribute("class", "offerEndDate");
        nEndDate.setAttribute("id", "endDateValue");
        nEndDate.textContent = oferta.fechaFin;

        nDate.appendChild(nEndDate);
        nDivPrices.appendChild(nDate);
    }


    const btnAdd = document.createElement("button");
    btnAdd.setAttribute("class", "btnAdd");
    btnAdd.setAttribute("id", "addCartBtn");
    btnAdd.setAttribute("type", "button");
    btnAdd.textContent = "Añadir a la cesta";
    nDivProduct.appendChild(btnAdd);

    btnAdd.addEventListener("click", addProductToCartHandler);

    const details = document.createElement("details");
    details.setAttribute("class", "productDescription");
    details.setAttribute("id", "productDescriptionContainer");
    nMain.appendChild(details);

    const summary = document.createElement("summary");
    summary.setAttribute("id", "descriptionSummary");
    summary.textContent = "Descripción del producto";
    details.appendChild(summary);

    const pDescription = document.createElement("p");
    pDescription.setAttribute("id", "descriptionText");
    pDescription.textContent = product.descripcion || "Sin descripción";
    details.appendChild(pDescription);
}
