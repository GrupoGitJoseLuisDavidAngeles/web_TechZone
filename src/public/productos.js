import productosService from "../services/productos.service.js";
setup();

async function setup() {
    const service = new productosService();
    const productos = service.getProducts();
    // console.log(productos);

}