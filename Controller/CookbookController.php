<?php

namespace Controller;
use Model\CookbookModel;
use View\View;

class CookbookController{
    private $model;
    private $action;
    private $data;
    private $view;
    private $controller = 'Cookbook';

    public function __construct($action = 'index'){
        $this->action = $action;
    }

    public function run($model_data){
        $this->model = new CookbookModel($this->action);
        $this->model->{$this->action}($model_data);
        $this->data = $this->model->getData();
        $this->view = new View();
    }

    public function indexAction(){
        echo $this->view->render('index_page', $this->controller, $this->data);
    }

    public function viewDishAction(){
        echo $this->view->render('view_dish_page', $this->controller, $this->data);
    }

    public function getMoreDishAction(){
        echo json_encode($this->data['dish']);
    }
}