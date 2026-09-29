<?php
    require_once "config/conexion.php";

    $mensaje = "";
    $tipoMensaje = "";

    //Variables para controlar el estado del formulario (Modo Crear vs Modo Editar)
    $modoEditar = false;
    $idEditar ="";
    $nombreEditar = "";
    $emailEditar = "";

    // ==========================================
    // 1. ELIMINAR REGISTRO (DELETE)
    // ==========================================

    if (isset($_GET["action"]) && $_GET["action"] === "eliminar" && !empty($_GET["id"])) {
        $idEliminar = (int)$_GET["id"];

        try {
            //Siempre con WHERE

            $sql = "DELETE FROM usuarios WHERE id = :id";
            $stmt = $pdo -> prepare($sql);
            $stmt -> execute([":id" => $idEliminar]);

            $mensaje = "Usuario eliminado correctamente";
            $tipoMensaje = "alerta-exito";
        } catch (\PDOException $e) {
            $mensaje = "Error al eliminar usuario: " . $e->getMessage();
            $tipoMensaje = "alerta-error";
        }
    }

    // ==========================================
    // 2. CARGAR DATOS PARA EDITAR (READ INDIVIDUAL)
    // ==========================================

    if (isset($_GET["accion"]) && $_GET["accion"] === "editar" && !empty($_GET["id"])) {
        $idEditar = (int)$_GET["id"];

        try {
            $sql = "SELECT id, nombre, email FROM usuarios WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([":id" => $idEditar]);
            $usuarioObtenido = $stmt->fetch(); // Usamos fetch() porque solo esperamos 1 registro

            if ($usuarioObtenido) {
                $modoEditar = true;
                $nombreEditar = $usuarioObtenido["nombre"];
                $emailEditar = $usuarioObtenido["email"];
            } else {
                $mensaje = "El usuario a editar no existe.";
                $tipoMensaje = "alerta-error";
            }
        } catch (\PDOException $e) {
            $mensaje = "Error al obtener usuario: " . $e->getMessage();
            $tipoMensaje = "alerta-error";
        }
    }
    
    
    // ==========================================
    // 3. PROCESAR FORMULARIO (INSERT u UPDATE)
    // ==========================================
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $id = trim($_POST["id"] ?? "");
        $nombre = trim($_POST["nombre"] ?? "");
        $email = trim($_POST["email"] ?? "");

        if (!empty($nombre) && !empty($email)) {
            try {
                if (!empty($id)) {
                    // --- MODO UPDATE ---
                    $sql = "UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        ":nombre" => $nombre,
                        ":email"  => $email,
                        ":id"     => $id
                    ]);

                    $mensaje = "¡Usuario actualizado con éxito!";
                    $tipoMensaje = "alerta-exito";
                    
                    // Reiniciamos las variables para salir del modo edición
                    $modoEditar = false;
                    $nombreEditar = "";
                    $emailEditar = "";
                } else {
                    // --- MODO INSERT ---
                    $sql = "INSERT INTO usuarios (nombre, email) VALUES (:nombre, :email)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        ":nombre" => $nombre,
                        ":email"  => $email
                    ]);

                    $mensaje = "¡Usuario guardado correctamente!";
                    $tipoMensaje = "alerta-exito";
                }
            } catch (\PDOException $e) {
                if ($e->getCode() == 23000) {
                    $mensaje = "Error: El correo electrónico ya está registrado por otro usuario.";
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

    // ==========================================
    // 4. CONSULTAR TODOS LOS REGISTROS (READ LISTA)
    // ==========================================
    try {
        $stmt = $pdo->query("SELECT id, nombre, email, creado_en FROM usuarios ORDER BY id DESC");
        $listaUsuarios = $stmt->fetchAll();
    } catch (\PDOException $e) {
        $listaUsuarios = [];
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>007 - CRUD Completo con PDO</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

    <div class="contenedor">
        <h1><?php echo $modoEditar ? "Editar Usuario" : "Registrar Usuario"; ?></h1>

        <?php if (!empty($mensaje)): ?>
            <div class="<?php echo $tipoMensaje; ?>"><?php echo $mensaje; ?></div>
        <?php endif; ?>

        <form action="index.php" method="POST">
            <!-- Campo Oculto para enviar el ID únicamente si estamos Editando -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($idEditar); ?>">

            <div class="campo">
                <label for="nombre">Nombre Completo:</label>
                <input type="text" id="nombre" name="nombre" required placeholder="Ej. Salvador Dalí" value="<?php echo htmlspecialchars($nombreEditar); ?>">
            </div>

            <div class="campo">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required placeholder="dali@ejemplo.com" value="<?php echo htmlspecialchars($emailEditar); ?>">
            </div>

            <button type="submit" class="<?php echo $modoEditar ? 'btn-actualizar' : ''; ?>">
                <?php echo $modoEditar ? "Actualizar Usuario" : "Guardar en MariaDB"; ?>
            </button>

            <?php if ($modoEditar): ?>
                <a href="index.php" class="btn-cancelar">Cancelar Edición</a>
            <?php endif; ?>
        </form>

        <hr style="margin: 2rem 0; border: 0; border-top: 1px solid #e2e8f0;">

        <h2>Usuarios Registrados</h2>

        <?php if (count($listaUsuarios) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listaUsuarios as $user): ?>
                        <tr>
                            <td><?php echo $user["id"]; ?></td>
                            <td><?php echo htmlspecialchars($user["nombre"]); ?></td>
                            <td><?php echo htmlspecialchars($user["email"]); ?></td>
                            <td class="acciones">
                                <a href="index.php?accion=editar&id=<?php echo $user['id']; ?>" class="enlace-editar">Editar</a>
                                <a href="index.php?accion=eliminar&id=<?php echo $user['id']; ?>" class="enlace-eliminar" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="color: #64748b;">No hay usuarios registrados aún.</p>
        <?php endif; ?>
    </div>

</body>
</html>