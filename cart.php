<?php
    include 'admin/db_connect.php';
    $conn = connectDB();
    $products = getProducts($conn);
    $conn->close();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Корзина</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/cart.css">
</head>
<body>
    <script>
        const products = <?php echo json_encode($products); ?>;
    </script>
    <script src="js/cart_actions.js"></script>
    <script src="js/common.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Корзина</title>
</head>
<body>
    <?php include 'user_header.php'; ?>
    <main>
        <div id="clock"></div>
        <div id="cart-content">
            <p>Корзина пуста</p>
        </div>
        <div id="order-summary"></div>
        <button id="place-order-button">Оформить заказ</button>
        
        <form id="order-form">
            <h2>Информация для заказа</h2>
            <div>
                <label for="fio">Введите ваше Имя:</label>
                <input type="text" id="fio" name="fio" required>
            </div>
            <div>
                <label for="phone">Номер телефона:</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <div>
                <label for="email">Электронная почта:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="city">Город:</label>
                <input type="text" id="city" name="city" required>
            </div>
            <div>
                <label for="street">Улица:</label>
                <input type="text" id="street" name="street" required>
            </div>
            <div>
                <label for="house">Дом:</label>
                <input type="text" id="house" name="house" required>
            </div>
            <div>
                <label for="apartment">Квартира:</label>
                <input type="text" id="apartment" name="apartment">
            </div>
            <div>
                <label for="zip">Индекс:</label>
                <input type="text" id="zip" name="zip" required>
            </div>
            <div>
                <label for="delivery">Способ доставки:</label>
                <select id="delivery" name="delivery" required>
                    <option value="самовывоз">Самовывоз</option>
                    <option value="курьер">Курьером</option>
                    <option value="экспресс">Экспресс доставка</option>
                </select>
            </div>
            <div>
                <label for="payment">Способ оплаты:</label>
                <select id="payment" name="payment" required>
                    <option value="наличные">Наличными при получении</option>
                    <option value="карта">Картой</option>
                    <option value="sbp">СБП</option>
                </select>
            </div>
            <button type="submit">Заказать</button>
        </form>
    </main>
    <?php require 'user_footer.php';?>
    <script src="js/cart_actions.js"></script>
    <script src="js/common.js"></script>
    <script src="js/burger.js"></script>
</body>
</html>
