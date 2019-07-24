<?php
session_start();
spl_autoload_register(function ($class) {
    $file = str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

require 'config.php';
$controller = new Controller\Controller();
$controller->run();
