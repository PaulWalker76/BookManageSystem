<?php
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "BooksDB";

// 创建连接
$conn = mysqli_connect($servername, $username, $password, $dbname);
// 检测连接
if (!$conn) {
    die("连接失败: " . mysqli_connect_error());
}
// 设置字符集为 utf8（解决插入中文乱码问题）
mysqli_set_charset($conn, "utf8");
