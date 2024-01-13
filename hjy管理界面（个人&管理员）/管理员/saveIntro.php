<?php
// saveIntro.php

// 连接数据库
$servername = "localhost";
$username = "root";
$password = "ab433600cd";
$dbname = "final";
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查数据库连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 检查是否接收到有效的电影ID和新简介
if (isset($_POST['film_id']) && isset($_POST['new_intro'])) {
    $filmId = $_POST['film_id'];
    $newIntro = $_POST['new_intro'];

    // 防止SQL注入
    $stmt = $conn->prepare("UPDATE all_films SET intro = ? WHERE id = ?");
    $stmt->bind_param("si", $newIntro, $filmId);

    // 执行更新操作
    if ($stmt->execute()) {
        echo "简介更新成功";
    } else {
        echo "简介更新失败: " . $stmt->error;
    }

    // 关闭预处理语句
    $stmt->close();
} else {
    echo "未接收到有效的电影ID或简介";
}

// 关闭数据库连接
$conn->close();
?>
