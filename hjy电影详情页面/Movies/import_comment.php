<?php
if(!$_COOKIE['userName']){
    echo "<script>alert('用户未登录！！！');</script>";
}
else{
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

    if (($_POST["cmt"]) && ($_POST["movieId"])) {
        $postCmt = $_POST['cmt'];
        $filmId = $_POST['movieId']; // 获取电影ID


        if (trim($postCmt) != "") {
            // 准备并绑定
            // 获取从cookie中获取username的代码
                $username = $_COOKIE['userName']; // 假设cookie的名称是'username'

                // 获取当前时间
                $current_time = date("Y-m-d H:i:s");

                // 准备并执行插入评论的SQL语句
                $stmt = $conn->prepare("INSERT INTO all_comments (comment, film_id,film, username, time) VALUES (?, ?, ?,?, ?)");
                $stmt->bind_param("sisss", $postCmt, $filmId, $filmName, $username, $current_time);


                // 执行并检查结果
                if ($stmt->execute()) {
                    echo "<script>alert('评论成功'); window.location.href='movie_details.php?id=" . $filmId . "';</script>";
                } else {
                    echo "<script>alert('评论更新失败');</script>";
                }

                $stmt->close();

        } else {
            echo "<script>alert('您的评论为空');</script>";
        }
    }

//else {
//    echo "<script>alert('评论提交失败，请检查表单数据');</script>";
//}

// 关闭连接
    $conn->close();

}
?>
