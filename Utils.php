<?php
function LogAtConsole($message)
{
    echo("<script type='text/javascript'> console.log('$message'); </script>");
}

function Alert($message)
{
    echo("<script type='text/javascript'> window.alert('$message'); </script>");
}

function GoToURL($url)
{
    exit("<script type='text/javascript'> window.location.href='$url'; </script>");
}