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