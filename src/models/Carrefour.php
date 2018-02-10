<?php
    namespace src\models;
    include_once(__DIR__.'./../simple_html_dom.php');

    class Carrefour {
        private $urlProducto;
        private $urlBusqueda='https://www.carrefour.es/global/?Ntx=mode+matchallany&Ntt=';
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
           /** $html= str_get_html(file_get_contents($busqueda));

            ////////////  ya que la forma anterior no funciona /////////////////////////////////*/
                $curl_handle=curl_init();
                curl_setopt($curl_handle, CURLOPT_URL,$busqueda);
                curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
                $query = curl_exec($curl_handle);
                curl_close($curl_handle);
                // echo $query;
                $html= str_get_html($query);


            //////////////////////////////////////*/


				foreach($html->find('.precio-nuevo') as $element) {
			        //echo ($element->plaintext) . '<br>'; /* $elemt tiene todo el html incluido la clase, p, otros, de ahí plaintext*/
			        $pvp= explode(" ", $element->plaintext);
			        $this->pvp=(float)$pvp[0];
			        $this->encontrado=true;
			        
			        //busco la url
			        foreach($html->find('.enlace-producto') as $element) {
			        	//echo $element->href . "<br>";
			        	
			        	//echo  '<a href="'."http://carrefour.es".$element->href.'">'.$this->producto."</a>";
			        	
			        	$this->urlProducto="http://www.carrefour.es".$element->href;
			        	break;



			        }
			        break;

				}

            /*
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
             
*/



        } 
        
        public function __get($propiedad){
            return $this->$propiedad;
        }



    }
