class Cookbook {
    dishImgResize(){
        let dishImg = document.querySelectorAll('.dishImg');
        dishImg.forEach((item) => {
            if (item.width > item.height) item.style.height = '100%';
            else item.style.width = '100%';
        });
    }

    getMoreDish(dishImgResize, setBookmark){
        let button = document.getElementById('more');
        if (button){
            button.addEventListener('click', () => {
                let xhr = new XMLHttpRequest();
                let form = new FormData();
                form.append('page', button.dataset.page);
                xhr.open('POST', button.dataset.url);
                xhr.send(form);
                xhr.onreadystatechange = function(){
                    if (xhr.readyState != 4) return;
                    if (xhr.status != 200) {
                        console.log(xhr.status + ': ' + xhr.statusText);
                    } else {
                        let newDish = JSON.parse(xhr.responseText);
                        newDish.forEach((item) => {
                            //блок с новым блюдом
                            let recipe = document.createElement('div');
                            recipe.classList.add('recipe');

                            //описание блюда
                            let dishDescription = document.createElement('div');
                            dishDescription.classList.add('dishDescription');

                            // создание элемента со ссылкой на категорию
                            let recipeLink = document.createElement('a');
                            recipeLink.classList.add('recipe_link');
                            let linkText = document.createTextNode(item.category_name);
                            recipeLink.appendChild(linkText);
                            recipeLink.setAttribute('href', 'http://food/cookbook/viewCategory/'+item.category_id);
                            let recipeCategory = document.createElement('p');
                            recipeCategory.classList.add('recipe_category');
                            recipeCategory.appendChild(recipeLink);

                            // создание элемента со ссылкой на блюдо
                            recipeLink = document.createElement('a');
                            recipeLink.classList.add('recipe_link');
                            linkText = document.createTextNode(item.name);
                            recipeLink.appendChild(linkText);
                            recipeLink.setAttribute('href', 'http://food/cookbook/viewDish/'+item.id_dish);
                            let recipeDishName = document.createElement('p');
                            recipeDishName.classList.add('recipe_dishName');
                            recipeDishName.appendChild(recipeLink);

                            //кнопка добавления в меню
                            let addToMenu = document.createElement('div');
                            addToMenu.classList.add('addToMenu');
                            addToMenu.classList.add('bookmark');
                            addToMenu.setAttribute('data-dishid', item.id_dish);

                            let svg = document.createElementNS("http://www.w3.org/2000/svg", 'svg');
                            svg.setAttributeNS(null, 'viewBox', '0 0 9 14');
                            svg.setAttributeNS(null, 'width', '9');
                            svg.setAttributeNS(null, 'height', '14');
                            let path = document.createElementNS("http://www.w3.org/2000/svg", 'path');
                            path.classList.add('flag');
                            path.setAttributeNS(null, 'd', 'M8.5 12.566l-3.723-2.482-.277-.185-.277.185L.5 12.566V1h8v11.566z');
                            let flagText = document.createElement('span');
                            let flagText_text = document.createTextNode(' Добавить в меню');
                            flagText.appendChild(flagText_text);
                            svg.appendChild(path);
                            addToMenu.appendChild(svg);
                            addToMenu.appendChild(flagText);

                            //создание блока с ингредиентами
                            let title = document.createElement('h4')
                            let titleText = document.createTextNode('Ингредиенты: ');
                            title.appendChild(titleText);

                            let ingredientsEnumeration = document.createElement('ul');
                            ingredientsEnumeration.classList.add('ingredients_enumeration');
                            item.ingredients.forEach((item) => {
                                let ingredientName = document.createElement('span');
                                ingredientName.classList.add('ingredient_name');
                                let ingredientText = document.createTextNode(item.product_name);
                                ingredientName.appendChild(ingredientText);

                                let ingredientUnit = document.createElement('span');
                                ingredientUnit.classList.add('ingredient_unit');
                                let unitText = document.createTextNode(`${item.number} ${item.unit_name}`);
                                ingredientUnit.appendChild(unitText);

                                let ingredientRow = document.createElement('li');
                                ingredientRow.classList.add('ingredient_row');
                                ingredientRow.appendChild(ingredientName);
                                ingredientRow.appendChild(ingredientUnit);
                                ingredientsEnumeration.appendChild(ingredientRow);
                            });

                            //создание блока с картинкой
                            let dishImg = document.createElement('img');
                            dishImg.classList.add('dishImg');
                            dishImg.setAttribute('src', `http://food${item.img_path}`);
                            let imgWrap = document.createElement('div');
                            imgWrap.classList.add('imgWrap');
                            imgWrap.appendChild(dishImg);

                            dishDescription.appendChild(recipeCategory);
                            dishDescription.appendChild(recipeDishName);
                            dishDescription.appendChild(addToMenu);
                            dishDescription.appendChild(title);
                            dishDescription.appendChild(ingredientsEnumeration);

                            recipe.appendChild(imgWrap);
                            recipe.appendChild(dishDescription);

                            let recipes = document.querySelector('.recipes');
                            recipes.appendChild(recipe);

                            dishImgResize();
                            setBookmark();

                            history.pushState(null, null, `Http://food/cookbook/${button.dataset.page}`);

                            if (button.dataset.page === button.dataset.pageCount){
                                button.parentNode.removeChild(button);
                            }
                            button.dataset.page = parseInt(button.dataset.page) + 1;
                        });
                    }
                }
            });
        }
    }

    setBookmark(){
        let bookmark = document.querySelectorAll('.bookmark');

        function listener(event){
            let flag = event.currentTarget.querySelector('.flag');
            let text = event.currentTarget.querySelector('span');
            text.textContent = (flag.classList.toggle('fill')) ? ' Добавлено' : ' Добавить в меню';
            let xhr = new XMLHttpRequest();
            let form = new FormData();
            form.append('dish_id', event.currentTarget.dataset.dishid);
            xhr.open('POST', 'http://food/menu/addDish');
            xhr.send(form);
            xhr.onreadystatechange = function() {
                if (xhr.readyState != 4) return;
                if (xhr.status != 200) {
                    console.log(xhr.status + ': ' + xhr.statusText);
                } else {
                    console.log(xhr.responseText);
                }
            };
        }

        bookmark.forEach((item) => {
            if (!item.classList.contains('listener')) {
                item.addEventListener('click', listener);
                item.classList.add('listener');
            }
        });
    }
}

let cookbook = new Cookbook();
cookbook.dishImgResize();
cookbook.getMoreDish(cookbook.dishImgResize.bind(cookbook), cookbook.setBookmark.bind(cookbook));
cookbook.setBookmark();