<?php
require_once "Events.php";


require_once "../Database/Connection.php";  // Connect Database
if ( !isset($connection) )  // Check if the Database connection exists
{
    exit("! Could not find Database connection, Please contact administrator");
}


// Query All Event of The User
// Prepare SQL statement, preparing the SQL statement will prevent SQL injection.
// and Statements can be reused without repeated loading.
if ( !$statement = $connection->prepare(
    "SELECT event.id , event.name, event.type, event.start_time, event.end_time, 
                  event.organization, event.presenter, event.description 
           FROM event WHERE event.user_id = ?") )
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

if ($statement->num_rows > 0)
{
    $statement->bind_result($id,$name, $type, $startTime, $endTime,
                            $organization, $presenter, $description);

    while ($statement->fetch())  // Fetch results from a prepared SQL statement into the bound variables
    {
        $events[] = array("id"=>$id,
                          "name"=>$name,
                          "type"=>$type,
                          "startTime"=>$startTime,
                          "endTime"=>$endTime,
                          "organization"=>$organization,
                          "presenter"=>$presenter,
                          "description"=>$description);
    }

    exit(json_encode($events));
}
else
{
    exit("No Result");
}