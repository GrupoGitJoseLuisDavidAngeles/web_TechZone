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

            if (userData.rol && userData.rol.toLowerCase() === 'admin') {
                loginButton.href = '/admin/admin.php';
            } else {
                loginButton.href = '/profile/profile.php';
            }
        } else {
            loginButton.textContent = 'Iniciar Sesión';
        }
    } catch (error) {
        loginButton.textContent = 'Iniciar Sesión';
    }
}

export async function isAdmin(token) {
    if (!token) return false;

    const service = new UsuarioService();

    try {
        var userData = await service.getUserDataByToken(token);

        if (userData && userData.rol) {
            console.log(userData.rol);
            return userData.rol.toLowerCase() === 'admin';
        } else {
            return false;
        }
    } catch (error) {
        return false;
    }
}

export function logout() {
    localStorage.removeItem('token');
    window.location = "/public/index.php";
}