<?php

namespace Model;


use helpers\Database;
use helpers\MyException;

class AdminModel extends Model{
    private $items_per_page = 10;

    public function __construct($action){
        parent::__construct($action);
    }

    public function indexAction($data){
        $this->title = 'Редактор рецептов';
        $page = $data['page'] ?? 1;
        $dish_count = $this->get_dish_count();
        $this->data['pages_count'] = ceil(((int)$dish_count[0]['count']/$this->items_per_page));
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
        $this->data['pages_count'] = ceil(((int)$ingredient_count[0]['count']/$this->items_per_page));
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
        $this->data['pages_count'] = ceil(((int)$categories_count[0]['count']/$this->items_per_page));
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
        $this->data['pages_count'] = ceil(((int)$categories_count[0]['count']/$this->items_per_page));
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
        $db = new Database($this->mysqli);
        $db->select(['id_dish', 'name', 'img_path', 'recipe', 'dish_categories.category_id', 'category_name'], 'dish')
            ->left_join('dish_categories', ['dish_categories.category_id', 'dish.category_id']);
        if (isset($array['id'])) $db->where(['id_dish' => $array['id']]);
        $db->order_by('name');
        if (isset($array['page'])) $db->limit(($array['page'] - 1) * $this->items_per_page, $this->items_per_page);
        return MyException::db_query_result($this->mysqli, $db->get_query());
    }

    private function get_dish_count(){
        $db = new Database($this->mysqli);
        $db->count('dish', 'id_dish', 'count');
        return MyException::db_query_result($this->mysqli, $db->get_query());
    }

    private function get_products_content($array = NULL){
        $db = new Database($this->mysqli);
        $db->select(['id_product', 'product_name'], 'products');
        if (isset($array['id'])) $db->where(['id_product' => $array['id']]);
        $db->order_by('product_name');
        if (isset($array['page'])) $db->limit(($array['page'] - 1) * $this->items_per_page, $this->items_per_page);
        return MyException::db_query_result($this->mysqli, $db->get_query());
    }

    private function get_products_count(){
        $db = new Database($this->mysqli);
        $db->count('products', 'id_product', 'count');
        return MyException::db_query_result($this->mysqli, $db->get_query());
    }

    private function get_categories_content($array = NULL){
        $db = new Database($this->mysqli);
        $db->select(['category_id', 'category_name'], 'dish_categories');
        if (isset($array['id'])) $db->where(['category_id' => $array['id']]);
        $db->order_by('category_name');
        if (isset($array['page'])) $db->limit(($array['page'] - 1) * $this->items_per_page, $this->items_per_page);
        return MyException::db_query_result($this->mysqli, $db->get_query());
    }

    private function get_categories_count(){
        $db = new Database($this->mysqli);
        $db->count('dish_categories', 'category_id', 'count');
        return MyException::db_query_result($this->mysqli, $db->get_query());
    }

    private function get_units_content($array = NULL){
        $db = new Database($this->mysqli);
        $db->select(['unit_id', 'unit_name'], 'units');
        if (isset($array['id'])) $db->where(['unit_id' => $array['id']]);
        $db->order_by('unit_name');
        if (isset($array['page'])) $db->limit(($array['page'] - 1) * $this->items_per_page, $this->items_per_page);
        return MyException::db_query_result($this->mysqli, $db->get_query());
    }

    private function get_units_count(){
        $db = new Database($this->mysqli);
        $db->count('units', 'unit_id', 'count');
        return MyException::db_query_result($this->mysqli, $db->get_query());
    }

    private function get_ingredients_content($id = NULL){
        $db = new Database($this->mysqli);
        $db->select(['id_product', 'number', 'unit_id'], 'ingredients');
        if ($id) $db->where(['id_dish' => $id]);
        return MyException::db_query_result($this->mysqli, $db->get_query());
    }

    private function add_products($name){
        $db = new Database($this->mysqli);
        $db->insert('products', ['product_name' => $name]);
        return MyException::db_query($this->mysqli, $db->get_query());
    }

    private function deleteIngredient($id){
        $db = new Database($this->mysqli);
        $db->delete('products', ['id_product' => $id]);
        return MyException::db_query($this->mysqli, $db->get_query());
    }

    private function updateIngredient($name, $id){
        $db = new Database($this->mysqli);
        $db->update('products', ['product_name' => $name])->where(['id_product' => $id]);
        return MyException::db_query($this->mysqli, $db->get_query());
    }

    private function add_category($name){
        $db = new Database($this->mysqli);
        $db->insert('dish_categories', ['category_name' => $name]);
        return MyException::db_query($this->mysqli, $db->get_query());
    }

    private function deleteCategory($id){
        $db = new Database($this->mysqli);
        $db->delete('dish_categories', ['category_id' => $id]);
        return MyException::db_query($this->mysqli, $db->get_query());
    }

    private function updateCategory($name, $id){
        $db = new Database($this->mysqli);
        $db->update('dish_categories', ['category_name' => $name])->where(['category_id' => $id]);
        return MyException::db_query($this->mysqli, $db->get_query());
    }

    private function add_unit($name){
        $db = new Database($this->mysqli);
        $db->insert('units', ['unit_name' => $name]);
        return MyException::db_query($this->mysqli, $db->get_query());
    }

    private function deleteUnit($id){
        $db = new Database($this->mysqli);
        $db->delete('units', ['unit_id' => $id]);
        return MyException::db_query($this->mysqli, $db->get_query());
    }

    private function updateUnit($name, $id){
        $db = new Database($this->mysqli);
        $db->update('units', ['unit_name' => $name])->where(['unit_id' => $id]);
        return MyException::db_query($this->mysqli, $db->get_query());
    }

    private function add_dish($name, $category_id, $img_path, $recipe){
        $db = new Database($this->mysqli);
        $db->insert('dish', ['name' => $name, 'category_id' => $category_id, 'img_path' => $img_path, 'recipe' => $recipe]);
        return MyException::db_query($this->mysqli, $db->get_query());
    }

    private function add_ingredients($id_product, $id_dish, $number, $unit_id){
        $db = new Database($this->mysqli);
        $db->insert('ingredients', ['id_product' => $id_product, 'id_dish' => $id_dish, 'number' => $number, 'unit_id' => $unit_id]);
        return MyException::db_query($this->mysqli, $db->get_query());
    }

    private function deleteDish($id){
        $db = new Database($this->mysqli);
        $db->delete('dish', ['id_dish' => $id]);
        return MyException::db_query($this->mysqli, $db->get_query());
    }

    private function updateDish($name, $category_id, $recipe, $id_dish, $img_path = NULL){
        $db = new Database($this->mysqli);
        $db->update('dish', ['name' => $name, 'category_id' => $category_id, 'recipe' => $recipe]);
        if ($img_path) $db->update('dish', ['img_path' => $img_path]);
        $db->where(['id_dish' => $id_dish]);
        return MyException::db_query($this->mysqli, $db->get_query());
    }

    private function deleteIngredients($id){
        $db = new Database($this->mysqli);
        $db->delete('ingredients', ['id_dish' => $id]);
        return MyException::db_query($this->mysqli, $db->get_query());
    }
}