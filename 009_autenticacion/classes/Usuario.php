<?php

class Usuario {
    private $db;

    // Recibimos la conexión PDO en el constructor (Inyección de Dependencia)
    public function __construct($conexionPdo) {
        $this->db = $conexionPdo;
    }
    // -------------------------------------------------------------
    // MÉTODOS HEREDADOS DEL MÓDULO 008 (CRUD Básico)
    // -------------------------------------------------------------


    // READ: Obtener todos los usuarios
    public function obtenerTodos() {
        try {
            $stmt = $this->db->query("SELECT id, nombre, email, rol, creado_en FROM usuarios_mod09 ORDER BY id DESC");
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            return [];
        }
    }

    // READ: Obtener un solo usuario por ID
    public function obtenerPorId($id) {
        try {
            $stmt = $this->db->prepare("SELECT id, nombre, email, rol FROM usuarios_mod09 WHERE id = :id");
            $stmt->execute([":id" => $id]);
            return $stmt->fetch();
        } catch (\PDOException $e) {
            return false;
        }
    }

   /*  // CREATE: Guardar un usuario nuevo
    public function crear($nombre, $email) {
        $sql = "INSERT INTO usuarios_mod09 (nombre, email) VALUES (:nombre, :email)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ":nombre" => $nombre,
            ":email"  => $email
        ]);
    } */

    // UPDATE: Actualizar datos de un usuario existente
    public function actualizar($id, $nombre, $email) {
        $sql = "UPDATE usuarios_mod09 SET nombre = :nombre, email = :email WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ":nombre" => $nombre,
            ":email"  => $email,
            ":id"     => $id
        ]);
    }

    // DELETE: Eliminar un usuario por ID
    public function eliminar($id) {
        $sql = "DELETE FROM usuarios_mod09 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([":id" => $id]);
    }

    // -------------------------------------------------------------
    // NUEVOS MÉTODOS DEL MÓDULO 009 (Autenticación y Seguridad)
    // -------------------------------------------------------------

    // Registro adaptado con HASH seguro
    public function registrar($nombre, $email, $password, $rol = 'editor') {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        
        $sql = "INSERT INTO usuarios_mod09 (nombre, email, password, rol) VALUES (:nombre, :email, :password, :rol)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nombre'   => $nombre,
            ':email'    => $email,
            ':password' => $passwordHash,
            ':rol'      => $rol
        ]);
    }

    // Validación de inicio de sesión con password_verify
    public function autenticar($email, $password) {
        $sql = "SELECT id, nombre, email, password, rol FROM usuarios_mod09 WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($password, $usuario['password'])) {
            return $usuario;
        }

        return false;
    }

    // UPDATE: Cambiar la contraseña del usuario autenticado
    public function cambiarPassword($id, $passwordActual, $passwordNueva) {
        // 1. Obtener el hash actual desde MariaDB
        $sql = "SELECT password FROM usuarios_mod09 WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $usuario = $stmt->fetch();

        if (!$usuario) {
            return false;
        }

        // 2. Validar que la contraseña actual ingresada coincida con el hash
        if (!password_verify($passwordActual, $usuario['password'])) {
            return false; // Contraseña actual incorrecta
        }

        // 3. Generar el nuevo hash y actualizar la base de datos
        $nuevoHash = password_hash($passwordNueva, PASSWORD_BCRYPT);
        $updateSql = "UPDATE usuarios_mod09 SET password = :password WHERE id = :id";
        $updateStmt = $this->db->prepare($updateSql);

        return $updateStmt->execute([
            ':password' => $nuevoHash,
            ':id'       => $id
        ]);
    }
}