<?php
$texto = htmlspecialchars($_REQUEST['comentario'] ?? '');

$longitud = strlen($texto);
$num_palabras = str_word_count($texto);

$texto_sin_espacios = str_replace(' ', '', $texto);
$letras = count_chars($texto_sin_espacios, 1);
arsort($letras);
$letra_mas_repetida = $letras ? chr(array_key_first($letras)) : '-';

$palabras = str_word_count(strtolower($texto), 1);
$frecuencia_palabras = array_count_values($palabras);
arsort($frecuencia_palabras);
$palabra_mas_repetida = $frecuencia_palabras ? array_key_first($frecuencia_palabras) : '-';
?>

<div>
    <b>Detalles:</b><br>
    Longitud: <?= $longitud ?><br>
    Nº de palabras: <?= $num_palabras ?><br>
    Letra + repetida: <?= $letra_mas_repetida ?><br>
    Palabra + repetida: <?= $palabra_mas_repetida ?><br>
</div>
