<?php
require_once 'db.php';

$category_name = trim((string) filter_input(INPUT_POST, 'category_name'));
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($category_name === '') {
        $error_message = 'Category name is required.';
    } elseif (!isset($db)) {
        $error_message = 'The database is not available.';
    } else {
        try {
            $statement = $db->prepare('INSERT INTO categories (categoryName) VALUES (:category_name)');
            $statement->execute(['category_name' => $category_name]);
            header('Location: category_list.php');
            exit;
        } catch (PDOException $exception) {
            $error_message = 'The category could not be added. It may already exist.';
        }
    }
}

$page_title = 'Add Category';
require 'header.php';
?>
<h2>Add Category</h2>
<?php if ($error_message !== '') : ?>
    <p class="error"><?php echo escape($error_message); ?></p>
<?php endif; ?>
<form action="add_category.php" method="post">
    <label for="category_name">Name:</label>
    <input type="text" id="category_name" name="category_name"
           value="<?php echo escape($category_name); ?>" maxlength="255" required>
    <button type="submit">Add</button>
</form>
<p><a href="category_list.php">Category List</a></p>
<?php require 'footer.php'; ?>