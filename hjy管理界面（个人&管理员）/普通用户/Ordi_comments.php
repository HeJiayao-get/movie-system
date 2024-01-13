<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment Manager</title>
    <style>
        * {margin: 0;padding: 0;}

        a {
            text-decoration: none;
        }

        .clearfix:after {
            content: "";
            display: block;
            height: 0;
            visibility: hidden;
            clear: both;
        }

        .clearfix {
            *zoom: 1;
        }

        body {
            background-size: cover;
            background: url(../管理界面的图片/3.png) no-repeat fixed;
        }

        .content {
            width: 900px;
            height: 500px;
            margin: 200px auto 0 auto;
            border-radius: 10px;
            background-color: rgba(236, 236, 236, 0.59);
            transition: all 1.0s;
            /*box-shadow: 0px 0px 20px rgba(0,0,0,0.3);*/
        }

        .content img {
            float: left;
            width: 200px;
            height: 200px;
            margin: 150px 0 0 80px;
            border-radius: 100px;

        }

        .content:hover {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.52);
        }

        .content_r {
            float: right;
            width: 500px;
            margin: 80px 60px 0 0;
            /*	background-color: pink;*/
        }

        .content_l {
            float: left;
            width: 100%;
            text-align: center;
        }

        .content_l h5 {

            font-size: 17px;
        }

        .cc {
            margin-top: 10px;
            color: #1F2023;
            font-size: 18px;
        }

        .color_1 {
            color: #4855EC;
            font-size: 18px;
        }

        .deeppink {
            color: deeppink;
        }

        .link {
            margin-top: 30px;
        }

        .link a {
            display: block;
            float: left;
            width: 120px;
            height: 45px;
            margin: 5px 5px 0 0;
            color: #fff;
            line-height: 45px;
            transition: all 0.8s;
            text-align: center; /* 居中文本 */
            font-weight: bold; /* 加粗文本 */
            font-size: 14px; /* 设置字体大小 */
            text-transform: uppercase; /* 将文本转换为大写 */
        }

        .link a:hover {
            background-color: rgba(0, 201, 243, 0.35);
            color: #000; /* 更改鼠标悬停时的文本颜色 */

        }

        .deeppink_1 {
            background-color: deeppink;
        }

        .dodgerblue {
            background-color: dodgerblue;
        }

        .magenta {
            background-color: #e78aea;
        }

        .orange {
            background-color: orange;
        }
        body {
            font-family: 'Arial', sans-serif;
            /*background-color: #fda7d2;*/
            margin: 0;
            padding: 20px;
            animation: backgroundAnimation 5s infinite;
            /*    !*实现了渐变效果*!*/
        }
        @keyframes backgroundAnimation {
            0% {
                background-color: #FFC0CB; /* 起始颜色为粉色 */
            }
            50% {
                background-color: #87CEEB; /* 中间颜色为天蓝色 */
            }
            100% {
                background-color: #FFC0CB; /* 结束颜色为粉色 */
            }
        }

        h1 {
            color: #f6e5b6;

        }

        .comment {
            background-color: #fff;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .comment p {
            margin: 0;
            color: #555;
        }

        .comment p:first-child {
            font-weight: bold;
        }

        #pagination {
            text-align: center;
            padding: 20px 0;
        }

        .pagination-link {
            display: inline-block;
            margin-right: 5px;
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            text-decoration: none;
        }

        .pagination-link:hover {
            background-color: #0056b3;
        }

        .search-form {
            margin-bottom: 20px;
        }

        .search-input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 5px;
        }

        .search-button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .search-button:hover {
            background-color: #0056b3;
        }

        /* 响应式布局 */
        @media (max-width: 600px) {
            .search-form form {
                display: flex;
                flex-direction: column;
            }

            .search-input {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }

    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>
<body>

<h1>Comments Manager</h1>
<!-- header部分 -->
<div class="header">
    <span>
<!--        <a href="registerAndLogin.html" style="color: rgb(19, 134, 95); " id="status">去登录/注册</a>-->
    </span>
    <span>
<!--        <a href="" style="color: rgb(19, 134, 95); ">去个人中心</a>-->
    </span>

    <span>
        <div class="search-form">
            <form id="searchForm" action="#" method="get">
                <input class="search-input" type="text" name="query" placeholder="搜索...">
                <input class="search-button" type="submit" value="搜索">
            </form>
        </div>
    </span>
</div>
<!-- header部分结束 -->

<div id="comments-container"></div>
<div id="pagination"></div>
<?php

// 配置数据库连接参数
$server = 'localhost:3306';
$username = 'root';
$password = 'ab433600cd';
$database = 'final';

// 创建连接
$conn = new mysqli($server, $username, $password, $database);

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

$conn->set_charset("utf8");

// 获取当前页码
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10; // 每页显示的评论数量
$offset = ($page - 1) * $perPage;

// 查询特定用户的评论
$stmt = $conn->prepare("SELECT * FROM all_comments WHERE username = ? LIMIT ? OFFSET ?");
$stmt->bind_param("sii", $username, $perPage, $offset);

// 用户名
//$username = '19857161767';
if (isset($_COOKIE["userName"])) {
    $username = $_COOKIE["userName"];
} else {
    die("用户未登录。");
}

// 查询特定用户的评论
$query = "SELECT * FROM all_comments WHERE username = ? LIMIT ? OFFSET ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sii", $username, $perPage, $offset);
$stmt->execute();
$result = $stmt->get_result();
$rows = $result->fetch_all(MYSQLI_ASSOC);

echo '<div id="comments-container">';
echo"<h1>用户：$username</h1>";
if (count($rows) > 0) {
    // 遍历每个评论并输出
    foreach ($rows as $row) {
        echo "<div class='comment'><p>评论内容：{$row['comment']}</p><p>评论时间: {$row['time']}</p>
                <p>评分: {$row['record']}</p>";
        echo "<button class='delete-button' data-comment-id='{$row['id']}'>删除评论</button>";
        echo "</div><br>";
    }
} else {
    echo "<p>没有找到评论。</p>";
}
echo '</div>'; // 结束评论容器
?>
<script>
    $(document).ready(function () {
        // 初始化页面加载
        loadComments(1);

        // 翻页点击事件
        $(document).on('click', '.pagination-link', function () {
            let page = $(this).data('page');
            loadComments(page);
        });
    });

    function loadComments(page) {
        // 使用AJAX调用getAllComments.php
        $.ajax({
            url: 'getAllComments.php',
            method: 'GET',
            data: { page: page },
            success: function (response) {
                let data = JSON.parse(response); // 修改这里，使用JSON.parse而不是eval
                // 处理获取的评论数据
                $('#comments-container').html(data.commentsHtml);
                $('#pagination').html(data.paginationHtml);
            },
            error: function () {
                console.error('Failed to get comments');
            }
        });
    }

    // Function to handle the AJAX request to delete a comment
    function deleteComment(commentId) {
        $.ajax({
            url: 'delComments.php?comment_id=' + commentId,
            method: 'POST',
            success: function (data) {
                // Reload the comments after deletion
                loadComments(1);
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    }

    // Function to add event listeners to delete buttons
    function setupDeleteButtons() {
        var deleteButtons = document.querySelectorAll('.delete-button');

        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                // Get the comment ID from the data-comment-id attribute
                var commentId = this.getAttribute('data-comment-id');

                // Call the function to delete the comment
                deleteComment(commentId);
            });
        });
    }

</script>

</body>
</html>
