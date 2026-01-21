import UsuarioService from '../services/usuario.service.js';

export function decodeJWT(token) {
    if (!token) return null;

    const partes = token.split('.');
    if (partes.length !== 3) return null;

    let payloadB64 = partes[1];

    payloadB64 = payloadB64.replace(/-/g, '+').replace(/_/g, '/');

    const padding = 4 - (payloadB64.length % 4);
    if (padding !== 4) {
        payloadB64 += '='.repeat(padding);
    }

    try {
        const payloadJSON = atob(payloadB64);
        return JSON.parse(payloadJSON);
    } catch (e) {
        throw new Error('Error decodificando token:', e);
    }
}

export async function checkTokenAndChangeLoginButton(token) {
    const loginButton = document.getElementById('tLnkLogin');
    const service = new UsuarioService();

    if (!token) {
        loginButton.textContent = 'Iniciar Sesión';
        return;
    }

    try {
        var userData = await service.getUserDataByToken(token);

        if (userData && userData.nombre) {
            loginButton.textContent = userData.nombre;
            loginButton.href = '/profile/profile.php';
        } else {
            loginButton.textContent = 'Iniciar Sesión';
        }
    } catch (error) {
        alert('Error al verificar el token: ' + error.message);
        loginButton.textContent = 'Iniciar Sesión';
    }
}