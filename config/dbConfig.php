<?php
// dbconfig.php

class Database {
    private $host = "127.0.0.1";
    private $dbname = "inventory_manager";
    private $username = "root";
    private $password = "";
    private $conn;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
            // Définir l'encodage
            $this->conn->set_charset("utf8mb4");
        } catch (Exception $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
