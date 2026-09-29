<?php

class Database {
    private $host = "127.0.0.1";
    private $db   = "curso_php";
    private $user = "desarrollador";
    private $pass = "clave123";
    private $charset = "utf8mb4";
    private $pdo;

    public function __construct() {
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
        
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (\PDOException $e) {
            die("Error de Conexión en Clase Database: " . $e->getMessage());
        }
    }

    // Método para obtener la instancia de PDO activa
    public function getConnection() {
        return $this->pdo;
    }
}