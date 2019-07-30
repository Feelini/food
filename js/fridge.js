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

    addInputId(get_id, set_id){
        let getId = document.getElementById(get_id);
        let list = getId.getAttribute('list');
        let option = document.querySelectorAll(`#${list} option`);
        let setId = document.getElementById(set_id);
        getId.addEventListener('change', (e) => {
            let value = e.currentTarget.value;
            for (let i = 0; i < option.length; i++){
                if (option[i].value == value){
                    setId.value = option[i].dataset.value;
                }
            }
        });
    }
}

let fridge = new Fridge();
fridge.confirmDelete('.deleteButton');
fridge.addInputId('get_id', 'set_id');