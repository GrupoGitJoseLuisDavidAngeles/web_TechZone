<?php
require_once __DIR__ . '/../config/database.php';
session_start();

$mensajeExito = $_SESSION['success_message'] ?? null;
unset($_SESSION['success_message']);
?>

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
        <button id="btnLogout">Cerrar sesión</button>

        <h2>Panel de Administración</h2>

        <?php if ($mensajeExito): ?>
            <div class="success">
                <?= htmlspecialchars($mensajeExito) ?>
            </div>
        <?php endif; ?>

        <div id="tDivErrors" class="errors"></div>

        <section class="add-product-form">

            <input type="text" id="inputName" placeholder="Nombre del producto">

            <input type="number" id="inputPrice" placeholder="Precio" 
                min="1" max="9999" step="0.01">

            <input type="text" id="inputDescription" placeholder="Descripción">

            <select id="tSelectCategory">
                <option value="">Selecciona categoría</option>
            </select>

            <button id="btnAddProduct">Añadir producto</button>
        </section>

        <table id="productsTable">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tbyProducts">
            </tbody>
        </table>

    </main>
</body>

</html>