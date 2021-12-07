<?php

namespace App\Core;

use App\Core\Interfaces\IDataBase;

class DataBase implements IDataBase
{
    private $dbConfig;
    private $conn;
    public function __construct()
    {
        $this->dbConfig= json_decode(file_get_contents(__DIR__ . "/../../config/dbConfig.json"), true);
        $this->connect();
    }
    private function connect()
    {
        $servername = $this->dbConfig["server"];
        $username = $this->dbConfig["user"];
        $password = $this->dbConfig["password"];
        $dbName = $this->dbConfig["dbname"];

        // Create connection
        $this->conn = new \mysqli($servername, $username, $password, $dbName);
    }

    public function executeSQL($sql)
    {
        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }
    public function actionSQL($sql)
    {
        return $this->conn->query($sql);
    }
    public function __destruct()
    {
        if ($this->conn != null) $this->conn->close();
    }
    public function escape($value){
        return $this->conn->real_escape_string($value);
    }
    public function prepare($stmt){
        return $this->conn->prepare($stmt);
    }
}
