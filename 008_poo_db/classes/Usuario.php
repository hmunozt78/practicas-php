<?php

class Usuario {
    private $db;

    // Recibimos la conexión PDO en el constructor (Inyección de Dependencia)
    public function __construct($conexionPdo) {
        $this->db = $conexionPdo;
    }

    // READ: Obtener todos los usuarios
    public function obtenerTodos() {
        try {
            $stmt = $this->db->query("SELECT id, nombre, email, creado_en FROM usuarios ORDER BY id DESC");
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            return [];
        }
    }

    // READ: Obtener un solo usuario por ID
    public function obtenerPorId($id) {
        try {
            $stmt = $this->db->prepare("SELECT id, nombre, email FROM usuarios WHERE id = :id");
            $stmt->execute([":id" => $id]);
            return $stmt->fetch();
        } catch (\PDOException $e) {
            return false;
        }
    }

    // CREATE: Guardar un usuario nuevo
    public function crear($nombre, $email) {
        $sql = "INSERT INTO usuarios (nombre, email) VALUES (:nombre, :email)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ":nombre" => $nombre,
            ":email"  => $email
        ]);
    }

    // UPDATE: Actualizar datos de un usuario existente
    public function actualizar($id, $nombre, $email) {
        $sql = "UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ":nombre" => $nombre,
            ":email"  => $email,
            ":id"     => $id
        ]);
    }

    // DELETE: Eliminar un usuario por ID
    public function eliminar($id) {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([":id" => $id]);
    }
}