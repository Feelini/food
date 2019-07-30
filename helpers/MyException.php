<?php

namespace helpers;
use Exception;
use Throwable;
use View\View;

class MyException extends Exception{
    public function __construct($message = "", $code = 0, Throwable $previous = null){
        parent::__construct($message, $code, $previous);
    }

    public static function db_query($mysqli, $query){
        try{
            if (!($result = $mysqli->query($query)))
                throw new MyException('Ошибка: ' . $mysqli->error);
        }
        catch (MyException $ex){
            $view = new View();
            $db = new Database($mysqli);
            $db->select(['name', 'link'], 'menu');
            echo $view->render('error_view', 'Exception', [
                'message' => $ex->getMessage(),
                'menu' => MyException::db_query_result($mysqli, $db->get_query())
            ]);
            die;
        }
        return false;
    }

    public static function db_query_result($mysqli, $query){
        try{
            $result_array = [];
            if (!($result = $mysqli->query($query)))
                throw new MyException('Ошибка: ' . $mysqli->error);
            while ($row = $result->fetch_assoc()){
                $result_array[] = $row;
            }
            $result->free_result();
        }
        catch (MyException $ex){
            $view = new View();
            $db = new Database($mysqli);
            $db->select(['name', 'link'], 'menu');
            echo $view->render('error_view', 'Exception', [
                'message' => $ex->getMessage(),
                'menu' => MyException::db_query_result($mysqli, $db->get_query())
            ]);
            die;
        }
        return $result_array;
    }
}