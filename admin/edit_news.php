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

// Получение данных новости
$stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
$stmt->bind_param('i', $news_id);
$stmt->execute();
$result = $stmt->get_result();
$news_item = $result->fetch_assoc();

if (!$news_item) {
    echo "Новость не найдена.";
    exit;
}

// Обработка формы редактирования
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Валидация данных
    if (empty($title) || empty($content)) {
        $error = "Все поля обязательны для заполнения.";
    } else {
        // Обновление данных новости
        $stmt = $conn->prepare("UPDATE news SET title = ?, content = ? WHERE id = ?");
        $stmt->bind_param('ssi', $title, $content, $news_id);
        
        if ($stmt->execute()) {
            header('Location: manage_news.php');
            exit;
        } else {
            $error = "Ошибка при обновлении новости: " . $stmt->error;
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать Новость</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'admin_header.php'; ?> 
    <div class="admin-main-content">  
        <section class="edit-news-form">  
            <h2>Редактировать Новость №<?= htmlspecialchars($news_item['id']); ?></h2>
            <?php if (isset($error)): ?>
                <p style="color:red;"><?= htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form method="post" action="">
                <label for="title">Название новости:</label>
                <input type="text" name="title" id="title" value="<?= htmlspecialchars($news_item['title']); ?>" required>
                <label for="content">Содержание новости:</label>
                <textarea name="content" id="content" required><?= htmlspecialchars($news_item['content']); ?></textarea>
                <button type="submit">Сохранить Изменения</button>
            </form>
        </section>
    </div>  
</body>
</html>