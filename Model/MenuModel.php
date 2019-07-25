<?php

namespace Model;

use helpers\Database;
use helpers\MyException;
use Model\DBModel;


class MenuModel extends Model{
    public function __construct($action){
        parent::__construct($action);
    }

    public function indexAction(){
        if (isset($_SESSION['user']) && $_SESSION['user'] !== '') {
            $this->title = 'Создавай свое меню';
            $this->data['ingredients'] = [];
            $this->data['dish'] = $this->getDishByUser($_SESSION['user']['user_id']);
            for ($i = 0; $i < count($this->data['dish']); $i++) {
                $this->data['ingredients'][] = $this->getIngredientsByDish($this->data['dish'][$i]['id_dish']);
            }
            $this->data['ingredients'] = $this->sortIngredients($this->data['ingredients']);
            $this->data['user_ingredients'] = $this->getUserIngredients($_SESSION['user']['user_id']);
            $this->data['result_ingredients'] = $this->data['ingredients'];
            for ($i = 0; $i < count($this->data['result_ingredients']); $i++) {
                for ($j = 0; $j < count($this->data['user_ingredients']); $j++) {
                    if ($this->data['result_ingredients'][$i]['id_product'] == $this->data['user_ingredients'][$j]['id_product']) {
                        if (((int)$this->data['user_ingredients'][$j]['number'] - (int)$this->data['result_ingredients'][$i]['number']) >= 0) {
                            array_splice($this->data['result_ingredients'], $i, 1);
                            $i--;
                            continue 2;
                        } else {
                            $this->data['result_ingredients'][$i]['number'] = (int)$this->data['result_ingredients'][$i]['number'] - (int)$this->data['user_ingredients'][$j]['number'];
                        }
                    }
                }
            }
        } else {
            $this->data['login'] = true;
        }
    }

    public function addDishAction(){
        $dish_id = $_POST['dish_id'];
        $this->data['success'] = $this->addDish($_SESSION['user']['user_id'], $dish_id);
    }

    public function deleteDishAction($data){
        if (isset($data['id']) && $data['id'] !== ''){
            $this->data['success'] = $this->deleteDish($data['id'], (int)$_SESSION['user']['user_id']);
        }
    }

    private function sortIngredients($ingredients){
        $new_ingredients = [];
        foreach ($ingredients as $ingredient){
            foreach ($ingredient as $item) {
                $new_ingredients[] = $item;
            }
        }
        for ($i = 0; $i < count($new_ingredients); $i++){
            for ($j = $i + 1; $j < count($new_ingredients); $j++){
                if ($new_ingredients[$i]['id_product'] === $new_ingredients[$j]['id_product']){
                    $new_ingredients[$i]['number'] = (int)$new_ingredients[$i]['number'] + (int)$new_ingredients[$j]['number'];
                    array_splice($new_ingredients, $j, 1);
                }
            }
        }
        return $new_ingredients;
    }

    private function getDishByUser($user_id){
        $db = new Database($this->mysqli);
        $db->select(['name', 'category_name', 'user_cookbook.id_dish'], 'user_cookbook')
            ->left_join('dish', ['dish.id_dish', 'user_cookbook.id_dish'])
            ->left_join('dish_categories', ['dish_categories.category_id', 'dish.category_id'])
            ->where(['user_cookbook.user_id' => $user_id]);
        return MyException::db_query_result($this->mysqli, $db->get_query());
    }

    private function getIngredientsByDish($dish_id){
        $db = new Database($this->mysqli);
        $db->select(['product_name', 'number', 'unit_name', 'ingredients.id_product'], 'ingredients')
            ->left_join('products', ['ingredients.id_product', 'products.id_product'])
            ->left_join('units', ['ingredients.unit_id', 'units.unit_id'])
            ->where(['id_dish' => $dish_id]);
        return MyException::db_query_result($this->mysqli, $db->get_query());
    }

    private function addDish($user_id, $dish_id){
        $db = new Database($this->mysqli);
        $db->insert('user_cookbook', ['user_id' => $user_id, 'id_dish' => $dish_id]);
        return MyException::db_query($this->mysqli, $db->get_query());
    }

    private function deleteDish($id, $user_id){
        $db = new Database($this->mysqli);
        $db->delete('user_cookbook', ['id_dish' => $id, 'user_id' => $user_id]);
        return MyException::db_query($this->mysqli, $db->get_query());
    }

    private function getUserIngredients($user_id){
        $db = new Database($this->mysqli);
        $db->select(['product_name', 'number', 'unit_name', 'user_fridge.id_product'], 'user_fridge')
            ->left_join('products', ['products.id_product', 'user_fridge.id_product'])
            ->left_join('units', ['user_fridge.unit_id', 'units.unit_id'])
            ->where(['user_id' => $user_id]);
        return MyException::db_query_result($this->mysqli, $db->get_query());
    }
}