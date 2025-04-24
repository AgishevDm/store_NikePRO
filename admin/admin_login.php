<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = connectDB();
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Получаем администратора
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // Проверка пароля
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        header('Location: admin_dashboard.php'); // Перенаправление на панель администратора
        exit;
    } else {
        $error = "Неправильный логин или пароль.";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход в админ-панель</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-form">
        <h2>Вход в админ-панель</h2>
        <?php if (isset($error)): ?>
            <p style="color:red;"><?= $error; ?></p>
        <?php endif; ?>
        <form method="post">
            <label for="username">Логин:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">Войти</button>
        </form>
    </div>
</body>
</html>
