<?php

namespace Model;

use helpers\Captcha;
use helpers\Database;
use helpers\MyException;
use helpers\Validate;

class LoginModel extends Model{
    private $min_pass_len = 5;
    private $max_pass_len = 30;
    private $min_login_len = 3;
    private $max_login_len = 10;

    public function __construct($action){
        parent::__construct($action);
    }

    public function indexAction(){
        $this->title = 'Вход';
    }

    public function registrationAction(){
        $this->title = 'Регистрация';
        $this->data['captcha_question'] = Captcha::getCaptchaQuestion();
    }

    public function enterAction(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $validate = new Validate();
            $login = $validate->clean_field($_POST['login']);
            $pass = $validate->clean_field($_POST['pass']);

            if ($error = $validate->is_empty($login)){
                $this->data['errors']['login'] = $error;
            } elseif ($error = $validate->check_lenght($login, $this->min_login_len, $this->max_login_len)){
                $this->data['errors']['login'] = $error;
            } elseif ($error = $validate->is_letter_only($login)){
                $this->data['errors']['login'] = $error;
            }

            if ($error = $validate->is_empty($pass)){
                $this->data['errors']['pass'] = $error;
            } elseif ($error = $validate->check_lenght($pass, $this->min_pass_len, $this->max_pass_len)){
                $this->data['errors']['pass'] = $error;
            }

            if (!isset($this->data['errors'])){
                $user = $this->get_user($login);
                if (isset($user)){
                    if (password_verify($pass, $user[0]['pass'])){
                        $_SESSION['user']['user_id'] = $user[0]['user_id'];
                        $_SESSION['user']['is_admin'] = $user[0]['is_admin'];
                        $_SESSION['user']['login'] = $user[0]['login'];
                    }
                } else {
                    $this->data['errors']['login'] = 'Такого пользователя не существует';
                    $this->data['login'] = $login;
                }
            }
        }
        $this->title = 'Вход';
    }

    public function registerAction(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $validate = new Validate();
            $login = $validate->clean_field($_POST['login']);
            $pass = $validate->clean_field($_POST['pass']);
            $pass2 = $validate->clean_field($_POST['pass2']);
            $captcha = $validate->clean_field($_POST['captcha']);

            if ($error = $validate->is_empty($login)){
                $this->data['errors']['login'] = $error;
            } elseif ($error = $validate->check_lenght($login, $this->min_login_len, $this->max_login_len)){
                $this->data['errors']['login'] = $error;
            } elseif ($error = $validate->is_letter_only($login)){
                $this->data['errors']['login'] = $error;
            } elseif ($error = $validate->is_exist_user($this->mysqli, $login)){
                $this->data['errors']['login'] = $error;
            }

            if ($error = $validate->is_empty($pass)){
                $this->data['errors']['pass'] = $error;
            } elseif ($error = $validate->check_lenght($pass, $this->min_pass_len, $this->max_pass_len)){
                $this->data['errors']['pass'] = $error;
            }

            if ($error = $validate->is_empty($pass2)){
                $this->data['errors']['pass2'] = $error;
            } elseif ($error = $validate->check_lenght($pass2, $this->min_pass_len, $this->max_pass_len)){
                $this->data['errors']['pass2'] = $error;
            } elseif ($error = $validate->is_equal_pass($pass, $pass2)){
                $this->data['errors']['pass'] = $error;
            }

            if ($error = $validate->is_empty($captcha)){
                $this->data['errors']['captcha'] = $error;
            } elseif (!Captcha::isValidCaptcha($captcha)){
                $this->data['errors']['captcha'] = 'Неверный ответ';
                $this->data['captcha_question'] = Captcha::generateCaptchaQuestion();
            }

            if(!isset($this->data['errors'])){
                $this->data['success'] = !($this->add_user($login, password_hash($pass, PASSWORD_DEFAULT)));
                if ($this->data['success']){
                    $_SESSION['user']['login'] = $login;
                    $_SESSION['user']['user_id'] = $this->mysqli->insert_id;
                }
            }
        }
        $this->title = 'Регистрация';
    }

    public function logoutAction(){}

    private function get_user($login){
        $db = new Database($this->mysqli);
        $db->select(['user_id', 'login', 'pass', 'is_admin'], 'users')
            ->where(['login' => $login]);
        return MyException::db_query_result($this->mysqli, $db->get_query());
    }

    private function add_user($login, $pass){
        $db = new Database($this->mysqli);
        $db->insert('users', ['login' => $login, 'pass' => $pass]);
        return MyException::db_query($this->mysqli, $db->get_query());
    }
}