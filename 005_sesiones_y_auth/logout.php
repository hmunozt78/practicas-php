<?php
    session_start();

    // 1. Limpiamos todas las variables de sesión
    $_SESSION = array();

    // 2. Destruimos la sesión en el servidor
    session_destroy();

    // 3. Redirigimos al usuario de vuelta al login
    header("Location: index.php");
    exit();
?>