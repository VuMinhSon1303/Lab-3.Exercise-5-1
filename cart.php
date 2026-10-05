<?php
require_once __DIR__ . '/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 3 * 365 * 24 * 60 * 60,
        'path' => '/',
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

$action = $_GET['action'] ?? '';

if ($action === 'clear') {
    $_SESSION['cart'] = [];
    header('Location: cart.php');
    exit;
}

if ($action === 'end_session') {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }
    session_destroy();
    header('Location: product_list.php');
    exit;
}

$page_title = 'Cart';
require __DIR__ . '/header.php';

$cart_items = $_SESSION['cart'] ?? [];
$total = 0;
foreach ($cart_items as $item) {
    $total += (float) $item['price'] * (int) $item['quantity'];
}
?>
<h2>Cart</h2>

<?php if (empty($cart_items)) : ?>
    <p>Your cart is empty.</p>
<?php else : ?>
    <table>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
        <?php foreach ($cart_items as $item) : ?>
            <tr>
                <td><?php echo escape($item['name']); ?></td>
                <td><?php echo escape(number_format((float) $item['price'], 2)); ?></td>
                <td><?php echo (int) $item['quantity']; ?></td>
                <td><?php echo escape(number_format((float) $item['price'] * (int) $item['quantity'], 2)); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p><strong>Grand total:</strong> <?php echo escape(number_format($total, 2)); ?></p>
<?php endif; ?>

<p>
    <a href="product_list.php">Back to Product List</a>
    <a href="cart.php?action=clear">Empty Cart</a>
    <a href="cart.php?action=end_session">End Session and Delete Cookie</a>
</p>

<?php require __DIR__ . '/footer.php'; ?>
