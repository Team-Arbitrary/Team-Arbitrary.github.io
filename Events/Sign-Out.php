<?php
require_once "../Utils.php";
session_start();

// TODO sign-out
//session_start();
//if( session_status() !== PHP_SESSION_ACTIVE )
//{
//    AlertAtJavaScript("No Active Session! ".
//                      "userName: {$_SESSION['userName']} ".
//                      "userID: {$_SESSION['userID']}");
//    GoToURL("Events.php");
//}
//if ( session_status() === PHP_SESSION_ACTIVE )
//{
//    AlertAtJavaScript("session active, ".
//                      "userName: {$_SESSION['userName']} ".
//                      "userID: {$_SESSION['userID']}");
//}

session_unset();  // TODO 区别
session_destroy();  //TODO 区别

if ( session_status() === PHP_SESSION_NONE )
{
    Alert("No Active Session! 已登出");
}

GoToURL("../Sign-In/Sign-In.html");
