<?php


namespace Controller;
use Model\IndexModel;
use View\View;


class IndexController{
    private $model;
    private $action;
    private $data;
    private $view;
    private $controller = 'Index';

    public function __construct($action){
        $this->action = $action;
        $this->model = new IndexModel($this->action);
        $this->model->{$this->action}();
        $this->data = $this->model->getData();
        $this->view = new View();
    }

    public function indexAction(){
        echo $this->view->render('index_page', $this->controller, $this->data);
    }
}