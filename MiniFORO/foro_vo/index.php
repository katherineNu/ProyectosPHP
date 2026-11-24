

<?php 
// PRIMERA APROXIMACIÓN AL MODELO VISTA CONTROLADOR. 
// Funciones auxiliars Ej- usuarioOK
include_once 'app/funciones.php';

// Salida hacia buffer  a partir de aqui todo lo q se escriba no se envia al 
//navegador se guardar en un buffer=memoria
ob_start(); 
$msg ="";   //mensaje de error para la pantalla de entrada (vacio al principio)


// Segun la orden  , se ha pulsado algun boton? todos los botones su nombre es orden
if ( !isset($_REQUEST['orden']) ){
    //no hay orden , es la primera vez que entro a la pagina
    include_once 'app/plantillas/entrada.php';
} 
else {
    //hago un switch segun el VALUE del boton pulsado 
    switch ($_REQUEST['orden']){
        //boton de entrar 
        case "Entrar":
            // Chequear usuario
            if ( isset($_REQUEST['nombre']) && isset($_REQUEST['contraseña']) && 
                 usuarioOK($_REQUEST['nombre'], $_REQUEST['contraseña'] )) {
               echo " Bienvenido <b>".$_REQUEST['nombre']."</b><br>";
               include_once  'app/plantillas/comentario.html';
            }
            else {
                $msg = " Usuario no válido ";  //lo mostrara entrada.php
                include_once 'app/plantillas/entrada.php';
                
            }
            break;
            
        case "Nueva opinión":
            echo " Nueva opinión <br>";
            include_once  'app/plantillas/comentario.html';
            break;
        case "Detalles": // Mensaje y detalles
              // Servidor: como mucho 300 caracteres. mb_substr() corta el texto
            // (desde la posición 0, 300 caracteres). ?? '' por si no llega nada.
           // $_REQUEST['comentario'] = mb_substr($_REQUEST['comentario'] ?? '', 0, 300);
            echo "Detalles de su opinión";
            include_once 'app/plantillas/comentariorelleno.php';
            include_once 'app/plantillas/detalles.php';
            break;
        case "Terminar": // Formulario inicial
            include_once 'app/plantillas/entrada.php';
    }
    
}
// ob_get_clean(): saco todo lo que se guardó en el buffer, lo meto en la
// variable $contenido_php y vacío el buffer (todavía no se ha enviado nada).
$contenido_php = ob_get_clean();

include_once "app/plantillas/principal.php";

?>

