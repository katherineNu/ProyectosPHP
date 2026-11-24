<?php
//clase BiciElectrica
//implemento aqui el get y set y tostring
class BiciElectrica{
private $id; // Identificador de la bicicleta (entero)
private $coordx; // Coordenada X (entero)
private $coordy; // Coordenada Y (entero)
private $bateria; // Carga de la batería en tanto por ciento (entero)
private $operativa; // Estado de la bicleta ( true operativa- false no disponible)

//hago el _get esto hace que PHP lea un atributo privado desde fuera
//se pone $atributo para que cuando se haga echo $bici->id , se llame a ID
//y asi con todo coordx,coordy,etc y asi evito poner getId,getCoordx,etc
public function __get($atributo)
{
    return $this->$atributo;
}

//set se utiliza para DAR EL VALOR de ese atributo que se llama y que a su vez
//ese atributo es privado
public function __set($atributo, $valor)
{
    $this->$atributo= $valor;
}

//toString salta cuando el objeto se usa como TEXTO
//ejemplo:  echo $bici;   ->  "Identificador: 2015 Bateria 63 %"
public function __toString(): string
{
    return "Identificador: " .$this->id . " Bateria " .$this->bateria . " %";
}

//aqui pongo la ecuacion de distancia que me ponia en el word
// d = raíz( (x2 - x1)² + (y2 - y1)² )
public function distancia(int $x, int $y): float{
    //pow (num,2) esto signifcia que el numero lo elevo al cuadrado
    //sqrt() se utliza para raiz cuadrada 
    return sqrt(pow($x - $this->coordx, 2) + pow($y - $this->coordy, 2));
}

}