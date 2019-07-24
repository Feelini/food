<?php

namespace Model;


class AdminModel extends Model{
    private $items_per_page = 10;

    public function __construct($action){
        parent::__construct($action);
    }

    public function indexAction($data){
        $this->title = 'Редактор рецептов';
        $page = $data['page'] ?? 1;
        $dish_count = $this->get_dish_count();
        $this->data['pages_count'] = ceil(((int)$dish_count[0]/$this->items_per_page));
        $this->data['current_page'] = $page;
        $this->data['dish_per_page'] = $this->items_per_page;
        $this->data['dish'] = $this->get_dish_content(['page' => $page]);
    }

    public function addDishAction(){
        $this->title = 'Добавить блюдо';
        if (isset($_POST['new_dish']) && $_POST['new_dish'] !== '') {
            $new_dish = $_POST['new_dish'];
            $img_path = '/img/dish_img/' . $_FILES['dish_img']['name'];
            $save_img_path = $_SERVER['DOCUMENT_ROOT'] . '/img/dish_img/' . $_FILES['dish_img']['name'];
            move_uploaded_file($_FILES['dish_img']['tmp_name'], $save_img_path);
            $this->add_dish($new_dish['name'], $new_dish['category_id'], $img_path, $new_dish['recipe']);
            $dish_id = $this->mysqli->insert_id;
            $ingr_count = count($new_dish['products']);
            for ($i = 0; $i < $ingr_count; $i++) {
                $this->add_ingredients($new_dish['products'][$i], $dish_id, $new_dish['unit_number'][$i], $new_dish['units'][$i]);
            }
            $this->data['complete'] = true;
        }
        $this->data['units'] = $this->get_units_content();
        $this->data['categories'] = $this->get_categories_content();
        $this->data['products'] = $this->get_products_content();
    }

    public function deleteDishAction($data){
        if (isset($data['id']) && $data['id'] !== '') {
            $this->deleteDish($data['id']);
        }
    }

    public function editDishAction($data){
        $this->title = 'Редактировать блюдо';
        if (isset($data['id']) && $data['id'] !== '') {
            $id = $data['id'];
            $this->data['dish'] = $this->get_dish_content(['id' => $id]);
            $this->data['units'] = $this->get_units_content();
            $this->data['categories'] = $this->get_categories_content();
            $this->data['products'] = $this->get_products_content();
            $this->data['ingredients'] = $this->get_ingredients_content($id);
        } else if (isset($_POST['new_dish']) && $_POST['new_dish'] !== '') {
            $new_dish = $_POST['new_dish'];
            $img_path = NULL;
            if (isset($_FILES['dish_img']) && $_FILES['dish_img']['name'] !== '') {
                $img_path = '/img/dish_img/' . $_FILES['dish_img']['name'];
                $save_img_path = $_SERVER['DOCUMENT_ROOT'] . '/img/dish_img/' . $_FILES['dish_img']['name'];
                move_uploaded_file($_FILES['dish_img']['tmp_name'], $save_img_path);
            }
            if ($this->updateDish($new_dish['name'], $new_dish['category_id'], $new_dish['recipe'], $new_dish['id_dish'], $img_path)) {
                $this->deleteIngredients($new_dish['id_dish']);
                $ingredients_count = count($new_dish['products']);
                for ($i = 0; $i < $ingredients_count; $i++){
                    $this->add_ingredients($new_dish['products'][$i], $new_dish['id_dish'], $new_dish['unit_number'][$i], $new_dish['units'][$i]);
                }
                $this->data['complete'] = true;
            }
        }
    }

    public function ingredientsAction($data){
        $page = $data['page'] ?? 1;
        $ingredient_count = $this->get_products_count();
        $this->data['pages_count'] = ceil(((int)$ingredient_count[0]/$this->items_per_page));
        $this->data['current_page'] = $page;
        $this->data['ingredients_per_page'] = $this->items_per_page;
        $this->title = 'Редактор ингредиентов';
        if (isset($_POST['name']) && $_POST['name'] !== '') {
            $ingredient_name = $_POST['name'];
            $this->data['complete'] = $this->add_products($ingredient_name);
        }
        $this->data['products'] = $this->get_products_content(['page' => $page]);
    }

    public function deleteIngredientsAction($data){
        if (isset($data['id']) && $data['id'] !== '') {
            $this->deleteIngredient($data['id']);
        }
    }

    public function editIngredientAction($data){
        if (isset($data['id']) && $data['id'] !== '') {
            $id = $data['id'];
            $this->data['product'] = $this->get_products_content(['id' => $id]);
        } elseif (isset($_POST['name']) && $_POST['name'] !== '') {
            $name = $_POST['name'];
            $id = $_POST['id'];
            $this->data['complete'] = $this->updateIngredient($name, $id);
        }
    }

