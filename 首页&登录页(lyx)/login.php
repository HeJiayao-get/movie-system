<?php
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
// login.php

// ...数据库连接代码...

if (!isset($_POST["login"])) {
    $postEmail = $_POST['email'];
    $postPassword = $_POST['password'];
    $sql = "SELECT * FROM userinfo WHERE email = '$postEmail' AND password = '$postPassword'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userName = $row["userName"];
        setcookie("userName", $userName, time() + 3600, "/", "", false, true);
        echo json_encode(["success" => true, "message" => "登录成功"]);
    } else {
        echo json_encode(["success" => false, "message" => "邮箱或密码错误，请重新输入"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "数据未提交"]);
}

$conn->close();


