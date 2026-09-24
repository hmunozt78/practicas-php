<?php

    session_start();

    //Proteccion de Ruta, no deja entrar si no hay usuario logeado

    if (!isset($_SESSION["usuario"])) {
        header("location: index.php");
        exit();
    }

    $usuario = $_SESSION["usuario"];
    $rol = $_SESSION["rol"];
    $horaIngreso = $_SESSION["login_time"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>005 - Panel Privado</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

    <div class="contenedor">
        <h1>👋 ¡Bienvenido, <?php echo htmlspecialchars($usuario); ?>!</h1>
        <p><strong>Rol de acceso:</strong> <?php echo $rol; ?></p>
        <p><strong>Hora de conexión:</strong> <?php echo $horaIngreso; ?></p>
        
        <p style="color: #166534; background: #dcfce7; padding: 0.8rem; border-radius: 6px;">
            🔒 Esta es una zona protegida por <code>$_SESSION</code>. Si intentas abrir esta página sin iniciar sesión, PHP te expulsará.
        </p>

        <hr style="margin: 1.5rem 0; border: 0; border-top: 1px solid #e2e8f0;">

        <a href="logout.php" class="btn-logout btn-danger">Cerrar Sesión</a>
    </div>
    
</body>
</html>