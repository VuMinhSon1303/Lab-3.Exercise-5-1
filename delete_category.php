<?php
require_once 'db.php';

$category_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (isset($db) && $category_id !== false && $category_id !== null && $category_id > 0) {
    try {
        $statement = $db->prepare('DELETE FROM categories WHERE categoryID = :id');
        $statement->execute(['id' => $category_id]);
    } catch (PDOException $exception) {
        $error_message = 'The category could not be deleted. Remove its products first.';
    }
}

if (isset($error_message)) {
    $page_title = 'Delete Category';
    require 'header.php';
    echo '<p class="error">' . escape($error_message) . '</p>';
    echo '<p><a href="category_list.php">Category List</a></p>';
    require 'footer.php';
} else {
    header('Location: category_list.php');
    exit;
}