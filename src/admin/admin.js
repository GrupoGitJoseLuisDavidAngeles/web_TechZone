import productosService from "../services/productos.service.js";
import { logout, isAdmin } from "../libs/token.utils.js";

setup();

async function setup() {
    const token = localStorage.getItem("token");

    const admin = await isAdmin(token);

    if (!admin) {
        alert("No tienes permisos para acceder a esta página");
        window.location = "/public/index.php";
        return;
    }

    const service = new productosService();
    const categories = await service.getCategories();
    const products = await service.getProducts();

    await fillCategories(categories);
    await fillTableWithProducts(products, categories);

    const btnAdd = document.querySelector("#tBtnAddProduct");
    btnAdd.addEventListener("click", addProduct);

    const btnLogout = document.querySelector("#tBtnLogout");
    btnLogout.addEventListener("click", logout);
}

async function addProduct(e) {
    const service = new productosService();
    const token = localStorage.getItem("token");

    const nombre = document.querySelector("#tInputName").value;
    const descripcion = document.querySelector("#tInputDescription").value;
    const stockInput = document.querySelector("#tInputStock").value;
    const stock = stockInput === "" ? 0 : parseInt(stockInput);
    const precio = parseFloat(document.querySelector("#tInputPrice").value);
    const categoriaId = parseInt(document.querySelector("#tSelectCategory").value);

    const productData = {
        nombre: nombre,
        descripcion: descripcion,
        precio: precio,
        stock: stock,
        categoria: categoriaId
    };

    try {
        await service.saveProduct(productData, token);
        alert("Producto creado correctamente");

        window.location = "/admin/admin.php";
    } catch (error) {
        const nDivError = document.querySelector("#tDivErrors");
        nDivError.textContent = `Error al crear el producto: ${error.message}`;
        nDivError.removeAttribute("hidden");
    }
}

async function deleteProduct(e) {
    if (!confirm("¿Seguro que quieres eliminar este producto?")) return;

    const row = e.target.closest("tr");
    const productoId = row.dataset.productId;
    const token = localStorage.getItem("token");

    const service = new productosService();

    try {
        await service.deleteProduct(productoId, token);
        alert("Producto eliminado correctamente.")
        window.location = "/admin/admin.php";
    } catch (error) {
        alert(error.message);
    }
}

async function updateProduct(e) {
    const service = new productosService();
    const token = localStorage.getItem("token");

    const btn = e.target;

    const nTr = btn.closest("tr");

    const productoId = nTr.dataset.productId;

    const inputs = nTr.querySelectorAll("input");
    const select = nTr.querySelector("select");

    const nombre = inputs[0].value.trim();
    const precio = parseFloat(inputs[1].value);
    const descripcion = inputs[2].value.trim();
    const stockInput = inputs[3].value;
    const stock = stockInput === "" ? 0 : parseInt(stockInput);
    const categoria = parseInt(select.value);

    const productData = {
        productoId: productoId,
        nombre: nombre,
        descripcion: descripcion,
        precio: precio,
        stock: stock,
        categoria: categoria
    };

    try {
        await service.saveProduct(productData, token);
        alert("Producto actualizado correctamente");

        window.location = "/admin/admin.php";
    } catch (error) {
        const nDivError = document.querySelector("#tDivErrors");
        nDivError.textContent = `Error al actualizar el producto: ${error.message}`;
        nDivError.removeAttribute("hidden");
    }
}

async function fillCategories(categories) {
    const nSelect = document.querySelector("#tSelectCategory");

    categories.forEach(category => {
        const nOption = document.createElement("option");
        nSelect.appendChild(nOption);
        nOption.value = category.id;
        nOption.textContent = category.nombre;
    });
}


async function fillTableWithProducts(products, categories) {
    const nTbody = document.querySelector("#tBodyProducts");

    products.forEach(product => {
        const nTr = document.createElement("tr");
        nTr.setAttribute("data-product-id", product.id);
        nTbody.appendChild(nTr);

        const nTdName = document.createElement("td");
        nTr.appendChild(nTdName);

        const nInputName = document.createElement("input");
        nTdName.appendChild(nInputName);

        nInputName.setAttribute("type", "text");
        nInputName.setAttribute("value", product.nombre);


        const nTdPrice = document.createElement("td");
        nTr.appendChild(nTdPrice);

        const nInputPrice = document.createElement("input");
        nTdPrice.appendChild(nInputPrice);

        nInputPrice.setAttribute("type", "number");
        nInputPrice.setAttribute("min", "1");
        nInputPrice.setAttribute("max", "9999");
        nInputPrice.setAttribute("step", "0.01");
        nInputPrice.setAttribute("value", product.precio);


        const nTdDescription = document.createElement("td");
        nTr.appendChild(nTdDescription);

        const nInputDescription = document.createElement("input");
        nTdDescription.appendChild(nInputDescription);

        nInputDescription.setAttribute("type", "text");
        nInputDescription.setAttribute("value", product.descripcion);

        const nTdStock = document.createElement("td");
        nTr.appendChild(nTdStock);

        const nInputStock = document.createElement("input");
        nTdStock.appendChild(nInputStock);

        nInputStock.setAttribute("type", "number");
        nInputStock.setAttribute("min", "0");
        nInputStock.setAttribute("max", "99999");
        nInputStock.setAttribute("step", "1");
        nInputStock.setAttribute("value", product.stock || 0);

        const nTdCategory = document.createElement("td");
        nTr.appendChild(nTdCategory);

        const nSelectCategory = document.createElement("select");
        nTdCategory.appendChild(nSelectCategory);

        categories.forEach(category => {
            const nOptionCategory = document.createElement("option");
            nSelectCategory.appendChild(nOptionCategory);

            nOptionCategory.value = category.id;
            nOptionCategory.textContent = category.nombre;

            if (category.id === product.categoria_id) {
                nOptionCategory.selected = true;
            }
        });


        const nTdActions = document.createElement("td");
        nTr.appendChild(nTdActions);

        const nEditButton = document.createElement("button");
        nTdActions.appendChild(nEditButton);
        nEditButton.textContent = "Editar";
        nEditButton.addEventListener("click", updateProduct);

        const nDeleteButton = document.createElement("button");
        nTdActions.appendChild(nDeleteButton);
        nDeleteButton.textContent = "Eliminar";
        nDeleteButton.addEventListener("click", deleteProduct);
    });

}