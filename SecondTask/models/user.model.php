<?php
namespace models;

use PDOStatement;
use PDO;

class User
{
    public ?PDO $conn;
    public string $table_name = "user";

    // User struct
    public int $id;
    public string $username;
    public string $name;
    public int $cityId;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    public function get(): bool|PDOStatement
    {

        $query = "SELECT city.name as city_name, user.id, user.name, user.username FROM " . $this->table_name . "  LEFT JOIN city ON user.city_id = city.id ORDER BY user.id DESC;";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;

    }

    public function create(): bool
    {

        $query = "INSERT INTO "  . $this->table_name . " SET name =: name, city_id =: cityId, username =: username;";

        $statement = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->cityId = htmlspecialchars(strip_tags($this->cityId));
        $this->username = htmlspecialchars(strip_tags($this->username));

        $statement->bindParam(":name", $this->name);
        $statement->bindParam(":city_id", $this->cityId);
        $statement->bindParam(":username", $this->username);

        if ($statement->execute()) {
            return true;
        }

        return false;
    }

    public function update(): bool
    {
        $query = "UPDATE " . $this->table_name . " SET name = :name, username = :username, city_id = :city_id WHERE id = :id;";
        $statement = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->cityId = htmlspecialchars(strip_tags($this->cityId));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $statement->bindParam(":name", $this->name);
        $statement->bindParam(":city_id", $this->cityId);
        $statement->bindParam(":username", $this->username);
        $statement->bindParam(":id", $this->id);

        if ($statement->execute()) {
            return true;
        }
        return false;
    }

    public function deleteById(): bool
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?;";
        $statement = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $statement->bindParam(1, $this->id);

        if ($statement->execute()) {
            return true;
        }
        return false;
    }


}