<?php
    namespace src\models;
    include_once(__DIR__.'./../simple_html_dom.php');

    class Worten {
        private $urlProducto;
        private $urlBusqueda='https://api.empathybroker.com/search/v1/query/worten/search?lang=es&q=';
        private $producto;
        private $pvp;
        private $fecha;
        private $encontrado;

        function __construct($producto){

            $this->producto= $producto;
            $this->encontrado=FALSE;

        }
        function buscarPvp(){
            
            $busqueda=$this->urlBusqueda.$this->producto;
            $htmlPvp= str_get_html(file_get_contents($busqueda));
            
          
            $htmlPvp=json_decode($htmlPvp);
            
            
            if ($htmlPvp->content->numFound>0){ // hay una posible coincidencia
                
                $objHtml=$htmlPvp->content->docs;
                //$spellchecked=$htmlPvp->content->spellchecked;
                    if (!isset($htmlPvp->content->spellchecked)){ // coincidencia exacta hasta la busqueda, coletillas pueden ser distintas
                        $this->pvp= $objHtml[0]->price;
                    
                        $this->urlProducto = $objHtml[0]->url;
                        $this->encontrado=TRUE;
                       
                    } else{ // aproximación similar 
                         $this->encontrado=FALSE;
                    }
            }else{ // no se ha encontrado
                $this->encontrado=false;

            }
             




        } 
        
        public function __get($propiedad){
            return $this->$propiedad;
        }



    }
