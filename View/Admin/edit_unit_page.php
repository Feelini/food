<div class="mainContent">
    <div class="addItem">
        <form class="addClass" action="<?= BASE_URL; ?>/admin/editUnit" method="post">
            <input class="input" type="text" name="name" autocomplete="off" value="<?= $unit[0]['unit_name'];?>" placeholder="Название">
            <input type="hidden" name="id" value="<?= $unit[0]['unit_id'];?>">
            <input class="inputBtn mFont" type="submit" value="Обновить">
        </form>
    </div>
</div>
</div>