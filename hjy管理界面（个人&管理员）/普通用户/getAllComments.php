<?php
// getAllComments.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
// 从Cookie中获取用户名

// 获取当前页码
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// 查询评论数据
$sql = "SELECT * FROM all_comments LIMIT $offset, $limit";
$result = $conn->query($sql);

// 处理评论数据
$commentsHtml = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $commentsHtml .= '<div style="width: 80%;margin: 0 auto;">';
        $commentsHtml .= '<strong>电影:</strong> ' . $row['film'] . '<br>';
        $commentsHtml .= '<strong>用户:</strong> ' . $row['username'] . '&nbsp&nbsp&nbsp&nbsp&nbsp';
        $commentsHtml .= '<strong>评分:</strong> ' . $row['record'] . '&nbsp&nbsp&nbsp&nbsp&nbsp';
        $commentsHtml .= '<strong>评论时间:</strong> ' . $row['time'] . '<br>';
        $commentsHtml .= '<strong>评论内容:</strong> ' . $row['comment'] . '<br>';
        $commentsHtml .= '<button class="delete-button" data-comment-id="' . $row['id'] . '">删除</button>';
        $commentsHtml .= '</div><hr>';
    }
} else {
    $commentsHtml = 'No comments found.';
}

// 计算总页数
$sqlCount = "SELECT COUNT(*) as total FROM all_comments";
$resultCount = $conn->query($sqlCount);
$rowCount = $resultCount->fetch_assoc();
$totalPages = ceil($rowCount['total'] / $limit);

// 生成分页链接
$paginationHtml = '';
for ($i = 1; $i <= $totalPages; $i++) {
    $activeClass = ($i == $page) ? 'active' : '';
    $paginationHtml .= '<a style="margin: 0 auto;" href="#"' . $activeClass . '" data-page="' . $i . '">' . $i . '</a>';
}

// 关闭数据库连接
$conn->close();

// 返回结果
$response = [
    'commentsHtml' => $commentsHtml,
    'paginationHtml' => $paginationHtml,
];
echo json_encode($response);
