<?php
// admin_header.php
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Административная Панель</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
</head>
<body>
<header class="admin-sidebar" id="sidebar">
    <div class="header-content">
        <img src="img/inc/logo.png" alt="Логотип" class="logo">
        <h1 class="sidebar-title">Админ</h1> 
        <button class="toggle-sidebar" id="toggleSidebar">
            <i class="fas fa-chevron-left"></i> 
        </button>
    </div>
    <nav>
        <ul>
            <li>
                <a href="manage_products.php">
                    <img src="img/inc/icon1.png" alt="" class="nav-icon">
                    <span class="nav-text">Управление Товарами</span>
                </a>
            </li>
            <li>
                <a href="manage_news.php">
                    <img src="img/inc/icon2.png" alt="" class="nav-icon">
                    <span class="nav-text">Управление Новостями</span>
                </a>
            </li>
            <li>
                <a href="manage_orders.php">
                    <img src="img/inc/icon3.png" alt="" class="nav-icon">
                    <span class="nav-text">Управление Заказами</span>
                </a>
            </li>
            <li>
                <a href="edit_admin.php">
                    <img src="img/inc/icon4.png" alt="" class="nav-icon">
                    <span class="nav-text">Учетные Данные</span>
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <img src="img/inc/icon5.png" alt="" class="nav-icon">
                    <span class="nav-text">Выход</span>
                </a>
            </li>
        </ul>
    </nav>
</header>
<script>
    // Функция для обновления состояния сайдбара
    function updateSidebarState(isCollapsed) {
        // Получаем элемент сайдбара и кнопку
        const sidebar = document.getElementById("sidebar");
        const toggleButton = document.getElementById("toggleSidebar");

        if (isCollapsed) {
            sidebar.style.width = "60px"; // Уменьшаем ширину
            toggleButton.innerHTML = '<i class="fas fa-chevron-right"></i>'; // Изменяем стрелку
            toggleButton.classList.remove('white');
            toggleButton.classList.add('black');
            document.querySelector(".sidebar-title").style.display = "none"; // Скрываем заголовок
            document.querySelectorAll(".nav-text").forEach(el => el.style.display = "none"); // Скрываем текст
        } else {
            sidebar.style.width = "300px"; // Ширина в развернутом состоянии
            toggleButton.innerHTML = '<i class="fas fa-chevron-left"></i>'; // Изменяем стрелку
            toggleButton.classList.remove('black');
            toggleButton.classList.add('white');
            document.querySelector(".sidebar-title").style.display = "block"; // Показываем заголовок
            document.querySelectorAll(".nav-text").forEach(el => el.style.display = "inline"); // Показываем текст
        }

        // Сохраняем состояние в localStorage
        localStorage.setItem('sidebarCollapsed', isCollapsed);
    }

    // Установка начального состояния при загрузке страницы
    window.onload = function () {
        // Получаем состояние из localStorage
        const collapsedState = JSON.parse(localStorage.getItem('sidebarCollapsed'));
        if (collapsedState) {
            updateSidebarState(true); 
        } else {
            updateSidebarState(false); 
        }
    };

    document.getElementById("toggleSidebar").addEventListener("click", function () {
        const sidebarCollapsed = sidebar.style.width === "60px"; // Проверяем текущее состояние
        updateSidebarState(!sidebarCollapsed); // Переключаем состояние
    });
</script>






