<?php

use models\User;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once 'config/database.php';
include_once 'models/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$user->id = $_POST['id'];
$user->name = $_POST['name'];
$user->cityId = $_POST['city_id'];
$user->username = $_POST['username'];

if ($user->update()) {
    http_response_code(204);
    echo json_encode(array("message" => "User has been updated."));
}
else {
    http_response_code(503);
    echo json_encode(array("message" => "Could't update user"));

}