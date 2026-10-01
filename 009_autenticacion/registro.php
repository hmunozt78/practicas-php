<?php
// 009_autenticacion/registro.php
require_once 'classes/Database.php';
require_once 'classes/Usuario.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = trim($_POST['nombre'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($nombre) && !empty($email) && !empty($password)) {
        // Obtenemos la conexión desde nuestra clase Database
        $database = new Database();
        $pdo = $database->conectar();
        
        // Inyectamos la conexión a la clase Usuario
        $usuarioModel = new Usuario($pdo);

        try {
            if ($usuarioModel->registrar($nombre, $email, $password, 'admin')) {
               $mensaje = "Usuario registrado con éxito. <a href='index.php'>Ir al Login</a>";
            }
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $mensaje = "El correo electrónico ya está registrado.";
            } else {
                $mensaje = "Error al registrar: " . $e->getMessage();
            }
        }
    } else {
        $mensaje = "Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo 009 - Registro POO</title>
</head>
<body>
    <h2>Registrar Usuario (POO)</h2>

    <?php if ($mensaje): ?>
        <p><strong><?= $mensaje ?></strong></p>
    <?php endif; ?>

    <form method="POST" action="">
        <div>
            <label>Nombre:</label><br>
            <input type="text" name="nombre" required>
        </div><br>

        <div>
            <label>Email:</label><br>
            <input type="email" name="email" required>
        </div><br>

        <div>
            <label>Contraseña:</label><br>
            <input type="password" name="password" required>
        </div><br>

        <button type="submit">Registrar</button>
    </form>
</body>
</html>