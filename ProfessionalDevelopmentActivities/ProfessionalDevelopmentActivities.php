<?php
require_once "../Utils.php";  // Load some common functions to reuse code

session_start();
if( session_status() !== PHP_SESSION_ACTIVE )
{
    Alert("No Active Session!");
    GoToURL("ProfessionalDevelopmentActivities.php");
}
if ( session_status() === PHP_SESSION_ACTIVE )
{
    Alert("session active, ".
          "isSignedIn: {$_SESSION['isSignedIn']} ".
          "userName: {$_SESSION['userName']} ".
          "userID: {$_SESSION['userID']}");
}

session_unset();
session_destroy();

if ( session_status() === PHP_SESSION_NONE )
{
    Alert("No Active Session!");
}
