<?php
// Si la petición es GET, se muestra el formulario HTML
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    include 'captura.html';
    exit;
}

// Si la petición es POST, procesamos los datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Control de inyección de código mediante htmlspecialchars
    $nombre = htmlspecialchars($_POST['nombre'] ?? '', ENT_QUOTES, 'UTF-8');
    $alias = htmlspecialchars($_POST['alias'] ?? '', ENT_QUOTES, 'UTF-8');
    $edad = (int)($_POST['edad'] ?? 0);
    
    // Convertir el array de armas seleccionadas a un string separado por comas
    $armas_array = $_POST['armas'] ?? [];
    $armas = htmlspecialchars(implode(", ", $armas_array), ENT_QUOTES, 'UTF-8');
    
    $magia = htmlspecialchars($_POST['magia'] ?? '', ENT_QUOTES, 'UTF-8');

    // 2. Procesamiento de la subida de imagen
    $dir_subida = "uploads/";
    if (!is_dir($dir_subida)) {
        mkdir($dir_subida, 0755, true); // Crear directorio si no existe
    }

    $imagen_final = "calavera.png"; // Fallback por defecto
    $error_msg = "";
    $estado_imagen = "no_subida"; // 'ok', 'error', 'no_subida'

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE) {
        $archivo = $_FILES['imagen'];
        
        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            $estado_imagen = "error";
            $error_msg = "Error en la transmisión del archivo.";
        } else {
            $tipo_mime = mime_content_type($archivo['tmp_name']);
            $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
           
            $peso_bytes = $archivo['size'];

            // Validación Servidor: Solo PNG y Máximo 10 KB (10240 bytes)
            if ($tipo_mime !== 'image/png' || $extension !== 'png') {
                $estado_imagen = "error";
                $error_msg = "Error: El archivo debe ser obligatoriamente PNG.";
            } elseif ($peso_bytes > 10240) {
                $estado_imagen = "error";
                $error_msg = "Error: La imagen supera el tamaño máximo de 10 KB.";
            } else {
                // Subida exitosa
                $nombre_archivo = uniqid() . ".png"; // Evitar colisiones de nombres
                $ruta_destino = $dir_subida . $nombre_archivo;
                
                if (move_uploaded_file($archivo['tmp_name'], $ruta_destino)) {
                    $imagen_final = $ruta_destino;
                    $estado_imagen = "ok";
                } else {
                    $estado_imagen = "error";
                    $error_msg = "Error al mover el archivo al directorio uploads.";
                }
            }
        }
    }

    // Renderizar resultados con el diseño visual solicitado
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Resultados del Jugador</title>
        <style>
            body { font-family: sans-serif; display: flex; justify-content: center; margin-top: 50px; background-color: #e6e6e6;}
            .tarjeta { background-color: #ffff33; padding: 30px; border-radius: 10px; width: 600px; display: flex; flex-direction: column; }
            h2 { text-align: center; margin-bottom: 30px; }
            .grid-contenido { display: flex; justify-content: space-between; }
            .columna-datos { width: 55%; font-size: 1.1em; line-height: 1.8; }
            .columna-imagen { width: 40%; display: flex; flex-direction: column; align-items: center; justify-content: center;}
            .columna-imagen img { max-width: 100%; border: 1px solid darkblue; }
            .texto-encima { font-weight: bold; margin-bottom: 10px; text-align: center;}
            .texto-debajo { margin-top: 10px; text-align: center; }
        </style>
    </head>
    <body>
        <div class="tarjeta">
            <h2>Datos del Jugador</h2>
            <div class="grid-contenido">
                <div class="columna-datos">
                    <div><strong>Nombre:</strong> <?= $nombre ?></div>
                    <div><strong>Alias:</strong> <?= $alias ?></div>
                    <div><strong>Edad:</strong> <?= $edad ?></div>
                    <div><strong>Armas seleccionadas:</strong> <?= $armas ?></div>
                    <div><strong>¿Practica artes mágicas?:</strong> <?= $magia ?></div>
                </div>
                
                <div class="columna-imagen">
                    <?php if ($estado_imagen === 'ok'): ?>
                        <div class="texto-encima">Imagen subida:</div>
                        <img src="<?= $imagen_final ?>" alt="Imagen del jugador">
                    
                    <?php elseif ($estado_imagen === 'no_subida'): ?>
                        <div class="texto-encima">No se subió ninguna<br>imagen.</div>
                        <img src="calavera.png" alt="Calavera">
                    
                    <?php else: // estado_imagen === 'error' ?>
                        <img src="calavera.png" alt="Calavera">
                        <div class="texto-debajo"><?= $error_msg ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
}
?>