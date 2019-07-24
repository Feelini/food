<?php


namespace Model;


class IndexModel extends Model{
    public function __construct($action){
        parent::__construct($action);
    }

    public function indexAction(){
        $this->title = 'Кухонный органайзер';
    }
}