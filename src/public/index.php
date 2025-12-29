<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechZone</title>
    <link rel="stylesheet" href="./index.css">
    <script type="module" src="index.js"></script>
</head>
<body>
    <header>
        <div class="tLogo"></div>

        <div>
            <label for="">Categorías</label>
            <select name="" id="" class="selectCategorias">
                <option disabled selected>Selecciona una categoría</option>
                <option value="">Portátiles</option>
                <option value="">Sobremesa</option>
                <option value="">Componentes</option>
                <option value="">Periféricos</option>
            </select>
        </div>
        
        <div class="divBusqueda">
            <input class="inputBusqueda" type="text" name="" id="" placeholder="Busque un producto">
            <span class="imagenLupa"></span>
        </div>

        <span>Iniciar sesión</span>
        <span>Carrito</span>
    </header>

    <aside class="asideIzquierdo"></aside>
    
    <main>
        <h1>Productos destacados</h1>
        <div id="tProductosDestacados" class="productos-destacados">     
        </div>
        
        <h1>Productos en oferta</h1>
        <div>
            (Usando la base de datos)
        </div>
    </main>

    <aside class="asideDerecho"></aside>
    
    <footer>
        <nav>
            <ul class="listaFooter">
                <li>Contacto</li>
                <li>Sobre nosotros</li>
                <li>Comunidad</li>
            </ul>
        </nav>
        <p class="pCopyright">© 2025 TechZone. Todos los derechos reservados.</p>
    </footer>

</body>
</html>