<?php
// 009_autenticacion/panel.php
session_start();

// Comprobar autenticación: si no hay sesión activa, redirige al login
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo 009 - Panel de Control</title>
</head>
<body>
    <h1>¡Bienvenido, <?= htmlspecialchars($_SESSION['usuario_nombre']) ?>!</h1>
    <p>Rol asignado: <strong><?= htmlspecialchars($_SESSION['usuario_rol']) ?></strong></p>

    <hr>
    
    <p>Acceso concedido a la zona protegida mediante sesiones de PHP nativo y POO.</p>

    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>