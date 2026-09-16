<?php
$dsn = 'mysql:host=localhost;dbname=my_guitar_shop;charset=utf8mb4';
$username = 'root';
$password = '';

try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $exception) {
    $error_message = 'Could not connect to the database. Check your MySQL settings.';
}

function escape($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}