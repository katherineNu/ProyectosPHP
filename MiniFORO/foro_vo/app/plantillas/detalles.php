<?php
//llamo a la funcion y guardo el array con los resultados de $d
//request es la fusion de get y post, da igual como llegue 
//por lo tanto $request['comentario'] es el  texto que escribio el usuario 
// ?? '' si no llego nada usa un texto vacio para que no de error
$d=analizarTexto($_REQUEST['comentario'] ?? '');
?>


<div>
<b> Detalles:</b><br>
<table>
    <!-- $d["clave"] saca cada dato del array. Las palabras y letras salen del
     texto del usuario, así que también pasan por htmlspecialchars() -->
<tr><td>Longitud:          </td><td><?= $d["longitud"] ?></td></tr>
<tr><td>Nº de palabras:    </td><td><?= $d["palabras"] ?></td></tr>
<tr><td>Letra + repetida:  </td><td><?= htmlspecialchars($d["letra"]) ?></td></tr>
<tr><td>Palabra + repetida:</td><td><?= htmlspecialchars($d["palabraRep"]) ?></td></tr>
<tr><td>Palabra + larga:   </td><td><?= htmlspecialchars($d["masLarga"]) ?></td></tr>
<tr><td>Nº de vocales:     </td><td><?= $d["vocales"] ?></td></tr>
</table>
</div>
