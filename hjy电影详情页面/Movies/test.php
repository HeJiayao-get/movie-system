<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
<!--    <link rel="stylesheet" href="../styles/style.css">-->
</head>
<?php
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

$conn->set_charset("utf8");

// 从Cookie获取用户名
if (isset($_COOKIE["userName"])) {
    $userName = $_COOKIE["userName"];
        if ($userName == 'admin') {
            header("Location: /hjy管理界面（个人&管理员）/管理员/admin.html");
            exit;
        } else {
            header("Location: /hjy管理界面（个人&管理员）/普通用户/NewOrdinaryUsers.html");
            exit;
        }
    } else {
        die("用户名不存在。");
    }

    $stmt->close();
$conn->close();
?>
</html>