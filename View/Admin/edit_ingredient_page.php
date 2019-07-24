<div class="mainContent">
    <div class="addItem">
        <form class="addClass" action="<?= BASE_URL; ?>/admin/editIngredient" method="post">
            <input class="input" type="text" name="name" autocomplete="off" value="<?= $product[0]['product_name'];?>" placeholder="Название">
            <input type="hidden" name="id" value="<?= $product[0]['id_product'];?>">
            <input class="inputBtn mFont" type="submit" value="Обновить">
        </form>
    </div>
</div>
</div>