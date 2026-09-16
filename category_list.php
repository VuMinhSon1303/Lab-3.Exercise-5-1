<?php
require_once 'db.php';

$page_title = 'Category List';
require 'header.php';
?>
<h2>Category List</h2>

<?php if (isset($error_message)) : ?>
    <p class="error"><?php echo escape($error_message); ?></p>
<?php else : ?>
    <?php
    try {
        $statement = $db->query('SELECT categoryID, categoryName FROM categories ORDER BY categoryName');
        $categories = $statement->fetchAll();
    } catch (PDOException $exception) {
        $categories = [];
        $error_message = 'The categories table could not be read.';
    }
    ?>
    <?php if (isset($error_message)) : ?>
        <p class="error"><?php echo escape($error_message); ?></p>
    <?php elseif (count($categories) === 0) : ?>
        <p>No categories were found.</p>
    <?php else : ?>
        <table>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($categories as $category) : ?>
                <tr>
                    <td><?php echo escape($category['categoryName']); ?></td>
                    <td class="actions">
                        <a href="edit_category.php?id=<?php echo (int) $category['categoryID']; ?>">Edit</a>
                        <form class="inline-form" action="delete_category.php" method="post">
                            <input type="hidden" name="id" value="<?php echo (int) $category['categoryID']; ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
<?php endif; ?>

<p><a href="add_category.php">Add Category</a></p>
<p><a href="product_list.php">List Products</a></p>
<?php require 'footer.php'; ?>