<div class="addDishContent">
    <form enctype="multipart/form-data" class="addDishContent_form" action="<?= BASE_URL; ?>/admin/editDish" method="post">
        <div class="addDishContent_name">
            <h3 class="addDishContent_title">Название</h3>
            <input class="input" value="<?= $dish[0]['name'];?>" type="text" name="new_dish[name]" autocomplete="off">
            <input type="hidden" value="<?= $dish[0]['id_dish'];?>" name="new_dish[id_dish]">
        </div>
        <div class="addDishContent_img">
            <h3 class="addDishContent_title">Фото</h3>
            <p><strong><?= $dish[0]['img_path'];?></strong></p>
            <input class="addDishContent_imgInput" name="dish_img" type="file" />
        </div>
        <div class="addDishContent_category">
            <h3 class="addDishContent_title">Раздел</h3>
            <select class="input" name="new_dish[category_id]">
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['category_id']; ?>"
                        <?= ($category['category_id'] === $dish[0]['category_id']) ? 'selected' : '';?>>
                        <?= $category['category_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="addDishContent_recipe">
            <h3 class="addDishContent_title">Рецепт</h3>
            <textarea name="new_dish[recipe]" cols="93" rows="15"><?= $dish[0]['recipe'];?></textarea>
        </div>
        <div id="addDishContent_products" class="addDishContent_products">
            <h3 class="addDishContent_title">Ингредиенты</h3>
            <?php foreach ($ingredients as $ingredient):?>
            <div class="addDishContent_product">
                <select class="input" name="new_dish[products][]">
                    <?php foreach ($products as $product): ?>
                        <option value="<?= $product['id_product']; ?>"
                            <?= ($product['id_product'] === $ingredient['id_product']) ? 'selected' : '';?>>
                            <?= $product['product_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input class="input small_input" type="text" name="new_dish[unit_number][]"
                       value="<?= $ingredient['number'];?>" autocomplete="off">
                <select class="input small_input" name="new_dish[units][]">
                    <?php foreach ($units as $unit): ?>
                        <option value="<?= $unit['unit_id']; ?>"
                            <?= ($unit['unit_id'] === $ingredient['unit_id']) ? 'selected' : '';?>>
                            <?= $unit['unit_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="removeButton">
                    <svg viewBox="2 2 26 26" width="26" height="26">
                        <path d="m15,3c-6.627,0 -12,5.373 -12,12c0,6.627 5.373,12 12,12s12,-5.373 12,-12c0,-6.627 -5.373,-12 -12,-12zm6,13l-12,0c-0.552,0 -1,-0.447 -1,-1s0.448,-1 1,-1l12,0c0.552,0 1,0.447 1,1s-0.448,1 -1,1z"
                              style="fill: #b70300"/>
                    </svg>
                </div>
            </div>
            <?php endforeach;?>
        </div>
        <div class="newProduct">
            <a class="addButton" id="addButton" href="#">
                <svg viewBox="2 2 26 26" width="26" height="26">
                    <path d="M15,3C8.373,3,3,8.373,3,15c0,6.627,5.373,12,12,12s12-5.373,12-12C27,8.373,21.627,3,15,3z M21,16h-5v5  c0,0.553-0.448,1-1,1s-1-0.447-1-1v-5H9c-0.552,0-1-0.447-1-1s0.448-1,1-1h5V9c0-0.553,0.448-1,1-1s1,0.447,1,1v5h5  c0.552,0,1,0.447,1,1S21.552,16,21,16z"
                          style="fill: #01eb00"/>
                </svg>
                Добавить ингредиент
            </a>
        </div>
        <div class="addDishContent_button">
            <input class="inputBtn mFont" type="submit" value="Обновить">
        </div>
    </form>
</div>
</div>
<script src="<?= BASE_URL;?>/js/edit_dish.js"></script>
