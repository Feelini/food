class Fridge{
    constructor(){}

    confirmDelete(deleteButton){
        let deleteItem = document.querySelectorAll(deleteButton);
        deleteItem.forEach(item => item.addEventListener('click', (event) => {
            event.preventDefault();
            if (confirm('Вы уверены, что хотите удалить этот элемент?')){
                location.href = item.href;
            }
        }));
    }
}

let fridge = new Fridge();
fridge.confirmDelete('.deleteButton');