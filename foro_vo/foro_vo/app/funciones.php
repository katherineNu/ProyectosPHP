<?php
function usuarioOk($usuario, $contraseña) :bool {

  if (strlen($usuario) >= 8 && strrev($usuario) === $contraseña) {
        return true;
    }
    return false;
}
?>

