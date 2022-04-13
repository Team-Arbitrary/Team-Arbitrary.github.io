<?php

if (isset($_POST["status"]) &&
    isset($_POST["sessionName"]) &&
    isset($_POST["sessionType"]) &&
    isset($_POST["startDate"]) &&
    isset($_POST["endDate"]) &&
    isset($_POST["org"]) &&
    isset($_POST["presenter"]) &&
    isset($_POST["description"])) 
{
    $empStatus = $_POST["status"];
    $sessionName = $_POST["sessionName"];
    $sessionType = $_POST["sessionType"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];
    $org = $_POST["org"];
    $presenter = $_POST["presenter"];
    $description = $_POST["description"];

    echo "$empStatus<br>$sessionName<br>$sessionType<br>$startDate<br>$endDate<br>";
    echo "$org<br>$presenter<br>$description<br>";
}

?>