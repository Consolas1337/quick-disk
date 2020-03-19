<?php
include 'config.php';

function sendError($message) {
    echo json_encode(array("error" => $message));
    die();
}

header('Content-Type: application/json');

if (!isset($_POST['new_password']) and !isset($_POST['session'])) {
    sendError("Need 'new_password' and 'session' values!");
}
$session = json_decode($_POST['session']);
$userPass = $_POST['new_password'];

// OAuth validator
$validate_string = "expire=".$session->expire."mid=".$session->mid."secret=".$session->secret."sid=".$session->sid.$secret;
if (md5($validate_string)!=$session->sig) {
    sendError("Wrong authorization!");
}

$mysqli = new mysqli($host, $login, $password, $database);
$response = array();

if ($mysqli->connect_error) {
    sendError("MySQL error: ".$mysqli->connect_error);
}

$first_name = $mysqli->real_escape_string($session->user->first_name);
$last_name = $mysqli->real_escape_string($session->user->last_name);
$user_id = $mysqli->real_escape_string($session->user->id);
$userPass = $mysqli->real_escape_string($userPass);
$userImage = $mysqli->real_escape_string($_POST['profilePhotoUrl']);
$folder = $user_id;

$result = $mysqli->query("SELECT id FROM `users` WHERE vk_id='".$user_id."'");

if ($result->num_rows === 0 or !$result) {
    $result = $mysqli->query("INSERT INTO `users` SET name='".$first_name."',last_name='".$last_name."',image_url='".$userImage."',vk_id='".$user_id."',folder='".$folder."',password='".$userPass."'");
} else {
    sendError("This account already registered! Try with another account.");
}

echo json_encode(array("register" => "success"));
$mysqli->close();
?>


