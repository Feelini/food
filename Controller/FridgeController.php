<?php

namespace Controller;
use Model\FridgeModel;
use View\View;

class FridgeController{
    private $controller = 'Fridge';
    private $model;
    private $action;
    private $data;
    private $view;

    public function __construct($action){
        $this->action = $action;
        $this->model = new FridgeModel($this->action);
        $this->model->{$this->action}();
        $this->data = $this->model->getData();
        $this->view = new View();
    }

    public function indexAction(){
        if (isset($this->data['login'])){
            echo $this->view->render('login_page', $this->controller, $this->data);
        } else if (isset($this->data['success'])){
            $this->view->redirect(['path' => '/index.php?controller=fridge']);
        } else {
            echo $this->view->render('index_page', $this->controller, $this->data);
        }
    }

    public function deleteIngredientAction(){
        if (isset($this->data['success'])){
            $this->view->redirect(['path' => '/index.php?controller=fridge']);
        }
    }

    public function editIngredientAction(){
        if (isset($this->data['success'])){
            $this->view->redirect(['path' => '/index.php?controller=fridge']);
        }
        echo $this->view->render('edit_page', $this->controller, $this->data);
    }
}