<html>
<link rel="stylesheet" type="text/css" href="style.css">
<a href="/首页&登录页(lyx)/index.html"></a>
</html>
<?php
// displayFilms.php
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
    die("连接失败: " . $conn->connect_error);
}

// 获取当前页码
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// 查询电影数据
$sql = "SELECT title, intro FROM all_films LIMIT $offset, $limit";
$result = $conn->query($sql);

echo "<html><a href='/首页&登录页(lyx)/index.html'></a></html>";
// 开始HTML输出
echo '<div class="films-container" style="width: 80%; margin: 0 auto;">';
echo '<h1>电影列表</h1>';

$sql = "SELECT id, title, intro FROM all_films LIMIT $offset, $limit";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $filmId = $row['id']; // 假设每行数据有一个'id'列
        echo '<div class="film-info" style="padding: 10px; border: 1px solid #ddd; margin-bottom: 10px;">';
        echo '<h2>' . htmlspecialchars($row['title']) . '</h2>';
        // 注意这里添加了 data-film-id 属性
        echo '<p contenteditable="true" data-film-id="' . $filmId . '">' . nl2br(htmlspecialchars($row['intro'])) . '</p>';
        // 添加一个保存按钮，也带有电影ID
        echo '<button class="btn";onclick="saveIntro(' . $filmId . ')">保存</button>';
        echo '</div>';
    }
}
// ...

echo '</div>'; // 结束电影容器的div

// 计算总页数
$sqlCount = "SELECT COUNT(*) as total FROM all_films";
$resultCount = $conn->query($sqlCount);
$rowCount = $resultCount->fetch_assoc();
$totalPages = ceil($rowCount['total'] / $limit);

// 生成分页链接
echo '<div class="pagination" style="text-align: center;">';
for ($i = 1; $i <= $totalPages; $i++) {
    $activeClass = ($i == $page) ? 'active' : '';
    echo '<a href="?page=' . $i . '" class="' . $activeClass . '" style="margin: 5px;">' . $i . '</a>';
}
echo '</div>'; // 结束分页链接的div

// 关闭数据库连接
$conn->close();
?>
<script>
    function saveIntro(filmId) {
        var introElement = document.querySelector('p[data-film-id="' + filmId + '"]');
        var newIntro = introElement.innerText;

        // 使用 fetch API 发送数据
        fetch('saveIntro.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'film_id=' + filmId + '&new_intro=' + encodeURIComponent(newIntro)
        })
            .then(response => response.text())
            .then(text => alert(text))
            .catch(error => console.error('Error:', error));
    }
</script>