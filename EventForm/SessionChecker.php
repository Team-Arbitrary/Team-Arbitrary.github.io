<?php
// Configuration
$SIGN_IN_PHP_URL = "../Sign-In/Sign-In.php";
$SIGN_IN_PAGE_URL = "../Sign-In/Sign-In.html";


require_once "../Utils.php";


// Check if user is signed in
header('Content-Type: text/javascript');
session_start();
if (!isset($_SESSION['userID']))  //User not signed in
{
    if (isset($_SESSION['password']))  //The account has just been signed up but not signed in
    {
        AlertAtJavaScript("Automatically sign in ...");
        GoToURLAtJavaScript($SIGN_IN_PHP_URL);
    }
    else
    {
        AlertAtJavaScript("The session has expired or the account is not signed in");
        GoToURLAtJavaScript($SIGN_IN_PAGE_URL);
    }
}