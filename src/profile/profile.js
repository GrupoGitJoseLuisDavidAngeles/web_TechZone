import PedidosService from "../services/pedidos.service.js";
import UsuarioService from "../services/usuario.service.js";
import { logout } from "../libs/token.utils.js";

setup();

async function setup() {
    const token = window.localStorage.getItem("token");
    
    if (!token) {
        alert('No hay sesión activa');
        window.location = '/public/index.php';
        return;
    }

    await loadUserData(token);
    
    await loadPedidos(token);
    
    document.querySelector('.end-session').addEventListener('click', () => {
        logout();
        window.location = '/public/index.php';
    });
}

async function loadUserData(token) {
    try {
        const usuarioService = new UsuarioService();
        const usuario = await usuarioService.getUserDataByToken(token);
        
        document.getElementById('tTitleUsername').textContent = usuario.nombre;
        document.querySelectorAll('.data-element')[0].textContent = usuario.nombre;
        document.querySelectorAll('.data-element')[1].textContent = usuario.email || 'No disponible';
    } catch (error) {
        alert('Sesión inválida o expirada');
        removeToken();
        window.location.href = '/public/index.php';
    }
}

async function loadPedidos(token) {
    try {
        const pedidosService = new PedidosService();
        const pedidos = await pedidosService.getPedidos(token);
        
        const container = document.getElementById('pedidosContainer');
        
        if (!pedidos || pedidos.length === 0) {
            container.innerHTML = '<p class="no-pedidos">No tienes pedidos todavía</p>';
            return;
        }
        
        pedidos.forEach(pedido => {
            const pedidoElement = createPedidoElement(pedido);
            container.appendChild(pedidoElement);
        });
        
    } catch (error) {
        console.error('Error cargando pedidos:', error);
        document.getElementById('pedidosContainer').innerHTML = 
            '<p class="error-pedidos">Error al cargar los pedidos</p>';
    }
}

function createPedidoElement(pedido) {
    const IVA_PORCENTAJE = 0.21;
    const GASTOS_ENVIO = 5;
    const UMBRAL_ENVIO_GRATIS = 200;
    
    let sumaSubtotales = 0;
    pedido.productos.forEach(producto => {
        sumaSubtotales += parseFloat(producto.precio) * parseInt(producto.cantidad);
    });
    
    const iva = sumaSubtotales * IVA_PORCENTAJE;
    const subtotalConIva = sumaSubtotales + iva;

    const gastosEnvio = (subtotalConIva < UMBRAL_ENVIO_GRATIS) ? GASTOS_ENVIO : 0;

    const totalEsperado = subtotalConIva + gastosEnvio;

    const totalPedido = parseFloat(pedido.total);

    const hayProductosEliminados = Math.abs(totalPedido - totalEsperado) > 0.5;
    
    const details = document.createElement('details');
    details.className = 'pedido-details';

    const summary = document.createElement('summary');
    summary.className = 'pedido-summary';
    summary.innerHTML = `
        <span class="pedido-id">Pedido #${pedido.id}</span>
        <span class="pedido-cantidad">${pedido.cantidad_productos} producto${pedido.cantidad_productos !== 1 ? 's' : ''}</span>
        <span class="pedido-total">Total (Tras IVA y gastos de envío): ${totalPedido.toFixed(2)}€</span>
    `;
    
    const contenido = document.createElement('div');
    contenido.className = 'pedido-contenido';
    
    if (pedido.productos.length > 0) {
        const productosLista = document.createElement('div');
        productosLista.className = 'productos-lista';
        
        pedido.productos.forEach(producto => {
            const productoItem = document.createElement('div');
            productoItem.className = 'producto-item';
            
            const subtotal = (parseFloat(producto.precio) * parseInt(producto.cantidad)).toFixed(2);
            
            productoItem.innerHTML = `
                <div class="producto-nombre">${producto.nombre}</div>
                <div class="producto-detalles">
                    <span class="producto-precio">${parseFloat(producto.precio).toFixed(2)}€</span>
                    <span class="producto-cantidad">x ${producto.cantidad}</span>
                    <span class="producto-subtotal">Subtotal: ${subtotal}€</span>
                </div>
            `;
            
            productosLista.appendChild(productoItem);
        });
        
        contenido.appendChild(productosLista);
    }

    if (hayProductosEliminados) {
        const mensajeEliminados = document.createElement('div');
        mensajeEliminados.className = 'productos-eliminados';
        mensajeEliminados.textContent = 'Algunos productos de este pedido han sido eliminados de la base de datos. Contacte con atención al cliente para saber más.';
        contenido.appendChild(mensajeEliminados);
    }
    
    details.appendChild(summary);
    details.appendChild(contenido);
    
    return details;
}
