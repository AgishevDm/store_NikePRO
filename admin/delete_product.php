<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

include 'db_connect.php';
$conn = connectDB();

// Проверка наличия ID товара
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: manage_products.php');
    exit;
}

$product_id = intval($_GET['id']);

// Удаление товара
$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param('i', $product_id);

if ($stmt->execute()) {
    header('Location: manage_products.php');
    exit;
} else {
    echo "Ошибка при удалении товара: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
