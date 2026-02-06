<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="admin.css">
    <script type="module" src="./admin.js"></script>
</head>

<body>
    <a href="../public/index.php">
        <div class="tLogo"></div>
    </a>

    <main>
        <button id="tBtnLogout">Cerrar sesión</button>

        <h2>Panel de Administración</h2>

        <div id="tDivErrors" class="errors" hidden></div>

        <section class="add-product-form">

            <input type="text" id="tInputName" placeholder="Nombre del producto">

            <input type="number" id="tInputPrice" placeholder="Precio" 
                min="1" max="9999" step="0.01">

            <input type="text" id="tInputDescription" placeholder="Descripción">

            <input type="number" id="tInputStock" placeholder="Stock" 
                min="1" max="9999" step="1">

            <select id="tSelectCategory">
                <option value="0" disabled selected>Selecciona categoría</option>
            </select>

            <button id="tBtnAddProduct">Añadir producto</button>
        </section>

        <table id="productsTable">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Descripción</th>
                    <th>Stock</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tBodyProducts">
            </tbody>
        </table>

    </main>
</body>

</html>