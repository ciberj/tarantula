<?php
    namespace src\models;
    include_once(__DIR__.'./../simple_html_dom.php');

    class Elcorteingles {
        private $urlProducto;
        private $producto;
        //private $urlBusqueda='https://www.elcorteingles.es/search/?s=';
        private $urlBusqueda='http://www.elcorteingles.es/api/typeahead/?question=';
        private $pvp;
        private $fecha;
        private $encontrado;

        function __construct($producto){

            $this->producto= $producto;
            $this->encontrado=FALSE;

        }
        /*
        function buscarPvp(){
            $busqueda=$this->urlBusqueda;
            $producto=$this->producto;
            $result=buscar($producto,$busqueda,false,1);
            //$this->urlProducto=$result['urlProducto'];
            $this->pvp=$result['pvp'];
            $this->encontrado=$result['encontrado'];
            $this->urlProducto=$result['url'];

        }*/
        
        function buscarPvp(){
            
            $busqueda=$this->urlBusqueda.$this->producto;
            $html= str_get_html(file_get_contents($busqueda));
            $html=json_decode($html);
           
            if (!$html->products==null){   // hay almenos una coincidencia puede ser un array
                
              
                $url='http://elcorteingles.es'.$html->products[0]->url;
                $html= str_get_html(file_get_contents('http://elcorteingles.es'.$html->products[0]->url));
                
                foreach($html->find('.current') as $element) {

                            $pvp=$element->plaintext;
                            $pvp=trim(str_replace("&euro;","", $pvp)); // para poder quitar el simbolo €
                            $this->encontrado=true;
                            $this->pvp=$pvp;
                            $this->urlProducto=$url;;
                }
            } else{ // no hay coincidencias se intenta buscar en google
                 
                $url=buscarEnGoogle("elcorteingles.es",$this->producto);
                if (!empty($url)){
                        $html= str_get_html(file_get_contents($url));
                        
                        foreach($html->find('.current') as $element) {

                                    $pvp=$element->plaintext;
                                    $pvp=trim(str_replace("&euro;","", $pvp)); // para poder quitar el simbolo €
                                    $this->encontrado=true;
                                    $this->pvp=$pvp;
                                    $this->urlProducto=$url;

                        }
                }else{
                    $this->encontrado=false;
                }
            }
            /*
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
            */
                       
            

            
        }  // funciion
        
        public function __get($propiedad){
            return $this->$propiedad;
        }



    }


function buscar($producto,$urlBusqueda,$encontrado,$contador){
   
        while (!$encontrado){   
            $busqueda=$urlBusqueda.$producto;
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
                            $encontrado=true;
                
                            $urlProducto='http://www.elcorteingles.es'.$cabeceras['Location'];
                             $result=[
                                'pvp'=>$pvp,
                                'url'=>$urlProducto,
                                'encontrado'=> true
                            ];

                            $encontrado=true;
                            break;
                     }
            } else { 
                foreach($html->find('.no-results') as $element) { // si existe la clase es que no se ha encontrado.
                    
                    if (strlen($producto)>5){
                       $producto=substr($producto, 0, -1);
                       
                      
                    }
                    $result=[
                        'pvp'=>'',
                        'url'=>'',
                        'encontrado'=>false

                    ];
                    break;
                }
                foreach($html->find('.product') as $element) { // si existe la clase es que no se ha encontrado.
                    foreach($element->find('a') as $elem) {
                            $urlProducto='http://www.elcorteingles.es'.$elem->href;
                            
                            break;
                    }
                    foreach($element->find('.current') as $elem) {
                            $pvp=$elem->plaintext;
                            $pvp=trim(str_replace("&euro;","", $pvp)); // para poder quitar el simbolo €
                            $encontrado=true;
                            $pvp=$pvp;
                            
                    }
                     $result=[
                                'pvp'=>$pvp,
                                'url'=>$urlProducto,
                                'encontrado'=>$encontrado
                            ];
                    break;
                    
                }

            }

                       
            

            
        }   //  while
           
         
      
        return $result;
        }  

function buscarEnGoogle($comercio,$producto){
    $url='https://www.google.es/search?q='.$producto.'+'.'site:'.$comercio;
    $html= str_get_html(file_get_contents($url));
    //echo $url;
    foreach($html->find('h3') as $element) {
        foreach($element->find('a') as $element){
            $url=str_replace('/url?q=','', $element->href);
            $pos = strpos($url, '&amp;sa');
            
            
            $url=substr($url,0,$pos);
            
            return $url;
        }
    }

}
?>