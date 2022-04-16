<?php
// Configuration
$serverName = "localhost";

// Local Website
$username = "admin";
$password = "zxcv7373";
$databaseNAME = "arbitrary_team_database";

// Testing Website
//$username = "id18780626_arbitrary_tests";
//$password = "k6wBr^9q@ShCt1Ns";
//$databaseNAME = "id18780626_arbitrary_tests_database"

// Project Website
//$username = "id18737052_projectschema";
//$password = "[vCQ=VZL\bR9n(m^";
//$databaseNAME = "id18737052_project_schema"

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
