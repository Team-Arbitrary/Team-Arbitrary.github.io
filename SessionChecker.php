<?php
// Check if user is signed in
session_start();
if (!isset($_SESSION['userID']))  //User not signed in
{
    if (isset($_SESSION['password']))  //The account has just been signed up but not signed in
    {
        exit("Automatically sign in ...");
    }
    else
    {
        exit("The session has expired or the account is not signed in");
    }
}
