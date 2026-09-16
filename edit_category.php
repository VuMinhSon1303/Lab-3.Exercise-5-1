<?php
require_once 'db.php';

$category_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$category_name = '';
$error_message = '';

if (!isset($db) || $category_id === false || $category_id === null || $category_id < 1) {
    $error_message = 'Invalid category.';
} else {
    try {
        $statement = $db->prepare('SELECT categoryName FROM categories WHERE categoryID = :id');
        $statement->execute(['id' => $category_id]);
        $category = $statement->fetch();
        if (!$category) {
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
            $statement = $db->prepare('UPDATE categories SET categoryName = :category_name WHERE categoryID = :id');
            $statement->execute(['category_name' => $category_name, 'id' => $category_id]);
            header('Location: category_list.php');
            exit;
        } catch (PDOException $exception) {
            $error_message = 'The category could not be updated.';
        }
    }
}

$page_title = 'Edit Category';
require 'header.php';
?>
<h2>Edit Category</h2>
<?php if ($error_message !== '') : ?>
    <p class="error"><?php echo escape($error_message); ?></p>
<?php else : ?>
    <form action="edit_category.php?id=<?php echo (int) $category_id; ?>" method="post">
        <label for="category_name">Name:</label>
        <input type="text" id="category_name" name="category_name"
               value="<?php echo escape($category_name); ?>" maxlength="255" required>
        <button type="submit">Save</button>
    </form>
<?php endif; ?>
<p><a href="category_list.php">Category List</a></p>
<?php require 'footer.php'; ?>