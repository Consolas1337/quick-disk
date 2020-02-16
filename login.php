<?php
include 'config.php';

header('Content-Type: application/json');
function sendError($message) {
    echo json_encode(array("error" => $message));
    die();
}
if (!isset($_POST['password'])) {
    sendError("Need password!");
}
$userPass = $_POST['password'];
$mysqli = new mysqli($host, $login, $password, $database);
$response = array();

if ($mysqli->connect_error) {
    sendError("MySQL error: ".$mysqli->connect_error);
}

$userPass = $mysqli->real_escape_string($userPass);
$result = $mysqli->query("SELECT token,name,role FROM `users` WHERE password=".$userPass);

if ($result->num_rows === 0 or !$result) {
    sendError("Wrong password");
}
echo json_encode($result->fetch_assoc());
$mysqli->close();
?>