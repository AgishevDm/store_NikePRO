<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

include 'db_connect.php';
$conn = connectDB();

// Проверка наличия ID новости
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: manage_news.php');
    exit;
}

$news_id = intval($_GET['id']);

// Удаление новости
$stmt = $conn->prepare("DELETE FROM news WHERE id = ?");
$stmt->bind_param('i', $news_id);

if ($stmt->execute()) {
    header('Location: manage_news.php');
    exit;
} else {
    echo "Ошибка при удалении новости: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
