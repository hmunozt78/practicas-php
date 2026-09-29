<?php
session_start(); // Iniciamos sesión para persistir mensajes tras la redirección

// Cargamos las dos clases que creamos
require_once "classes/Database.php";
require_once "classes/Usuario.php";

// Instanciamos la conexión y el modelo de Usuario
$database = new Database();
$db = $database->getConnection();
$usuarioModel = new Usuario($db);

// Recuperar mensaje de la sesión si existe y borrarlo de inmediato
$mensaje = $_SESSION["mensaje"] ?? "";
$tipoMensaje = $_SESSION["tipoMensaje"] ?? "";
unset($_SESSION["mensaje"], $_SESSION["tipoMensaje"]);

$modoEditar = false;
$idEditar = "";
$nombreEditar = "";
$emailEditar = "";

// 1. ELIMINAR REGISTRO (DELETE)
if (isset($_GET["accion"]) && $_GET["accion"] === "eliminar" && !empty($_GET["id"])) {
    $idEliminar = (int)$_GET["id"];
    
    if ($usuarioModel->eliminar($idEliminar)) {
    $_SESSION["mensaje"] = "Usuario eliminado correctamente (vía POO).";
    $_SESSION["tipoMensaje"] = "alerta-exito";
} else {
    $_SESSION["mensaje"] = "Error al eliminar el usuario.";
    $_SESSION["tipoMensaje"] = "alerta-error";
}

    // Redirección PRG para limpiar la URL
    header("Location: index.php");
    exit();
}

// 2. CARGAR DATOS PARA EDITAR (READ INDIVIDUAL)
if (isset($_GET["accion"]) && $_GET["accion"] === "editar" && !empty($_GET["id"])) {
    $idEditar = (int)$_GET["id"];
    $usuarioObtenido = $usuarioModel->obtenerPorId($idEditar);

    if ($usuarioObtenido) {
        $modoEditar = true;
        $nombreEditar = $usuarioObtenido["nombre"];
        $emailEditar = $usuarioObtenido["email"];
    } else {
        $mensaje = "El usuario a editar no existe.";
        $tipoMensaje = "alerta-error";
    }
}

// 3. PROCESAR FORMULARIO (INSERT u UPDATE)
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $id = trim($_POST["id"] ?? "");
        $nombre = trim($_POST["nombre"] ?? "");
        $email = trim($_POST["email"] ?? "");

        if (!empty($nombre) && !empty($email)) {
            try {
                if (!empty($id)) {
                    $usuarioModel->actualizar($id, $nombre, $email);
                    $_SESSION["mensaje"] = "¡Usuario actualizado con éxito (vía POO)!";
                } else {
                    $usuarioModel->crear($nombre, $email);
                    $_SESSION["mensaje"] = "¡Usuario guardado correctamente (vía POO)!";
                }
                $_SESSION["tipoMensaje"] = "alerta-exito";

                // REDIRECCIÓN PRG: Al recargar con F5 ya no pedirá reenviar el formulario
                header("Location: index.php");
                exit();
                
            } catch (\PDOException $e) {
                if ($e->getCode() == 23000) {
                    $mensaje = "Error: El correo electrónico ya está registrado.";
                } else {
                    $mensaje = "Error en la operación: " . $e->getMessage();
                }
                $tipoMensaje = "alerta-error";
            }
        } else {
            $mensaje = "Por favor completa todos los campos.";
            $tipoMensaje = "alerta-error";
        }
    }

// 4. CONSULTAR TODOS LOS REGISTROS (READ LISTA)
$listaUsuarios = $usuarioModel->obtenerTodos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>008 - POO & Clases de Base de Datos</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

    <div class="contenedor">
        <h1><?php echo $modoEditar ? "POO: Editar Usuario" : "POO: Registrar Usuario"; ?></h1>

        <?php if (!empty($mensaje)): ?>
            <div class="<?php echo $tipoMensaje; ?>"><?php echo $mensaje; ?></div>
        <?php endif; ?>

        <form action="index.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($idEditar); ?>">

            <div class="campo">
                <label for="nombre">Nombre Completo:</label>
                <input type="text" id="nombre" name="nombre" required placeholder="Ej. Ada Lovelace" value="<?php echo htmlspecialchars($nombreEditar); ?>">
            </div>

            <div class="campo">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required placeholder="ada@ejemplo.com" value="<?php echo htmlspecialchars($emailEditar); ?>">
            </div>

            <button type="submit" class="<?php echo $modoEditar ? 'btn-actualizar' : ''; ?>">
                <?php echo $modoEditar ? "Actualizar con POO" : "Guardar con POO"; ?>
            </button>

            <?php if ($modoEditar): ?>
                <a href="index.php" class="btn-cancelar">Cancelar Edición</a>
            <?php endif; ?>
        </form>

        <hr style="margin: 2rem 0; border: 0; border-top: 1px solid #e2e8f0;">

        <h2>Usuarios Registrados (Consulta POO)</h2>

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
                                <a href="index.php?accion=eliminar&id=<?php echo $user['id']; ?>" class="enlace-eliminar" onclick="return confirm('¿Estás seguro de eliminar este usuario con POO?');">Eliminar</a>
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