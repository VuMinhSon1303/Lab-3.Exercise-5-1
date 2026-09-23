<?php
require_once __DIR__ . '/../../../db.php';

if (!isset($page_title)) {
    $page_title = 'Delete Category';
}
require __DIR__ . '/../../../header.php';
?>
<p class="error"><?php echo escape($error_message); ?></p>
<p><a href="category_list.php">Category List</a></p>
<?php require __DIR__ . '/../../../footer.php'; ?>
