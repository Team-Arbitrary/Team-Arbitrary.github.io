<!--<section>-->
<!--    TODO: Add fields and file to handle login. -->
<!--     This should point to a .php file that handles the login by checking the $_POST superglobal-->
<!--            and testing whether user input matches the hashed password in the database. If so,-->
<!--            mark the session as logged in. -->
<!--            -->
<!--    <form method="POST" action="">-->
<!--        This should have username/password with appropriate HTML types. -->
<!---->
<!--    </form>-->
<!--</section>-->

<?php //include '../header.php'; ?>

<?php
require_once "../utils.php";  // 载入一些常用函数以复用代码

session_start();

// connect database and check if the database connection exists.
require_once "../Database/connection.php";
if ( !isset($connection) )
{
    exit("! Could not find database connection");
}

// check if the username and the password exists.
if ( !isset($_POST['username'], $_POST['password']) )
{
    exit("Please fill both the username and password fields!");
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($statement = $connection->prepare("SELECT user.id, user.password_hash FROM user WHERE user.username = ?"))
{
    // Bind parameters (s = string, i = int, etc), in our case the username is a string, so we use "s"
    $statement->bind_param('s', $_POST['username']);
    $statement->execute();
    $statement->store_result();  // Store the result if the account exists in the database.

    if ($statement->num_rows == 1)
    {
        $statement->bind_result($id, $password_hash);
        $statement->fetch();  // Fetch results from a prepared SQL statement into the bound variables

//        if (password_verify($_POST['password'], $password_hash))
        if ($_POST['password'] === $password_hash)
        {
            // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION['is_logged'] = TRUE;

            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;

            Alert("Login Successful! Welcome back, {$_SESSION['name']} (*^▽^*)");
        }
        else
        {
            Alert("Incorrect Password!");
            GoToURL("../login/login.html");
        }
    }
    else
    {
        // Incorrect username or The database has more than one identical username that the user entered
        Alert("Incorrect Username or Database Error!");
        GoToURL("../login/login.html");
    }

    $statement->close();  // 关闭SQL语句的执行
    $connection->close();  // 关闭数据库的连接
}
?>

<?php //include '../footer.php'; ?>


