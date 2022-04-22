<?php
$EVENT_FORM_PAGE_URL = "../EventForm/EventForm.html";


require_once "../Utils.php";  // Load some common functions to reuse code


// Check If The name, type, startDate and endDate Exists
if ( !isset($_POST['name'], $_POST['type'], $_POST['startDate'], $_POST['endDate']) )
{
    Alert("Please fill the name, type, start date and end date fields!");
    GoToURL($EVENT_FORM_PAGE_URL);
}


// Connect Database
require_once "../Database/Connection.php";
if ( !isset($connection) )  // Check if the Database connection exists
{
    Alert("! Could not find Database connection, Please contact administrator");
    GoToURL($EVENT_FORM_PAGE_URL);
}


// Prepare our SQL, preparing the SQL statement will prevent SQL injection
// and Statements can be reused without repeated loading.
if ( !$statement = $connection->prepare("INSERT INTO event (user_id, name, type, start_time, end_time, 
                                                                  organization, presenter, description) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)") )
{
    Alert("! Failed to prepare SQL statement, Please contact administrator");
    GoToURL($EVENT_FORM_PAGE_URL);
}

// Bind parameters (s = string, i = int, d = double, b = BLOB[binary large object])
session_start();
$statement->bind_param('ssssssss', $_SESSION['userID'],$_POST['name'], $_POST['type'], $_POST['startDate'], $_POST['endDate'],
                       $_POST['organization'], $_POST['presenter'], $_POST['description']);


// Execute
if ( !$statement->execute() )
{
    Alert("! Failed to insert new event into database, Please contact administrator");
    GoToURL($EVENT_FORM_PAGE_URL);
}
Alert("Add event successfully");
GoToURL($EVENT_FORM_PAGE_URL);
