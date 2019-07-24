<header>
    <?php if (isset($_SESSION['user'])): ?>
        <div class="logoutButton">
            <span class="userWelcom">Добро пожаловать, <?= $_SESSION['user']['login']; ?></span>
            <a href="<?= BASE_URL; ?>/login/logout" class="loginLink">Выйти</a>
            <?php if (isset($_SESSION['user']['is_admin']) && ((int)$_SESSION['user']['is_admin'] === 1)):?>
                <a href="<?= BASE_URL; ?>/admin" class="loginLink">Админка</a>
            <?php endif;?>
        </div>
    <?php else : ?>
        <div class="loginButtons">
            <a href="<?= BASE_URL; ?>/login" class="loginLink">Войти</a>
            <a href="<?= BASE_URL; ?>/login/registration" class="loginLink">Зарегистрироваться</a>
        </div>
    <?php endif; ?>
    <ul class="menu">
        <?php foreach ($menu as $item): ?>
            <li class="menu_item">
                <a class="menu_link" href="<?= $item['link']; ?>"><?= $item['name']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</header>