<?php

namespace Model;


class CookbookModel extends Model{
    private $items_per_page = 1;

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
        $result_array = [];
        $sql = "SELECT id_dish, `name`, img_path, category_name, recipe, dish.category_id
                FROM dish LEFT JOIN dish_categories
                ON dish.category_id = dish_categories.category_id";
        if ($page){
            $offset = ($page - 1) * $this->items_per_page;
            $sql .= " LIMIT $offset, $this->items_per_page";
        }
        if (!($result=mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса содержимого главной: ' . mysqli_error($this->mysqli));
        while ($row = mysqli_fetch_assoc($result)){
            $result_array[] = $row;
        }
        mysqli_free_result($result);
        return $result_array;
    }

    private function get_dish($array = NULL){
        $result_array = [];
        $sql = "SELECT id_dish, `name`, img_path, category_name, recipe, dish.category_id
                FROM dish LEFT JOIN dish_categories
                ON dish.category_id = dish_categories.category_id";
        if (isset($array['id'])) $sql .= " WHERE id_dish = {$array['id']}";
        if (isset($array['page'])){
            $limit = ($array['page']) * $this->items_per_page;
            $sql .= " LIMIT $limit";
        }
        if (!($result=mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса содержимого главной: ' . mysqli_error($this->mysqli));
        while ($row = mysqli_fetch_assoc($result)){
            $result_array[] = $row;
        }
        mysqli_free_result($result);
        return $result_array;
    }

    private function get_ingredients($dish_id){
        $result_array = [];
        $sql = "SELECT product_name, number, unit_name
                    FROM ingredients LEFT JOIN products
                    ON ingredients.id_product = products.id_product
                    LEFT JOIN units 
                    ON ingredients.unit_id = units.unit_id
                    WHERE id_dish = $dish_id";
        if (!($result=mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса содержимого главной: ' . mysqli_error($this->mysqli));
        while ($row = mysqli_fetch_assoc($result)){
            $result_array[] = $row;
        }
        mysqli_free_result($result);
        return $result_array;
    }

    private function get_dish_count(){
        $result_array = [];
        $sql = "SELECT COUNT(name) AS count FROM dish";
        if (!($result=mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса количества блюд: ' . mysqli_error($this->mysqli));
        while ($row = mysqli_fetch_assoc($result)){
            $result_array[] = $row;
        }
        return $result_array;
    }
}