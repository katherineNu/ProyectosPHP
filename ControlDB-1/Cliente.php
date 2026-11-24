<?php
class cliente{
    private string $cod_cliente;
    private string $nombre;
    private string $clave;
    private int $veces;

    //se pueden copiar los get y set de otro ejercicio 
    //este por ejemplo lo he copiado de VUELO.PHP
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