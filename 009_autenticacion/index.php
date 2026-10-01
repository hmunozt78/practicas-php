<?php
// 009_autenticacion/index.php
session_start();

// Si el usuario ya está autenticado, lo enviamos directo al panel
if (isset($_SESSION['usuario_id'])) {
    header('Location: panel.php');
    exit;
}

require_once 'classes/Database.php';
require_once 'classes/Usuario.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        $database = new Database();
        $pdo = $database->conectar();
        $usuarioModel = new Usuario($pdo);

        $usuario = $usuarioModel->autenticar($email, $password);

        if ($usuario) {
            session_regenerate_id(true);

            $_SESSION['usuario_id']     = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_rol']    = $usuario['rol'];

            header('Location: panel.php');
            exit;
        } else {
            $error = "Credenciales incorrectas. Revisa el correo o la contraseña.";
        }
    } else {
        $error = "Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo 009 - Iniciar Sesión</title>
</head>
<body>
    <h2>Iniciar Sesión (POO)</h2>

    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <div>
            <label>Correo Electrónico:</label><br>
            <input type="email" name="email" required>
        </div><br>

        <div>
            <label>Contraseña:</label><br>
            <input type="password" name="password" required>
        </div><br>

        <button type="submit">Ingresar</button>
    </form>

    <br>
    <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
</body>
</html>