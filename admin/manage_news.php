<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

include 'db_connect.php';
$conn = connectDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $date = date("Y-m-d"); // Автоматически устанавливается текущая дата
    
    // Валидация данных
    if (empty($title) || empty($content)) {
        $error = "Все поля обязательны для заполнения.";
    } else {
        // Вставка новости в базу данных
        $stmt = $conn->prepare("INSERT INTO news (title, content, date) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $title, $content, $date);
        
        if ($stmt->execute()) {
            header('Location: manage_news.php');
            exit;
        } else {
            $error = "Ошибка при добавлении новости: " . $stmt->error;
        }
        $stmt->close();
    }
}
// Получение всех новостей
$news = getNews($conn);
$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление новостями</title>
    <link rel="stylesheet" href="style.css">  
</head>
<body>
    <?php include 'admin_header.php'; ?> 
    <div class="admin-main-content">  
        <section>
            <h2>Добавить новость</h2>
            <?php if (isset($error)): ?>
                <p style="color:red;"><?= htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form method="post" action="">
                <label for="title">Название новости:</label>
                    <input type="text" name="title" id="title" required>
                <label for="content">Содержание новости:</label>
                    <textarea name="content" id="content" required></textarea>
                <button type="submit">Добавить Новость</button>
            </form>
        </section>

        <section>
            <h2>Список новостей</h2>
            <?php if (count($news) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Содержание</th>
                            <th>Дата</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($news as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['id']); ?></td>
                                <td><?= htmlspecialchars($item['title']); ?></td>
                                <td><?= htmlspecialchars($item['content']); ?></td>
                                <td><?= htmlspecialchars($item['date']); ?></td>
                                <td>
                                    <a href="edit_news.php?id=<?= $item['id']; ?>">Редактировать</a> |
                                    <a href="delete_news.php?id=<?= $item['id']; ?>" onclick="return confirm('Вы уверены, что хотите удалить эту новость?');">Удалить</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Нет добавленных новостей.</p>
            <?php endif; ?>
        </section>
    </div> 
</body>
</html>
