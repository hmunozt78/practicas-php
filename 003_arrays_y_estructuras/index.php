<?php
    //  Array Asociativo, esto equivale a diccionario en Python

    $usuario = [
        "nombre" => "Kejuma",
        "rol" => "Desarrollador Backend",
        "activo" => true
    ];

    // Array de Arrays (Lista de Productos y Proyectos)

    $proyectos = [
        [
            "titulo" => "001 - Hola Mundo",
            "lenguaje" => "PHP 8.5",
            "estado" => "Completado"
        ],
        [
            "titulo" => "002 - Variables y DOM",
            "lenguaje" => "PHP 8.5 y JS",
            "estado" => "Completado"
        ],
        [
            "titulo" => "003 - Arrays y Estructuras",
            "lenguaje" => "PHP 8.5",
            "estado" => "En Proceso"
        ],
        [
            "titulo" => "004 - Formularios y Post",
            "lenguaje" => "PHP 8.5 y HTML5",
            "estado" => "Pendiente"
        ]
    ];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>003 - Arrays y Bucles en PHP</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 2rem; background: #f0f4f8; }
        .contenedor { max-width: 600px; margin: auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .badge { background: #0288d1; color: white; padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.85rem; }
        .completado { background: #2e7d32; }
        .proceso { background: #ed6c02; }
        .pendiente { background: #d84867ef; }
        ul { list-style: none; padding: 0; }
        li { padding: 0.8rem; border-bottom: 1px solid #e0e0e0; display: flex; justify-content: space-between; align-items: center; }
    </style>
</head>
<body>
    <div class="contenedor">
        <h1>Perfil del Usuario</h1>
        <p><strong>Nombre : </strong><?php echo $usuario["nombre"]; ?></p>
        <p><strong>Rol : </strong><?php echo $usuario["rol"]; ?></p>
        <p><strong>Estado : </strong>
            <?php  if ($usuario["activo"]): ?>
                <span class="badge completado">Cuenta Activa</span>
            <?php else: ?>
                <span class="badge proceso">Inactiva</span>
            <?php endif; ?>
        </p>

        <hr>

        <h2>Lista de Proyectos</h2>
        <ul>
            <!-- Bucle foreach para recorrer el array de proyectos -->
            <?php foreach ($proyectos as $proyecto): ?>
                <li>
                    <div>
                        <strong><?php echo $proyecto["titulo"]; ?></strong><br>
                        <small><?php echo $proyecto["lenguaje"]; ?></small>
                    </div>
                    
                    <!-- Condicional para cambiar la clase CSS según el estado -->
                    <?php if ($proyecto["estado"] === "Completado"): ?>
                        <span class="badge completado">Completado</span>
                    <?php elseif ($proyecto["estado"] === "Pendiente"): ?>
                        
                        <span class="badge pendiente">Pendiente</span>
                    <?php else: ?>
                        <span class="badge proceso">En proceso</span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>

    </div>
    
</body>
</html>