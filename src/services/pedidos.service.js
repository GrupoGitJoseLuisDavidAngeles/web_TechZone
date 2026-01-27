export default class PedidosService {
    async addPedido(productosIds, token) {

        const url = 'http://localhost:8081/api/pedido_add.php';

        let response;
        try {
            response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({
                    productos: productosIds
                })
            });
        } catch (error) {
            throw new Error(`Error de conexión: ${error.message}`);
        }

        let data;
        try {
            data = await response.json();
        } catch (error) {
            throw new Error(`Error leyendo la respuesta: ${error.message}`);
        }

        if (!data.ok) {
            throw new Error(data.message || 'Error al crear el pedido');
        }

        return data.message;
    }

    async getPedidos(token) {

        const url = 'http://localhost:8081/api/pedidos_get.php';

        let response;
        try {
            response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
        } catch (error) {
            throw new Error(`Error de conexión: ${error.message}`);
        }

        let data;
        try {
            data = await response.json();
        } catch (error) {
            throw new Error(`Error leyendo la respuesta del servidor: ${error.message}`);
        }

        if (!data.ok) {
            throw new Error(data.message || 'Error obteniendo los pedidos');
        }

        return data.pedidos;
    }
}