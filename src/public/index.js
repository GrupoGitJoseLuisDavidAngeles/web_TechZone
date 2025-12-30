import productosService from "../services/productos.service.js";
setup();

async function setup() {
    const service = new productosService();
    let productos = await service.getProducts();
    fillFeaturedContainer(productos);
    const nSelCategory = document.querySelector('#tSelectCategory');
    nSelCategory.addEventListener('change', fillFeaturedByCategory)
}

async function fillFeaturedByCategory(e) {
    const nSelect = e.target;
    const categoria = nSelect.value;

    const service = new productosService();
    let productos = await service.getProducts();
    if (categoria != 'all') {
        productos = productos.filter(prod => prod['categoria'] == categoria)
    }
    fillFeaturedContainer(productos);

}


/**
 * 
 * @param {Array<{id:number, nombre:string, descripcion:string, precio:number, stock:number, imagen:string, categoria:string}>} productos 
 */
function fillFeaturedContainer(productos) {
    const nContainer = document.querySelector('#tFeaturedProducts');
    nContainer.innerHTML = '';
    for (let i = 0; i < productos.length; i++) {
        const producto = productos[i];

        const nCard = document.createElement('div');
        nContainer.appendChild(nCard);
        nCard.classList.add('product-card')

        const nImg = document.createElement('img');
        nCard.appendChild(nImg);
        nImg.classList.add('product-image');
        nImg.src = 'http://localhost:8081/assets/' + producto.imagen;

        const nNombre = document.createElement('h3');
        nCard.appendChild(nNombre)
        nNombre.textContent = producto.nombre;

        const nPrecio = document.createElement('p');
        nCard.appendChild(nPrecio);
        nPrecio.textContent = producto.precio + ' €';

        const nDescripcion = document.createElement('p');
        nCard.appendChild(nDescripcion);
        nDescripcion.textContent = producto.descripcion;

    }
}