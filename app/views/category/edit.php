<?php
require_once __DIR__ . '/../../../db.php';

if (!isset($page_title)) {
    $page_title = 'Edit Category';
}
require __DIR__ . '/../../../header.php';
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
<?php require __DIR__ . '/../../../footer.php'; ?>
