<?php
require_once "../SessionChecker.php";


require_once "../Database/Connection.php";  // Connect Database
if ( !isset($connection) )  // Check if the Database connection exists
{
    exit("! Could not find Database connection, Please contact administrator");
}


// Change Related Information of The User
// Prepare SQL statement, preparing the SQL statement will prevent SQL injection.
// and Statements can be reused without repeated loading.
if ( $_POST['newPassword'] == '' )  //Do not change user password
{
    if ( !$statement = $connection->prepare(
        "UPDATE user SET user.name = ?, user.status = ?, user.email = ? 
               WHERE user.id = ?") )
    {
        exit("! Failed to prepare SQL statement, Please contact administrator");
    }

    // Bind parameters (s = string, i = int, d = double, b = BLOB[binary large object])
    $statement->bind_param('ssss', $_POST['userName'],
                                          $_POST['status'], $_POST['email'], $_SESSION['userID']);
}
else  //Change user password
{
    if ( !$statement = $connection->prepare(
        "UPDATE user SET user.name = ?, user.password_hash = ?, user.status = ?, user.email = ? 
               WHERE user.id = ?") )
    {
        exit("! Failed to prepare SQL statement, Please contact administrator");
    }

    if ( !$newPasswordHash = password_hash($_POST['newPassword'], PASSWORD_DEFAULT) )
    {
        exit("! Password encryption failed, Please try again and contact administrator");
    }

    // Bind parameters (s = string, i = int, d = double, b = BLOB[binary large object])
    $statement->bind_param('sssss', $_POST['userName'], $newPasswordHash,
                                                $_POST['status'], $_POST['email'], $_SESSION['userID']);
}


// Execute
if ( !$statement->execute() )
{
    exit("! Failed to update user information to the database, Please contact administrator");
}
exit("Modify user information successfully");
