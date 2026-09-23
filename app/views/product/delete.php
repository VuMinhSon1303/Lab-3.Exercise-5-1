<?php
if (!isset($page_title)) {
    $page_title = 'Delete Product';
}
require __DIR__ . '/../../../header.php';
?>
<p class="error"><?php echo escape($error_message); ?></p>
<p><a href="product_list.php">Product List</a></p>
<?php require __DIR__ . '/../../../footer.php'; ?>
