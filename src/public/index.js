import productosService from "../services/productos.service.js";
setup();

async function setup() {
    const service = new productosService();
    const productos = await service.getProducts();
    fillDestacados(productos)


}

/**
 * 
 * @param {Array<{id:number, nombre:string,descripcion:string, precio:number,stock:number, imagen:string, categoria:string}>} productos 
 */
function fillDestacados(productos) {
    const nContainer = document.querySelector('#tProductosDestacados');
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