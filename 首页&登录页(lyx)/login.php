<?php
session_start();
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

if (!isset($_POST["login"])) {
    $postEmail = $_POST['email'];
    $postPassword = $_POST['password'];

    // 对用户输入的密码进行 MD5 加密
    $postPasswordMD5 = md5($postPassword);

    // 使用准备好的语句来查询数据库
    $stmt = $conn->prepare("SELECT * FROM userinfo WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $postEmail, $postPasswordMD5);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userName = $row["userName"];
        // 存储用户信息到 Session
        setcookie("userName", $userName, time() + 3600);
        $_SESSION["userName"] = $userName;

        // 返回 JSON 格式的成功消息
        echo json_encode(["success" => true, "message" => "登录成功", "userName" => $userName]);
    } else {
        // 返回 JSON 格式的失败消息
        echo json_encode(["success" => false, "message" => "邮箱或密码错误，请重新输入"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "数据未提交"]);
}

$conn->close();
