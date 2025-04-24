<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}
include 'db_connect.php';
$conn = connectDB();

// Получение всех заказов
$orders = $conn->query("SELECT * FROM orders ORDER BY order_date DESC");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление заказами</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'admin_header.php'; ?> 

    <div class="admin-main-content">  
        <section>
            <h2>Список заказов</h2>
            <?php if ($orders && $orders->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Дата заказа</th>
                            <th>Имя клиента</th>
                            <th>Телефон</th>
                            <th>Email</th>
                            <th>Адрес</th>
                            <th>Доставка</th>
                            <th>Оплата</th>
                            <th>Сумма (руб.)</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = $orders->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($order['id']); ?></td>
                                <td><?= htmlspecialchars($order['order_date']); ?></td>
                                <td><?= htmlspecialchars($order['customer_name']); ?></td>
                                <td><?= htmlspecialchars($order['customer_phone']); ?></td>
                                <td><?= htmlspecialchars($order['customer_email']); ?></td>
                                <td><?= htmlspecialchars($order['customer_address']); ?></td>
                                <td><?= htmlspecialchars($order['delivery_method']); ?></td>
                                <td><?= htmlspecialchars($order['payment_method']); ?></td>
                                <td><?= htmlspecialchars(number_format($order['total_amount'], 2, ',', ' ')); ?></td>
                                <td>
                                    <a href="edit_order.php?id=<?= $order['id']; ?>">Редактировать</a> |
                                    <a href="delete_order.php?id=<?= $order['id']; ?>" onclick="return confirm('Вы уверены, что хотите удалить этот заказ?');">Удалить</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Нет заказов.</p>
            <?php endif; ?>
        </section>
    </div> 
</body>

</html>
