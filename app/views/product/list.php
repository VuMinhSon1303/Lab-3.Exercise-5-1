<?php
if (!isset($page_title)) {
    $page_title = 'Product List';
}
require __DIR__ . '/../../../header.php';
?>
<h2>Product List</h2>

<?php if (isset($error_message) && $error_message !== '') : ?>
    <p class="error"><?php echo escape($error_message); ?></p>
<?php elseif (empty($products)) : ?>
    <p>No products were found.</p>
<?php else : ?>
    <table>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($products as $product) : ?>
            <tr>
                <td><?php echo escape($product['productCode']); ?></td>
                <td><?php echo escape($product['productName']); ?></td>
                <td><?php echo escape($product['categoryName']); ?></td>
                <td><?php echo escape(number_format((float) $product['listPrice'], 2)); ?></td>
                <td class="actions">
                    <a href="edit_product.php?id=<?php echo (int) $product['productID']; ?>">Edit</a>
                    <form class="inline-form" action="delete_product.php" method="post">
                        <input type="hidden" name="id" value="<?php echo (int) $product['productID']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<p><a href="add_product.php">Add Product</a></p>
<p><a href="category_list.php">Category List</a></p>
<?php require __DIR__ . '/../../../footer.php'; ?>
