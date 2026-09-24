<?php
// Configuración y lista dinámica de proyectos finalizados
$usuarioDev = "Kejuma";
$servidorOS = "Kubuntu 26.04 & Ubuntu Server (HP)";

$proyectos = [
    [
        "id" => "001",
        "titulo" => "001 - Hola Mundo & Entorno",
        "descripcion" => "Configuración inicial del entorno Nginx, PHP 8.5 y pruebas de ejecución del servidor.",
        "carpeta" => "practicas-php", // O la carpeta correspondiente si la mantienes ahí
        "tecnologias" => ["PHP 8.5", "Nginx", "Git"],
        "estado" => "Completado"
    ],
    [
        "id" => "002",
        "titulo" => "002 - Variables PHP y DOM",
        "descripcion" => "Interacción entre PHP (servidor) y JavaScript (cliente) para manipular el DOM y contadores.",
        "carpeta" => "002_variables_y_dom",
        "tecnologias" => ["PHP", "JavaScript", "HTML5"],
        "estado" => "Completado"
    ],
    [
        "id" => "003",
        "titulo" => "003 - Arrays y Estructuras",
        "descripcion" => "Manejo de matrices, arrays asociativos, bucles foreach y renderizado condicional con elseif.",
        "carpeta" => "003_arrays_y_estructuras",
        "tecnologias" => ["PHP", "CSS3", "Arrays"],
        "estado" => "Completado"
    ],
    [
        "id" => "004",
        "titulo" => "004 - Formularios y POST",
        "descripcion" => "Estructura modular (CSS/JS externos), captura de datos con $_POST y sanitización XSS.",
        "carpeta" => "004_formularios_y_post",
        "tecnologias" => ["PHP POST", "JS Modular", "CSS3"],
        "estado" => "Completado"
    ],
    [
        "id" => "005",
        "titulo" => "005 - Sesiones y Autenticación",
        "descripcion" => "Gestión del estado de usuario con $_SESSION, login ficticio y protección de rutas.",
        "carpeta" => "005_sesiones_y_auth",
        "tecnologias" => ["$_SESSION", "Auth", "PHP Security"],
        "estado" => "Completado"
    ],
     [
        "id" => "006",
        "titulo" => "006 - Bases de Datos con PDO & MySQL",
        "descripcion" => "Conexión segura a MariaDB mediante PDO, creación de tablas, inserción (INSERT) y consulta de datos (SELECT).",
        "carpeta" => "006_bases_de_datos_pdo",
        "tecnologias" => ["PHP PDO", "MySQL/MariaDB", "SQL"],
        "estado" => "Próximamente"
    ]
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Proyectos - PHP & Fullstack Lab</title>
    <style>
        :root {
            --primary: #0288d1;
            --primary-dark: #01579b;
            --bg: #f4f6f9;
            --text: #2c3e50;
            --card-bg: #ffffff;
        }

        body {
            font-family: system-ui, -apple-system, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            margin: 0;
            padding: 2rem 1rem;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        header {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        header h1 { margin: 0 0 0.5rem 0; font-size: 1.8rem; }
        header p { margin: 0; opacity: 0.85; font-size: 0.95rem; }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .card {
            background: var(--card-bg);
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: 1px solid #e2e8f0;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.8rem;
        }

        .card-title {
            font-size: 1.15rem;
            font-weight: 700;
            margin: 0;
            color: #0f172a;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.6rem;
            border-radius: 20px;
            font-weight: 600;
        }

        .badge-completado { background: #dcfce7; color: #166534; }
        .badge-proximo { background: #fef3c7; color: #92400e; }

        .card-desc {
            font-size: 0.9rem;
            color: #64748b;
            margin-bottom: 1.2rem;
            line-height: 1.4;
        }

        .tags {
            display: flex;
            gap: 0.4rem;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        .tag {
            background: #f1f5f9;
            color: #475569;
            font-size: 0.75rem;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
        }

        .btn-link {
            display: inline-block;
            text-align: center;
            background-color: var(--primary);
            color: white;
            text-decoration: none;
            padding: 0.6rem 1rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: background 0.2s;
        }

        .btn-link:hover {
            background-color: var(--primary-dark);
        }

        .btn-disabled {
            background-color: #cbd5e1;
            color: #64748b;
            cursor: not-allowed;
            pointer-events: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <header>
            <h1>⚡ Dashboard de Proyectos PHP & JS</h1>
            <p>Desarrollador: <strong><?php echo $usuarioDev; ?></strong> | Entorno: <strong><?php echo $servidorOS; ?></strong></p>
        </header>

        <div class="grid">
            <?php foreach ($proyectos as $item): ?>
                <div class="card">
                    <div>
                        <div class="card-header">
                            <h2 class="card-title"><?php echo $item["titulo"]; ?></h2>
                            <?php if ($item["estado"] === "Completado"): ?>
                                <span class="badge badge-completado">Listo</span>
                            <?php else: ?>
                                <span class="badge badge-proximo">Próximamente</span>
                            <?php endif; ?>
                        </div>

                        <p class="card-desc"><?php echo $item["descripcion"]; ?></p>

                        <div class="tags">
                            <?php foreach ($item["tecnologias"] as $tech): ?>
                                <span class="tag"><?php echo $tech; ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <?php if ($item["estado"] === "Completado"): ?>
                        <a href="./<?php echo $item["carpeta"]; ?>/" class="btn-link">Abrir Ejercicio →</a>
                    <?php else: ?>
                        <a href="#" class="btn-link btn-disabled">En desarrollo</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>