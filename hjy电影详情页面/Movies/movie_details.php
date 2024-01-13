<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>电影详情页 - 豆瓣</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
<header>
    <div class="header">
        <span>
<!--            <a href="judgeId.php" style="color: rgb(19, 134, 95); ">去登录/注册</a>-->
        </span>
        <span>
            <a href="/hjy管理界面（个人&管理员）/普通用户/Ordi_comments.php"
               style="color: rgb(19, 134, 95); ">去个人中心</a>
        </span>

        <span>
            <div class="search-form">
                <link rel="stylesheet" href="../styles/header.css">
                <form id="searchForm" action="../../首页&登录页(lyx)/search.php" method="get">
                    <div class="search-form">
                        <input type="text" class="search-input" placeholder="搜索...">
                        <button class="search-button">搜索</button>
                    </div>
                </form>
            </div>
        </span>
    </div>
</header>

<main class="content-layout">
    <section class="left-content">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "ab433600cd";
        $dbname = "final";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // 从 URL 中获取电影 ID，并进行检查
        if (!isset($_GET['id'])) {
            echo "电影 ID 没有指定。请跳转至首页进入";
            exit;
        }
        $movieId = intval($_GET['id']);

        // 准备并执行查询
        $stmt = $conn->prepare("SELECT * FROM all_films WHERE id = ?");
        if ($stmt === false) {
            echo "Prepare failed: " . $conn->error;
            exit;
        }
        $stmt->bind_param("i", $movieId);
        $stmt->execute();
        $result = $stmt->get_result();
        $movie = $result->fetch_assoc();

        if (!$movie) {
            echo "没有找到电影。";
        } else {            // 现在获取图片数据
            $stmt2 = $conn->prepare("SELECT movieImage FROM all_films WHERE id = ?");
            if ($stmt2 === false) {
                echo "Prepare failed: " . $conn->error;
                $stmt->close();
                $conn->close();
                exit;
            }
            $stmt2->bind_param("i", $movieId);
            $stmt2->execute();
            $stmt2->store_result();
            $stmt2->bind_result($imageData);
            if ($stmt2->fetch()) {
                // 输出图片数据
                echo '<img src="' . $imageData . ' " alt="" />';
            } else {
                echo "没有找到电影海报。";
            }
            $stmt2->close();
        }

        // 展示电影信息
        echo '<h1>' . $movie['title'] . '</h1>';
        echo '<p>导演：' . $movie['director'] . '</p>';
        echo '<p>主演：' . $movie['leadAct'] . '</p>';
        echo '<p>电影类型：' . $movie['type'] . '</p>';
        echo '<p>上映时间：' . $movie['releaseTime'] . '</p>';
        echo '<p>评分：' . $movie['record'] . '</p>';
        echo '<p>电影简介：' . $movie['intro'] . '</p>';
        // 这里可以包含一些PHP逻辑，例如获取用户的评分
//        $userRating = 0; // 假设用户之前评过分，并且评分是3星
//
//        // 然后在HTML中输出星级评分
//        echo '<div class="star-rating" id="star-rating">';
//        for ($i = 1; $i <= 5; $i++) {
//            $selectedClass = ($i <= $userRating) ? 'selected' : ''; // 如果循环的星级小于等于用户评分，则添加selected类
//            echo '<span class="star ' . $selectedClass . '" data-rating="' . $i . '">&#9733;</span>';
//        }
//        echo '</div>';
//        echo '<div id="selected-rating">您的评分：' . $userRating . '</div>';
        $stmt->close();
        $conn->close();
        ?>


    </section>

    <section class="right-content">
        <form action="./import_comment.php" class="form" id="cmtForm" method="post">
            <h2>请发表你的评论~</h2>
            <input type="hidden" name="movieId" value="<?php echo $movieId; ?>">

            <label>
                <input name="cmt" style="height: 200px;width:800px">
            </label>
            <button type="submit" class="btn" name="submit">发送评论</button>
        </form>
        <br>

        <style>
            .star-rating {
                font-size: 24px;
                cursor: pointer;
            }

            .star {
                display: inline-block;
                margin-right: 5px;
            }

            .star:hover,
            .star.active {
                color: gold;
            }

        </style>


        <div id="selected-rating">您的评分：0</div><div class="star-rating" id="star-rating">
            <span class="star" data-rating="1">&#9733;</span>
            <span class="star" data-rating="2">&#9733;</span>
            <span class="star" data-rating="3">&#9733;</span>
            <span class="star" data-rating="4">&#9733;</span>
            <span class="star" data-rating="5">&#9733;</span>
        </div>
        <script type="text/javascript">
            const stars = document.querySelectorAll(".star");
            const selectedRating = document.getElementById("selected-rating");

            let rating = 0;

            stars.forEach((star) => {
                star.addEventListener("mouseover", () => {
                    resetStars();
                    const ratingValue = parseInt(star.getAttribute("data-rating"));
                    highlightStars(ratingValue);
                });

                star.addEventListener("mouseout", () => {
                    resetStars();
                    highlightStars(rating);
                });

                star.addEventListener("click", () => {
                    rating = parseInt(star.getAttribute("data-rating"));
                    selectedRating.innerHTML = `您的评分：${rating}`;
                });
            });

            function resetStars() {
                stars.forEach((star) => {
                    star.classList.remove("active");
                });
            }

            function highlightStars(count) {
                for (let i = 0; i < count; i++) {
                    stars[i].classList.add("active");
                }
            }

        </script>


        <p style="font-size:25px;font-weight:bold">用户评论:</p>
        <form id="comments-display" class="comments-display" action="import_comment.php">
            <link rel="stylesheet" href="../styles/disp-cmt.css">

            <script>console.log(111)</script>
            <!--            测试-->
            <!-- 这里将会使用PHP动态填充评论 -->
            <?php include('disp_comment.php'); ?>
        </form>

    </section>

</main>

<div id="footer-container"></div>
<link rel="stylesheet" href="../styles/footer.css">

<!--<script src="../Dynamic effects.js" type="text/javascript"></script>-->
</body>
</html>