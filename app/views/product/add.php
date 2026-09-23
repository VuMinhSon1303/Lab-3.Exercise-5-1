<?php
if (!isset($page_title)) {
    $page_title = 'Add Product';
}
require __DIR__ . '/../../../header.php';
?>
<h2>Add Product</h2>
<?php if ($error_message !== '') : ?>
    <p class="error"><?php echo escape($error_message); ?></p>
<?php endif; ?>
<form action="add_product.php" method="post">
    <label for="category_id">Category:</label>
    <select id="category_id" name="category_id" required>
        <option value="">Select a category</option>
        <?php foreach ($categories as $category) : ?>
            <option value="<?php echo (int) $category['categoryID']; ?>"><?php echo escape($category['categoryName']); ?></option>
        <?php endforeach; ?>
    </select>
    <br>
    <label for="product_code">Code:</label>
    <input type="text" id="product_code" name="product_code" maxlength="10" required>
    <br>
    <label for="product_name">Name:</label>
    <input type="text" id="product_name" name="product_name" maxlength="255" required>
    <br>
    <label for="list_price">Price:</label>
    <input type="number" id="list_price" name="list_price" step="0.01" min="0.01" required>
    <br>
    <button type="submit">Add</button>
</form>
<p><a href="product_list.php">Product List</a></p>
<?php require __DIR__ . '/../../../footer.php'; ?>
