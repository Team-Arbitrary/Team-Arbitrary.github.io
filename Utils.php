<?php
function LogAtConsole($message)
{
    echo("<script> console.log('$message'); </script>");
}

function Alert($message)
{
    echo("<script> window.alert('$message'); </script>");
}

function AlertAtJavaScript($message)
{
    echo("window.alert('$message');");
}

function GoToURL($url)
{
    exit("<script> window.location.href='$url'; </script>");
}

function GoToURLAtJavaScript($url)
{
    exit("window.location.href='$url';");
}