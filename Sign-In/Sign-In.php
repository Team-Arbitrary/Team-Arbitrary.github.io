<?php
// Configuration
$SIGN_IN_PAGE_URL = "../Sign-In/Sign-In.html";
$MAIN_PAGE_URL = "../ProfessionalDevelopmentEvents/ProfessionalDevelopmentEvents.html";


require_once "../Utils.php";  // Load some common functions to reuse code


// Check If The Username And The Password Exists
session_start();
if ( isset($_POST['userName'], $_POST['password']) )  // From sign-in action of user
{
    $postedUserName = $_POST['userName'];
    $postedPassword = $_POST['password'];
}
elseif (isset($_SESSION['userName'], $_SESSION['password']))  // From sign-up action of user
{
    $postedUserName = $_SESSION['userName'];
    $postedPassword = $_SESSION['password'];
    unset($_SESSION['password']);
}
else
{
    Alert("Please fill both the username and password fields!");
    GoToURL($SIGN_IN_PAGE_URL);
}


// Connect Database
require_once "../Database/Connection.php";
if ( !isset($connection) )  // Check if the Database connection exists
{
    Alert("! Could not find Database connection, Please contact the administrator");
    GoToURL($SIGN_IN_PAGE_URL);
}


// Query The User ID And Password of The User
// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
// and Statements can be reused without repeated loading.
if ( !$statement = $connection->prepare("SELECT user.id, user.password_hash FROM user WHERE user.name = ?") )
{
    Alert("! Failed to prepare SQL statement, Please contact administrator");
    GoToURL($SIGN_IN_PAGE_URL);
}

// Bind parameters (s = string, i = int, d = double, b = BLOB[binary large object])
$statement->bind_param('s', $postedUserName);


// Execute
if ( !$statement->execute() )
{
    Alert("! Failed to query the database, Please contact administrator");
    GoToURL($SIGN_IN_PAGE_URL);
}
$statement->store_result();

if ($statement->num_rows == 1)
{
    $statement->bind_result($userID, $passwordHash);
    $statement->fetch();  // Fetch results from a prepared SQL statement into the bound variables

    //$statement->close();  // Close the SQL prepared statement
    //$connection->close(); // close the connection to the Database

    if (password_verify($postedPassword, $passwordHash))
    {
        $_SESSION['userID'] = $userID;

        if ( !isset($_SESSION['userName']) )  // From sign-in action of user
        {
            $_SESSION['userName'] = $postedUserName;
            Alert("Sign In Successful! Welcome back, {$_SESSION['userName']} (*^▽^*)");
        }
        else  // From sign-up action of user
        {
            Alert("Sign In Successful! Welcome, {$_SESSION['userName']} (*^▽^*)");
        }

        session_write_close();

//        if ( session_status() === PHP_SESSION_NONE )
//        {
//            Alert("session NONE, ".
//                "userName: {$_SESSION['userName']} ".
//                "userID: {$_SESSION['userID']}");
//        }

        GoToURL($MAIN_PAGE_URL);
    }
    else
    {
        Alert("Incorrect Password!");
        GoToURL($SIGN_IN_PAGE_URL);
    }
}
elseif ($statement->num_rows < 1)
{
    Alert("Incorrect Username!");
}
elseif ($statement->num_rows > 1)
{
    Alert("! Database Error:".
                "The Database has more than one identical username that the user entered,".
                "Please contact the administrator");
}
else
{
    Alert("! Database Error, Please contact the administrator");
}
GoToURL($SIGN_IN_PAGE_URL);
