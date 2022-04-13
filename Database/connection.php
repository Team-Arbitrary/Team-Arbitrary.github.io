<?php
require_once "../utils.php";  // 载入一些常用函数以复用代码

// connection information
$serverName = "localhost";
$username = "admin";
$password = "zxcv7373";
$databaseNAME = "id18737052_project_schema";

// Try to connect
$connection = new mysqli($serverName, $username, $password, $databaseNAME);
if ($connection->connect_error) {
    exit("! Database connection failed: $connection->connect_error");
}
LogAtConsole("Database connection succeeded");
