export default class CarritoService {
    /**
     * 
     * @param {*} productID 
     * @param {*} token 
     * @returns {Promise<string>}
     */
    async addToCart(productID, token) {

        const url = 'http://localhost:8081/api/carrito_add.php';

        let response;
        try {
            response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({ productoId: productID })
            });
        } catch (error) {
            alert(`Error de conexión con el servidor: ${error.message}`);
            throw new Error(`Error de conexión: ${error.message}`);
        }

        let data;
        try {
            data = await response.json();
        } catch (error) {
            alert(`Error leyendo la respuesta del servidor: ${error.message}`);
            throw new Error(`Error leyendo la respuesta: ${error.message}`);
        }

        if (!data.ok) {
            alert(data.message || "Error al añadir al carrito.");
            throw new Error(data.message || 'Error al añadir al carrito');
        }

        return data.message;
    }

    async deleteFromCart(productID, token) {

        const url = 'http://localhost:8081/api/carrito_delete.php';

        let response;
        try {
            response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({ productoId: productID })
            });
        } catch (error) {
            alert(`Error de conexión con el servidor: ${error.message}`);
            throw new Error(`Error de conexión: ${error.message}`);
        }

        let data;
        try {
            data = await response.json();
        } catch (error) {
            alert(`Error leyendo la respuesta del servidor: ${error.message}`);
            throw new Error(`Error leyendo la respuesta: ${error.message}`);
        }

        if (!data.ok) {
            alert(data.message || "Error al eliminar del carrito.");
            throw new Error(data.message || 'Error al eliminar del carrito');
        }

        return data.message;
    }

    /**
     * 
     * @param {*} token 
     * @returns {Promise<Array>} 
     */
    async getCart(token) {
        const url = 'http://localhost:8081/api/carrito_get.php';

        let response;
        try {
            response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
        } catch (error) {
            throw new Error(`Error conectando con el servidor: ${error.message}`);
        }

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

    async clearCart(token) {
        const url = 'http://localhost:8081/api/carrito_clear.php';

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });

        const data = await response.json();

        if (!data.ok) {
            throw new Error(data.message);
        }

        return data.message;
    }
}
