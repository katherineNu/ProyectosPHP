<?php
require_once ('dat/datos.php');   //cargo $usuarios,$nombreModulos y $notas

// RECUERDA cómo es $usuarios:   login => [nombre, clave, rol]
//   $usuarios[100002]    -> ["Andrés Pío", "andres2", ROL_ALUMNO]
//   $usuarios[100002][0] -> "Andrés Pío"   (posición 0 = nombre)
//   $usuarios[100002][1] -> "andres2"      (posición 1 = clave)
//   $usuarios[100002][2] -> ROL_ALUMNO     (posición 2 = rol)

//Es un array dentro de otro array: primero eliges el usuario y luego la posición.

/**
 *  Devuelve true si el código del usuario y contraseña se 
 *  encuentra en la tabla de usuarios
 *  @param $login : Código de usuario
 *  @param $clave : Clave del usuario
 *  @return true o false
 */
function userOk($login,$clave):bool {
    global $usuarios;    //global:uso la variable $usuarios de datos.php (que esta fuera de la funcion
    //                      que estoy creando ahora mismo)
     // 1) isset: ¿existe ese código en la tabla?
    // 2) ===  : ¿la clave guardada (posición 1) es EXACTAMENTE igual a la escrita?
    return isset($usuarios[$login]) && $usuarios[$login][1]=== $clave ;
}

/**
 *  Devuelve el rol asociado al usuario
 *  @param $login: código de usuario
 *  @return ROL_ALUMNO o ROL_PROFESOR
 */
function getUserRol($login){
    global $usuarios;

    return $usuarios[$login][2];  //posicion 2 x el ROL 
    
}

/**
 *  Muestra las notas del alumno indicado.
 *  @param $codigo: Código del usuario
 *  @return $devuelve una cadena con una tabla html con los resultados 
 */
function verNotasAlumno($codigo):String{
    $msg="";
    global $nombreModulos;
    global $notas;
    global $usuarios;

    $msg .= " Bienvenido/a alumno/a: ". $usuarios[$codigo][0] . "<hr>"; //su nombre q esta en la posicion 0
    $msg .= "<table class='sinborde'>";
    $msg .= "<tr><th>Módulo</th><th>Nota</th></tr>";
    // Completar
    //Recorro los modulos. $i es la posicion (0,1,2,3) y $modulo su nombre
    //la nota de ese modulo esta en la misma posicion: $notas[$codigo][$i]
    /*

$i	$modulo               	$notas[100002][$i]
0	Prog. Entorno Servidor  	7.3
1	Prog. Entorno Cliente	     6
2	Despliegue de aplicaciones	5.4
3	Diseño de interfaces Web	1
*/
            foreach($nombreModulos as $i => $modulo){
                    $msg .= "<tr><td>$modulo</td><td>" . $notas[$codigo][$i] . "</td></tr>";
            }
    $msg .= "</table>";
    return $msg;
}

/**
 *  Muestra las notas de todos alumnos. 
 *  @param $codigo: Código del profesor
 *  @return $devuelve una cadena con una tabla html con los resultados 
 */
function verNotaTodas ($codigo): String {
    $msg="";
    global $nombreModulos;
    global $notas;
    global $usuarios;
    $msg .= " Bienvenido Profesor: ". $usuarios[$codigo][0] . "<hr>";  //nombre del profesor
    $msg .= "<table>";

    //fila de tituilos: "NOMBRE" + el nombre de cada modulo
    $msg .= "<tr><th>Nombre</th>";
    foreach($nombreModulos as $modulo ){
        $msg .= "<th>$modulo</th>";
    }
    $msg .= "</tr>";

    //una fiila x alumno . $cod = código del alumno, $listaNotas = sus 4 notas
    foreach ($notas as $cod => $listaNotas){   //1 vuelta x alumno
        $msg .= "<tr><td>" . $usuarios[$cod][0] . "</td>";  //su nombre,sacado de $usuarios
        foreach($listaNotas as $nota){  //1 vuelta x cada nota de ese alumno
                $msg .= "<td align='right'>$nota</td>";
            }
         $msg .= "</tr>";
    }
    $msg .= "</table>";
    return $msg;
}
    