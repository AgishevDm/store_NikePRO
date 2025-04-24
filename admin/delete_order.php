<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

include 'db_connect.php';
$conn = connectDB();

// Проверка наличия ID заказа
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: manage_orders.php');
    exit;
}

$order_id = intval($_GET['id']);

// Удаление заказа
$stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
$stmt->bind_param('i', $order_id);

if ($stmt->execute()) {
    header('Location: manage_orders.php');
    exit;
} else {
    echo "Ошибка при удалении заказа: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
