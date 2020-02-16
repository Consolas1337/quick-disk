<?php
header('Content-Type: application/json');
function sendError($message) {
    echo json_encode(array("error" => $message));
    die();
}
if (!isset($_POST['password'])) {
    sendError("Need password!");
}
$password = $_POST['password'];
$mysqli = new mysqli("localhost", "a0320508_disk", "019283", "a0320508_disk");
// $mysqli = new mysqli("localhost", "root", "", "disk");
$response = array();

if ($mysqli->connect_error) {
    sendError("MySQL error: ".$mysqli->connect_error);
}

$passowrd = $mysqli->real_escape_string($password);
$result = $mysqli->query("SELECT token,name,role FROM `users` WHERE password=".$password);

if ($result->num_rows === 0 or !$result) {
    sendError("Wrond password");
}
echo json_encode($result->fetch_assoc());
$mysqli->close();
?>