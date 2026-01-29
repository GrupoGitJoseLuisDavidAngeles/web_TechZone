import { fillCategorySelect, redirectToSearchPage } from "../libs/search.utils.js";
import { checkTokenAndChangeLoginButton } from "../libs/token.utils.js";
import productosService from "../services/productos.service.js";

setup();

async function setup() {
    const token = window.localStorage.getItem('token');
    await checkTokenAndChangeLoginButton(token);
    
    fillCategorySelect();

    const searchBtn = document.querySelector("#tSpnSearch");
    searchBtn.addEventListener("click", redirectToSearchPage);

    const params = new URLSearchParams(window.location.search);
    
    const name = params.get('name') ?? "";
    const category = params.get('category') ?? "";

    const service = new productosService();
    const products = await service.searchProducts(name, category);
    console.log(products);
}

async function loadFoundProducts(products) {
    
}