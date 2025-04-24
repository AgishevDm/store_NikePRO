<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-Панель</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'admin_header.php'; ?> 
    
    <main>
        <section>
            <h2>Добро пожаловать в Админ-Панель</h2>
            <p>Используйте навигационное меню для управления сайтом.</p>
        </section>
    </main>
</body>
</html>

