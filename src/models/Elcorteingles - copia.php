<?php
    namespace src\models;
    include_once(__DIR__.'./../simple_html_dom.php');

    class Elcorteingles {
        private $urlProducto;
        private $producto;
        private $urlBusqueda='http://www.elcorteingles.es/api/typeahead/?question=';
        private $pvp;
        private $fecha;
        private $encontrado;

        function __construct($producto){

            $this->producto= $producto;
            $this->encontrado=FALSE;

        }
        function buscarPvp(){
            
            $busqueda=$this->urlBusqueda.$this->producto;
           

            $html= str_get_html(file_get_contents($busqueda));
            
           
            $myjson=json_decode($html); // devuelve un objeto
            
            if (!empty($myjson->products)){
                // echo "he entrado";
                    $url="http://elcorteingles.es".$myjson->products[0]->url;// url del poructo a buscar ya solo nos queda bajar la pgina y cober el pvp
                    
                    file_get_contents($url); // en la cabecera hay un location que indica la url correcta
                    
                    $urlProducto=explode(" ", $http_response_header[1]);
                    $urlProducto=$urlProducto[1];
                    
                      
                    
                    $html= str_get_html(file_get_contents($urlProducto));
                    $contador=0;
                    foreach($html->find('.current') as $element) {

                            $pvp=$element->plaintext;
                            $pvp=trim(str_replace("&euro;","", $pvp)); // para poder quitar el simbolo €
                            $this->encontrado=true;

                            if ($pvp="Mostrar cuatro productos por fila"){   // para solventar el error de que encuentre 2 produc.
                                $this->pvp="ERROR";
                            }else{
                                $this->pvp=$pvp;
                            }
                            


                                
                            /*

                            echo "<pre>";
                            var_dump($this);
                            echo "</pre>";*/
                            break;

                    }
            }else{
               //echo "no he entrado";
            }

            
        } 
        
        public function __get($propiedad){
            return $this->$propiedad;
        }



    }
?>