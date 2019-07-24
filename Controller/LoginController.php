<?php

namespace Controller;
use Model\LoginModel;
use View\View;

class LoginController{
    private $model;
    private $action;
    private $data;
    private $view;
    private $controller = 'Login';

    public function __construct($action){
        $this->data['success']  = false;
        $this->action = $action;
        $this->view = new View();
        $this->model = new LoginModel($this->action);
        $this->model->{$this->action}();
        $this->data = $this->model->getData();
    }

    public function loginAction(){
        echo $this->view->render('login_page', $this->controller, $this->data);
    }

    public function enterAction(){
        if (isset($_SESSION['user'])){
            $this->view->redirect(['path' => '/index.php']);
        } else {
            echo $this->view->render('login_page', $this->controller, $this->data);
        }
    }

    public function registrationAction(){
        echo $this->view->render('registration_page', $this->controller, $this->data);
    }

    public function registerAction(){
        if (isset($this->data['success'])){
            $this->view->redirect(['path' => '/index.php']);
        } else {
            echo $this->view->render('registration_page', $this->controller, $this->data);
        }
    }

    public function logoutAction(){
        session_destroy();
        $this->view->redirect(['path' => '/index.php']);
    }
}