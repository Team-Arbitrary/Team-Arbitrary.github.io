<?php
$HOME_PAGE_URL = "Home/Home.html";


require_once "Utils.php";


session_start();
session_unset();
session_destroy();
Alert("Your account has been successfully Signed out");
GoToURL($HOME_PAGE_URL);
