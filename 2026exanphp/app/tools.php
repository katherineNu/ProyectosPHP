<?php 
/**
 *  Genera una cadena un texto de la clase -> 1: Turista, 2: Business, 3: First Class
 * @param int $num
 * @return string - Texto asociado al valor del número
 */
function verClase( int $num):string {
    $tabla=["1" => "Turista", "2"=>"Bussines", "3"=>"First Class"];
     return $tabla[$num];
    };

/**
 *  Muestra un mensaje según el valor de plazas, si es menor de 10  devuelve 
 *  la cadena 'Ultimas plazas' y es caso contrario 'Disponibles'
 * @param int $plazas
 * @return string
 */
function verEstado ( int $plazas):string {
    if ($plazas > 10){
    return "Disponible";
}else{
    return "Ultimas plazas";
}
}