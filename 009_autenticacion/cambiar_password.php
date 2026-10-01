<?php
// 009_autenticacion/cambiar_password.php
session_start();

// Guard de sesión: Solo usuarios autenticados
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

require_once 'classes/Database.php';
require_once 'classes/Usuario.php';

$mensaje = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $passActual = $_POST['pass_actual'] ?? '';
    $passNueva  = $_POST['pass_nueva']  ?? '';
    $passConfirm = $_POST['pass_confirm'] ?? '';

    if (!empty($passActual) && !empty($passNueva) && !empty($passConfirm)) {
        if ($passNueva !== $passConfirm) {
            $error = "La nueva contraseña y su confirmación no coinciden.";
        } else {
            $database = new Database();
            $pdo = $database->conectar();
            $usuarioModel = new Usuario($pdo);

            $exito = $usuarioModel->cambiarPassword($_SESSION['usuario_id'], $passActual, $passNueva);

            if ($exito) {
                $mensaje = "Contraseña actualizada con éxito.";
            } else {
                $error = "La contraseña actual es incorrecta.";
            }
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
    <title>Módulo 009 - Cambiar Contraseña</title>
</head>
<body>
    <h2>Cambiar Contraseña</h2>
    <p>Usuario: <strong><?= htmlspecialchars($_SESSION['usuario_nombre']) ?></strong></p>

    <?php if ($mensaje): ?>
        <p style="color: green;"><strong><?= $mensaje ?></strong></p>
    <?php endif; ?>

    <?php if ($error): ?>
        <p style="color: red;"><strong><?= $error ?></strong></p>
    <?php endif; ?>

    <form method="POST" action="">
        <div>
            <label>Contraseña Actual:</label><br>
            <input type="password" name="pass_actual" required>
        </div><br>

        <div>
            <label>Nueva Contraseña:</label><br>
            <input type="password" name="pass_nueva" required>
        </div><br>

        <div>
            <label>Confirmar Nueva Contraseña:</label><br>
            <input type="password" name="pass_confirm" required>
        </div><br>

        <button type="submit">Actualizar Contraseña</button>
    </form>

    <br>
    <a href="panel.php">Volver al Panel</a>
</body>
</html>