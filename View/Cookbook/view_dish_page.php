<div class="recipesContent">
    <div class="dishRecipe">
        <div class="dishRecipe_header">
            <p class="recipe_category">
                <a class="recipe_link"
                   href="<?= BASE_URL; ?>/index.php?controller=cookbook&action=viewCategory&category=<?= $dish[0]['category_id']; ?>">
                    <?= $dish[0]['category_name']; ?>
                </a>
            </p>
            <h1 class="dishRecipe_title"><?= $dish[0]['name']; ?></h1>
        </div>
        <div class="dishRecipe_description">
            <div class="dishRecipe_img">
                <img class="dishRecipe_img__source" src="<?= BASE_URL; ?><?= $dish[0]['img_path']; ?>" alt="">
            </div>
            <div class="dishRecipe_ingredients">
                <h4 class="dishRecipe_ingredients_title">Ингридиенты: </h4>
                <ul class="ingredients_enumeration">
                    <?php foreach ($ingredients as $ingredient): ?>
                        <li class="ingredient_row">
                            <span class="ingredient_name"><?= $ingredient['product_name']; ?></span>
                            <span class="ingredient_unit"><?= ($ingredient['number'] == 0) ? '' : $ingredient['number']; ?> <?= $ingredient['unit_name']; ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="dishRecipe_text">
            <h3>Способ приготовления</h3>
            <?php
            $sentences = explode("\r\n", $dish[0]['recipe']);
            foreach ($sentences as $sentence) {
                echo "<p>" . $sentence . "</p>";
            }
            ?>
        </div>
    </div>
</div>
