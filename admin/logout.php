<?php
session_start();
session_destroy();
header('Location: admin_login.php'); // Перенаправление на страницу входа
exit;
?>
