<div class="addItem_center">
    <form class="addClass" action="<?= BASE_URL; ?>/fridge/editIngredient" method="post">
        <select class="input" name="new_ingredient[product]">
            <option value="<?= $ingredient['id_product']; ?>">
                <?= $ingredient[0]['product_name']; ?>
            </option>
        </select>
        <input class="input small_input<?php echo (isset($error['number']) && $error['number'] !== '') ? ' red' : ''?>"
               type="text" name="new_ingredient[unit_number]" value="<?= $ingredient[0]['number'];?>" autocomplete="off">
        <select class="input small_input" name="new_ingredient[unit]">
            <?php foreach ($units as $unit): ?>
                <option value="<?= $unit['unit_id']; ?>"
                    <?php echo ($unit['unit_id'] == $ingredient[0]['unit_id']) ? 'selected' : ''?>>
                    <?= $unit['unit_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input class="inputBtn mFont" type="submit" value="Обновить">
    </form>
</div>
