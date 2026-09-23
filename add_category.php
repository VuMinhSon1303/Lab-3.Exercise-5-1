<?php
require_once 'db.php';
require_once __DIR__ . '/app/controllers/CategoryController.php';

$controller = new CategoryController($db);
$controller->addCategory();