    public function categoriesAction($data){
        $this->title = 'Редактор категорий';
        $page = $data['page'] ?? 1;
        $categories_count = $this->get_categories_count();
        $this->data['pages_count'] = ceil(((int)$categories_count[0]/$this->items_per_page));
        $this->data['current_page'] = $page;
        $this->data['categories_per_page'] = $this->items_per_page;
        if (isset($_POST['name']) && $_POST['name'] !== '') {
            $category_name = $_POST['name'];
            $this->data['complete'] = $this->add_category($category_name);
        }
        $this->data['categories'] = $this->get_categories_content(['page' => $page]);
    }

    public function deleteCategoryAction($data){
        if (isset($data['id']) && $data['id'] !== '') {
            $this->deleteCategory($data['id']);
        }
    }

    public function editCategoryAction($data){
        if (isset($data['id']) && $data['id'] !== '') {
            $id = $data['id'];
            $this->data['category'] = $this->get_categories_content(['id' => $id]);
        } elseif (isset($_POST['name']) && $_POST['name'] !== '') {
            $name = $_POST['name'];
            $id = $_POST['id'];
            $this->data['complete'] = $this->updateCategory($name, $id);
        }
    }

    public function unitsAction($data){
        $this->title = 'Редактор мер';
        $page = $data['page'] ?? 1;
        $categories_count = $this->get_units_count();
        $this->data['pages_count'] = ceil(((int)$categories_count[0]/$this->items_per_page));
        $this->data['current_page'] = $page;
        $this->data['units_per_page'] = $this->items_per_page;
        if (isset($_POST['name']) && $_POST['name'] !== '') {
            $unit_name = $_POST['name'];
            $this->data['complete'] = $this->add_unit($unit_name);
        }
        $this->data['units'] = $this->get_units_content(['page' => $page]);
    }

    public function deleteUnitAction($data){
        if (isset($data['id']) && $data['id'] !== '') {
            $this->deleteUnit($data['id']);
        }
    }

    public function editUnitAction($data){
        if (isset($data['id']) && $data['id'] !== '') {
            $id = $data['id'];
            $this->data['unit'] = $this->get_units_content(['id' => $id]);
        } elseif (isset($_POST['name']) && $_POST['name'] !== '') {
            $name = $_POST['name'];
            $id = $_POST['id'];
            $this->data['complete'] = $this->updateUnit($name, $id);
        }
    }

    private function get_dish_content($array = NULL){
        $result_array = [];
        $sql = "SELECT `id_dish`, `name`, `img_path`, `recipe`, dish_categories.category_id, `category_name` FROM `dish`
                LEFT JOIN `dish_categories` ON dish_categories.category_id = dish.category_id";
        if (isset($array['id'])) $sql .= " WHERE id_dish = '{$array['id']}'";
        $sql .= " ORDER BY `name`";
        if (isset($array['page'])){
            $offset = ($array['page'] - 1) * $this->items_per_page;
            $sql .= " LIMIT $offset, $this->items_per_page";
        }
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса контента: ' . mysqli_error($this->mysqli));
        while ($row = mysqli_fetch_assoc($result)) {
            $result_array[] = $row;
        }
        mysqli_free_result($result);
        return $result_array;
    }

    private function get_dish_count(){
        $result_array = '';
        $sql = "SELECT COUNT(*) FROM dish";
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса контента: ' . mysqli_error($this->mysqli));
        while ($row = mysqli_fetch_array($result)) {
            $result_array = $row;
        }
        return $result_array;
    }

    private function get_products_content($array = NULL){
        $result_array = [];
        $sql = "SELECT `id_product`, `product_name` FROM `products`";
        if (isset($array['id'])) {
            $sql .= " WHERE id_product = '{$array['id']}'";
        }
        $sql .= " ORDER BY `product_name`";
        if (isset($array['page'])){
            $offset = ($array['page'] - 1) * $this->items_per_page;
            $sql .= " LIMIT $offset, $this->items_per_page";
        }
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса контента: ' . mysqli_error($this->mysqli));
        while ($row = mysqli_fetch_assoc($result)) {
            $result_array[] = $row;
        }
        mysqli_free_result($result);
        return $result_array;
    }

    private function get_products_count(){
        $result_array = '';
        $sql = "SELECT COUNT(*) FROM products";
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса контента: ' . mysqli_error($this->mysqli));
        while ($row = mysqli_fetch_array($result)) {
            $result_array = $row;
        }
        return $result_array;
    }

    private function get_categories_content($array = NULL){
        $result_array = [];
        $sql = "SELECT `category_id`, `category_name` FROM `dish_categories`";
        if (isset($array['id'])) {
            $sql .= " WHERE category_id = '{$array['id']}'";
        }
        $sql .= " ORDER BY `category_name`";
        if (isset($array['page'])){
            $offset = ($array['page'] - 1) * $this->items_per_page;
            $sql .= " LIMIT $offset, $this->items_per_page";
        }
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса контента: ' . mysqli_error($this->mysqli));
        while ($row = mysqli_fetch_assoc($result)) {
            $result_array[] = $row;
        }
        mysqli_free_result($result);
        return $result_array;
    }

