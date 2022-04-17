<?php
require_once "Utils.php";  // Load some common functions to reuse code

session_start();
if( session_status() !== PHP_SESSION_ACTIVE )
{
    Alert("No Active Session!");
    GoToURL("index.php");
}

GoToURL("Homepage.html");
