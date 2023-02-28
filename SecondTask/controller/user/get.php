<?php

use models\User;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "config/database.php";
include_once "models/user.php";

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$statement = $user->get();
$num = $statement->rowCount();

if ($num > 0) {

    $userArray = array();
    $userArray["items"] = array();

    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $userItem = array(
            "id" => $id,
            "username" => $username,
            "name" => $name,
            "city" => $city_name

        );

        $userArray["items"][] = $userItem;

    }

    http_response_code(200);

    echo json_encode($userArray);

} else {
    http_response_code(404);

    echo json_encode(["message" => "Users not found"]);
}
