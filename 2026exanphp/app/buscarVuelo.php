<?php
session_start();

require_once 'modelo/Vuelo.php';
require_once 'modelo/AccesoDatos.php';
require_once 'tools.php';



$destino = htmlspecialchars($_GET['destino']);
$plazas= htmlspecialchars( $_GET['plazas']);
//compruebo que las plazas son correctas 
$mensajeError="";
if(!is_numeric($plazas) || $plazas <=0 || $plazas >5){
    $mensajeError = "ERROR: El numero de plazas no es correcto ";
    include 'vistas/error.php';
    die();
}

$ac = AccesoDatos::initModelo();
//el destino no existe
if ( ! $ac->hayVuelos($destino)){
    $mensajeError = "ERROR: No hay vuelos con destino a  " .$destino;
    include 'vistas/error.php';
    die();
    }
//Actualizo el cookie

$nconsultas=0;
    if(isset ($_COOKIE['consultas'])){
        $nconsultas=$_COOKIE['consultas'];
    }
 $nconsultas++;
 // si pongo "/" se puede recuperar desde cualquier ruta
 //y si pongo un dominio en cocnectro como "elpais.com" y se añade esa cookie
 setcookie('consultas', $nconsultas, time()+3600*24*7, "/");

$listavuelos=$ac->getVuelos($destino, $plazas);
if(count($listavuelos) == 0){
    $mensajeError = "ERROR: No hay vuelos con plazas para el  destino a  " .$destino;
    include 'vistas/error.php';
    die();
}

include 'vistas/listado.php';
    




 
