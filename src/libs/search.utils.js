import productosService from "../services/productos.service.js";

export function redirectToSearchPage() {
    let conditions = "";
    const name = document.querySelector("#tInputSearch").value;
    const category = document.querySelector("#tSelectCategory").value;

    if (name != "") {
        conditions += conditions ? "&" : "?";
        conditions += `name=${encodeURIComponent(name)}`;
    }

    if (category != "all") {
        conditions += conditions ? "&" : "?";
        conditions += `category=${encodeURIComponent(category)}`;
    }

    if (!conditions) {
        return;
    }

    const url = `/search/search.php${conditions}`;
    window.location = url;
}

export async function fillCategorySelect() {
    const service = new productosService();
    let categories = await service.getCategories();

    const nSelect = document.querySelector('#tSelectCategory');

    categories.forEach(category => {
        const nOpt = document.createElement('option');
        nSelect.appendChild(nOpt);
        nOpt.value = category.id;
        nOpt.textContent = category.nombre;
    });
}