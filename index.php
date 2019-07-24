<?php
session_start();
spl_autoload_register(function ($class) {
    $file = str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

require 'config.php';

$request = trim($_SERVER['REQUEST_URI'], '/');
if ($request !== ''){
    $request = explode('/', $request);
    if ($request[0] !== 'index.php'){
        switch (count($request)){
            case 1:
                $request_controller = $request[0];
                $controller = new Controller\Controller($request_controller);
                break;
            case 2:
                $request_controller = $request[0];
                $request_action = $request[1];
                $controller = new Controller\Controller($request_controller, $request_action);
        }
    } else {
        $controller = new Controller\Controller();
    }
} else {
    $controller = new Controller\Controller();
}


$controller->run();
