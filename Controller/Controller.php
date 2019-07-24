<?php

namespace Controller;

class Controller{
    private $controller = 'index';
    private $action = 'index';
    private $model_data = [];

    public function __construct($params){
        if (isset($params['controller'])) $this->controller = ucfirst($params['controller']);
        if (isset($params['action'])) $this->action = $params['action'];
        if (isset($params['id'])) $this->model_data['id'] = $params['id'];
        if (isset($params['page'])) $this->model_data['page'] = $params['page'];
        if (isset($params['dish'])) $this->model_data['dish'] = $params['dish'];
    }

    public function run(){
        $class = __NAMESPACE__ . '\\' . $this->controller . 'Controller';
        $this->action .= 'Action';
        $controller = new $class($this->action);
        $controller->run($this->model_data);
        $controller->{$this->action}();
    }
}