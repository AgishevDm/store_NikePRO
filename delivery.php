<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Доставка и оплата</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/delivery.css">
</head>
<body>
    <?php include 'user_header.php'; ?>
    <main>
    <div class="info-block-container">
        <div class="info-block delivery-info">
            <h2 class="main-title">Информация о доставке</h2>
            <p class="main-paragraph">Мы стремимся обеспечить максимально удобный и быстрый процесс доставки для наших клиентов.</p>
            <ol>
                <li class="delivery-item">Стандартная доставка (3-7 рабочих дней, бесплатно от 20000 руб., иначе 1000 руб.)</li>
                <li class="delivery-item">Экспресс-доставка (1-3 рабочих дня, 2500 руб.)</li>
                <li class="delivery-item">Самовывоз (наш офис, 1-2 часа после оформления)</li>
            </ol>
        </div>

        <div class="info-block order-processing">
            <h2 class="main-title">Обработка заказов</h2>
            <p class="main-paragraph">Все заказы обрабатываются в течение 1 рабочего дня. Свяжитесь с нами, если у вас есть вопросы.</p>
        </div>

        <div class="info-block payment-info">
            <h2 class="main-title">Информация о способах оплаты</h2>
            <ol>
                <li class="payment-item">Банковская карта (МИР, защищенные платежные шлюзы)</li>
                <li class="payment-item">Наложенный платеж (только стандартная доставка, комиссия за обратную пересылку)</li>
                <li class="payment-item">Система быстрых платежей (банковский перевод, уточните сроки)</li>
            </ol>
        </div>

        <div class="info-block payment-security">
            <h2 class="main-title">Безопасность платежей</h2>
            <p class="main-paragraph">Мы гарантируем безопасность всех транзакций. Ваши данные защищены в соответствии с законодательством.</p>
        </div>

        <div class="info-block return-policy">
            <h2 class="main-title">Возврат и обмен</h2>
            <p class="main-paragraph">Вы можете вернуть или обменять товары в течение 14 дней с момента покупки при условии, что товар не был использован, находится в оригинальной упаковке, сохранены все ярлыки. Более подробная информация в<a class="main-link" href="policy.php" target="_blank">Политике возврата</a>.</p>
            <p class="main-paragraph">Для вопросов о возврате: <a class="main-link" href="">+7-(950)-102-03-04</a>, <a class="main-link" href="">info@nikepro.com</a></p>
        </div>
    </div>  
    <div class="final-message">
            <h4 class="final-message">Желаем вам хороших покупок!</h4>
    </div>  
    </main>
    <?php require 'user_footer.php';?>
    <script src="js/burger.js"></script>
</body>
</html>


