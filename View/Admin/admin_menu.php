<script defer src="<?= BASE_URL;?>/js/admin_menu.js"></script>
<div class="adminContent">
    <div class="adminSidebar">
        <div class="button_wrap">
            <span id="slideButton" class="adminSidebar_button">
                Кулинарная книга
            </span>
            <div id="slide" class="subButtons">
                <span class="adminSidebar_subButton">
                    <a href="<?= BASE_URL; ?>/index.php?controller=admin"
                       class="adminSidebar_subLink">Редактор рецептов</a>
                </span>
                <span class="adminSidebar_subButton">
                    <a href="<?= BASE_URL; ?>/index.php?controller=admin&action=ingredients"
                       class="adminSidebar_subLink">Редактор ингридиентов</a>
                </span>
                <span class="adminSidebar_subButton">
                    <a href="<?= BASE_URL; ?>/index.php?controller=admin&action=categories"
                       class="adminSidebar_subLink">Редактор категорий</a>
                </span>
                <span class="adminSidebar_subButton">
                    <a href="<?= BASE_URL; ?>/index.php?controller=admin&action=units"
                       class="adminSidebar_subLink">Редактор мер</a>
                </span>
            </div>
        </div>
    </div>