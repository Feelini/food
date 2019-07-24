<?php

namespace Controller;

class Controller{
    private $controller = 'index';
    private $action = 'index';
    private $model = NULL;

    public function __construct($controller = null, $action = null){
        if ($controller) $this->controller = ucfirst($controller);
        if ($action) $this->action = $action;
        if (isset($_GET['model']) && $_GET['model'] !== '') $this->model = $_GET['model'];
    }

    public function run(){
        $class = __NAMESPACE__ . '\\' . $this->controller . 'Controller';
        $this->action .= 'Action';
        $controller = new $class($this->action);
        $controller->{$this->action}($this->model);
    }
}