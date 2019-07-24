<div class="loginContent">
    <div class="loginWrap">
<!--        <h2 class="loginTitle">Зарегистрироваться</h2>-->
        <form action="<?= BASE_URL;?>/login/register" class="loginForm" method="post">
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
                <?php echo (isset($errors['pass'])) ? $errors['pass'] : ''?>
            </div>
            <input type="password" class="input large_input<?php echo (isset($errors['pass2']) && $errors['pass2'] !== '') ? ' red' : ''?>" name="pass2" placeholder="Повторите пароль">
            <div class="error">
                <?php echo (isset($errors['pass2'])) ? $errors['pass2'] : ''?>
            </div>
            <input type="submit" class="inputBtn" value="Зарегистрироваться">
        </form>
    </div>
</div>