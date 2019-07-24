<?php

namespace Controller;
use Model\MenuModel;
use View\View;

class MenuController{
    private $model;
    private $controller = 'Menu';
    private $action;
    private $data;
    private $view;

    public function __construct($action){
        $this->action = $action;
    }

    public function run($model_data){
        $this->model = new MenuModel($this->action);
        $this->model->{$this->action}($model_data);
        $this->data = $this->model->getData();
        $this->view = new View();
    }

    public function indexAction(){
        if (isset($this->data['login'])){
            echo $this->view->render('login_page', $this->controller, $this->data);
        } else {
            echo $this->view->render('index_page', $this->controller, $this->data);
        }
    }

    public function addDishAction(){
        return $this->data['success'];
    }

    public function deleteDishAction(){
        if (isset($this->data['success'])){
            $this->view->redirect(['path' => '/menu']);
        }
    }
}