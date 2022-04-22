<?php
$HOME_PAGE_URL = "Home/Home.html";


require_once "Utils.php";


session_start();

//if( session_status() !== PHP_SESSION_ACTIVE )
//{
//    AlertAtJavaScript("No Active Session! ".
//                      "userName: {$_SESSION['userName']} ".
//                      "userID: {$_SESSION['userID']}");
//}
//if ( session_status() === PHP_SESSION_ACTIVE )
//{
//    AlertAtJavaScript("session active, ".
//                      "userName: {$_SESSION['userName']} ".
//                      "userID: {$_SESSION['userID']}");
//}

session_unset();
session_destroy();
Alert("Your account has been successfully Signed out");

//if ( session_status() === PHP_SESSION_NONE )
//{
//    Alert("No Active Session!");
//}

GoToURL($HOME_PAGE_URL);
