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

// Получение данных товара
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param('i', $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "Товар не найден.";
    exit;
}

// Обработка формы редактирования
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
        // Обновление данных товара
        $stmt = $conn->prepare("UPDATE products SET name = ?, brand = ?, price = ?, image = ?, description = ? WHERE id = ?");
        $stmt->bind_param('ssdssi', $name, $brand, $price, $image, $description, $product_id);
        if ($stmt->execute()) {
            header('Location: manage_products.php');
            exit;
        } else {
            $error = "Ошибка при обновлении товара: " . $stmt->error;
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
    <title>Редактировать Товар</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'admin_header.php'; ?> 
    <div class="admin-main-content">  
        <section class="edit-product-form">
            <h2>Редактировать Товар №<?= htmlspecialchars($product['id']); ?></h2>
            <?php if (isset($error)): ?>
                <p style="color:red;"><?= htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form method="post" action="">
                <label for="name">Название товара:</label>
                    <input type="text" name="name" id="name" value="<?= htmlspecialchars($product['name']); ?>" required>
                <label for="brand">Бренд:</label>
                    <input type="text" name="brand" id="brand" value="<?= htmlspecialchars($product['brand']); ?>" required>
                <label for="price">Цена (руб.):</label>
                    <input type="number" step="0.01" name="price" id="price" value="<?= htmlspecialchars($product['price']); ?>" required>
                <label for="image">Изображение:</label>
                    <input type="text" name="image" id="image" value="<?= htmlspecialchars($product['image']); ?>" required>
                <label for="description">Описание товара:</label>
                    <textarea name="description" id="description" required><?= htmlspecialchars($product['description']); ?></textarea>
                <button type="submit">Сохранить Изменения</button>
            </form>
        </section>
    </div>  
</body>
</html>

