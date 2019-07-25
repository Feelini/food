<?php

namespace Model;

use helpers\Database;
use helpers\MyException;

class FridgeModel extends Model{
    private $ingredient_per_page = 10;

    public function __construct($action){
        parent::__construct($action);
    }

    public function indexAction($data){
        if (isset($_SESSION['user']) && $_SESSION['user'] !== ''){
            $user_id = $_SESSION['user']['user_id'];
            if (isset($_POST['new_ingredient']) && $_POST['new_ingredient'] !== ''){
                if (isset($_POST['new_ingredient']['unit_number']) && $_POST['new_ingredient']['unit_number'] !== ''){
                    $this->data['success'] = $this->addUserIngredient(
                        (int)$_POST['new_ingredient']['product'],
                        (int)$_POST['new_ingredient']['unit_number'],
                        (int)$_POST['new_ingredient']['unit'],
                        (int)$_SESSION['user']['user_id']
                    );
                } else {
                    $this->data['error']['number'] = 'Поле обязательно для заполнения.';
                }
            }
            $this->title = 'Держи холодильник под рукой';
            $page = $data['page'] ?? 1;
            $this->data['products'] = $this->getAllProducts();
            $this->data['units'] = $this->getAllUnits();
            $this->data['ingredients'] = $this->getUserIngredients($user_id, $page);
            $user_ingredients_count = $this->getUserIngredientsCount($user_id);
            $user_ingredients_count = $user_ingredients_count[0]['ingredients_count'];
            $this->data['ingredients_per_page'] = $this->ingredient_per_page;
            $this->data['pages_count'] = ceil((int)$user_ingredients_count / $this->ingredient_per_page);
            $this->data['current_page'] = $page;
        } else {
            $this->data['login'] = true;
        }

    }

    public function deleteIngredientAction($data){
        if (isset($data['id']) && $data['id'] !== ''){
            $id = (int)$data['id'];
            $user_id = (int)$_SESSION['user']['user_id'];
            $this->data['success'] = $this->deleteIngredient($id, $user_id);
        }
    }

    public function editIngredientAction($data){
        if (isset($data['id']) && $data['id'] !== ''){
            $id = (int)$data['id'];
            $user_id = (int)$_SESSION['user']['user_id'];
            $this->data['ingredient'] = $this->getIngredientById($id, $user_id);
            $this->data['ingredient']['id_product'] = $id;
            $this->data['units'] = $this->getAllUnits();
        } else if (isset($_POST['new_ingredient']) && $_POST['new_ingredient'] !== ''){
            $id_product = $_POST['new_ingredient']['product'];
            $number = $_POST['new_ingredient']['unit_number'];
            $unit_id = $_POST['new_ingredient']['unit'];
            $user_id = $_SESSION['user']['user_id'];
            $this->data['success'] = $this->updateIngredient($id_product, $number, $unit_id, $user_id);
        }
    }

    private function getAllProducts(){
        $db = new Database($this->mysqli);
        $db->select(['id_product', 'product_name'], 'products');
        return MyException::db_query_result($this->mysqli, $db->get_query());
    }

    private function getAllUnits(){
        $db = new Database($this->mysqli);
        $db->select(['unit_id', 'unit_name'], 'units');
        return MyException::db_query_result($this->mysqli, $db->get_query());
    }

    private function getUserIngredients($id, $page){
        $db = new Database($this->mysqli);
        $db->select(['user_fridge.id_product', 'product_name', 'number', 'unit_name'], 'user_fridge')
            ->left_join('units', ['units.unit_id', 'user_fridge.unit_id'])
            ->left_join('products', ['products.id_product', 'user_fridge.id_product'])
            ->where(['user_id' => $id]);
        if (isset($page)) $db->limit((($page - 1) * $this->ingredient_per_page), $this->ingredient_per_page);
        return MyException::db_query_result($this->mysqli, $db->get_query());
    }

    private function addUserIngredient($id_product, $number, $unit_id, $user_id){
        $db = new Database($this->mysqli);
        $values = ['user_id' => $user_id, 'id_product' => $id_product, 'number' => $number, 'unit_id' => $unit_id];
        $db->insert('user_fridge', $values);
        return MyException::db_query($this->mysqli, $db->get_query());
    }

    private function deleteIngredient($id_product, $user_id){
        $db = new Database($this->mysqli);
        $db->delete('user_fridge', ['user_id' => $user_id, 'id_product' => $id_product]);
        return MyException::db_query($this->mysqli, $db->get_query());
    }

    private function getIngredientById($id_product, $user_id){
        $db = new Database($this->mysqli);
        $db->select(['product_name', 'number', 'unit_id'], 'user_fridge')
            ->left_join('products', ['products.id_product', 'user_fridge.id_product'])
            ->where(['user_id' => $user_id, 'user_fridge.id_product' => $id_product]);
        return MyException::db_query_result($this->mysqli, $db->get_query());
    }

    private function updateIngredient($id_product, $number, $unit_id, $user_id){
        $db = new Database($this->mysqli);
        $db->update('user_fridge', ['number' => $number, 'unit_id' => $unit_id])
            ->where(['user_id' => $user_id, 'id_product' => $id_product]);
        return MyException::db_query($this->mysqli, $db->get_query());
    }

    private function getUserIngredientsCount($user_id){
        $db = new Database($this->mysqli);
        $db->count('user_fridge', 'id_product', 'ingredients_count')
            ->where(['user_id' => $user_id]);
        return MyException::db_query_result($this->mysqli, $db->get_query());
    }
}