    private function get_categories_count(){
        $result_array = '';
        $sql = "SELECT COUNT(*) FROM dish_categories";
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса контента: ' . mysqli_error($this->mysqli));
        while ($row = mysqli_fetch_array($result)) {
            $result_array = $row;
        }
        return $result_array;
    }

    private function get_units_content($array = NULL){
        $result_array = [];
        $sql = "SELECT `unit_id`, `unit_name` FROM `units`";
        if (isset($array['id'])) {
            $sql .= " WHERE unit_id = '{$array['id']}'";
        }
        $sql .= " ORDER BY `unit_name`";
        if (isset($array['page'])){
            $offset = ($array['page'] - 1) * $this->items_per_page;
            $sql .= " LIMIT $offset, $this->items_per_page";
        }
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса контента: ' . mysqli_error($this->mysqli));
        while ($row = mysqli_fetch_assoc($result)) {
            $result_array[] = $row;
        }
        mysqli_free_result($result);
        return $result_array;
    }

    private function get_units_count(){
        $result_array = '';
        $sql = "SELECT COUNT(*) FROM units";
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса контента: ' . mysqli_error($this->mysqli));
        while ($row = mysqli_fetch_array($result)) {
            $result_array = $row;
        }
        return $result_array;
    }

    private function get_ingredients_content($id = NULL){
        $result_array = [];
        $sql = "SELECT `id_product`, `number`, `unit_id` FROM `ingredients`";
        if ($id) {
            $sql .= " WHERE id_dish = '$id'";
        }
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка запроса контента: ' . mysqli_error($this->mysqli));
        while ($row = mysqli_fetch_assoc($result)) {
            $result_array[] = $row;
        }
        mysqli_free_result($result);
        return $result_array;
    }

    private function add_products($name){
        $sql = "INSERT INTO products(`product_name`) VALUES ('$name')";
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка добавления: ' . mysqli_error($this->mysqli));
        return true;
    }

    private function deleteIngredient($id){
        $sql = "DELETE FROM products WHERE `id_product` = '$id'";
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка удаления: ' . mysqli_error($this->mysqli));
        return true;
    }

    private function updateIngredient($name, $id){
        $sql = "UPDATE products SET `product_name` = '$name' WHERE id_product = '$id'";
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка обновления: ' . mysqli_error($this->mysqli));
        return true;
    }

    private function add_category($name){
        $sql = "INSERT INTO dish_categories(`category_name`) VALUES ('$name')";
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка добавления: ' . mysqli_error($this->mysqli));
        return true;
    }

    private function deleteCategory($id){
        $sql = "DELETE FROM dish_categories WHERE `category_id` = '$id'";
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка удаления: ' . mysqli_error($this->mysqli));
        return true;
    }

    private function updateCategory($name, $id){
        $sql = "UPDATE dish_categories SET `category_name` = '$name' WHERE category_id = '$id'";
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка обновления: ' . mysqli_error($this->mysqli));
        return true;
    }

    private function add_unit($name){
        $sql = "INSERT INTO units(`unit_name`) VALUES ('$name')";
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка добавления: ' . mysqli_error($this->mysqli));
        return true;
    }

    private function deleteUnit($id){
        $sql = "DELETE FROM units WHERE `unit_id` = '$id'";
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка удаления: ' . mysqli_error($this->mysqli));
        return true;
    }

    private function updateUnit($name, $id){
        $sql = "UPDATE units SET `unit_name` = '$name' WHERE unit_id = '$id'";
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка обновления: ' . mysqli_error($this->mysqli));
        return true;
    }

    private function add_dish($name, $category_id, $img_path, $recipe){
        $sql = "INSERT INTO dish(name, category_id, img_path, recipe) VALUES ('$name', '$category_id', '$img_path', '$recipe')";
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка обновления: ' . mysqli_error($this->mysqli));
        return true;
    }

    private function add_ingredients($id_product, $id_dish, $number, $unit_id){
        $sql = "INSERT INTO ingredients(id_product, id_dish, number, unit_id) VALUES ('$id_product', '$id_dish', '$number', '$unit_id')";
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка обновления: ' . mysqli_error($this->mysqli));
        return true;
    }

    private function deleteDish($id){
        $sql = "DELETE FROM dish WHERE `id_dish` = '$id'";
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка удаления: ' . mysqli_error($this->mysqli));
        return true;
    }

    private function updateDish($name, $category_id, $recipe, $id_dish, $img_path = NULL){
        $sql = "UPDATE dish SET `name` = '$name', `category_id` = '$category_id', `recipe` = '$recipe'";
        if ($img_path) $sql .= ", `img_path` = '$img_path'";
        $sql .= " WHERE id_dish = '$id_dish'";
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка обновления: ' . mysqli_error($this->mysqli));
        return true;
    }

    private function deleteIngredients($id){
        $sql = "DELETE FROM ingredients WHERE `id_dish` = '$id'";
        if (!($result = mysqli_query($this->mysqli, $sql)))
            die('Ошибка удаления: ' . mysqli_error($this->mysqli));
        return true;
    }
}