<?php
echo "<script>alert('已成功注册');</script>";
//配置数据库连接参数
if (isset($_POST['register'])) { //判断用户是否提交了表单（即有无post过来的信息）
    $user = $_POST['username'];
    $Pwd = $_POST['password'];
    $email=$_POST['email'];
    $conn=new mysqli();
    $conn->connect('localhost','root','ab433600cd');
    $conn->select_db('final');
    $conn->query("insert into userinfo (username, email ,password) VALUES ('$user','$email','".md5($Pwd)."')");
//    header("Location: 登录页面的URL");
//    exit;
    if($conn->errno){
        echo $conn->error;
    }else{
        echo"<script>alert('已成功注册');
    </script>";
//        window.location.href='registerAndLogin.html';
    }
    $conn->set_charset("utf8");
    if (mysqli_connect_errno()) {
        echo mysqli_connect_error();
    }
    if ($conn->errno) {
        echo $conn->error;
    }

// $result->close();
    $conn->close();
}




