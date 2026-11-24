<?php
require_once "Cliente.php";
require_once "Pedido.php";
require_once "AccesoDatos.php";


//compruebo que este vacio
if (empty($_GET['nombre']) ||  empty($_GET['clave'])){
    $msg;
    -->vistaerror.php
    exit();
}
?>

ac=AccesoDatos::initModelo();
$cli= $ac->getCliente($_GET['nombre']) ||  $_GET['clave'];
IF(!$cli)
vistaerror

    ac >actualizarAccesoCliente()
array az ->getPedidosClientes;
vistapedidos.php