<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

include 'db_connect.php';
$conn = connectDB();

// Получение данных текущего администратора
$stmt = $conn->prepare("SELECT * FROM admins WHERE id = ?");
$stmt->bind_param('i', $_SESSION['admin_id']);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

if (!$admin) {
    echo "Администратор не найден.";
    exit;
}

// Обработка формы редактирования
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = trim($_POST['username']);
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Валидация данных
    if (empty($new_username)) {
        $error = "Логин не может быть пустым.";
    } elseif (!empty($new_password) && $new_password !== $confirm_password) {
        $error = "Пароли не совпадают.";
    } else {
        // Проверка уникальности нового логина
        if ($new_username !== $admin['username']) {
            $stmt = $conn->prepare("SELECT id FROM admins WHERE username = ?");
            $stmt->bind_param('s', $new_username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $error = "Пользователь с таким логином уже существует.";
                $stmt->close();
            } else {
                $stmt->close();
            }
        }

        // Если нет ошибок, обновляем данные
        if (!isset($error)) {
            if (!empty($new_password)) {
                // Хеширование нового пароля
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE admins SET username = ?, password = ? WHERE id = ?");
                $stmt->bind_param('ssi', $new_username, $hashed_password, $_SESSION['admin_id']);
            } else {
                // Обновление только логина
                $stmt = $conn->prepare("UPDATE admins SET username = ? WHERE id = ?");
                $stmt->bind_param('si', $new_username, $_SESSION['admin_id']);
            }

            if ($stmt->execute()) {
                header('Location: admin_dashboard.php');
                exit;
            } else {
                $error = "Ошибка при обновлении учётных данных: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать учётные данные</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'admin_header.php'; ?>
    <div class="admin-main-content">
        <div class="edit-admin-form">
            <h2>Редактировать учётные данные</h2>
            <?php if (isset($error)): ?>
                <p style="color:red;"><?= htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form method="post" action="">
                <label for="username">Логин:</label>
                <input type="text" name="username" id="username" value="<?= htmlspecialchars($admin['username']); ?>" required>

                <label for="password">Новый пароль:</label>
                <input type="password" name="password" id="password" placeholder="Оставьте пустым, если не хотите менять пароль">

                <label for="confirm_password">Подтвердите новый пароль:</label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Оставьте пустым, если не хотите менять пароль">

                <button type="submit">Сохранить изменения</button>
            </form>
        </div>
    </div>
</body>
</html>