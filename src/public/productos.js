import productosService from "../services/productos.service.js";
setup();

async function setup() {
    const service = new productosService();
    const productos = await service.getProducts();
    console.log(productos);
    
}