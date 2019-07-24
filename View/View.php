<?php

namespace View;


class View{
    public function redirect($path){
        ob_start();
        extract($path);
        include 'View/template/redirect.php';
        ob_get_clean();
    }

    public function render($view, $controller, $vars){
        ob_start();
        extract($vars);
        include 'View/Template/head.php';
        include 'View/Template/header.php';
        if ($controller === 'Admin') include 'View/Admin/admin_menu.php';
        include 'View/' . $controller . '/' . $view .'.php';
        include 'View/Template/footer.php';
        return ob_get_clean();
    }
}