<?php
function LogAtConsole($message)
{
    echo("<script> console.log('$message'); </script>");
}

function Alert($message)
{
    echo("<script> window.alert('$message'); </script>");
}

function GoToURL($url)
{
    exit("<script> window.location.href='$url'; </script>");
}