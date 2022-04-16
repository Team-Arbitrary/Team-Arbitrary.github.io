<?php
// Configuration
$serverName = "localhost";
$username = "id18780626_arbitrary_tests";
$password = "k6wBr^9q@ShCt1Ns";
$databaseNAME = "id18780626_arbitrary_tests_database";

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
