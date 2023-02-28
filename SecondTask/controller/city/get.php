<?php

use models\City;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "config/database.php";
include_once "models/city.php";

$database = new Database();
$db = $database->getConnection();

$city = new City($db);

$statement = $city->get();
$num = $statement->rowCount();

if ($num > 0) {
    $cityArray = array();
    $cityArray["items"] = array();

    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $cityItem = array(
            "id" => $id,
            "name" => $name
        );

        $cityArray["items"][] = $cityItem;

    }

    http_response_code(200);
    echo json_encode($cityArray);
} else {
    http_response_code(404);
    echo json_encode(["message" => "City not found."]);
}