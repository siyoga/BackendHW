<?php

use models\User;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once 'config/database.php';
include_once 'models/user.model.php';

$database = new Database();
$conn = $database->getConnection();

$user = new User($conn);

if (
    !empty($_POST['name']) &&
    !empty($_POST['username']) &&
    !empty($_POST['city_id'])
    )
{
    $user->name = $_POST['name'];
    $user->username = $_POST['username'];
    $user->cityId = $_POST['city_id'];

    if ($user->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "User created."));
    } else {
        http_response_code(503);
        echo json_encode(["message" => "Could't create user."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Could't create user. Check the request data."]);
}
