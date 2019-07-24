<?php

namespace Model;


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
        $result_array = [];
        $sql = "SELECT name, category_name, user_cookbook.id_dish FROM user_cookbook
                LEFT JOIN dish ON dish.id_dish = user_cookbook.id_dish
                LEFT JOIN dish_categories ON dish_categories.category_id = dish.category_id
                WHERE user_cookbook.user_id = '$user_id'";
        if (!($result=mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса содержимого: ' . mysqli_error($this->mysqli));
        while ($row = mysqli_fetch_assoc($result)){
            $result_array[] = $row;
        }
        mysqli_free_result($result);
        return $result_array;
    }

    private function getIngredientsByDish($dish_id){
        $result_array = [];
        $sql = "SELECT product_name, number, unit_name, ingredients.id_product
                    FROM ingredients LEFT JOIN products
                    ON ingredients.id_product = products.id_product
                    LEFT JOIN units 
                    ON ingredients.unit_id = units.unit_id
                    WHERE id_dish = $dish_id";
        if (!($result=mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса содержимого: ' . mysqli_error($this->mysqli));
        while ($row = mysqli_fetch_assoc($result)){
            $result_array[] = $row;
        }
        mysqli_free_result($result);
        return $result_array;
    }

    private function addDish($user_id, $dish_id){
        $sql = "INSERT INTO `user_cookbook` (`user_id`, `id_dish`) VALUES ('$user_id', '$dish_id')";
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса пользователя: ' . mysqli_error($this->mysqli));
        return true;
    }

    private function deleteDish($id, $user_id){
        $sql = "DELETE FROM user_cookbook WHERE `id_dish` = '$id' AND `user_id` = '$user_id'";
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка удаления: ' . mysqli_error($this->mysqli));
        return true;
    }

    private function getUserIngredients($user_id){
        $result_array = [];
        $sql = "SELECT product_name, number, unit_name, user_fridge.id_product
                    FROM user_fridge LEFT JOIN products
                    ON products.id_product = user_fridge.id_product
                    LEFT JOIN units 
                    ON user_fridge.unit_id = units.unit_id
                    WHERE user_id = '$user_id'";
        if (!($result=mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса содержимого: ' . mysqli_error($this->mysqli));
        while ($row = mysqli_fetch_assoc($result)){
            $result_array[] = $row;
        }
        mysqli_free_result($result);
        return $result_array;
    }
}