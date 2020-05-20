<?php
require 'config.php';

// 创建连接
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

// 检测连接
if($conn->connect_error){
	die('数据库连接错误：'.$conn->connect_error);
}
?>