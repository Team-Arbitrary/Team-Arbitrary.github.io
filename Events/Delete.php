<?php
// Configuration
$EVENTS_PAGE_URL = "../Events/Events.html";


require_once "Events.php";


require_once "../Database/Connection.php";  // Connect Database
if ( !isset($connection) )  // Check if the Database connection exists
{
    exit("! Could not find Database connection, Please contact administrator");
}


// Delete An Event with A Specified ID
// Prepare SQL statement, preparing the SQL statement will prevent SQL injection.
// and Statements can be reused without repeated loading.
if ( !$statement = $connection->prepare(
    "DELETE FROM event WHERE event.id = ?") )
{
    exit("! Failed to prepare SQL statement, Please contact administrator");
}

// Bind parameters (s = string, i = int, d = double, b = BLOB[binary large object])
$statement->bind_param('s', $_POST['id']);


// Execute
if ( !$statement->execute() )
{
    exit("! Failed to query the database, Please contact administrator");
}
$statement->store_result();

Alert("已成功删除");
GoToURL($EVENTS_PAGE_URL);
