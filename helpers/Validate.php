<?php

namespace helpers;


class Validate{
    public function __construct(){
    }

    public function is_empty($field){
        if (isset($field) && $field !== '') {
            return false;
        } else{
            return 'Поле обязательно для заполнения';
        }
    }

    public function check_lenght($field, $min_len, $max_len){
        if (strlen($field) >= $min_len && strlen($field) <= $max_len){
            return false;
        } else {
            return "Поле должно содержать от {$min_len} до {$max_len} символов";
        }
    }

    public function is_letter_only($field){
        if (preg_match("/^[a-zA-Z]+$/", $field)){
            return false;
        } else {
            return "Поле должно содержать только буквы латинского алфавита";
        }
    }

    public function is_equal_pass($pass1, $pass2){
        if ($pass1 == $pass2){
            return false;
        } else {
            return "Пароли не совпадают";
        }
    }

    public function clean_field($field){
        $field = trim($field);
        $field = stripslashes($field);
        $field = htmlspecialchars($field);
        return $field;
    }

    public function is_exist_user($mysqli, $login){
        $login = $mysqli->real_escape_string($login);
        $query = "SELECT count(*) AS num FROM users WHERE login = '$login'";
        if ($result = $mysqli->query($query)) {
            $number = $result->fetch_assoc();
            if ((int)$number['num'] > 0) {
                return 'Такой пользователь уже существует';
            } else return false;
        } else die('Ошибка запроса пользователя: ' . $mysqli->error);
    }
}