<?php
// create_admin.php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error = "Все поля обязательны для заполнения.";
    } elseif ($password !== $confirm_password) {
        $error = "Пароли не совпадают.";
    } else {
        // Хеширование пароля
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $conn = connectDB();

        // Проверка существования пользователя
        $stmt = $conn->prepare("SELECT id FROM admins WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $error = "Пользователь с таким логином уже существует.";
        } else {
            // Вставка нового администратора
            $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
            $stmt->bind_param('ss', $username, $hashed_password);
            
            if ($stmt->execute()) {
                $success = "Администратор успешно добавлен.";
            } else {
                $error = "Ошибка при добавлении администратора: " . $stmt->error;
            }
        }
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить администратора</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-form">
        <h2>Добавить администратора</h2>
        <?php if (isset($error)): ?>
            <p style="color:red;"><?= htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <p style="color:green;"><?= htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <form method="post">
            <label for="username">Логин:</label>
            <input type="text" name="username" id="username" required>
            
            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password" required>
            
            <label for="confirm_password">Подтвердите пароль:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
            
            <button type="submit">Добавить</button>
        </form>
    </div>
</body>
</html>
