<?php

require_once __DIR__ . '/../models/CategoryModel.php';

class CategoryController
{
    private CategoryModel $model;

    public function __construct(PDO $db)
    {
        $this->model = new CategoryModel($db);
    }

    public function listCategories(): void
    {
        $page_title = 'Category List';

        if (!isset($GLOBALS['db'])) {
            $categories = [];
            $error_message = 'The database is not available.';
            include __DIR__ . '/../views/category/list.php';
            return;
        }

        try {
            $categories = $this->model->getCategoryList();
            $error_message = null;
        } catch (PDOException $exception) {
            $categories = [];
            $error_message = 'The categories table could not be read.';
        }

        include __DIR__ . '/../views/category/list.php';
    }

    public function addCategory(): void
    {
        $category_name = trim((string) filter_input(INPUT_POST, 'category_name'));
        $error_message = '';

        if (!isset($GLOBALS['db'])) {
            $error_message = 'The database is not available.';
            $page_title = 'Add Category';
            include __DIR__ . '/../views/category/add.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($category_name === '') {
                $error_message = 'Category name is required.';
            } else {
                try {
                    $this->model->addCategory($category_name);
                    header('Location: category_list.php');
                    exit;
                } catch (PDOException $exception) {
                    $error_message = 'The category could not be added. It may already exist.';
                }
            }
        }

        $page_title = 'Add Category';
        include __DIR__ . '/../views/category/add.php';
    }

    public function editCategory(): void
    {
        $category_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $category_name = '';
        $error_message = '';

        if (!isset($GLOBALS['db'])) {
            $error_message = 'The database is not available.';
            $page_title = 'Edit Category';
            include __DIR__ . '/../views/category/edit.php';
            return;
        }

        if ($category_id === false || $category_id === null || $category_id < 1) {
            $error_message = 'Invalid category.';
        } else {
            try {
                $category = $this->model->getById($category_id);
                if ($category === null) {
                    $error_message = 'Category not found.';
                } else {
                    $category_name = $category['categoryName'];
                }
            } catch (PDOException $exception) {
                $error_message = 'The category could not be loaded.';
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $error_message === '') {
            $category_name = trim((string) filter_input(INPUT_POST, 'category_name'));

            if ($category_name === '') {
                $error_message = 'Category name is required.';
            } else {
                try {
                    $this->model->update($category_id, $category_name);
                    header('Location: category_list.php');
                    exit;
                } catch (PDOException $exception) {
                    $error_message = 'The category could not be updated.';
                }
            }
        }

        $page_title = 'Edit Category';
        include __DIR__ . '/../views/category/edit.php';
    }

    public function deleteCategory(): void
    {
        $category_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $error_message = '';

        if (!isset($GLOBALS['db'])) {
            $error_message = 'The database is not available.';
            $page_title = 'Delete Category';
            include __DIR__ . '/../views/category/delete.php';
            return;
        }

        if ($category_id !== false && $category_id !== null && $category_id > 0) {
            try {
                $this->model->deleteCategory($category_id);
                header('Location: category_list.php');
                exit;
            } catch (PDOException $exception) {
                $error_message = 'The category could not be deleted. Remove its products first.';
            }
        } else {
            $error_message = 'Invalid category.';
        }

        $page_title = 'Delete Category';
        include __DIR__ . '/../views/category/delete.php';
    }
}
