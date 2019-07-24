<div class="recipesContent">
    <h1 class="recipesContent_title">Рецепты</h1>
    <div class="recipes">
        <?php foreach ($dish as $item): ?>
            <div class="recipe">
                <div class="imgWrap">
                    <img class="dishImg" src="<?= BASE_URL; ?><?= $item['img_path']; ?>" alt="">
                </div>
                <div class="dishDescription">
                    <p class="recipe_category">
                        <a class="recipe_link"
                           href="<?= BASE_URL;?>/index.php?controller=cookbook&action=viewCategory&category=<?= $item['category_id'];?>">
                            <?= $item['category_name']; ?>
                        </a>
                    </p>
                    <p class="recipe_dishName">
                        <a class="recipe_link"
                           href="<?= BASE_URL;?>/index.php?controller=cookbook&action=viewDish&dish=<?= $item['id_dish'];?>">
                            <?= $item['name']; ?>
                        </a>
                    </p>
                    <div class="addToMenu bookmark" data-dishId="<?= $item['id_dish'];?>">
                        <svg viewBox="0 0 9 14" width="9" height="14">
                            <path d="M8.5 12.566l-3.723-2.482-.277-.185-.277.185L.5 12.566V1h8v11.566z" class="flag"></path>
                        </svg>
                        <span>Добавить в меню</span>
                    </div>
                    <h4>Ингридиенты: </h4>
                    <ul class="ingredients_enumeration">
                        <?php foreach ($item['ingredients'] as $ingredient): ?>
                            <li class="ingredient_row">
                                <span class="ingredient_name"><?= $ingredient['product_name']; ?></span>
                                <span class="ingredient_unit"><?= ($ingredient['number'] == 0) ? '' : $ingredient['number']; ?> <?= $ingredient['unit_name']; ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if ($displayButton):?>
        <div class="moreButton">
            <button class="inputBtn mFont" name="more" id="more"
                    data-url="<?= BASE_URL;?>/index.php?controller=cookbook&action=getMoreDish"
                    data-page="<?= $next_page;?>"
                    data-page-count="<?= $page_count;?>">Загрузить еще
            </button>
        </div>
    <?php endif;?>
</div>
<script src="<?= BASE_URL;?>/js/cookbook.js" defer></script>