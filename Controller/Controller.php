<?php

namespace Controller;

class Controller{
    private $controller = 'index';
    private $action = 'index';
    private $model = NULL;

    public function __construct(){
        if (isset($_GET['controller'])) $this->controller = ucfirst($_GET['controller']);
        if (isset($_GET['action'])) $this->action = $_GET['action'];
        if (isset($_GET['model']) && $_GET['model'] !== '') $this->model = $_GET['model'];
    }

    public function run(){
        $class = __NAMESPACE__ . '\\' . $this->controller . 'Controller';
        $this->action .= 'Action';
        $controller = new $class($this->action);
        $controller->{$this->action}($this->model);
    }
}