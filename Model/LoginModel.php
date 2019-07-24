<?php

namespace Model;

class LoginModel extends Model{
    private $login;
    private $correct_login = true;
    private $correct_pass = true;
    private $pass;
    private $pass2;
    private $min_symbol = 3;
    private $max_symbol = 30;

    public function __construct($action){
        parent::__construct($action);
    }

    public function loginAction(){
        $this->title = 'Вход';
    }

    public function registrationAction(){
        $this->title = 'Регистрация';
    }

    public function enterAction(){
        $this->login = $_POST['login'];
        if ($error = $this->test_field($this->login)){
            $data['errors']['login'] = $error;
            $this->correct_login = false;
        }
        if ($error = $this->test_field(trim($_POST['pass']))){
            $data['errors']['pass'] = $error;
            $this->correct_pass = false;
        }
        if ($this->correct_login && $this->correct_pass){
            $this->pass = md5($_POST['pass']);
            if ($user = $this->is_login($this->mysqli, $this->login, $this->pass)) {
                $_SESSION['user'] = $user[0];
            } else {
                $this->data['errors']['login'] = 'Ошибка при авторизации';
                $this->data['login'] = $this->login;
            }
        }
        $this->title = 'Вход';
    }

    public function registerAction(){
        $this->login = $_POST['login'];
        if ($error = $this->test_field($this->login)){
            $this->data['errors']['login'] = $error;
            $this->correct_login = false;
        }
        if ($error = $this->test_field(trim($_POST['pass']))){
            $this->data['errors']['pass'] = $error;
            $this->correct_pass = false;
        }
        if ($error = $this->test_field(trim($_POST['pass2']))){
            $this->data['errors']['pass2'] = $error;
            $this->correct_pass = false;
        }
        $this->pass = md5(trim($_POST['pass']));
        $this->pass2 = md5(trim($_POST['pass2']));
        if ($this->is_exist($this->mysqli, $this->login)) {
            $this->data['errors']['login'] = 'Такой пользователь уже существует';
            $this->correct_login = false;
            $this->data['login'] = $this->login;
        }
        if ($this->pass !== $this->pass2) {
            $this->data['errors']['pass'] = 'Пароли не совпадают';
            $this->correct_pass = false;
        }
        if ($this->correct_login && $this->correct_pass){
            $this->data['success'] = ($this->add_user($this->mysqli, $this->login, $this->pass));
            if ($this->data['success']){
                $_SESSION['user']['login'] = $this->login;
                $_SESSION['user']['user_id'] = mysqli_insert_id($this->mysqli);
            }
        }
        $this->title = 'Регистрация';
    }

    public function logoutAction(){}

    private function test_field($field){
        $error = '';
        if (!(isset($field) && $field !== '')) {
            $error = 'Поле обязательно для заполнения';
        } else if (!(mb_strlen($field) >= $this->min_symbol && mb_strlen($field) <= $this->max_symbol)){
            $error = "Поле должно содержать от {$this->min_symbol} до {$this->max_symbol} символов";
        }
        return $error;
    }

    private function is_exist($mysqli, $login){
        $result_array = [];
        $sql = "SELECT count(*) FROM users WHERE login = '$login'";
        if (!($result = mysqli_query($mysqli, $sql)))
            die('Ошибка запроса пользователя: ' . mysqli_error($mysqli));
        while ($row = mysqli_fetch_array($result)) {
            $result_array[] = $row;
        }
        mysqli_free_result($result);
        return ((int)$result_array[0][0] > 0);
    }

    private function is_login($mysqli, $login, $pass){
        $result_array = [];
        $sql = "SELECT `user_id`, `login`, `is_admin` FROM users WHERE login = '$login' AND pass = '$pass'";
        if (!($result = mysqli_query($mysqli, $sql)))
            die('Ошибка запроса пользователя: ' . mysqli_error($mysqli));
        while ($row = mysqli_fetch_assoc($result)) {
            $result_array[] = $row;
        }
        mysqli_free_result($result);
        return $result_array;
    }

    private function add_user($mysqli, $login, $pass){
        $sql = "INSERT INTO `users` (`login`, `pass`) VALUES ('$login', '$pass')";
        if (!($result = mysqli_query($mysqli, $sql)))
            die('Ошибка запроса пользователя: ' . mysqli_error($mysqli));
        return true;
    }
}