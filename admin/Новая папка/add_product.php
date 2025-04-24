<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

include 'db_connect.php';
$conn = connectDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $brand = trim($_POST['brand']);
    $price = floatval($_POST['price']);
    $image = trim($_POST['image']);
    $description = trim($_POST['description']);

    // Валидация данных
    if (empty($name) || empty($brand) || empty($price) || empty($image) || empty($description)) {
        $error = "Все поля обязательны для заполнения.";
    } else {
        // Вставка товара в базу данных
        $stmt = $conn->prepare("INSERT INTO products (name, brand, price, image, description) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('ssdss', $name, $brand, $price, $image, $description);
        
        if ($stmt->execute()) {
            header('Location: manage_products.php');
            exit;
        } else {
            $error = "Ошибка при добавлении товара: " . $stmt->error;
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
    <title>Добавить Товар</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'admin_header.php'; ?> <!-- Общий хедер с навигацией -->
    
    <main>
        <section>
            <h2>Добавить Новый Товар</h2>
            <?php if (isset($error)): ?>
                <p style="color:red;"><?= htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form method="post" action="">
                <label for="name">Название товара:</label>
                <input type="text" name="name" id="name" required>
                
                <label for="brand">Бренд:</label>
                <input type="text" name="brand" id="brand" required>
                
                <label for="price">Цена (руб.):</label>
                <input type="number" step="0.01" name="price" id="price" required>
                
                <label for="image">Ссылка на изображение:</label>
                <input type="text" name="image" id="image" required>
                
                <label for="description">Описание товара:</label>
                <textarea name="description" id="description" required></textarea>
                
                <button type="submit">Добавить Товар</button>
            </form>
        </section>
    </main>
    
    <?php include 'admin_footer.php'; ?> <!-- Общий футер -->
</body>
</html>
