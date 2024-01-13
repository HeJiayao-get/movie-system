<?php
// 连接数据库
$servername = "localhost";
$username = "root";
$password = "ab433600cd";
$dbname = "final";

$conn = new mysqli($servername, $username, $password, $dbname);

// 检查数据库连接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 检查是否接收到有效的评论ID
if (isset($_GET['comment_id'])) {
    $commentId = $_GET['comment_id'];

    // 使用评论ID从数据库中删除评论
    $sql = "DELETE FROM all_comments WHERE id = $commentId";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array('message' => '评论删除成功'));
    } else {
        echo json_encode(array('message' => '评论删除失败: ' . $conn->error));
    }
} else {
    echo json_encode(array('message' => '未接收到有效的评论ID'));
}

// 关闭数据库连接
$conn->close();
?>