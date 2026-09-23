<?php

require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';

class ProductController
{
    private ProductModel $productModel;
    private CategoryModel $categoryModel;

    public function __construct(PDO $db)
    {
        $this->productModel = new ProductModel($db);
        $this->categoryModel = new CategoryModel($db);
    }

    public function listProducts(): void
    {
        $page_title = 'Product List';

        try {
            $products = $this->productModel->getAll();
            $error_message = null;
        } catch (PDOException $exception) {
            $products = [];
            $error_message = 'The products table could not be read.';
        }

        include __DIR__ . '/../views/product/list.php';
    }

    public function addProduct(): void
    {
        $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
        $product_code = trim((string) filter_input(INPUT_POST, 'product_code'));
        $product_name = trim((string) filter_input(INPUT_POST, 'product_name'));
        $list_price = filter_input(INPUT_POST, 'list_price', FILTER_VALIDATE_FLOAT);
        $error_message = '';

        try {
            $categories = $this->categoryModel->getAll();
        } catch (PDOException $exception) {
            $categories = [];
            $error_message = 'The categories table could not be read.';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($category_id === false || $category_id === null || $category_id < 1) {
                $error_message = 'Please select a category.';
            } elseif ($product_code === '') {
                $error_message = 'Product code is required.';
            } elseif ($product_name === '') {
                $error_message = 'Product name is required.';
            } elseif ($list_price === false || $list_price === null || $list_price <= 0) {
                $error_message = 'List price must be greater than zero.';
            } else {
                try {
                    $this->productModel->add($product_code, $product_name, $list_price, $category_id);
                    header('Location: product_list.php');
                    exit;
                } catch (PDOException $exception) {
                    $error_message = 'The product could not be added.';
                }
            }
        }

        $page_title = 'Add Product';
        include __DIR__ . '/../views/product/add.php';
    }

    public function editProduct(): void
    {
        $product_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $error_message = '';
        $product = null;

        try {
            $categories = $this->categoryModel->getAll();
        } catch (PDOException $exception) {
            $categories = [];
            $error_message = 'The categories table could not be read.';
        }

        if ($product_id === false || $product_id === null || $product_id < 1) {
            $error_message = 'Invalid product.';
        } else {
            try {
                $product = $this->productModel->getById($product_id);
                if ($product === null) {
                    $error_message = 'Product not found.';
                }
            } catch (PDOException $exception) {
                $error_message = 'The product could not be loaded.';
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $error_message === '') {
            $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
            $product_code = trim((string) filter_input(INPUT_POST, 'product_code'));
            $product_name = trim((string) filter_input(INPUT_POST, 'product_name'));
            $list_price = filter_input(INPUT_POST, 'list_price', FILTER_VALIDATE_FLOAT);

            if ($category_id === false || $category_id === null || $category_id < 1) {
                $error_message = 'Please select a category.';
            } elseif ($product_code === '') {
                $error_message = 'Product code is required.';
            } elseif ($product_name === '') {
                $error_message = 'Product name is required.';
            } elseif ($list_price === false || $list_price === null || $list_price <= 0) {
                $error_message = 'List price must be greater than zero.';
            } else {
                try {
                    $this->productModel->update($product_id, $category_id, $product_code, $product_name, $list_price);
                    header('Location: product_list.php');
                    exit;
                } catch (PDOException $exception) {
                    $error_message = 'The product could not be updated.';
                }
            }
        }

        $page_title = 'Edit Product';
        include __DIR__ . '/../views/product/edit.php';
    }

    public function deleteProduct(): void
    {
        $product_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $error_message = '';

        if ($product_id !== false && $product_id !== null && $product_id > 0) {
            try {
                $this->productModel->delete($product_id);
                header('Location: product_list.php');
                exit;
            } catch (PDOException $exception) {
                $error_message = 'The product could not be deleted.';
            }
        } else {
            $error_message = 'Invalid product.';
        }

        $page_title = 'Delete Product';
        include __DIR__ . '/../views/product/delete.php';
    }
}
