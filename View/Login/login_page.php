<div class="loginContent">
    <div class="loginWrap">
        <form action="<?= BASE_URL;?>/login/enter" class="loginForm" method="post">
            <input type="text"
                   class="input large_input<?php echo (isset($errors['login']) && $errors['login'] !== '') ? ' red' : ''?>"
                   name="login"
                   autocomplete="off"
                   placeholder="Логин"
                   value="<?php echo (isset($login)) ? $login : ''?>">
            <div class="error">
                <?php echo (isset($errors['login'])) ? $errors['login'] : ''?>
            </div>
            <input type="password" class="input large_input<?php echo (isset($errors['pass']) && $errors['pass'] !== '') ? ' red' : ''?>" name="pass" placeholder="Пароль">
            <div class="error">
                <?php echo (isset($errors['pass'])) ? $errors['pass'] : '';?>
            </div>
            <input type="submit" class="inputBtn" value="Войти">
        </form>
    </div>
</div>