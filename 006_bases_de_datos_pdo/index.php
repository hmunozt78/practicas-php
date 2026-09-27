<?php
    require_once "config/conexion.php";

    $mensaje = "";
    $tipoMensaje = "";

    //1. Procesar Formulario (Insert con sentencia preparada)
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $nombre = trim($_POST["nombre"] ?? "");
        $email = trim($_POST["email"] ?? "");

        if (!empty($nombre) && !empty($email)) {
            try {
                //sentencia preparada contra inyeccion SQL
                $sql = ("INSERT INTO usuarios (nombre, email) values (:nombre, :email)");
                $stmt = $pdo -> prepare($sql);

                $stmt-> execute([
                    ":nombre" => $nombre,
                    ":email" => $email
                ]);
                $mensaje = "¡Usuario guardado correctamente en la Base de Datos!";
                $tipoMensaje = "alerta-exito";
            } catch (\PDOException $e) {
                if($e -> getCode() == 23000) {
                    $mensaje = "Error: El correo electrónico ya está registrado.";
                } else {
                    $mensaje = "Error de base de datos: " . $e->getMessage();
                }
                $tipoMensaje = "alerta-error";
            }
        } else {
            $mensaje = "Por favor completa todos los campos.";
            $tipoMensaje = "alerta-error";
        }
    }

    // 2. Consulta de Registros (SELECT)
    try {
        $stmt = $pdo -> query("SELECT id, nombre, email, creado_en FROM usuarios ORDER BY id DESC");
        $listaUsuarios = $stmt-> fetchAll();
    } catch (\PDOException $e) {
        $listaUsuarios = [];
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>006 - Base de Datos con PDO</title>
        <link rel="stylesheet" href="css/estilos.css">
    </head>
    <body>
        <div class="contenedor">
            <h1>Registrar Usuario en DB</h1>

            <?php if(!empty($mensaje)): ?>
                <div class="<?php echo $tipoMensaje; ?>"><?php echo $mensaje ?></div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="campo">
                    <label for="nombre">Nombre Completo:</label>
                    <input type="text" name="nombre" id="nombre" required placeholder="Ej. Juan Perez">
                </div>

                <div class="campo">
                    <label for="email">Correo Electronico</label>
                    <input type="email" name="email" id="email" required placeholder="Ej. correo@ejemplo.cl">
                </div>

                <button type="submit">Guardar en MariaDB</button>
            </form>

            <hr style="margin: 2rem 0; border: 0; border-top: 1px solid #e2e8f0;">

            <h2>Usuarios Registrados</h2>

            <?php if(count($listaUsuarios) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listaUsuarios as $user): ?>
                            <tr>
                                <td><?php echo $user["id"]; ?></td>
                                <td><?php echo htmlspecialchars($user["nombre"]); ?></td>
                                <td><?php echo htmlspecialchars($user["email"]); ?></td>
                                <td><?php echo $user["creado_en"]; ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="color: #64748b;">No hay usuarios registrados aún.</p>
            <?php endif; ?>
        </div>
        
    </body>
</html>