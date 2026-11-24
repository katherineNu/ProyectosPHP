<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD DE USUARIOS</title>
    <link href="web/default.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div id="container">
    <div id="header">
       <h1>GESTIÓN DE USUARIOS versión 1.1 + BD (PDO)</h1>
    </div>

    <div id="content">
        <form method="POST">
            <table>
                <tr>
                    <td><label for="nombre">Nombre</label></td>
                    <td>
                        <input type="text" id="nombre" name="nombre" 
                               value="<?= $user->nombre ?>" 
                               <?= ($orden == "Detalles") ? "readonly" : "" ?> 
                               autofocus>
                    </td>
                </tr>
                <tr>
                    <td><label for="login">Login</label></td>
                    <td>
                        <input type="text" id="login" name="login" 
                               value="<?= $user->login ?>" 
                               <?= ($orden == "Detalles" || $orden == "Modificar") ? "readonly" : "" ?>>
                    </td>
                </tr>
                <tr>
                    <td><label for="clave">Contraseña</label></td>
                    <td>
                        <input type="password" id="clave" name="clave" 
                               value="<?= $user->password ?>" 
                               <?= ($orden == "Detalles") ? "readonly" : "" ?>>
                    </td>
                </tr>
                <tr>
                    <td><label for="comentario">Comentario</label></td>
                    <td>
                        <input type="text" id="comentario" name="comentario" 
                               value="<?= $user->comentario ?>" 
                               <?= ($orden == "Detalles") ? "readonly" : "" ?>>
                    </td>
                </tr>
            </table>

            <div style="margin-top: 20px;">
                <input type="submit" name="orden" value="<?= $orden ?>">
                <input type="submit" name="orden" value="Volver">
            </div>
        </form> 
    </div>
</div>

</body>
</html>
<?php exit(); ?>