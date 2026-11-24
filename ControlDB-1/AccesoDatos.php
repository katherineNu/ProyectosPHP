<?php
require_once "Pedido.php";
require_once "Cliente.php";
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
        // Cambiar le password !!!!! //hay que cambiar siempre el nombre d ela
        //dbname y quitar lo de password root
        try {
            $dsn = "mysql:host=localhost;dbname=etienda;charset=utf8";
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
function getPedido(string $cod_cliente): bool{
    $resu=false;
    //creo una sentencia
    $stmt = $this->dbh->prepare("Select * from pedidos where destino = :destino limit 1"); 
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

public function getCliente(string $nombre, string $clave)
{
    //tablaresu
    $resu=null;
    $stmt = $this->dbh->prepare("Select * from clientes where nombre = :nombre and clave = :clave"); 
    $stmt->binValue(":nombre",$nombre);
     $stmt->binValue(":clave",$clave);
    //fetch class me devuelve como objeto un cliente 
    $stmt->setFetchMode(PDO::FETCH_CLASS,"Cliente");
    if($stmt->execute()){
        
            $resu= $stmt->fetch();
        }
    

    return $resu;
}
  
}

