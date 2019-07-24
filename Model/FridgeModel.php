<?php

namespace Model;


class FridgeModel extends Model{
    private $ingredient_per_page = 10;

    public function __construct($action){
        parent::__construct($action);
    }

    public function indexAction(){
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
            $page = $_GET['page'] ?? 1;
            $this->data['products'] = $this->getAllProducts();
            $this->data['units'] = $this->getAllUnits();
            $this->data['ingredients'] = $this->getUserIngredients($user_id, $page);
            $user_ingredients_count = $this->getUserIngredientsCount($user_id);
            $user_ingredients_count = $user_ingredients_count['ingredients_count'];
            $this->data['ingredients_per_page'] = $this->ingredient_per_page;
            $this->data['pages_count'] = ceil((int)$user_ingredients_count / $this->ingredient_per_page);
            $this->data['current_page'] = $page;
        } else {
            $this->data['login'] = true;
        }

    }

    public function deleteIngredientAction(){
        if (isset($_GET['id']) && $_GET['id'] !== ''){
            $id = (int)$_GET['id'];
            $user_id = (int)$_SESSION['user']['user_id'];
            $this->data['success'] = $this->deleteIngredient($id, $user_id);
        }
    }

    public function editIngredientAction(){
        if (isset($_GET['id']) && $_GET['id'] !== ''){
            $id = (int)$_GET['id'];
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
        $result_array = [];
        $sql = "SELECT id_product, product_name FROM products";
        if (!($result=mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса содержимого: ' . mysqli_error($this->mysqli));
        while ($row = mysqli_fetch_assoc($result)){
            $result_array[] = $row;
        }
        mysqli_free_result($result);
        return $result_array;
    }

    private function getAllUnits(){
        $result_array = [];
        $sql = "SELECT unit_id, unit_name FROM units";
        if (!($result=mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса содержимого: ' . mysqli_error($this->mysqli));
        while ($row = mysqli_fetch_assoc($result)){
            $result_array[] = $row;
        }
        mysqli_free_result($result);
        return $result_array;
    }

    private function getUserIngredients($id, $page){
        $result_array = [];
        $sql = "SELECT user_fridge.id_product, product_name, number, unit_name
                FROM user_fridge
                LEFT JOIN units ON units.unit_id = user_fridge.unit_id
                LEFT JOIN products ON products.id_product = user_fridge.id_product
                WHERE user_id = '$id'";
        if (isset($page)){
            $offset = ($page - 1) * $this->ingredient_per_page;
            $sql .= " LIMIT $offset, $this->ingredient_per_page";
        }
        if (!($result=mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса содержимого: ' . mysqli_error($this->mysqli));
        while ($row = mysqli_fetch_assoc($result)){
            $result_array[] = $row;
        }
        mysqli_free_result($result);
        return $result_array;
    }

    private function addUserIngredient($id_product, $number, $unit_id, $user_id){
        $sql = "INSERT INTO user_fridge VALUES ('$user_id', '$id_product', '$number', '$unit_id')";
        if (!($result=mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса содержимого: ' . mysqli_error($this->mysqli));
        return true;
    }

    private function deleteIngredient($id_product, $user_id){
        $sql = "DELETE FROM user_fridge WHERE user_id = '$user_id' AND id_product = '$id_product'";
        if (!($result=mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса содержимого: ' . mysqli_error($this->mysqli));
        return true;
    }

    private function getIngredientById($id_product, $user_id){
        $result_array = '';
        $sql = "SELECT product_name, number, unit_id 
                FROM user_fridge 
                LEFT JOIN products ON products.id_product = user_fridge.id_product
                WHERE user_id = '$user_id' AND user_fridge.id_product = '$id_product'";
        if (!($result=mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса содержимого: ' . mysqli_error($this->mysqli));
        while ($row = mysqli_fetch_assoc($result)){
            $result_array = $row;
        }
        mysqli_free_result($result);
        return $result_array;
    }

    private function updateIngredient($id_product, $number, $unit_id, $user_id){
        $sql = "UPDATE user_fridge SET number = '$number', unit_id = '$unit_id' 
                WHERE user_id = '$user_id' AND id_product = '$id_product'";
        if (!($result=mysqli_query($this->mysqli, $sql)))
            die('Ошибка обновления: ' . mysqli_error($this->mysqli));
        return true;
    }

    private function getUserIngredientsCount($user_id){
        $result_array = '';
        $sql = "SELECT COUNT(id_product) AS ingredients_count FROM user_fridge WHERE user_id = '$user_id'";
        if (!($result=mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса содержимого: ' . mysqli_error($this->mysqli));
        while ($row = mysqli_fetch_assoc($result)){
            $result_array = $row;
        }
        mysqli_free_result($result);
        return $result_array;
    }
}