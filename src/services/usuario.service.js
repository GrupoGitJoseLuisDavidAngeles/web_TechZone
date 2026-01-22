export default class UsuarioService {
    async getUserDataByToken(token) {
        const url = 'http://localhost:8081/api/usuario.php';

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
            throw new Error(data.message || 'Error obteniendo los datos del usuario');
        }

        return data.usuario;
    }
}