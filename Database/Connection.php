<?php
// Configuration
$SERVER_NAME = "localhost";

// Local Website
$USERNAME = "admin";
$PASSWORD = "zxcv7373";
$DATABASE_NAME = "arbitrary_team_database";

// Testing Website
//$USERNAME = "id18780626_arbitrary_tests";
//$PASSWORD = "k6wBr^9q@ShCt1Ns";
//$DATABASE_NAME = "id18780626_arbitrary_tests_database";

// Project Website
//$USERNAME = "id18737052_projectschema";
//$PASSWORD = "[vCQ=VZL\bR9n(m^";
//$DATABASE_NAME = "id18737052_project_schema";

require_once "../Utils.php";  // Load some common functions to reuse code

// Try to connect
$connection = new mysqli($SERVER_NAME, $USERNAME, $PASSWORD, $DATABASE_NAME);
if ($connection->connect_error)
{
    exit("! Database connection failed: $connection->connect_error");
}
else
{
    LogAtConsole("Database connection succeeded");
}
