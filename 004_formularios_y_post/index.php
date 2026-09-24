<?php
// PHP se ejecuta al cargar la página o al recibir un envío de formulario (POST)
$mensaje = "";
$tipoMensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Capturamos las variables enviadas vía POST desde el formulario
    $nombre = htmlspecialchars(trim($_POST["nombre"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $interes = htmlspecialchars($_POST["interes"]);

    if (!empty($nombre) && !empty($email)) {
        $mensaje = "¡Registro exitoso! Bienvenido $nombre ($email). Te has inscrito en el módulo: $interes.";
        $tipoMensaje = "alerta-exito";
    } else {
        $mensaje = "Error en el servidor: Todos los campos son obligatorios.";
        $tipoMensaje = "alerta-error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>004 - Procesamiento de Formularios POST</title>
    <!-- Vinculación del archivo CSS externo -->
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

    <div class="contenedor">
        <h1>Registro de Estudiante</h1>

        <!-- Si existe un mensaje treas procesar el POST, lo mostramos -->
        <?php if (!empty($mensaje)): ?>
            <div class="<?php echo $tipoMensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <!-- Formulario apuntando a la misma pagina mediante metodo POST -->
        <form id="formRegistro" action="/004_formularios_y_post/index.php" method="post">
            <div class="campo">
                <label for="nombre">Nombre Completo</label>
                <input type="text" name="nombre" id="nombre" placeholder="Ej. Salvador Dali">
            </div>
            <div class="campo">
                <label for="email">Correo Electronico</label>
                <input type="email" name="email" id="email" placeholder="prueba@correo.com">
            </div>
            <div class="campo">
                <label for="interes">Modulo de Interes:</label>
                <select name="interes" id="interes">
                    <option value="PHP 8.5 & Nginx">PHP 8.5 & Nginx</option>
                    <option value="JavaScript & DOM">JavaScript & DOM</option>
                    <option value="Django & Python">Django & Python</option>
                </select>
            </div>
            <button type="submit">Enviar Registro</button>
        </form>
    </div>
    <!-- Vinculación del archivo JavaScript externo -->
    <script src="js/validacion.js"></script>
</body>
</html>