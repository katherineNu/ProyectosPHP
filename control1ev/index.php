<?php
// aqui controlo la consultas de notas y decido que pantalla voy a mostrar
//acceso.php , resultado.php, o bloqueado.php
session_start();   //empiezo abriendo la sesion para guardas los fallos

include_once('app/funciones.php');  //llamo a funciones.php xq ahi estan los datos (usuarios
                                          //modulos, notas etc)

define('MAX_FALLOS', 5);    //defino el maximo de intentos erroneos x sesion
//2da parte contador de fallos en la sesion
if(!isset($_SESSION['fallos'])){  //si no existe ninguna sesion (primera vez en esta sesion)
  $_SESSION['fallos']=0;          //empiezo el contador en 0
}
if($_SESSION['fallos'] >= MAX_FALLOS){  //si llevo 5 fallos muestro
  include_once('app/bloqueado.php');    //la pantalla de bloqueo sin formulario 
  exit();                               //y paro todo no se procesa nada mas
}

//1eraParte 
//ha llegado el usuario y clave (el formulario usa GET por eso nos referimos $GET)
if (  !empty( $_GET['login']) && !empty($_GET['clave'])){

    if ( userOk($_GET['login'],$_GET['clave'])){
      $_SESSION['fallos']=0;   //datos todos correctos contador de fallos en 0

      //caso 2 y 3 segun si profe o alumno 
      if ( getUserRol($_GET['login']) == ROL_PROFESOR){
        $contenido = verNotaTodas($_GET['login']);   //caso 3 profesor
      } else {
        $contenido = verNotasAlumno($_GET['login']);  //caso 2 alumno
      }
      include_once ('app/resultado.php');
    } 
    // caso 1: userOK falso
    else {
      $_SESSION['fallos']++;  //si el usuario falla sumo 1 fallo
       $contenido = "El número de usuario y la contraseña no son válidos";
       include_once('app/acceso.php');   ////vuelvo a pedir los datos 
    }
} else {
    $contenido = " Introduzca su número de usuario y su contraseña";
    include_once('app/acceso.php');
}


