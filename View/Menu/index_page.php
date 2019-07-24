<div class="userMenu">
    <form action="" class="dishForm">
        <table class="dishContent">
            <thead>
            <tr>
                <th>#</th>
                <th>№</th>
                <th>Название</th>
                <th>Раздел</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php for ($i = 0; $i < count($dish); $i++): ?>
                <tr>
                    <td><input type="checkbox" name="id_dish[]" value="<?= $dish[$i]['id_dish']; ?>"></td>
                    <td><?= ($i + 1); ?></td>
                    <td><?= $dish[$i]['name']; ?></td>
                    <td><?= $dish[$i]['category_name']; ?></td>
                    <td>
                        <a class="adminLink deleteButton"
                           href="<?= BASE_URL; ?>/menu/deleteDish/<?= $dish[$i]['id_dish']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 viewBox="0 0 26 26" version="1.1" width="26px" height="26px">
                                <g id="surface1">
                                    <path class="adminButton"
                                          d="M 11 -0.03125 C 10.164063 -0.03125 9.34375 0.132813 8.75 0.71875 C 8.15625 1.304688 7.96875 2.136719 7.96875 3 L 4 3 C 3.449219 3 3 3.449219 3 4 L 2 4 L 2 6 L 24 6 L 24 4 L 23 4 C 23 3.449219 22.550781 3 22 3 L 18.03125 3 C 18.03125 2.136719 17.84375 1.304688 17.25 0.71875 C 16.65625 0.132813 15.835938 -0.03125 15 -0.03125 Z M 11 2.03125 L 15 2.03125 C 15.546875 2.03125 15.71875 2.160156 15.78125 2.21875 C 15.84375 2.277344 15.96875 2.441406 15.96875 3 L 10.03125 3 C 10.03125 2.441406 10.15625 2.277344 10.21875 2.21875 C 10.28125 2.160156 10.453125 2.03125 11 2.03125 Z M 4 7 L 4 23 C 4 24.652344 5.347656 26 7 26 L 19 26 C 20.652344 26 22 24.652344 22 23 L 22 7 Z M 8 10 L 10 10 L 10 22 L 8 22 Z M 12 10 L 14 10 L 14 22 L 12 22 Z M 16 10 L 18 10 L 18 22 L 16 22 Z "/>
                                </g>
                            </svg>
                        </a>
                    </td>
                </tr>
            <?php endfor; ?>
            </tbody>
        </table>
    </form>
    <div class="needIngredients">
        <table class="userMenuIngredients">
            <thead class="userMenuIngredients_head">
                <th>Вам необходимы следующие ингредиенты:</th>
                <th>У Вас уже есть:</th>
                <th>Недостающие ингредиенты:</th>
            </thead>
            <tbody class="userMenuIngredients_body">
            <?php foreach ($ingredients as $ingredient): ?>
                <tr>
                    <td class="ingredient_row short">
                        <span class="ingredient_name"><?= $ingredient['product_name']; ?></span>
                        <span class="ingredient_unit"><?= ($ingredient['number'] == 0) ? '' : $ingredient['number']; ?> <?= $ingredient['unit_name']; ?></span>
                    </td>
                    <td class="ingredient_row short">
                        <?php foreach ($user_ingredients as $key => $user_ingredient): ?>
                            <?php if ($ingredient['id_product'] == $user_ingredient['id_product']):?>
                                <span class="ingredient_name"><?= $user_ingredient['product_name']; ?></span>
                                <span class="ingredient_unit"><?= ($user_ingredient['number'] == 0) ? '' : $user_ingredient['number']; ?> <?= $user_ingredient['unit_name']; ?></span>
                            <?php array_splice($user_ingredients, $key, 1);?>
                            <?php endif;?>
                        <?php endforeach;?>
                    </td>
                    <td class="ingredient_row short">
                        <?php foreach ($result_ingredients as $key => $result_ingredient): ?>
                            <?php if ($ingredient['id_product'] == $result_ingredient['id_product']):?>
                                <span class="ingredient_name"><?= $result_ingredient['product_name']; ?></span>
                                <span class="ingredient_unit"><?= ($result_ingredient['number'] == 0) ? '' : $result_ingredient['number']; ?> <?= $result_ingredient['unit_name']; ?></span>
                            <?php endif;?>
                        <?php endforeach;?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script defer src="<?= BASE_URL;?>/js/user_menu.js"></script>