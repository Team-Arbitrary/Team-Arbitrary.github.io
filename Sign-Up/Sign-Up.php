<?php
// Configuration
$SIGN_UP_PAGE_URL = "../Sign-Up/Sign-Up.html";
$MAIN_PAGE_URL = "../Main.html";  // TODO Homepage url

session_start();

require_once "../Utils.php";  // Load some common functions to reuse code
require_once "../Database/Connection.php";  // connect Database

// Check if the Database connection exists.
if ( !isset($connection) )
{
    Alert("! Could not find Database connection, Please contact administrator");
    GoToURL($SIGN_UP_PAGE_URL);
}

// Check if the username and the password exists.
if ( !isset($_POST['userName'], $_POST['password']) )
{
    Alert("Please fill both the username and password fields!");
    GoToURL($SIGN_UP_PAGE_URL);
}


// Check if the account exists in the Database
// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
// and Statements can be reused without repeated loading.
if ( !$statement = $connection->prepare("SELECT user.id FROM user WHERE user.name = ?") )
{
    Alert("! Failed to prepare SQL statement, Please contact administrator");
    GoToURL($SIGN_UP_PAGE_URL);
}

// Bind parameters (s = string, i = int, d = double, b = BLOB[binary large object])
$statement->bind_param('s', $_POST['userName']);
if ( !$statement->execute() )
{
    Alert("! Failed to query the database, Please contact administrator");
    GoToURL($SIGN_UP_PAGE_URL);
}
$statement->store_result();

if ($statement->num_rows == 1)
{
    Alert("The account already exists");
    GoToURL($SIGN_UP_PAGE_URL);
}
elseif ($statement->num_rows > 1)
{
    Alert("! Database Error:".
                "The Database has more than one identical username that the user entered,".
                "Please contact the administrator");
    GoToURL($SIGN_UP_PAGE_URL);
}


// Sign Up
// Prepare our SQL, preparing the SQL statement will prevent SQL injection
// and Statements can be reused without repeated loading.
if ( !$statement = $connection->prepare("INSERT INTO user (name, password_hash, email) VALUES (?, ?, ?)") )
{
    Alert("! Failed to prepare SQL statement, Please contact administrator");
    GoToURL($SIGN_UP_PAGE_URL);
}

if ( !$passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT) )
{
    Alert("! Password encryption failed, Please try again and contact administrator");
    GoToURL($SIGN_UP_PAGE_URL);
}

// Bind parameters (s = string, i = int, d = double, b = BLOB[binary large object])
$statement->bind_param('sss', $_POST['userName'], $passwordHash, $_POST['email']);

if ( !$statement->execute() )
{
    Alert("! Failed to insert new account into database, Please contact administrator");
    GoToURL($SIGN_UP_PAGE_URL);
}
//$statement->close();  // Close the SQL prepared statement
//$connection->close();  // close the connection to the Database

Alert("Congratulations, {$_POST['userName']}, Successfully signed up an account");
GoToURL($MAIN_PAGE_URL);
