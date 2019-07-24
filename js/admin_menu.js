class AdminMenu{
    constructor(){}

    slide(idButton, idSlide){
        let slide = idSlide;
        let slideItem = document.getElementById(slide);
        if (localStorage.getItem('open') == 1){
            slideItem.classList.add('open');
        } else {
            slideItem.classList.add('close');
        }
        let item = document.getElementById(idButton);
        item.addEventListener('click', () => {
            slideItem.classList.toggle("open");
            slideItem.classList.toggle("close");
            let c = (slideItem.classList.contains('open')) ? 1 : 0;
            localStorage.setItem('open', c);
        });
    }

    newLink(btn, link){
        let link2 = link;
        let menuItems = document.querySelectorAll(btn);
        menuItems.forEach(item => item.addEventListener('click', onClick));

        function onClick(event){
            let link = event.target.getElementsByClassName(link2);
            window.location = link[0].href;
        }
    }

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

let menu = new AdminMenu();
menu.slide('slideButton', 'slide');
menu.newLink('span.adminSidebar_subButton', 'adminSidebar_subLink');
menu.confirmDelete('.deleteButton');