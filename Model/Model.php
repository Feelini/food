<?php

namespace Model;

use helpers\Database;
use helpers\MyException;
use mysqli;

class Model{
    protected $action;
    protected $data;
    protected $mysqli;
    protected $title;

    public function __construct($action){
        $this->action = $action;
        $this->mysqli = $this->connect();
        $this->data['menu'] = $this->get_menu();
    }

    private function get_menu(){
        $db = new Database($this->mysqli);
        $db->select(['name', 'link'], 'menu');
        return MyException::db_query_result($this->mysqli, $db->get_query());
    }

    private function connect() {
        try{
            if (!($mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE)))
                throw new MyException('Не удалось подключиться к базе данных: ' . $mysqli->connect_error);
            if (!$mysqli->set_charset('utf8'))
                throw new MyException('Ошибка при установке кодировки: ' . $mysqli->error);
        }
        catch (MyException $ex){
            return $ex->getMessage();
        }
        return $mysqli;
    }

    public function getData() {
        $this->mysqli->close();
        $this->data['title'] = $this->title;
        return $this->data;
    }
}