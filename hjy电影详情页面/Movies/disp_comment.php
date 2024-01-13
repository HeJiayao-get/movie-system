<?php
//////这个文件是display_cmt.php
////
////// 配置数据库连接参数
////$servername = "localhost";
////$username = "root"; // 数据库用户名
////$password = "ab433600cd"; // 数据库密码
////$dbname = "final";
////
////// 创建数据库连接
////$conn = new mysqli($servername, $username, $password, $dbname);
////
////// 检查数据库连接
////if ($conn->connect_error) {
////    die("连接失败: " . $conn->connect_error);
////}
////
////// 设置字符集为 utf8
////$conn->set_charset("utf8");
////// 检索所有评论
////$sql = "SELECT comment FROM all_comments";
////$result = $conn->query($sql);
////
////// 检索所有评论
////if ($result->num_rows > 0) {
////    while ($row = $result->fetch_assoc()) {
////        echo "<div class='comment'>" . htmlspecialchars($row['comment']) . "</div>";
////    }
////} else {
////    echo "<div class='comment'>暂无评论。</div>";
////}
////
////// 关闭连接
////$conn->close();
//
//
////这个文件是display_cmt.php
//
//// 配置数据库连接参数
//$servername = "localhost";
//$username = "root"; // 数据库用户名
//$password = "ab433600cd"; // 数据库密码
//$dbname = "final";
//
//// 创建数据库连接
//$conn = new mysqli($servername, $username, $password, $dbname);
//
//// 检查数据库连接
//if ($conn->connect_error) {
//    die("连接失败: " . $conn->connect_error);
//}
//
//// 设置字符集为 utf8
//$conn->set_charset("utf8");
//
//// 检索所有评论及其用户信息
//$sql = "SELECT all_comments.comment, username
//        FROM all_comments ";
//
//$result = $conn->query($sql);
//
//// 检索所有评论和用户信息
//if ($result->num_rows > 0) {
//    while ($row = $result->fetch_assoc()) {
//        echo "<div class='comment'>";
//        echo "<p class='user'>" . htmlspecialchars($row['username']) . ':' . htmlspecialchars($row['comment']) . "</p>"; // 显示用户名
//
//        echo "</div>";
//    }
//} else {
//    echo "<div class='comment'>暂无评论。</div>";
//}
//
//// 关闭连接
//$conn->close();
//

// display_cmt.php

// 配置数据库连接参数
$servername = "localhost";
$username = "root"; // 数据库用户名
$password = "ab433600cd"; // 数据库密码
$dbname = "final";

// 创建数据库连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查数据库连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 设置字符集为 utf8
$conn->set_charset("utf8");


// 从 URL 中获取电影 ID，并进行检查
if (!isset($_GET['id'])) {
    echo "电影 ID 没有指定。请跳转至首页进入";
    exit;
}
$movieId = intval($_GET['id']);

    // 根据电影ID检索评论
    $stmt = $conn->prepare("SELECT username, comment ,`time` FROM all_comments WHERE film_id = ?");
    $stmt->bind_param("i", $movieId);
    $stmt->execute();
    $result = $stmt->get_result();

    // 检索所有评论和用户信息
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='comment'>";
            echo "<p class='user'>" . htmlspecialchars($row['username']) . ':' . htmlspecialchars($row['comment']) . "</p>"; // 显示用户名和评论
            echo "<p class='time' style='color: #bea1a1'>" . $row['time'] . "</p>";
            echo "</div>";
        }
    } else {
        echo "<div class='comment'>暂无评论。</div>";
    }

    // 关闭预处理语句
    $stmt->close();

// 关闭数据库连接
$conn->close();

