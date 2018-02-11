<?php
    namespace src\models;
    use \PDO;

    

    class Juanlucas {
        private $urlProducto;
        private $urlBusqueda='https://api.empathybroker.com/search/v1/query/mediamarkt/search?jsonCallback=angular.callbacks._0&lang=es&q=';
        private $producto;
        private $pvp;
        private $fecha;
        private $encontrado;

        function __construct($producto){
          
            $this->producto= $producto;
            $this->encontrado=FALSE;

        }
        public function __get($propiedad){
            return $this->$propiedad;
        }
        function buscarPvp(){
        	$producto= "%".$this->producto."%";
        	$mbd = new PDO('mysql:host=localhost;dbname=productos','alfonso', '123456'); 
        	$sql= "SELECT * FROM productos WHERE codigo like :codigo";
        	$com=$mbd->prepare($sql);
        	$com->bindParam(':codigo', $producto);  
        	$com->execute();
        	$result = $com->fetchAll();
        	
        	foreach ($result as $row)
        		$this->pvp=$row['tarifa_tiendas'];

			$this->encontrado=true;

        }

    }

?>