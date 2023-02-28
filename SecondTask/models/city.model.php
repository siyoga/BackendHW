<?php
namespace models;

use PDOStatement;
use PDO;

class City{
    private ?PDO $connect;
    private string $table_name = "city";

    public int $id;
    public string $name;

    public function __construct($db)
    {
        $this->connect = $db;
    }

    public function get(): bool|PDOStatement
    {
        $query = "SELECT * FROM " . $this->table_name . ";";

        $statement = $this->connect->prepare($query);
        $statement->execute();

        return $statement;
    }

    public function create(): bool
    {
        $query = "INSERT INTO "  . $this->table_name . " SET name =: name;";

        $statement = $this->connect->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));

        $statement->bindParam(":name", $this->name);

        if ($statement->execute()) {
            return true;
        }

        return false;
    }

    public function update(): bool
    {
        $query = "UPDATE " . $this->table_name . " SET name = :name WHERE id = :id;";
        $statement = $this->connect->prepare($query);
        
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $statement->bindParam(":name", $this->name);
        $statement->bindParam(":id", $this->id);

        if ($statement->execute()) {
            return true;
        }
        return false;
    }

    public function delete(): bool
    {

        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?;";
        $statement = $this->connect->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $statement->bindParam(1, $this->id);

        if ($statement->execute()) {
            return true;
        }
        return false;
    }



}