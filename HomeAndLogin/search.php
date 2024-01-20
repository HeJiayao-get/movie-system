<?php
// 允许所有源跨域访问
header("Access-Control-Allow-Origin: *");

// 连接数据库
$servername = "localhost";
$username = "root";
$password = "ab433600cd";
$dbname = "final";

// 创建数据库连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接是否成功
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 接收搜索关键字
$query = $_GET['query'];

// 查询数据库中匹配关键字的电影信息
$sql = "SELECT id, title FROM all_films WHERE title LIKE '%$query%'";
$result = $conn->query($sql);

// 提取匹配的电影名
$movieNames = array();
$movieIds = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $movieNames[] = $row["title"];
        $movieIds[] = $row["id"];
    }
}else{
    echo"<script>alert('你输入的电影名不存在');window.location.href='index.html';</script>";
}

// 获取数组长度
$count = count($movieIds);
// 输出匹配的电影名
echo '<div id="movieList">'; // 用div包裹电影列表
for ($i = 0; $i < $count; $i++) {
    $id = $movieIds[$i];
    $name = $movieNames[$i];
    echo '<a class="movie-link" href="../hjy电影详情页面/Movies/movie_details.php?id=' . $id . '">' . $name . '</a> ';
}
echo '</div>';

// 在页面的 <head> 部分，用 <style> 标签来设置链接的样式
echo '
    <style>
    .movie-link {

        background-image: none; /* 取消渐变背景图 */
        color: rgb(19, 134, 95); /* 设置链接的颜色为蓝色 */
    }

    .movie-link:hover {
        text-decoration: none; /* 取消链接的下划线 */
        background-image: linear-gradient(to right, #ff8a00, #e52e71); /* 设置链接的渐变背景颜色 */
        color: transparent; /* 链接文本颜色设为透明 */
        -webkit-background-clip: text; /* 使用文字作为背景剪裁 */
        background-clip: text; /* 使用文字作为背景剪裁 */
    }
    </style>
    ';

?>

<script type="text/javascript">
    $(document).ready(function () {
        // 为动态生成的电影链接绑定点击事件
        $("#movieList").on('click', '.movie-link', function (e) {
            e.preventDefault(); // 阻止默认链接跳转行为

            // 获取点击的电影名称
            var selectedMovie = $(this).text();

            // 进行页面跳转到电影详情页面，传递选中的电影名称作为参数
            window.location.href = 'movie_details.php?movie=' + selectedMovie;
        });
    });

    // 关闭数据库连接
    // $conn->close();
</script>

