export default class productosService {
    /**
     * 
     * @returns {Array<{ id: number, nombre: string, descripcion: string, precio: number, stock: number, imagen: string, categoria_id: number }>}
     */
    async getProducts() {
        const url = 'http://localhost:8081/api/productos.php';
        const response = await fetch(url);
        const data = await response.json();
        return data;
    }

    /**
     * 
     * @returns {Array<{id: number, nombre: string, descripcion: string}>}
     */
    async getCategories() {
        const url = 'http://localhost:8081/api/categorias.php';
        const response = await fetch(url);
        let data = await response.json();
        return data;
    }
    
    /**
     * 
     * @returns {Array<{producto_id: number, nombre: string, categoria_id: number, precio_original: number, precio_nuevo: number, fecha_inicio: string, fecha_fin: string}>}
     */
    async getOffers() {
        const url = 'http://localhost:8081/api/ofertas.php';
        const response = await fetch(url);
        let data = await response.json();
        return data;
    }
}