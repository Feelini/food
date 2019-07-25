<?php

namespace helpers;
use Exception;
use Throwable;

class MyException extends Exception{
    public function __construct($message = "", $code = 0, Throwable $previous = null){
        parent::__construct($message, $code, $previous);
    }

    public static function db_query($mysqli, $query){
        try{
            if (!($result = $mysqli->query($query)))
                throw new MyException('Ошибка: ' . $mysqli->error);
        }
        catch (Exception $ex){
            return $ex->getMessage();
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
        catch (Exception $ex){
            return $ex->getMessage();
        }
        return $result_array;
    }
}