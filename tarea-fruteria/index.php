<?php
session_start();  //abro la sesion a partir de ahora usare SESSION 

// Manejo de la sesión con dos valores
// 'cliente' => nombre del cliente
// 'pedidos' => array asociativo fruta => cantidad


// Nuevo cliente: anoto en la sesión su nombre y creo su tabla de pedidos vacía
if (isset($_GET['cliente'])) {
    //guardo el nombre en la sesion copio el nombre que pone 
    $_SESSION['cliente']= $_GET['cliente'];
    $_SESSION['pedidos']=[];  //creo la tabla de pedidos vacia
    //xque el cliente acaba de llegar y no hay nada peiddo todavia
    
}

// No hay definido un cliente todavía en la session 
//Si no existe un cliente muestro Bienvenida.php 
if (!isset($_SESSION['cliente'])) {
    include "bienvenida.php";       //muestro el formulario de bienvenida

    die();                 // y para aqui
}


// Proceso las acciones de los botones (llegan por POST) 
if (isset($_POST["accion"])) {

switch ($_POST["accion"]) {
     case " Anotar ":
        $fruta= $_POST['fruta'];
        $cantidad=(int)$_POST['cantidad'];  //al ponerle int el texto pasa a numero entero
        // Actualizo la tabla de pedidos en la sesión
        //es decir lo que ya hay de cantidad de esa fruta lo guardo
        // ??si no habia nada de esa fruta uso un 0 y +$cantidad le sumo si vuelve añadir 
        //de esa fruta 

        $_SESSION['pedidos'][$fruta]=($_SESSION['pedidos'][$fruta] ?? 0) + $cantidad;
        break;
    case " Anular ":
        $fruta=$_POST['fruta'];  //la fruta que esta seleccionada 
        // Vacío la tabla de pedidos en la sesión
        unset($_SESSION['pedidos'][$fruta] );  //si pulso anular borro esa fruta total
        break;
    case " Terminar ":
           // Destruyo la sesión y vuelvo a la página de bienvenida
           //llamo a la tabla de pedidos y guardo en comprarealizada
           
           $compraRealizada = htmlTablaPedidos();
           include_once "despedida.php";
           session_destroy();
           exit();
        break;
            
}
}
//genero la tabla con lo pedido hasta ahora 
$compraRealizada = htmlTablaPedidos();
require_once 'compra.php';


// Función axiliar que genera una tabla HTML a partir  la tabla de pedidos
// Almacenada en la sesión
function htmlTablaPedidos(): string
{
    $msg = "";
    $msg .= "<table><tr><th>Fruta</th><th>Cantidad</th></tr>";
    //recorro el array de pedidos en cada vuelta, fruta es la clave y cantidad valor
    foreach ($_SESSION['pedidos'] as $fruta => $cantidad) {
    $msg .= "<tr><td>" . $fruta . "</td><td>" . $cantidad . "</td></tr>";
}
    $msg .="</table>";
    
    return $msg;
}
/* OTRA FORMA DE SOLUCIONARLO
<?php
// ==================================================================
// index.php -> CONTROLADOR de la frutería.
// Decide qué pantalla mostrar: bienvenida.php, compra.php o despedida.php
//
// Manejo de la sesión con dos valores:
//   $_SESSION['cliente'] => nombre del cliente
//   $_SESSION['pedidos'] => array asociativo  fruta => cantidad
//                           ej: ["Naranjas" => 4, "Limones" => 3]
// ==================================================================

session_start();        // inicio (o recupero) la sesión. Siempre lo primero.

// ------------------------------------------------------------------
// 1) NUEVO CLIENTE: llega el nombre por GET desde bienvenida.php
//    (el formulario de bienvenida tiene method="get" y name="cliente")
// ------------------------------------------------------------------
if (!empty($_GET['cliente'])) {                 // !empty: que llegue y que no esté vacío
    $_SESSION['cliente'] = $_GET['cliente'];    // guardo el nombre en la sesión
    $_SESSION['pedidos'] = [];                  // y creo su tabla de pedidos VACÍA
}

// ------------------------------------------------------------------
// 2) Si todavía NO hay cliente en la sesión -> pantalla de bienvenida
// ------------------------------------------------------------------
if (!isset($_SESSION['cliente'])) {
    require_once 'bienvenida.php';      // muestro el formulario del nombre
    exit();                             // y paro aquí: no hay nada más que hacer
}

// ------------------------------------------------------------------
// 3) Proceso los botones del formulario de compra (llegan por POST)
//    OJO: los value de los botones tienen ESPACIOS: " Anotar ", " Anular "...
//    Los case tienen que ser EXACTAMENTE iguales, con los espacios.
// ------------------------------------------------------------------
if (isset($_POST["accion"])) {

    switch ($_POST["accion"]) {

        case " Anotar ":
            $fruta    = $_POST["fruta"] ?? "";
            $cantidad = (int) ($_POST["cantidad"] ?? 0);    // (int): texto -> número entero

            // Lista blanca de frutas + cantidad entre 1 y 10 (como el min/max del formulario)
            if (in_array($fruta, ["Platanos", "Naranjas", "Limones", "Manzanas"]) &&
                $cantidad >= 1 && $cantidad <= 10) {

                // ACUMULAR: lo que ya había de esa fruta (o 0 si es la primera vez) + lo nuevo
                // Ej: había ["Naranjas" => 2], pido 2 más -> ["Naranjas" => 4]
                $_SESSION['pedidos'][$fruta] = ($_SESSION['pedidos'][$fruta] ?? 0) + $cantidad;
            }
            break;

        case " Anular ":
            $_SESSION['pedidos'] = [];          // vacío la tabla de pedidos (sigue el mismo cliente)
            break;

        case " Terminar ":
            // Genero la tabla ANTES de borrar la sesión (después ya no habría datos)
            $compraRealizada = htmlTablaPedidos();
            session_destroy();                  // borro todos los datos de la sesión
            require_once 'despedida.php';       // pantalla de despedida con la tabla
            exit();
    }
}

// ------------------------------------------------------------------
// 4) Pantalla de compra: la tabla del pedido + el formulario de frutas
// ------------------------------------------------------------------
$compraRealizada = htmlTablaPedidos();  // compra.php escribe esta variable en su HTML
require_once 'compra.php';


// ------------------------------------------------------------------
// Función auxiliar que genera una tabla HTML a partir de la tabla de
// pedidos almacenada en la sesión. Devuelve el HTML en un string.
// ------------------------------------------------------------------
function htmlTablaPedidos(): string
{
    // Si todavía no ha pedido nada, no muestro tabla (figura de "REALICE SU COMPRA")
    if (empty($_SESSION['pedidos'])) {
        return "";
    }

    $msg = "Este es su pedido :";
    $msg .= "<table style='border: 1px solid black'>";     // .= añade al final del texto

    // foreach con clave => valor: $fruta = "Naranjas", $cantidad = 4
    foreach ($_SESSION['pedidos'] as $fruta => $cantidad) {
        $msg .= "<tr><td><b>$fruta</b></td><td>$cantidad</td></tr>";
    }

    $msg .= "</table>";
    return $msg;
}
*/