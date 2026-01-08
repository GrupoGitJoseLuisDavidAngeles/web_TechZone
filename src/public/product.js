import productosService from "../services/productos.service.js";

setup();

async function setup(){
    const service = new productosService();

    const products = await service.getProducts();
    const categories = await service.getCategories();
    const offerts = await service.getOffers();

    const productId = getIdFromUrl();
    if (!productId) return;

    fillProductWithData(products, offerts, categories, productId);
}

function getIdFromUrl(){
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get("id");
}


function fillProductWithData(products, offerts, categories, productId){
    const product = products.find(p => p.id == productId);
    const nMain = document.querySelector("#mainContainer");

    if (!product) {
        const mensaje = document.createElement("p");
        mensaje.textContent = "Producto no encontrado";
        nMain.appendChild(mensaje);
        return;
    }

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
    img.style.width = "100%";
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

    const nOldPrice = document.createElement("p");
    nOldPrice.setAttribute("class", "oldPrice");
    nOldPrice.setAttribute("id", "oldPriceText");
    const nOldAmount = document.createElement("span");
    nOldAmount.setAttribute("class", "oldAmount");
    nOldAmount.setAttribute("id", "oldPriceAmount");
    nOldAmount.textContent = product.precio_anterior || product.precio;
    nOldPrice.appendChild(nOldAmount);
    nOldPrice.appendChild(document.createTextNode(" €"));
    nDivPrices.appendChild(nOldPrice);

    const nNewPrice = document.createElement("p");
    nNewPrice.setAttribute("class", "newPrice");
    nNewPrice.setAttribute("id", "newPriceText");
    const nNewAmount = document.createElement("span");
    nNewAmount.setAttribute("class", "newAmount");
    nNewAmount.setAttribute("id", "newPriceAmount");
    nNewAmount.textContent = product.precio;
    nNewPrice.appendChild(nNewAmount);
    nNewPrice.appendChild(document.createTextNode(" €"));
    nDivPrices.appendChild(nNewPrice);

    const nDate = document.createElement("p");
    nDate.setAttribute("class", "date");
    nDate.setAttribute("id", "dateContainer");
    nDate.appendChild(document.createTextNode("Hasta. "));

    const nEndDate = document.createElement("span");
    nEndDate.setAttribute("class", "offerEndDate");
    nEndDate.setAttribute("id", "endDateValue");

    const oferta = offerts.find(o => o.producto_id == product.id);
    nEndDate.textContent = oferta && oferta.fecha_fin ? oferta.fecha_fin : "Sin oferta";

    nDate.appendChild(nEndDate);
    nDivPrices.appendChild(nDate);


    const btnAdd = document.createElement("button");
    btnAdd.setAttribute("class", "btnAdd");
    btnAdd.setAttribute("id", "addCartBtn");
    btnAdd.setAttribute("type", "submit");
    btnAdd.textContent = "Añadir a la cesta";
    nMain.appendChild(btnAdd);


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

