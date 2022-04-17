<!--<section>-->
<!--    TODO: Add fields and file to handle Login. -->
<!--     This should point to a .php file that handles the Login by checking the $_POST superglobal-->
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
$LOGIN_PAGE_URL = "../Login/Login.html";
$MAIN_PAGE_URL = "../Main.html";  // TODO Homepage url after Login

session_start();

require_once "../Utils.php";  // Load some common functions to reuse code
require_once "../Database/Connection.php";  // connect Database

// check if the Database connection exists.
if ( !isset($connection) )
{
    exit("! Could not find Database connection");
}

// check if the username and the password exists.
if ( !isset($_POST['userName'], $_POST['password']) )
{
    Alert("Please fill both the username and password fields!");
    GoToURL($LOGIN_PAGE_URL);
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($statement = $connection->prepare("SELECT user.id, user.password_hash FROM user WHERE user.name = ?"))
{
    // Bind parameters (s = string, i = int, etc), in our case the username is a string, so we use "s"
    $statement->bind_param('s', $_POST['userName']);
    $statement->execute();
    $statement->store_result();  // Store the result if the account exists in the Database.

    if ($statement->num_rows == 1)
    {
        $statement->bind_result($userId, $passwordHash);
        $statement->fetch();  // Fetch results from a prepared SQL statement into the bound variables

        // TODO before the registration system is completed, the hash value is not used as a judgment basis
//        if (password_verify($_POST['password'], $password_hash))
        if ($_POST['password'] === $passwordHash)
        {
            // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION['isLogged'] = TRUE;

            $_SESSION['userName'] = $_POST['userName'];
            $_SESSION['userId'] = $userId;

            Alert("Login Successful! Welcome back, {$_SESSION['userName']} (*^▽^*)");
            GoToURL($MAIN_PAGE_URL);
        }
        else
        {
            Alert("Incorrect Password!");
            GoToURL($LOGIN_PAGE_URL);
        }
    }
    else
    {
        // Incorrect username or The Database has more than one identical username that the user entered
        Alert("Incorrect Username or Database Error!");
        GoToURL($LOGIN_PAGE_URL);
    }

    $statement->close();  // Close the SQL prepared statement
    $connection->close();  // close the connection to the Database
}
?>
