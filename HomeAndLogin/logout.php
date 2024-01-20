<?php
// 删除 cookie 中的 userName 信息
if (isset($_COOKIE["userName"])) {
    setcookie("userName", "", time() - 3600,);
}

// 构建 JSON 响应
$response = array("success" => true);

// 返回 JSON 响应给前端
header('Content-Type: application/json');
echo json_encode($response);
