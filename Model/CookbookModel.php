<?php

namespace Model;

use helpers\Database;
use helpers\MyException;

class CookbookModel extends Model{
    private $items_per_page = 10;

    public function __construct($action){
        parent::__construct($action);
    }

    public function indexAction($data){
        $page = $data['page'] ?? 1;
        $this->data['dish'] = $this->get_dish(['page' => $page]);
        foreach ($this->data['dish'] as $key => $dish){
            $this->data['dish'][$key]['ingredients'] = $this->get_ingredients($dish['id_dish']);
        }
        $page_count = $this->get_dish_count();
        $this->data['next_page'] = $page + 1;
        $this->data['page_count'] = ceil((int)$page_count[0]['count'] / $this->items_per_page);
        $this->data['displayButton'] = ((int)$page_count[0]['count'] > $this->items_per_page * $page);
        $this->title = 'Кулинарная книга';
    }

    public function viewDishAction($data){
        if (isset($data['dish']) && $data['dish'] !== ''){
            $id = $data['dish'];
            $this->data['dish'] = $this->get_dish(['id' => $id]);
            $this->data['ingredients'] = $this->get_ingredients($id);
            $this->title = $this->data['dish'][0]['name'];
        }
    }

    public function getMoreDishAction(){
        if (isset($_POST['page']) && $_POST['page'] !== ''){
            $page = $_POST['page'];
            $this->data['dish'] = $this->get_dish_on_page($page);
            foreach ($this->data['dish'] as $key => $value){
                $this->data['dish'][$key]['ingredients'] = $this->get_ingredients($value['id_dish']);
            }
        }
    }

    private function get_dish_on_page($page = NULL){
        $db = new Database($this->mysqli);
        $db->select(['id_dish', 'name', 'img_path', 'category_name', 'recipe', 'dish.category_id'], 'dish')
            ->left_join('dish_categories', ['dish.category_id', 'dish_categories.category_id']);
        if ($page) $db->limit(($page - 1) * $this->items_per_page, $this->items_per_page);
        return MyException::db_query_result($this->mysqli, $db->get_query());
    }

    private function get_dish($array = NULL){
        $db = new Database($this->mysqli);
        $db->select(['id_dish', 'name', 'img_path', 'category_name', 'recipe', 'dish.category_id'], 'dish')
            ->left_join('dish_categories', ['dish.category_id', 'dish_categories.category_id']);
        if (isset($array['id'])) $db->where(['id_dish' => $array['id']]);
        if (isset($array['page'])) $db->limit(($array['page']) * $this->items_per_page);
        return MyException::db_query_result($this->mysqli, $db->get_query());
    }

    private function get_ingredients($dish_id){
        $db = new Database($this->mysqli);
        $db->select(['product_name', 'number', 'unit_name'], 'ingredients')
            ->left_join('products', ['ingredients.id_product', 'products.id_product'])
            ->left_join('units', ['ingredients.unit_id', 'units.unit_id'])
            ->where(['id_dish' => $dish_id]);
        return MyException::db_query_result($this->mysqli, $db->get_query());
    }

    private function get_dish_count(){
        $db = new Database($this->mysqli);
        $db->count('dish', 'name', 'count');
        return MyException::db_query_result($this->mysqli, $db->get_query());
    }
}