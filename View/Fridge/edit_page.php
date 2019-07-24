<div class="addItem_center">
    <form class="addClass" action="<?= BASE_URL; ?>/index.php?controller=fridge&action=editIngredient" method="post">
        <select class="input" name="new_ingredient[product]">
            <option value="<?= $ingredient['id_product']; ?>">
                <?= $ingredient['product_name']; ?>
            </option>
        </select>
        <input class="input small_input<?php echo (isset($error['number']) && $error['number'] !== '') ? ' red' : ''?>"
               type="text" name="new_ingredient[unit_number]" value="<?= $ingredient['number'];?>" autocomplete="off">
        <select class="input small_input" name="new_ingredient[unit]">
            <?php foreach ($units as $unit): ?>
                <option value="<?= $unit['unit_id']; ?>"
                    <?php echo ($unit['unit_id'] == $ingredient['unit_id']) ? 'selected' : ''?>>
                    <?= $unit['unit_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input class="inputBtn mFont" type="submit" value="Обновить">
    </form>
</div>
