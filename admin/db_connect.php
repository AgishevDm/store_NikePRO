<?php
function connectDB(){
    $servername = "localhost";
    $username = "root";
    $password = "mysql"; 
    $dbname = "shoe_store";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function getProducts($conn){
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

function getNews($conn){
    $sql = "SELECT * FROM news ORDER BY id DESC"; 
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

?>
