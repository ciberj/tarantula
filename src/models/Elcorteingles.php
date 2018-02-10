<?php
    namespace src\models;
    include_once(__DIR__.'./../simple_html_dom.php');

    class Elcorteingles {
        private $urlProducto;
        private $producto;
        private $urlBusqueda='https://www.elcorteingles.es/search/?s=';
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
            $cabeceras=get_headers($busqueda,1);
            //echo "<pre>";var_dump($cabeceras);echo "</pre>";
            if (isset($cabeceras['Location'])){
                //echo "mi url location es: ".$cabeceras['Location'];
                $html= str_get_html(file_get_contents('http://www.elcorteingles.es'.$cabeceras['Location']));
                    $contador=0;
                    foreach($html->find('.current') as $element) {

                            $pvp=$element->plaintext;
                            $pvp=trim(str_replace("&euro;","", $pvp)); // para poder quitar el simbolo €
                            $this->encontrado=true;
                            $this->pvp=$pvp;
                            $this->urlProducto='http://www.elcorteingles.es'.$cabeceras['Location'];
                     }
            } else { 
                foreach($html->find('.no-results') as $element) { // si existe la clase es que no se ha encontrado.
                    $this->pvp=null;
                    break;
                }
                foreach($html->find('.product') as $element) { // si existe la clase es que no se ha encontrado.
                    foreach($element->find('a') as $elem) {
                            $this->urlProducto='http://www.elcorteingles.es'.$elem->href;
                            
                            break;
                    }
                    foreach($element->find('.current') as $elem) {
                            $pvp=$elem->plaintext;
                            $pvp=trim(str_replace("&euro;","", $pvp)); // para poder quitar el simbolo €
                            $this->encontrado=true;
                            $this->pvp=$pvp;
                            break;
                    }
                    break;
                    
                }

            }

                       
            

            
        } 
        
        public function __get($propiedad){
            return $this->$propiedad;
        }



    }
?>