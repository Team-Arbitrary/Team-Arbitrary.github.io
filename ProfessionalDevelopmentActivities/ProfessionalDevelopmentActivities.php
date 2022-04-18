<?php
require_once "../Utils.php";  // Load some common functions to reuse code

// TODO 根据session是否有userID判断是否已登录
// TODO 通过JSON从服务器传输数据到本地
session_start();
if( session_status() !== PHP_SESSION_ACTIVE )
{
    Alert("No Active Session! ".
          "userName: {$_SESSION['userName']} ".
          "userID: {$_SESSION['userID']}");
    GoToURL("ProfessionalDevelopmentActivities.php");
}
if ( session_status() === PHP_SESSION_ACTIVE )
{
    Alert("session active, ".
          "userName: {$_SESSION['userName']} ".
          "userID: {$_SESSION['userID']}");
}

session_unset();  // TODO 区别
session_destroy();  //TODO 区别

if ( session_status() === PHP_SESSION_NONE )
{
    Alert("No Active Session!");
}
