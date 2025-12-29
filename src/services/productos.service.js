export default class productosService {
    /**
     * 
     * @returns {Array<{id:number, nombre:string,descripcion:string, precio:number,stock:number, imagen:string, categoria:string}>}
     */
    async getProducts() {
        const url = 'http://localhost:8081/api/productos.php';
        const response = await fetch(url);
        const data = await response.json();
        return data;
    }
}