class EditDish {
    addProduct(){
        let addButton = document.getElementById("addButton");
        addButton.addEventListener('click', () => {
            let parentBody = document.getElementById('addDishContent_products');
            let product = document.querySelectorAll('.addDishContent_product');
            product = product[product.length - 1];
            let removeButton = document.querySelectorAll('.removeButton');
            let newProduct = product.cloneNode(true);
            removeButton[removeButton.length-1].style.display = 'inline-block';
            removeButton[removeButton.length-1].addEventListener('click', (event) => {
                let remove = event.currentTarget.parentNode;
                remove.parentNode.removeChild(remove);
            });
            parentBody.appendChild(newProduct);
        });
    }

    removeButtotns(){
        let removeButton = document.querySelectorAll('.removeButton');
        for (let i = 0; i < removeButton.length - 1; i++){
            removeButton[i].style.display = 'inline-block';
            removeButton[i].addEventListener('click', (event) => {
                let remove = event.currentTarget.parentNode;
                remove.parentNode.removeChild(remove);
            });
        }
    }
}

let edit = new EditDish();
edit.addProduct();
edit.removeButtotns();