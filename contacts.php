<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Контакты</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/contact.css">
</head>
<body>   
    <?php include 'user_header.php'; ?>
    <main>
        <section id="contacts">
            <div class="contact-info">
                <div class="contact-details">
                    <h1>Контакты</h1>
                    <ul>
                        <li><strong>Адрес:</strong> г. Пермь, ул. Букирева, д. 15 </li>
                        <li><strong>Телефон:</strong> +7(950)1020304</li>
                        <li><strong>Email:</strong> info@nikepro.com</li>
                        <h4> Мы в социальных сетях:</h4>
                        <div class="social-links2">
                            <ul>
                                <li>
                                    <a href="#" >
                                        <img src="img/vk.png" alt="VKontakte"> ВКонтакте
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/tiktok.png" alt="ТикТок"> ТикТок
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/telegram.png" alt="Telegram"> Телеграм
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </ul>
                </div>
                <div class="contact-map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2113.781434474373!2d56.18894947323611!3d58.008469015968984!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x43e8c76a5ace55d5%3A0xda7dcae500370921!2z0YPQuy4g0JHRg9C60LjRgNC10LLQsCwgMTUsINCf0LXRgNC80YwsINCf0LXRgNC80YHQutC40Lkg0LrRgNCw0LksIDYxNDA2OA!5e0!3m2!1sru!2sru!4v1733499357902!5m2!1sru!2sru" width="1810" height="550" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </section>
    </main>
    <?php require 'user_footer.php';?>
    <script src="js/burger.js"></script>
</body>
</html>
