<?php

if (isset($_POST['register'])) {
    $user = $_POST['username'];
    $Pwd = $_POST['password'];
    $email = $_POST['email'];

    // 创建数据库连接
    $conn = new mysqli('localhost', 'root', 'ab433600cd', 'final');
    $conn->set_charset("utf8");

    // 检查数据库连接
    if ($conn->connect_errno) {
        echo "数据库连接失败: " . $conn->connect_error;
        exit();
    }

    // 使用预处理语句防止 SQL 注入
    $stmt = $conn->prepare("INSERT INTO userinfo (username, email, password) VALUES (?, ?, ?)");
    $hashedPwd = password_hash($Pwd, PASSWORD_DEFAULT);
    $stmt->bind_param("sss", $user, $email, $hashedPwd);
    $stmt->execute();

    if ($stmt->errno) {
        echo "注册失败: " . $stmt->error;
    } else {
        echo "<script>alert('已成功注册');</script>";
        // echo "<script>window.location.href='registerAndLogin.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
