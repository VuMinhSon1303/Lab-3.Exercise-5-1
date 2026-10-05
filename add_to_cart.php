<?php
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

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
$product_name = trim((string) filter_input(INPUT_POST, 'product_name'));
$list_price = filter_input(INPUT_POST, 'list_price', FILTER_VALIDATE_FLOAT);

if ($product_id !== false && $product_id !== null && $product_id > 0 && $product_name !== '' && $list_price !== false && $list_price !== null) {
    if (!isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = [
            'id' => $product_id,
            'name' => $product_name,
            'price' => (float) $list_price,
            'quantity' => 0,
        ];
    }

    $_SESSION['cart'][$product_id]['quantity'] += 1;
}

header('Location: product_list.php');
exit;
