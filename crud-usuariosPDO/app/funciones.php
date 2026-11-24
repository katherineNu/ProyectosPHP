<?php

// MUESTRA TODOS LOS USUARIOS
function mostrarDatos (){
    
    $titulos = [ "Nombre","login","Password","Comentario"];
    $msg = "<table>\n";
     // Identificador de la tabla
    $msg .= "<tr>";
    for ($j=0; $j < count($titulos); $j++){
        $msg .= "<th>$titulos[$j]</th>";
    }  
    $msg .= "</tr>";
    $auto = $_SERVER['PHP_SELF'];
    $db = AccesoDatos::getModelo();
    $tuser = $db->getproductos();
    foreach ($tuser as $user) {
        $msg .= "<tr>";
        $msg .= "<td>$user->nombre</td>";
        $msg .= "<td>$user->codigo</td>";
        $msg .= "<td>$user->stock</td>";
        $msg .= "<td>$user->stock_min</td>";
        $msg .="<td><a href=\"#\" onclick=\"confirmarBorrar('$user->nombre','$user->login');\" >🗑️</a></td>\n";
        $msg .="<td><a href=\"".$auto."?orden=Modificar&id=$user->login\">✏️</a></td>\n";
        $msg .="<td><a href=\"".$auto."?orden=Detalles&id=$user->login\" >👁️</a></td>\n";
        $msg .="</tr>\n";
        
    }
    $msg .= "</table>";
   
    return $msg;    
}

/*
 *  Funciones para limpiar la entreda de posibles inyecciones
 */

function limpiarEntrada(string $entrada):string{
    $salida = trim($entrada); // Elimina espacios antes y después de los datos
    $salida = strip_tags($salida); // Elimina marcas
    return $salida;
}
// Función para limpiar todos elementos de un array
function limpiarArrayEntrada(array &$entrada){
 
    foreach ($entrada as $key => $value ) {
        $entrada[$key] = limpiarEntrada($value);
    }
}

