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
$params = [];
if ($request !== ''){
    $request = explode('/', $request);
    if ($request[0] !== 'index.php'){
        $params['controller'] = $request[0];
        if (isset($request[1])) {
            if ((int)$request[1] > 0){
                $params['page'] = $request[1];
            } else {
                $params['action'] = $request[1];

                switch ($params['controller']){
                    case 'admin':
                        switch ($params['action']){
                            case 'editCategory':
                            case 'deleteDish':
                            case 'editDish':
                            case 'editIngredient':
                            case 'deleteIngredients':
                            case 'editUnit':
                            case 'deleteUnit':
                                $params['id'] = $request[2] ?? '';
                                break;
                            case 'ingredients':
                            case 'categories':
                            case 'units':
                                $params['page'] = $request[2] ?? 1;
                        }
                        break;
                    case 'cookbook':
                        switch ($params['action']){
                            case 'viewCategory':
                                $params['category'] = $request[2];
                                break;
                            case 'viewDish':
                                $params['dish'] = $request[2];
                                break;
                        }
                        break;
                }
            }
        }
    }
}

$controller = new Controller\Controller($params);
$controller->run();
