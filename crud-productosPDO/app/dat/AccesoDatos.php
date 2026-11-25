<?php
//include_once me dice incluyelo solo una vez
include_once "app/dat/Producto.php";
include_once "app/config.php";

/*
 * Acceso a datos con BD productos y Patrón Singleton 
 * Un único objeto para la clase
 * VERSION 1:  las sentencias precompiladas ser crean en cada función
 */
class AccesoDatos {
    //los dos tributos empiezan vacios
    private static $modelo = null;  //guarda el unico objeto accesoDatos que va a existir
                                    //es static asi q es de clase ,es decir solo hay uno
    private $dbh = null;    //este atributo es la datbase y guarda la conexion
    
    
    //Constructor privado  Patron singleton, se accede por getModelo
    public static function getModelo(){
        // Si no existe lo crea el acceso de a la BD
        if (self::$modelo == null){     //esto me dice "todavia no existe el objeto?"
            self::$modelo = new AccesoDatos();  //pues lo creo y se conecta 
        }
        return self::$modelo;           //devuelvo siempre el mismo 
    }  //la 1era vez modelo esta vacio=null, se crea el objeto y se conecta a la BD
    
    

   // al ser privado desde fuera la unica forma de conseguir el objeto 
   //es x getModelo
   
    private function __construct(){
        
        try {
            //dsn dice en donde conectarse
            $dsn = "mysql:host=".SERVER_DB.";dbname=productosdb;charset=utf8";
            // Creo el objeto PDO estableciendo la conexión a la BD
            $this->dbh = new PDO($dsn,DB_USER,DB_PASSWD);
            // Si falla genera una excepción
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            echo "Error de conexión ".$e->getMessage();
            exit();
        }   
    }

    // Cierro la conexión anulando todos los objectos relacioanado con la conexión PDO (stmt)
    public static function closeModelo(){
        if (self::$modelo != null){  //si hay conexion abierta 
            $obj = self::$modelo;
            $obj->dbh = null;     // Cierro la conexión
            self::$modelo = null; // Borro el objeto.
        }
    }


    // Devuelvo un array de objeto de productos
    public function getProductos ():array {
        $tprod = [];                     //creo un array vacio para los productos
        // Sobre la conexión PDO prepara la consulta;
        //stmt guarda sentencias sql preparadas x eso se pone
        $stmt_productos  = $this->dbh->prepare("select * from productos ");
        // Los resultados se devuelven como objetos de la clase productos
        $stmt_productos->setFetchMode(PDO::FETCH_CLASS, 'Producto'); //cada fila sera un objeto Producto
        
        // Ejecuto la sentencias 
        if ( $stmt_productos->execute() ){  //ejecuto
            //$tprod = $stmt_productos->fetchAll();
            // Mientra $prod no sea false, sea un objeto
            while ( $prod = $stmt_productos->fetch()){  //leo las filas una a una
               // añado ese objeto al array
               $tprod[]= $prod;
            }
        }
        

        return $tprod;
    }
    
    // Devuelvo un producto o false
    public function getProducto (int $codigo) {
        $prod = false;  //lo pongo asi por si no lo encuentra el producto
        $stmt_producto   = $this->dbh->prepare("select * from productos where codigo=:codigo");
        $stmt_producto->setFetchMode(PDO::FETCH_CLASS, 'Producto');
        $stmt_producto->bindParam(':codigo', $codigo);   //relleno el hueco :codigo(es un marcador)
        //bindParam lo rellena con el valor de codigo 
        if ( $stmt_producto->execute() ){
             // Solo hay un objeto
             if ( $obj = $stmt_producto->fetch()){ //solo exite un el codigo es la clave
                $prod= $obj;
            }
            //Aquí no hay while, sino un if: como codigo es la clave primaria, 
            //como mucho hay una fila. Si no existe ese código, 
            //fetch() da false y la función devuelve false.
        }
        return $prod;  //me da el prodcuto o FALSE si no existe
    }
    
    // UPDATE
    public function modProducto($prod):bool{
      //la sentencia me dice modifica los datos del producto nombre,stock,etc cuyo codigo es codigo
      //el where si no se pone se cambiarian todos los productos 
        $stmt_modprod   = $this->dbh->prepare("update productos set nombre=:nombre, stock=:stock, stock_min=:stock_min, precio=:precio where codigo=:codigo");
        $stmt_modprod->bindValue(':codigo',$prod->codigo);
        $stmt_modprod->bindValue(':nombre',$prod->nombre);
        $stmt_modprod->bindValue(':stock',$prod->stock);
        $stmt_modprod->bindValue(':stock_min',$prod->stock_min);
        $stmt_modprod->bindValue(':precio',$prod->precio);
        $stmt_modprod->execute();  //aqui me rellena cada hueco con el atriubuto del objeto y lo ejecuta
        // El número de filas modificadas debe ser 1
        $resu = ($stmt_modprod->rowCount () == 1);
        return $resu;
    }

    //INSERT
    public function addProducto($prod):bool{
        $stmt_creaprod  = $this->dbh->prepare("insert into productos (codigo,nombre,stock,stock_min,precio) Values(?,?,?,?,?)");
        //$stmt_creaprod->bindValue(1,$prod->codigo);
        //este seria la manera corta en lugar de poner 5 bindValue
        $stmt_creaprod->execute( [$prod->codigo, $prod->nombre, $prod->stock, $prod->stock_min, $prod->precio]);
        $resu = ($stmt_creaprod->rowCount () == 1);
        return $resu;
    }

    //DELETE
    public function borrarProducto(int $codigo):bool {
        //en la consulta seria: Borra el producto con ese código. 
        //Otra vez, el where es imprescindible: sin él, se borraría 
        //la tabla entera.
        $stmt_borprod = $this->dbh->prepare("delete from productos where codigo =:codigo");
        $stmt_borprod->bindValue(':codigo', $codigo);
        $stmt_borprod->execute();
        $resu = ($stmt_borprod->rowCount () == 1);  //se ha borrado 1 fila?
        return $resu;
    }   
    
     // Evito que se pueda clonar el objeto. (SINGLETON)
    public function __clone()
    { 
        trigger_error('La clonación no permitida', E_USER_ERROR); 
    }
}

