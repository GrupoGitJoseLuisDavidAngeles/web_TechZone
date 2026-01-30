import productosService from "../services/productos.service.js";

setup();

async function setup(){
    const service = new productosService();
    const categories = await service.getCategories();
    const products = await service.getProducts();

    await fillCategories(categories);
    await fillTableWithProducts(products, categories);
}


async function fillCategories(categories){
    const nSelect = document.querySelector("#tSelectCategory");
    
    categories.forEach(category => {
        const nOption = document.createElement("option");
        nSelect.appendChild(nOption);
        nOption.value = category.id;
        nOption.textContent = category.nombre;
    });
}


async function fillTableWithProducts(products, categories){
    const nTbody = document.querySelector("#tbyProducts");

    products.forEach(product => {
        const nTr = document.createElement("tr");
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


        const nTdCategory = document.createElement("td");
        nTr.appendChild(nTdCategory);
        
        const nSelectCategory = document.createElement("select");
        nTdCategory.appendChild(nSelectCategory);

        categories.forEach(category => {
            const nOptionCategory = document.createElement("option");
            nSelectCategory.appendChild(nOptionCategory);

            nOptionCategory.value = category.id;
            nOptionCategory.textContent = category.nombre;
            
            if(category.id === product.categoria_id){
                nOptionCategory.selected = true;
            }
        });


        const nTdActions = document.createElement("td");
        nTr.appendChild(nTdActions);

        const nEditButton = document.createElement("button");
        nTdActions.appendChild(nEditButton);
        nEditButton.textContent = "Editar";

        const nDeleteButton = document.createElement("button");
        nTdActions.appendChild(nDeleteButton);
        nDeleteButton.textContent = "Eliminar";
    });


    function editProduct(e) {
        
    }

    function deleteProduct(e) {

    }

}