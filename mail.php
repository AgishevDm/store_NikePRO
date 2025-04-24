<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Подключаем необходимые файлы PHPMailer
require 'vendor/autoload.php'; // Используйте этот путь, если вы установили PHPMailer с помощью Composer
// Или, если у вас нет Composer:
// require 'path/to/PHPMailer/src/PHPMailer.php';
// require 'path/to/PHPMailer/src/Exception.php';
// require 'path/to/PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true); // Создаем новую экземпляр PHPMailer

try {
    // Настройки сервера
    $mail->isSMTP();                                        // Устанавливаем использование SMTP
    $mail->Host       = 'smtp.yandex.ru';                 // Указываем основной сервер SMTP
    $mail->SMTPAuth   = true;                             // Включаем аутентификацию SMTP
    $mail->Username   = 'nukepro2024@yandex.ru';          // Ваш адрес электронной почты
    $mail->Password   = 'iohuipytjqtrffeq';                     // Ваш пароль от почты (может потребоваться использование пароля приложения)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Включаем шифрование TLS
    $mail->Port       = 587;                              // TCP-порт для подключения

    // Получатели
    $mail->setFrom('nukepro2024@yandex.ru', 'Your Name'); // Указываем адрес отправителя
    $mail->addAddress('agishev.dm@gmail.com', 'Recipient Name'); // Указываем адрес получателя

    // Содержание письма
    $mail->isHTML(true);                                   // Устанавливаем формат в HTML
    $mail->Subject = 'Тестовое письмо';                    // Тема письма
    $mail->Body    = '<h1>Привет!</h1><p>Это тестовое сообщение.</p>'; // HTML-содержимое письма
    $mail->AltBody = 'Это тестовое сообщение.';           // Альтернативный текст для некорректно отображающихся HTML

    $mail->send();                                        // Отправляем письмо
    echo 'Письмо отправлено';
} catch (Exception $e) {
    echo "Ошибка при отправке письма: {$mail->ErrorInfo}"; // Вывод ошибок
}
