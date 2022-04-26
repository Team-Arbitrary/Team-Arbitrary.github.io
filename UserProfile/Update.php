<?php
require_once "../SessionChecker.php";


require_once "../Database/Connection.php";  // Connect Database
if ( !isset($connection) )  // Check if the Database connection exists
{
    exit("! Could not find Database connection, Please contact administrator");
}


// Query Related Information of The User
// Prepare SQL statement, preparing the SQL statement will prevent SQL injection.
// and Statements can be reused without repeated loading.
if ( !$statement = $connection->prepare(
    "SELECT user.name, user.status, user.email FROM user WHERE user.id = ?") )
{
    exit("! Failed to prepare SQL statement, Please contact administrator");
}

// Bind parameters (s = string, i = int, d = double, b = BLOB[binary large object])
$statement->bind_param('s', $_SESSION['userID']);


// Execute
if ( !$statement->execute() )
{
    exit("! Failed to query the database, Please contact administrator");
}
$statement->store_result();

if ($statement->num_rows == 1)
{
    $statement->bind_result($name, $status, $email);

    while ($statement->fetch())  // Fetch results from a prepared SQL statement into the bound variables
    {
        $user[] = array("name"=>$name,
                        "status"=>$status,
                        "email"=>$email);
    }

    exit(json_encode($user));
}
else
{
    exit("! Database Error, Please contact the administrator");
}