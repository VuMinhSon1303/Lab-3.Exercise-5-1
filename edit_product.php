<?php
require_once 'db.php';
require_once __DIR__ . '/app/controllers/ProductController.php';

$controller = new ProductController($db);
$controller->editProduct();
