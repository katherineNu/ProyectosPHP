<?php
require_once "app/dat/Producto.php";
require_once 'app/dat/AccesoDatos.php';
//este programa me da las acciones por GET o POST
// Cada función atiende una orden. Las que devuelven texto, es el mensaje
// que index.php muestra encima de la tabla.
function accionBorrar ($codigo){    
    $db = AccesoDatos::getModelo();  //pido la conexion 
    $tprod = $db->borrarProducto($codigo);  //delete de ese producto q esta
                                            //en Accesodatos.php
}

function accionTerminar(){
    AccesoDatos::closeModelo();  //cierro la conexion de BD
    session_destroy();          //borro la sesion
    header("Refresh:0 url='./index.php'"); //recargo index y limpio
}
 
function accionAlta(){
    $prod = new Producto();  //es un producto nuevo 
    $prod->codigo    = "";  //con todos los campos vacios
    $prod->nombre    = "";
    $prod->stock     = "";
    $prod->stock_min = "";
    $prod->precio    = "";
    $orden= "Nuevo";        //el boton del formulario se llaamara NUEVO
    include_once "layout/formulario.php";
}

function accionDetalles($codigo){
    $db = AccesoDatos::getModelo();
    $prod = $db->getProducto($codigo);  //leo ese producto de la BD 
    $orden = "Detalles";
    include_once "layout/formulario.php";
}


function accionModificar($codigo){
    $db = AccesoDatos::getModelo();
    $prod = $db->getProducto($codigo);  //leo el producto
    $orden="Modificar";
    include_once "layout/formulario.php";
}

function accionPostAlta(){
    $prod = new Producto();  //objeto vacio
    $prod->codigo     = $_POST['codigo'];  //relleno con lo escrito en el formulario
    $prod->nombre     = $_POST['nombre'];
    $prod->stock      = $_POST['stock'];
    $prod->stock_min  = $_POST['stock_min'];
    $prod->precio     = $_POST['precio'];
    $db = AccesoDatos::getModelo();
    $db->addProducto($prod);  //insetr en la BD
    
    //cada accion pasa x el set de producto por eso lo llama
    // ::getModelo se pone los :: x q es static
}

function accionPostModificar(){
    
    $prod = new Producto();
    $prod->codigo     = $_POST['codigo'];  //el codigo no podra cambiar xq es readondoly
    $prod->nombre     = $_POST['nombre'];  //los tros datos si que los cambios 
    $prod->stock      = $_POST['stock'];
    $prod->stock_min  = $_POST['stock_min'];
    $prod->precio     =$_POST['precio'];
    $db = AccesoDatos::getModelo();
    $db->modProducto($prod);
    //Exactamente igual que el alta, pero al final llama a modProducto()
    // (UPDATE) en vez de addProducto() (INSERT). El código llega en el 
    //$_POST aunque sea readonly, porque las cajas readonly sí se envían. 
    //Así el WHERE codigo = :codigo sabe qué producto cambiar. 
}

