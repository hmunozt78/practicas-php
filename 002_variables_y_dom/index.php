<?php
    //1. Bloque de PHP: definicion de variables en el servidor
    $usuario = "Kejuma";
    $curso = "PHP 8.5 y JS";
    $nivelInicial = 1;
    $modulo = "Manipulacion del DOM";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>002 - Variables PHP y manipulacion del DOM</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 2rem; background: #eceff1; }
        .card { background: white; padding: 2rem; border-radius: 10px; max-width: 450px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        button { background: #0288d1; color: white; border: none; padding: 0.6rem 1.2rem; border-radius: 5px; cursor: pointer; font-size: 1rem; }
        button:hover { background: #01579b; }
        .destacado { color: #2e7d32; font-weight: bold; }
    </style>
    
</head>
<body>
    <div class="card">
        <!-- Inyectamos las variables PHP dentro del HTML-->
         <h1>Estudiante: <?php echo $usuario; ?></h1>
         <p>Curso Actual: <strong><?php echo $curso; ?></strong></p>
         <p>Modulo: <strong><?php echo $modulo; ?></strong></p>
         <hr>

         <p>Nivel de Progreso : <span id="nivel" class="destacado"><?php echo $nivelInicial; ?></span></p>

         <!-- Boton que activara el nivel de JS -->

         <button id="btnSubirNivel">Subir nivel con JS</button>
        
        <button id="btnReinicio">Reiniciar Nivel</button>
         

    </div>

    <script>
        // 2. Bloque de JS: se ejecuta en el navegador del usuario

        // Selecciona los elementos del HTML por su id
        const boton = document.getElementById('btnSubirNivel');
        const etiquetaNivel = document.getElementById('nivel');
        const btnReiniciar = document.getElementById('btnReinicio');

        //convertimos el tecto inicial de PHP a un numero entero en JS
        let nivelActual = parseInt(etiquetaNivel.innerText);

        //Evento Click
        boton.addEventListener('click', function() {
            nivelActual++; //Aqui sumamos 1 al nivel actual
            etiquetaNivel.innerText = nivelActual;

            if (nivelActual === 5) {
                alert("Felicidades, has alcanzado el nivel 5 de practica");

            }
        })

        btnReiniciar.addEventListener('click', function() {
            nivelActual = 1;
            etiquetaNivel.innerText = nivelActual;
        })
    </script>
</body>
</html>