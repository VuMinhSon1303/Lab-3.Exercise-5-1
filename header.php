<?php
if (!isset($page_title)) {
    $page_title = 'Product Manager';
}

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

$session_id = session_id();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo escape($page_title); ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; color: #222; }
        main { max-width: 960px; margin: 30px auto; padding: 0 20px; }
        header { border-bottom: 2px solid #333; margin-bottom: 20px; }
        h1 { font-size: 1.7rem; margin-bottom: 8px; }
        h2 { color: #a87500; font-size: 1.2rem; }
        nav { margin: 8px 0 12px; }
        nav a { margin-right: 12px; }
        a { color: #075985; }
        table { border-collapse: collapse; margin: 10px 0 25px; min-width: 360px; }
        th, td { border: 1px solid #aaa; padding: 7px 10px; text-align: left; }
        th { background: #eee; }
        form { margin: 12px 0; }
        label { display: inline-block; min-width: 90px; }
        input { padding: 5px; }
        button { padding: 5px 10px; cursor: pointer; }
        .error { color: #a00; font-weight: bold; }
        .actions { white-space: nowrap; }
        .inline-form { display: inline; margin: 0; }
        .session-info { font-weight: bold; margin: 10px 0; }
        @media (max-width: 500px) { table { min-width: 0; width: 100%; } }
    </style>
</head>
<body>
<main>
    <header>
        <h1>Product Manager</h1>
        <nav>
            <a href="category_list.php">Category List</a>
            <a href="product_list.php">Product List</a>
            <a href="cart.php">Cart</a>
            <a href="cart.php?action=end_session">End Session and Delete Cookie</a>
        </nav>
        <div class="session-info">Session ID: <?php echo escape($session_id); ?></div>
    </header>