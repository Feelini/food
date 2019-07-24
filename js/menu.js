class Food{
    newLink(btn, listItem){
        let menuItems = document.querySelectorAll(btn);
        menuItems.forEach(item => item.addEventListener('click', onClick));

        function onClick (event){
            let link = event.target.getElementsByClassName(listItem);
            window.location = link[0].href;
        }
    }
}

let food = new Food();
food.newLink('li.menu_item', 'menu_link');