import { checkTokenAndChangeLoginButton } from "../libs/token.utils.js";
import productosService from "../services/productos.service.js";
import {redirectToSearchPage, fillCategorySelect} from "../libs/search.utils.js";

setup();

async function setup() {
    const token = window.localStorage.getItem('token');
    await checkTokenAndChangeLoginButton(token);

    await fillCategorySelect();

    const service = new productosService();
    let productos = await service.getProducts();
    let ofertas = await service.getOffers();

    fillContainers(productos, ofertas);

    const nSelCategory = document.querySelector('#tSelectCategory');
    nSelCategory.addEventListener('change', async e => {
        await changeTitles(e, service);
        await fillContainersByCategory(e, service);
    });

    const searchBtn = document.querySelector("#tSpnSearch");
    searchBtn.addEventListener("click", redirectToSearchPage);
}


async function changeTitles(e, service) {
    const nSelect = e.target;
    const categoriaId = nSelect.value;

    const categories = await service.getCategories();
    let newTitle = 'Productos';
    if (categoriaId != 'all') {
        const cat = categories.find(cat => cat.id == categoriaId);
        if (cat) newTitle = cat.nombre;
    }

    document.querySelector('#tTitleFeatured').textContent = newTitle;
    document.querySelector('#tTitleOffers').textContent = newTitle;
}


async function fillContainersByCategory(e, service) {
    const nSelect = e.target;
    const categoriaId = nSelect.value;

    let productos = await service.getProducts();
    let ofertas = await service.getOffers();

    if (categoriaId != 'all') {
        productos = productos.filter(prod => prod.categoria_id == categoriaId);
        ofertas = ofertas.filter(oferta => oferta.categoria_id == categoriaId);
    }

    fillContainers(productos, ofertas);
}


function fillContainers(productos, ofertas) {
    const ofertaIds = ofertas.map(oferta => oferta.producto_id);
    const productosSinOferta = productos.filter(prod => !ofertaIds.includes(prod.id));

    fillFeaturedContainer(productosSinOferta); 
    fillOnOffer(productos, ofertas);           
}


function redirectToProduct(event){
    const productId = event.currentTarget.dataset.id;
    window.location = `product.php?id=${productId}`;
}

/**
 * 
 * @param {Array<{id:number, nombre:string, descripcion:string, precio:number, stock:number, imagen:string, categoria:string}>} productos 
 */
function fillFeaturedContainer(productos) {
    const nContainer = document.querySelector('#tFeaturedProducts');
    nContainer.innerHTML = '';

    for (let i = 0; i < productos.length; i++) {
        const product = productos[i];

        const nCard = document.createElement('div');
        nContainer.appendChild(nCard);
        nCard.classList.add('product-card');
        nCard.dataset.id = product.id;
        nCard.addEventListener("click", redirectToProduct);
        
        const nImg = document.createElement('img');
        nCard.appendChild(nImg);
        nImg.classList.add('product-image');
        nImg.src = 'http://localhost:8081/assets/' + product.imagen;

        const nNombre = document.createElement('p');
        nCard.appendChild(nNombre)
        nNombre.textContent = product.nombre;
        nNombre.classList.add('product-name');

        const nPrecio = document.createElement('p');
        nCard.appendChild(nPrecio);
        nPrecio.textContent = product.precio + ' €';
        nPrecio.classList.add('product-price');

        const nDescripcion = document.createElement('p');
        nCard.appendChild(nDescripcion);
        nDescripcion.textContent = product.descripcion;
    }
}

/**
 * 
 * @param {Array<{id:number, nombre:string, descripcion:string, precio:number, stock:number, imagen:string, categoria:string}>} products 
 * @param {Array<{producto_id: number, nombre: string, categoria_id: number, precio_original: number, precio_nuevo: number, fecha_inicio: string, fecha_fin: string}>} offers
 */
async function fillOnOffer(products, offers) {
    const nContainer = document.querySelector('#tProductsOnOffer');
    nContainer.innerHTML = '';
    offers.forEach(offer => {
        const productId = offer.producto_id;
        const product = products.find(prod => prod.id === productId);
        if (!product) return;

        const nCard = document.createElement('div');
        nContainer.appendChild(nCard);
        nCard.classList.add('product-card')
        nCard.dataset.id = productId;
        nCard.addEventListener("click", redirectToProduct);

        const nImg = document.createElement('img');
        nCard.appendChild(nImg);
        nImg.classList.add('product-image');
        nImg.src = 'http://localhost:8081/assets/' + product.imagen;

        const nNombre = document.createElement('p');
        nCard.appendChild(nNombre)
        nNombre.textContent = offer.nombre;
        nNombre.classList.add('product-name');

        const nPrecioNuevo = document.createElement('p');
        nCard.appendChild(nPrecioNuevo);
        nPrecioNuevo.textContent = offer.precio_nuevo + ' €'
        nPrecioNuevo.classList.add('product-price');

        const nDescuento = document.createElement('p');
        nCard.appendChild(nDescuento);
        const discountPercent = offer.precio_original
            ? '-' + ((offer.precio_original - offer.precio_nuevo) / offer.precio_original * 100).toFixed(0) + '%'
            : '';
        nDescuento.textContent = discountPercent;
        nDescuento.classList.add('product-discount')

        const nPrecioOriginal = document.createElement('span');
        nPrecioNuevo.appendChild(nPrecioOriginal);
        nPrecioOriginal.textContent = offer.precio_original + ' €';
        nPrecioOriginal.classList.add('product-price-old');

        const nDescripcion = document.createElement('p');
        nCard.appendChild(nDescripcion);
        nDescripcion.textContent = product.descripcion;
    });
}
