<?php
// Configuration
$serverName = "localhost";
$username = "admin";
$password = "zxcv7373";
$databaseNAME = "id18737052_project_schema";

require_once "../utils.php";  // Load some common functions to reuse code

// Try to connect
$connection = new mysqli($serverName, $username, $password, $databaseNAME);
if ($connection->connect_error)
{
    exit("! Database connection failed: $connection->connect_error");
}
else
{
    LogAtConsole("Database connection succeeded");
}
