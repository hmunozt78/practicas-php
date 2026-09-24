<?php

    //Sesion Start debe ser la primera linea en el codigo PHP
    session_start();

    // Si el usuario ya esta logeado, va directo al dashboard
    if (isset($_SESSION["usuario"])) {
        header("location: dashboard.php");
        exit();
    }

    $error = "";

    //Credenciales Ficticias
    $usuarioValido = "kejuma";
    $claveValida = "12345";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $inputUsuario = trim($_POST["usuario"] ?? "");
        $inputClave = trim($_POST["password"] ?? "");

        if ($inputUsuario === $usuarioValido && $inputClave === $claveValida) {
            //Guardamos la informacion en el Array de Session
            $_SESSION["usuario"] = $inputUsuario;
            $_SESSION["rol"] = "Administrador";
            $_SESSION["login_time"] = date("H:i:s");

            // Redirigimos al usuario a la página privada
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
        # code...
    }
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>005 - Iniciar Sesión</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

    <div class="contenedor">
        <h1>Iniciar Sesion</h1>

        <?php if (!empty($error)): ?>
            <div class="alerta-error"><?php echo $error ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="campo">
                <label for="usuario">Usuario :</label>
                <input type="text" name="usuario" id="usuario" placeholder="Ej. Wenseslao" required>
            </div>

            <div class="campo">
                <label for="password">Contraseña :</label>
                <input type="password" name="password" id="password" placeholder="abcde" required>
            </div>

            <button type="submit">Ingresar</button>
        </form>
    </div>

</body>
</html>