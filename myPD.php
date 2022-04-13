<?php
require_once 'databaseLogin.php';
try 
{
    $pdo = new PDO($attr, $user, $pass, $opts);
} 
catch (PDOException $e)
{
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

if (isset($_POST["status"]) &&
    isset($_POST["sessionName"]) &&
    isset($_POST["sessionType"]) &&
    isset($_POST["startDate"]) &&
    isset($_POST["endDate"]) &&
    isset($_POST["org"]) &&
    isset($_POST["presenter"]) &&
    isset($_POST["description"])) 
{
    $empStatus = get_post($pdo, "status");
    $sessionName = get_post($pdo, "sessionName");
    $sessionType = get_post($pdo, "sessionType");
    $startDate = get_post($pdo, "startDate");
    $endDate = get_post($pdo, "endDate");
    $org = get_post($pdo, "org");
    $presenter = get_post($pdo, "presenter");
    $description = get_post($pdo, "description");
}

$query = "INSERT INTO `session`(`employee_status`, `session_name`, `session_type`, `start_date`, `end_date`, `organization_name`,
            `presenter`, `session_description`) VALUES" . "($empStatus, $sessionName, $sessionType, $startDate, $endDate, $org, $presenter, $description)";
$result = $pdo->query($query);

?>