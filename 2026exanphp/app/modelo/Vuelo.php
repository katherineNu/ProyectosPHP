<?php
/*
`cod_vuelo` varchar(10) NOT NULL,
  `destino` varchar(50) NOT NULL,
  `aerolinea` varchar(50) NOT NULL,
  `clase` int(11) NOT NULL, -- 1: Turista, 2: Business, 3: First Class
  `precio_billete` float NOT NULL,
  `asientos_libres` 
*/
class Vuelo {
    private string $cod_vuelo;
    private string $destino;
    private string $aerolinea;
    private int $clase;
    private float $precio_billete;
    private int $asientos_libres;
    


    public function __get(string $name)
    {
        if(property_exists($this,$name )){
            return $this->$name;
        }else{
            return "Atributo ERROR";
        }
        
    }

    public function __set(string $name, $value)
    {
        if(property_exists($this,$name)){
            $this->$name=$value;
        }
    }
}
