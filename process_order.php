<?php
// process_order.php
header('Content-Type: application/json');

// Отключаем отображение ошибок (для продакшн-среды)
ini_set('display_errors', 0);
error_reporting(0);

// Получение данных из запроса
$orderData = json_decode(file_get_contents('php://input'), true);

// Проверка корректности данных
if (!$orderData) {
    echo json_encode(['success' => false, 'message' => 'Неверные данные.']);
    exit;
}

// Валидация обязательных полей
$requiredFields = ['fio', 'phone', 'email', 'city', 'street', 'house', 'zip', 'delivery', 'payment', 'items', 'total_amount'];
foreach ($requiredFields as $field) {
    if (empty($orderData[$field])) {
        echo json_encode(['success' => false, 'message' => "Поле '$field' обязательно для заполнения."]);
        exit;
    }
}

// Дополнительная валидация ФИО (только русские буквы и пробелы)
if (!preg_match('/^[А-Яа-яЁё\s]+$/u', $orderData['fio'])) {
    echo json_encode(['success' => false, 'message' => 'ФИО должно содержать только русские буквы и пробелы.']);
    exit;
}

// Валидация Email
if (!filter_var($orderData['email'], FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Некорректный формат электронной почты.']);
    exit;
}

// Подключение к базе данных
include 'admin/db_connect.php';
$conn = connectDB();

// Сборка полного адреса
$customer_address = 
    $conn->real_escape_string($orderData['city']) . ', ' .
    $conn->real_escape_string($orderData['street']) . ', ' .
    'д. ' . $conn->real_escape_string($orderData['house']) . 
    (!empty($orderData['apartment']) ? ', кв. ' . $conn->real_escape_string($orderData['apartment']) : '') . ', ' .
    $conn->real_escape_string($orderData['zip']);

// Подготовка данных для вставки
$customer_name = $conn->real_escape_string($orderData['fio']);
$customer_phone = $conn->real_escape_string($orderData['phone']);
$customer_email = $conn->real_escape_string($orderData['email']);
$delivery_method = $conn->real_escape_string($orderData['delivery']);
$payment_method = $conn->real_escape_string($orderData['payment']);
$promocode = isset($orderData['promocode']) ? $conn->real_escape_string($orderData['promocode']) : '';
$order_items = json_encode($orderData['items']); // Сохранение как JSON
$total_amount = $conn->real_escape_string($orderData['total_amount']);

// Подготовка SQL-запроса
$stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_phone, customer_email, customer_address, delivery_method, payment_method, promocode, order_items, total_amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param(
    "ssssssssd",
    $customer_name,
    $customer_phone,
    $customer_email,
    $customer_address,
    $delivery_method,
    $payment_method,
    $promocode,
    $order_items,
    $total_amount
);

// Выполнение запроса
if ($stmt->execute()) {
    // Получение ID заказа
    $order_id = $stmt->insert_id;

    // Отправка подтверждения на email
    $to = $customer_email;
    $subject = "Подтверждение заказа №{$order_id}";
    $message = "Здравствуйте, {$customer_name}!\n\nВаш заказ №{$order_id} успешно оформлен.\n\nДетали заказа:\n\n";

    foreach ($orderData['items'] as $item) {
        $message .= "- {$item['name']} x {$item['quantity']} = " . ($item['price'] * $item['quantity']) . " руб.\n";
    }

    $message .= "\nИтого: {$total_amount} руб.\n\nСпособ доставки: {$delivery_method}\nСпособ оплаты: {$payment_method}\n\nСпасибо за вашу покупку!";
    $headers = "From: info@nikepro.com\r\n";

    // Используем @ для подавления возможных предупреждений от функции mail()
    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(['success' => true, 'message' => 'Заказ успешно оформлен и подтверждение отправлено на ваш email.']);
    } else {
        echo json_encode(['success' => true, 'message' => 'Заказ успешно оформлен, но не удалось отправить подтверждение на ваш email.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Ошибка при оформлении заказа. Пожалуйста, попробуйте снова.']);
}

$stmt->close();
$conn->close();

