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
    <title>Каталог</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
</head>
<body>
    <?php include 'user_header.php'; ?>
    <main>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="img/collage1.jpg" alt="Слайд 1"><h2>Акция! Скидка 20%!</h2></div>
                <div class="swiper-slide"><img src="img/collage2.jpg" alt="Слайд 2"><h2>Зимние новинки!</h2></div>
                <div class="swiper-slide"><img src="img/collage3.jpg" alt="Слайд 3"><h2>Распродажа осенней коллекции!</h2></div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
        <div id="date"></div>
        <div class="product-grid" id="product-grid"></div>
    </main>

    <?php require 'user_footer.php';?>

    <script src="js/index.js"></script>
    <script>
        const products = <?php echo json_encode($products); ?>;
        displayProducts(products);
    </script>
    <script src="js/cart_actions.js"></script>
    <script src="js/common.js"></script>
    <script src="js/swiper.js"></script>
    <script src="js/burger.js"></script>
</body>
</html>
