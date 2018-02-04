<?php
    namespace src\models;
    include_once(__DIR__.'./../simple_html_dom.php');

    class Worten {
        private $urlProducto;
        private $urlBusqueda='https://api.empathybroker.com/search/v1/query/worten/search?jsonCallback=angular.callbacks._0&lang=es&q=';
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
            
            $htmlPvp = substr($htmlPvp, 21, -1);
            $htmlPvp=json_decode($htmlPvp);
            $topTrends=$htmlPvp->topTrends;
            
            if ($topTrends==null){
                
                $objHtml=$htmlPvp->content->docs;
                    if ($objHtml==NULL){
                        $this->encontrado=FALSE;
                    } else{
                        $this->pvp= $objHtml[0]->price;
                    
                        $this->urlProducto = $objHtml[0]->url;
                        $this->encontrado=TRUE;
                    }
            }else{
                $this->encontrado=false;

            }
             




        } 
        
        public function __get($propiedad){
            return $this->$propiedad;
        }



    }
