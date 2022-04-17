<?php
require_once "../Utils.php";  // Load some common functions to reuse code

session_start();
if ( session_status() === PHP_SESSION_ACTIVE )
{
    Alert("session active, ".
          "isSignedIn: {$_SESSION['isSignedIn']} ".
          "userName: {$_SESSION['userName']} ".
          "userID: {$_SESSION['userID']}");
}

session_destroy();
session_unset();

if ( session_status() === PHP_SESSION_NONE )
{
    Alert("No Active Session!");
}
