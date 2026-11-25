<?php
session_start();
//basicamente aqui no toco nada 

include_once 'app/dat/AccesoDatos.php';
include_once 'app/funciones.php';
include_once 'app/acciones.php';


// Div con contenido
$contenido="";    // mensaje que se mostrará encima de la tabla

// GET: los enlaces (iconos) y los botones Nuevo / Salir
if ($_SERVER['REQUEST_METHOD'] == "GET" ){
    
    if ( isset($_GET['orden'])){
        switch ($_GET['orden']) {
            case "Nuevo"    : accionAlta(); break;
            case "Borrar"   : accionBorrar   ($_GET['id']); break;
            case "Modificar": accionModificar($_GET['id']); break;
            case "Detalles" : accionDetalles ($_GET['id']);break;
            case "Terminar" : accionTerminar(); break;
        }
    }
} 
// POST Formulario de alta o de modificación
else {
    if (  isset($_POST['orden'])){
        limpiarArrayEntrada($_POST); //Evito la posible inyección de código
         switch($_POST['orden']) {
             case "Nuevo"    : accionPostAlta(); break;
             case "Modificar": accionPostModificar(); break;
             case "Detalles":; // No hago nada
         }
    }
}

$contenido .= mostrarDatos();
// Muestro la página principal
include_once "app/layout/principal.php";




