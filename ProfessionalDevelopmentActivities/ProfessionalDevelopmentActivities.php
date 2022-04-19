<?php
// Configuration
$SIGN_IN_PHP_URL = "../Sign-In/Sign-In.php";
$SIGN_IN_PAGE_URL = "../Sign-In/Sign-In.html";
$MAIN_PAGE_URL = "../ProfessionalDevelopmentActivities/ProfessionalDevelopmentActivities.html";


require_once "../Utils.php";  // Load some common functions to reuse code


// Check 是否已登录
session_start();
if (isset($_SESSION['userID']))
{
//    AlertAtJavaScript("已登录");
}
elseif (isset($_SESSION['password']))
{
    AlertAtJavaScript("账号刚注册但未登录，即将自动登录");
    GoToURL($SIGN_IN_PHP_URL);
}
else  // 没登录
{
    GoToURL($SIGN_IN_PAGE_URL);
}


require_once "../Database/Connection.php";  // Connect Database
if ( !isset($connection) )  // Check if the Database connection exists
{
    Alert("! Could not find Database connection, Please contact administrator");
    GoToURL($MAIN_PAGE_URL);
}


// Query All Event of The User
// Prepare SQL statement, preparing the SQL statement will prevent SQL injection.
// and Statements can be reused without repeated loading.
if ( !$statement = $connection->prepare(
    "SELECT event.name, event.type, event.start_time, event.end_time, 
                  event.organization, event.presenter, event.description 
           FROM event WHERE event.user_id = ?") )
{
    Alert("! Failed to prepare SQL statement, Please contact administrator");
    GoToURL($MAIN_PAGE_URL);
}

// Bind parameters (s = string, i = int, d = double, b = BLOB[binary large object])
$statement->bind_param('s', $_SESSION['userID']);


// Execute
if ( !$statement->execute() )
{
    Alert("! Failed to query the database, Please contact administrator");
    GoToURL($MAIN_PAGE_URL);
}
$statement->store_result();

if ($statement->num_rows > 0) {
    $statement->bind_result($name, $type, $startTime, $endTime,
                            $organization, $presenter, $description);

    while ($statement->fetch())  // Fetch results from a prepared SQL statement into the bound variables
    {
//        AlertAtJavaScript("{$name}, {$type}, {$startTime}, {$endTime},".
//                          "{$organization}, {$presenter}, {$description}");
//        echo("{$name}, {$type}, {$startTime}, {$endTime}, {$organization}, {$presenter}, {$description}");
        $events[] = array("name"=>$name,
                          "type"=>$type,
                          "startTime"=>$startTime,
                          "endTime"=>$endTime,
                          "organization"=>$organization,
                          "presenter"=>$presenter,
                          "description"=>$description);
    }

    $eventsJSON = json_encode($events);

} else {
    AlertAtJavaScript("No Result");
}

if (isset($eventsJSON))
{
    exit($eventsJSON);
}
else{
    exit();
}









// TODO 通过JSON从服务器传输数据到本地















//session_start();
//if( session_status() !== PHP_SESSION_ACTIVE )
//{
//    AlertAtJavaScript("No Active Session! ".
//                      "userName: {$_SESSION['userName']} ".
//                      "userID: {$_SESSION['userID']}");
//    GoToURL("ProfessionalDevelopmentActivities.php");
//}
//if ( session_status() === PHP_SESSION_ACTIVE )
//{
//    AlertAtJavaScript("session active, ".
//                      "userName: {$_SESSION['userName']} ".
//                      "userID: {$_SESSION['userID']}");
//}






// TODO sign-out
//session_unset();  // TODO 区别
//session_destroy();  //TODO 区别
//
//if ( session_status() === PHP_SESSION_NONE )
//{
//    AlertAtJavaScript("No Active Session!");
//}
