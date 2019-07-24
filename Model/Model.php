<?php

namespace Model;


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
        $result_array = [];
        $sql = "SELECT `name`, `link` FROM menu";
        if (!($result=mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса меню: ' . mysqli_error($this->mysqli));
        while ($row = mysqli_fetch_assoc($result)){
            $result_array[] = $row;
        }
        mysqli_free_result($result);
        return $result_array;
    }

    private function connect() {
        if (!($mysqli = mysqli_connect(HOST, USER, PASSWORD, DATABASE)))
            die('Не удалось подключиться к базе данных: ' . mysqli_connect_error());
        if (!mysqli_set_charset($mysqli, 'utf8'))
            die('Ошибка при установке кодировки: ' . mysqli_error($mysqli));
        return $mysqli;
    }

    public function getData() {
        mysqli_close($this->mysqli);
        $this->data['title'] = $this->title;
        return $this->data;
    }
}