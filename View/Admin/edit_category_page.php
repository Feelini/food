<div class="mainContent">
    <div class="addItem">
        <form class="addClass" action="<?= BASE_URL; ?>/index.php?controller=admin&action=editCategory" method="post">
            <input class="input" type="text" name="name" autocomplete="off" value="<?= $category[0]['category_name'];?>" placeholder="Название">
            <input type="hidden" name="id" value="<?= $category[0]['category_id'];?>">
            <input class="inputBtn mFont" type="submit" value="Обновить">
        </form>
    </div>
</div>
</div>