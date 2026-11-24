<p> <?=$msg ?></p>
<div>
<form name='entrada' method="POST">
<table>
<tr>
<td>Nombre:</td><td> <input type="text" name="nombre" 
    value="<?=/*isset() comprueba si una variable existe (true o false)*/(isset($_REQUEST['nombre']))?$_REQUEST['nombre']:''?>"></td></tr>
<tr>
<td>Contraseña: </td><td><input type="password" name="contraseña"
    value="<?= $_REQUEST['contraseña']?? '' ?>"></td>
</tr>
</table>
<input type="submit" name="orden" value="Entrar">
</form>
</div>
<!-- Mensaje de error debajo del formulario (como en la figura 2). $msg viene de index.php -->
<p><?= $msg ?></p>
