<?php
require_once "Utils.php";  // Load some common functions to reuse code

if( !session_start() )
{
    Alert("session no start!");
    GoToURL("index.php");
}

GoToURL("Homepage.html");
