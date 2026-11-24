<?php
include_once 'BiciElectrica.php';

// ------------------------------------------------------------------
// cargabicis: lee Bicis.csv y devuelve un ARRAY DE OBJETOS BiciElectrica
// Cada línea del CSV:  id, coordx, coordy, bateria, operativa
// ------------------------------------------------------------------

function cargabicis(): array{
$tabla = [];
$fich =fopen("Bicis.csv", "r");   //fopen me dice que abre el fichero en modo r=lectura
 // fgetcsv: lee UNA línea y la parte por las comas en un array
    //   "1002,22332,12002,50,1"  ->  ["1002","22332","12002","50","1"]
    // Cuando no quedan líneas devuelve false y el while termina
    while (($datos = fgetcsv($fich)) !== false) {
        $bici = new BiciElectrica();            // objeto vacío
        $bici->id        = (int) $datos[0];     // cada asignación llama a __set
        $bici->coordx    = (int) $datos[1];
        $bici->coordy    = (int) $datos[2];
        $bici->bateria   = (int) $datos[3];
        $bici->operativa = $datos[4] == "1";    // "1" -> true , "0" -> false
        $tabla[] = $bici;                       // lo añado al final del array
    }
    fclose($fich);                              // cierro el fichero
    return $tabla;
}

// ------------------------------------------------------------------
// mostrartablabicis: devuelve una cadena con la tabla html de bicis OPERATIVAS
// ------------------------------------------------------------------
function mostrartablabicis(array $tabla): string {
    $msg = "<table><tr><th>Id</th><th>Coord X</th><th>Coord Y</th><th>Bateria</th></tr>";
    foreach ($tabla as $bici) {
        if ($bici->operativa) {                 // las no operativas no se muestran
            // cada $bici->... llama a __get
            $msg .= "<tr><td>" . $bici->id . "</td><td>" . $bici->coordx . "</td><td>" .
                    $bici->coordy . "</td><td>" . $bici->bateria . "%</td></tr>";
        }
    }
    return $msg . "</table>";
}

// ------------------------------------------------------------------
// bicimascercana: devuelve la bici OPERATIVA con menor distancia al usuario
// ------------------------------------------------------------------
function bicimascercana(int $x, int $y, array $tabla): ?BiciElectrica {
    $masCercana = null;                         // todavía no tengo ninguna
    $distMin    = PHP_FLOAT_MAX;                // empiezo con la distancia más grande posible

    foreach ($tabla as $bici) {
        if ($bici->operativa && $bici->distancia($x, $y) < $distMin) {
            $distMin    = $bici->distancia($x, $y);  // nueva distancia mínima
            $masCercana = $bici;                     // y esta es la bici más cercana
        }
    }
    return $masCercana;   // ?BiciElectrica: puede devolver un objeto o null (si no hay ninguna)
}





//Programa principal
$tabla=cargabicis();
// isset y no empty: así la coordenada 0 también vale (empty("0") es true)
if (isset($_GET['coordx'], $_GET['coordy']) && $_GET['coordx'] !== "" && $_GET['coordy'] !== "") {
$biciRecomendada = bicimascercana((int)$_GET['coordx'], (int)$_GET['coordy'], $tabla);
}


?>
<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<title>MOSTRAR BICIS OPERATIVAS</title>
<style>
table, th, td {
border: 1px solid black;
}
</style>

</head>

<body>
<h1> Listado de bicicletas operativas </h1>
<?= mostrartablabicis($tabla); ?>
<?php if (isset($biciRecomendada)) : ?>
<h2> Bicicleta disponible más cercana es <?= $biciRecomendada ?> </h2>
<button onclick="history.back()"> Volver </button>
<?php else : ?>
<h2> Indicar su ubicación: </h2>
<form>
Coordenada X: <input type="number" name="coordx"><br>
Coordenada Y: <input type="number" name="coordy"><br>
<input type="submit" value=" Consultar ">
</form>
<?php endif ?>
</body>

</html>
