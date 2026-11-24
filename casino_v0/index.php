<?php

//Sesion  el dinero disponible mientras juega ($session=disponible)
//COOKIE las vistas del casino durante un mes ($cookie=visitas)
session_start();   //siempre tengo que empezar con esto para abrir la session

//1ero hago visitas (cookie) y se cuenta una vez por cada sesision nueva
//si la sesion no tiene visitas es xque acaba de crearse
// esto me dice: SI NO EXISTE NINGUNA SESION
if(!isset($_SESSION['visitas'])){
  //lo que habia en la cookie(o 0 si es la primera vez)+ 1(esta visita)
  $_SESSION['visitas'] = ($_COOKIE['visitas'] ?? 0)+1;
  //guardo el nuevo numero en la cookkie durante un mes asi lo pide el enunciado
  //con esto estoy actualizando la cookie
  setcookie("visitas", $_SESSION['visitas'], time() + 30*24*3600);
}

// Cambiar  visitar --> VALOR DE COOKIE
// Cambiar disponible --> VALOR DE SESSION
$visitas = $_SESSION['visitas'] ; //lo pongo asi xq en el archivo de for_bienvenida.php esta asi
//lo guardo en la sesion Para contar una vez por sesión. 
//Si contara en cada petición, cada recarga o cada apuesta sumaría una visita.
//por eso lo guardo tanto en la sesion como en la cookie

 

$msg="";

// Entra en el casino --------------------------------
if (! isset($_SESSION['disponible'])) {
  //compruebo si ya ha enviado el dinero inciial 
    if(isset($_POST['cantidadini']) && (int)$_POST['cantidadini'] > 0){
      //lo guardo en la sesion como numero entero 
      $_SESSION['disponible'] = (int) $_POST['cantidadini'];
    }else{
      require_once "form_bienvenida.php";  //si no, le pido el dinero y muestro la pagina de
      exit();                           //bienvenida y no continuo
     }
}



// Si realiza una apuesta ----------------------------------
// llama a procesar apuesta 
if (isset($_POST["apostar"])) {
  $cantidad=(int) ($_POST["cantidad"] ?? 0);  //la cantidad que apuesta lo paso como un num entero
   $apuesta = $_POST["apuesta"] ?? "PAR";     //PAR o IMPAR (lo qe se marque
   if($cantidad <=0){
    $msg="ERROR: introduzca una cantidad para apostar.";
   }elseif ($cantidad > $_SESSION['disponible']){
  //si la cantidad es mayor a lo que tengo aun asi le dejo apostar con lo que le 
    //queda disponible x eso se comprueba 

    $msg="ERROR: no dispones de $cantidad euros disponibles";
   }else{
    //Si la apuesta es válida, la juega con la función. 
    //Lo que devuelve (el texto “RESULTADO... GANASTE”) va a $msg.
    $msg= procesarApuesta($cantidad, $_SESSION['disponible'], $apuesta);
   }
}
   //Copia el dinero a $disponible, porque los formularios escriben <?= $disponible 
   // Va después de la apuesta, para que muestre el dinero ya actualizado.
   $disponible= $_SESSION['disponible'];  
 
// Si abandona o ya no le queda dinero -------------------------
//¿Pulsa “Abandonar el Casino” o se ha quedado a 0? El || significa “o”:
  // basta con una de las dos.
 if (isset($_POST["dejar"]) || ($_SESSION["disponible"] == 0) ) {
  require_once "despedida.php";  //muestro el dinero final
  session_destroy();  //borro la sesion : la proxima entrada sera una visita nueva
    
   exit();
} 
// Muestro el formulario si puede seguir apostando
//Si no ha abandonado, muestra el mensaje, “Dispone de X para jugar” y el formulario.
require_once  "form_apuesta.php";

/**
 *  FUNCIONES AUXILIARES
 *  procesarApuesta: juega una apuesta y devuelve el mensaje del resultado.
 *   int $valorapuesta       -> lo que apuesta
 *   int &$saldodisponible   -> el & significa "por REFERENCIA": la función trabaja
 *                              con la variable ORIGINAL, no con una copia. Si aquí
 *                              se suma o se resta, cambia $_SESSION['disponible']
 *   string $apuesta         -> "PAR" o "IMPAR"
 */

function procesarApuesta(int $valorapuesta, int &$saldodisponible, string $apuesta): String {
  
    $numero    = rand(1, 100);                          // número aleatorio entre 1 y 100
    $resultado = ($numero % 2 == 0) ? "PAR" : "IMPAR";  // resto 0 al dividir entre 2 -> par

    $msgresultado = "RESULTADO DE LA APUESTA : $resultado <br>";

    if ($resultado == $apuesta) {
        $saldodisponible += $valorapuesta;      // += suma: gana lo apostado
        $msgresultado .= "GANASTE";
    } else {
        $saldodisponible -= $valorapuesta;      // -= resta: pierde lo apostado
        $msgresultado .= "PERDISTE";
    }
    return $msgresultado;
}
