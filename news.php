<?php
    include 'admin/db_connect.php';
    $conn = connectDB();
    $news = getNews($conn);
    $conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Новости</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/news.css">
</head>
<body>
    <?php include 'user_header.php'; ?>
    <main> 
        <div id="news-section"> 
            <div id="news-content"></div>
        </div>
    </main>
    <?php require 'user_footer.php';?>
    <script src="js/burger.js"></script>
    <script src="js/news.js"></script>
    <script>
        const news = <?php echo json_encode($news); ?>;
        displayNews(news);
    </script>
</body>
</html>