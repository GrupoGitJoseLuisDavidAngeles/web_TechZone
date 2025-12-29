export default class productosService{
    /**
     * 
     * @returns {Array}
     */
    async getProducts(){
        const url = 'http://localhost:8081/api/productos.php';
        const response = await fetch(url);
        const data = await response.json();
        return data;
    }
}