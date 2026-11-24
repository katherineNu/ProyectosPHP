<?php
require_once "Vuelo.php";
/*
 * Acceso a datos con BD y Patrón Singleton
 */
class AccesoDatos {
    
    private static $modelo = null;
    private $dbh = null;
    private $stmt = null;
    
    public static function initModelo(){
        if (self::$modelo == null){
            self::$modelo = new AccesoDatos();
        }
        return self::$modelo;
    }
    
    
    private function __construct(){
        // Cambiar le password !!!!!
        try {
            $dsn = "mysql:host=localhost;dbname=vuelos;charset=utf8";
            $this->dbh = new PDO($dsn, "root", "");
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            echo "Error de conexión ".$e->getMessage();
            exit();
        }
          
    }

     // Evito que se pueda clonar el objeto.
    public function __clone()
    { 
        trigger_error('La clonación no permitida', E_USER_ERROR); 
    }
function hayVuelos(string $destino): bool{
    $resu=false;
    //creo una sentencia
    $stmt = $this->dbh->prepare("Select * from vuelos where destino = :destino limit 1"); 
    $stmt->binValue(":destino",$destino);
    //fetch class me devuelve como objeto un vuelo 
    $stmt->setFetchMode(PDO::FETCH_CLASS,"vuelo");
    if($stmt->execute()){
        if($stmt->fech()){
            $resu=true;
        }
    }
    return $resu;
}

public function getVuelos(string $destino, int $plazas):array
{
    //tablaresu
    $tresu=[];
$stmt = $this->dbh->prepare("Select * from vuelos where destino = :destino and asientos_libres >= :plazas"); 
    $stmt->binValue(":destino",$destino);
     $stmt->binValue(":plazas",$plazas);
    //fetch class me devuelve como objeto un vuelo 
    $stmt->setFetchMode(PDO::FETCH_CLASS,"vuelo");
    if($stmt->execute()){
        if($stmt->fech()){
            $tresu= $stmt->fetchAll();
        }
    }

    return $tresu;
}
  
}

