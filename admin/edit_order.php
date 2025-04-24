<?
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

// Получение данных заказа
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param('i', $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    echo "Заказ не найден.";
    exit;
}

// Обработка формы редактирования
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = trim($_POST['customer_name']);
    $customer_phone = trim($_POST['customer_phone']);
    $customer_email = trim($_POST['customer_email']);
    $customer_address = trim($_POST['customer_address']);
    $delivery_method = trim($_POST['delivery_method']);
    $payment_method = trim($_POST['payment_method']);
    $promocode = trim($_POST['promocode']);
    $total_amount = floatval($_POST['total_amount']);
    
    // Валидация данных
    if (empty($customer_name) || empty($customer_email) || empty($delivery_method) || empty($payment_method)) {
        $error = "Поля Имя, Email, Способ доставки и Способ оплаты обязательны для заполнения.";
    } elseif (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
        $error = "Некорректный формат электронной почты.";
    } else {
        // Обновление данных заказа
        $stmt = $conn->prepare("UPDATE orders SET customer_name = ?, customer_phone = ?, customer_email = ?, customer_address = ?, delivery_method = ?, payment_method = ?, promocode = ?, total_amount = ? WHERE id = ?");
        $stmt->bind_param(
            'ssssssdii',
            $customer_name,
            $customer_phone,
            $customer_email,
            $customer_address,
            $delivery_method,
            $payment_method,
            $promocode,
            $total_amount,
            $order_id
        );
        
        if ($stmt->execute()) {
            header('Location: manage_orders.php');
            exit;
        } else {
            $error = "Ошибка при обновлении заказа: " . $stmt->error;
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
    <title>Редактировать Заказ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'admin_header.php'; ?> 
<div class="admin-main-content"> 
    <section class="edit-order-form">
        <h2>Редактировать Заказ №<?= htmlspecialchars($order['id']); ?></h2>
        <?php if (isset($error)): ?>
            <p style="color:red;"><?= htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <label for="customer_name">Имя клиента:</label>
                <input type="text" name="customer_name" id="customer_name" value="<?= htmlspecialchars($order['customer_name']); ?>" required>
            <label for="customer_phone">Телефон клиента:</label>
                <input type="tel" name="customer_phone" id="customer_phone" value="<?= htmlspecialchars($order['customer_phone']); ?>">
            <label for="customer_email">Email клиента:</label>
                <input type="email" name="customer_email" id="customer_email" value="<?= htmlspecialchars($order['customer_email']); ?>" required>
            <label for="customer_address">Адрес клиента:</label>
                <textarea name="customer_address" id="customer_address"><?= htmlspecialchars($order['customer_address']); ?></textarea>
            <label for="delivery_method">Способ доставки:</label>
                <select name="delivery_method" id="delivery_method" required>
                    <option value="Курьерская доставка" <?php if ($order['delivery_method'] == 'Курьерская доставка') echo 'selected'; ?>>Курьерская доставка</option>
                    <option value="Самовывоз" <?php if ($order['delivery_method'] == 'Самовывоз') echo 'selected'; ?>>Самовывоз</option>
                </select>
            <label for="payment_method">Способ оплаты:</label>
                <select name="payment_method" id="payment_method" required>
                    <option value="Наличными" <?php if ($order['payment_method'] == 'Наличными') echo 'selected'; ?>>Наличными</option>
                    <option value="Картой" <?php if ($order['payment_method'] == 'Картой') echo 'selected'; ?>>Картой</option>
                </select>
            <label for="promocode">Промокод:</label>
                <input type="text" name="promocode" id="promocode" value="<?= htmlspecialchars($order['promocode']); ?>">
            <label for="total_amount">Сумма (руб.):</label>
                <input type="number" name="total_amount" id="total_amount" step="0.01" value="<?= htmlspecialchars($order['total_amount']); ?>" required>
            <button type="submit">Сохранить Изменения</button>
        </form>
    </section>
</div>  
</body>
</html>