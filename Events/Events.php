<?php
require_once "../Utils.php";  // Load some common functions to reuse code


// Check 是否已登录
session_start();
if (!isset($_SESSION['userID']))  //未登录
{
    if (isset($_SESSION['password']))
    {
        exit("账号刚注册但未登录，即将自动登录");
    }
    else
    {
        exit("登录会话已过期 或 未登录账号");
    }
}


require_once "../Database/Connection.php";  // Connect Database
if ( !isset($connection) )  // Check if the Database connection exists
{
    exit("! Could not find Database connection, Please contact administrator");
}
