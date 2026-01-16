import productosService from "../services/productos.service.js";
setup();

async function setup() {
    fillCategorySelect();

    const service = new productosService();
    let productos = await service.getProducts();
    let ofertas = await service.getOffers();

    fillFeaturedContainer(productos);
    fillOnOffer(productos, ofertas);

    const nSelCategory = document.querySelector('#tSelectCategory');
    nSelCategory.addEventListener('change', fillContainersByCategory);
    nSelCategory.addEventListener('change', changeTitles);


}


async function fillCategorySelect() {
    const service = new productosService();
    let categories = await service.getCategories();

    const nSelect = document.querySelector('#tSelectCategory');

    categories.forEach(category => {
        const nOpt = document.createElement('option');
        nSelect.appendChild(nOpt);
        nOpt.value = category.id;
        nOpt.textContent = category.nombre;
    });
}

async function changeTitles(e) {
    const nSelect = e.target;
    const categoriaId = nSelect.value;

    const service = new productosService();
    const categories = await service.getCategories();
    let newTitle = 'Productos';
    if (categoriaId != 'all') {
        newTitle = categories.filter(cat => cat['id'] == categoriaId).at(0).nombre;
    }

    document.querySelector('#tTitleFeatured').textContent = newTitle;
    document.querySelector('#tTitleOffers').textContent = newTitle;

}

async function fillContainersByCategory(e) {
    const nSelect = e.target;
    const categoriaId = nSelect.value;


    const service = new productosService();
    let productos = await service.getProducts();
    let ofertas = await service.getOffers();
    if (categoriaId != 'all') {
        productos = productos.filter(prod => prod['categoria_id'] == categoriaId)
        ofertas = ofertas.filter(oferta => oferta['categoria_id'] == categoriaId)
    }

    fillFeaturedContainer(productos);
    fillOnOffer(productos, ofertas);
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
        nCard.classList.add('product-card')

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


        const product = products.filter(prod => prod['id'] == productId).at(0)

        const nCard = document.createElement('div');
        nContainer.appendChild(nCard);
        nCard.classList.add('product-card')

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
        const discountPercent = '-' + ((offer.precio_original - offer.precio_nuevo) / offer.precio_original * 100).toFixed(0) + '%';
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