<?php
require_once "Utils.php";  // Load some common functions to reuse code

if ( session_status() )
{
    Alert("session active");
}

session_unset();

if ( !session_status() )
{
    Alert("session no active");
}
