<!--<section>-->
<!--    TODO: Add fields and file to handle Sign-In. -->
<!--     This should point to a .php file that handles the Sign-In by checking the $_POST superglobal-->
<!--            and testing whether user input matches the hashed password in the Database. If so,-->
<!--            mark the session as logged in. -->
<!--            -->
<!--    <form method="POST" action="">-->
<!--        This should have username/password with appropriate HTML types. -->
<!---->
<!--    </form>-->
<!--</section>-->

<?php
// Configuration
$SIGN_IN_PAGE_URL = "../Sign-In/Sign-In.html";
$MAIN_PAGE_URL = "../Main.html";  // TODO Homepage url after Sign-In

session_start();

require_once "../Utils.php";  // Load some common functions to reuse code
require_once "../Database/Connection.php";  // connect Database

// Check if the Database connection exists.
if ( !isset($connection) )
{
    Alert("! Could not find Database connection, Please contact the administrator");
    GoToURL($SIGN_IN_PAGE_URL);
}

// Check if the username and the password exists.
if ( !isset($_POST['userName'], $_POST['password']) )
{
    Alert("Please fill both the username and password fields!");
    GoToURL($SIGN_IN_PAGE_URL);
}


// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
// and Statements can be reused without repeated loading.
if ( !$statement = $connection->prepare("SELECT user.id, user.password_hash FROM user WHERE user.name = ?") )
{
    Alert("! Failed to prepare SQL statement, Please contact administrator");
    GoToURL($SIGN_IN_PAGE_URL);
}

// Bind parameters (s = string, i = int, d = double, b = BLOB[binary large object])
$statement->bind_param('s', $_POST['userName']);


// Execute
if ( !$statement->execute() )
{
    Alert("! Failed to query the database, Please contact administrator");
    GoToURL($SIGN_IN_PAGE_URL);
}
$statement->store_result();

if ($statement->num_rows == 1)
{
    $statement->bind_result($userId, $passwordHash);
    $statement->fetch();  // Fetch results from a prepared SQL statement into the bound variables

    //$statement->close();  // Close the SQL prepared statement
    //$connection->close(); // close the connection to the Database

    if (password_verify($_POST['password'], $passwordHash))
    {
        // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
        session_regenerate_id();
        $_SESSION['isLogged'] = TRUE;

        $_SESSION['userName'] = $_POST['userName'];
        $_SESSION['userId'] = $userId;

        Alert("Sign In Successful! Welcome back, {$_SESSION['userName']} (*^▽^*)");
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
?>