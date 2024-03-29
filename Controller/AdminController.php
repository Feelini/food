<?php

namespace Controller;
use Model\AdminModel;
use View\View;

class AdminController{
    private $model;
    private $action;
    private $data;
    private $view;
    private $controller = 'Admin';

    public function __construct($action){
        $this->action = $action;
    }

    public function run($model_data){
        $this->view = new View();
        $this->model = new AdminModel($this->action);
        $this->model->{$this->action}($model_data);
        $this->data = $this->model->getData();
    }

    public function indexAction(){
        echo $this->view->render('index_page', $this->controller, $this->data);
    }

    public function editDishAction(){
        if (isset($this->data['complete'])){
            $this->view->redirect(['path' => '/admin']);
        } else {
            echo $this->view->render('edit_dish_page', $this->controller, $this->data);
        }
    }

    public function addDishAction(){
        if (isset($this->data['complete'])){
            $this->view->redirect(['path' => '/admin']);
        } else {
            echo $this->view->render('add_dish_page', $this->controller, $this->data);
        }
    }

    public function deleteDishAction(){
        $this->view->redirect(['path' => '/admin']);
    }

    public function ingredientsAction(){
        if (isset($this->data['complete'])){
            $this->view->redirect(['path' => '/admin/ingredients']);
        } else {
            echo $this->view->render('ingredients_page', $this->controller, $this->data);
        }
    }

    public function deleteIngredientsAction(){
        $this->view->redirect(['path' => '/admin/ingredients']);
    }

    public function editIngredientAction(){
        if (isset($this->data['complete'])){
            $this->view->redirect(['path' => '/admin/ingredients']);
        } else {
            echo $this->view->render('edit_ingredient_page', $this->controller, $this->data);
        }
    }

    public function categoriesAction(){
        if (isset($this->data['complete'])){
            $this->view->redirect(['path' => '/admin/categories']);
        } else {
            echo $this->view->render('categories_page', $this->controller, $this->data);
        }
    }

    public function deleteCategoryAction(){
        $this->view->redirect(['path' => '/admin/categories']);
    }

    public function editCategoryAction(){
        if (isset($this->data['complete'])){
            $this->view->redirect(['path' => '/admin/categories']);
        } else {
            echo $this->view->render('edit_category_page', $this->controller, $this->data);
        }
    }

    public function unitsAction(){
        if (isset($this->data['complete'])){
            $this->view->redirect(['path' => '/admin/units']);
        } else {
            echo $this->view->render('units_page', $this->controller, $this->data);
        }
    }

    public function deleteUnitAction(){
        $this->view->redirect(['path' => '/admin/units']);
    }

    public function editUnitAction(){
        if (isset($this->data['complete'])){
            $this->view->redirect(['path' => '/admin/units']);
        } else {
            echo $this->view->render('edit_unit_page', $this->controller, $this->data);
        }
    }
}