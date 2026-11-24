<?php
class Pedido{
    private int $numped;
    private string $cod_cliente;
    private string $producto;
    private int $precio;

    
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
?>