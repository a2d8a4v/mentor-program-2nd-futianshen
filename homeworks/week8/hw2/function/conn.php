<?php
/* 建立登入檔案 */
$db_hostname = "localhost"; 
$db_username = "tian";
$db_password = "zUUM9nku=FkKwtyX"; 
$db_name = "week8hw2"; // database name

$conn = new mysqli($db_hostname, $db_username, $db_password, $db_name); // 建立一個新物件 mysqli
$conn->query("SET NAMES 'UTF8'"); // 設定資料庫編碼
$conn->query("SET time_zone = '+08:00'"); // 設定資料庫時區

if ($conn->connect_error) { //connect_error 是內建函式 回傳錯誤訊息
    die("連接失敗: " . $conn->connect_error); // die 停止執行 PHP 程式
}
?>