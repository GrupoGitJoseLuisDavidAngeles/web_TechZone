export default class productosService {
    /**
     * 
     * @returns {Array<{ id: number, nombre: string, descripcion: string, precio: number, stock: number, imagen: string, categoria_id: number }>}
     */
    async getProducts() {
        const url = 'http://localhost:8081/api/productos.php';
        const response = await fetch(url);
        let data;

        try {
            data = await response.json();
        } catch (error) {
            throw new Error(`Error leyendo la respuesta del servidor: ${error.message}`);
        }

        if (!data.ok) {
            throw new Error(data.message || 'Error obteniendo el carrito');
        }

        return data.productos;
    }

    async getProductById(id) {
        const url = `http://localhost:8081/api/productos.php?id=${id}`;
        const response = await fetch(url);
        let data;
        
        try {
            data = await response.json();
        } catch (error) {
            throw new Error(`Error leyendo la respuesta del servidor: ${error.message}`);
        }

        if (!data.ok) {
            throw new Error(data.message || 'Error obteniendo el producto');
        }

        return data.producto;
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

    async searchProducts(name = "", category = "") {
        let conditions = "";

        if (name != "") {
            conditions += conditions ? "&" : "?";
            conditions += `name=${encodeURIComponent(name)}`;
        }

        if (category != "") {
            conditions += conditions ? "&" : "?";
            conditions += `category=${encodeURIComponent(category)}`;
        }

        const url = `http://localhost:8081/api/productos_search.php${conditions}`;
        console.log(url);
        const response = await fetch(url);
        let data;
        
        try {
            data = await response.json();
        } catch (error) {
            throw new Error(`Error leyendo la respuesta del servidor: ${error.message}`);
        }

        if (!data.ok) {
            throw new Error(data.message || 'Error obteniendo los productos');
        }

        return data.productos;
    }
}