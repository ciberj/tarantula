<?php
    include '../src/models/Mediamarkt.php';
    include '../src/models/Worten.php';
    include '../src/models/Carrefour.php';
    include '../src/models/Elcorteingles.php';
        
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    require '../vendor/autoload.php';

    $app = new \Slim\App;
    
   

    $app->post('/test', function (Request $request, Response $response) {
      var_dump($request->getParsedBody()) ;

    });

    $app->get('/producto/{producto}', function (Request $request, Response $response) {
        $producto = $request->getAttribute('producto');
        $objMediamarkt = new src\models\Mediamarkt($producto);
        $objWorten = new src\models\Worten($producto);
        $objMediamarkt->buscarPvp();
        $respuesta = [
            "producto" => $objMediamarkt->producto,
            "pvp" =>$objMediamarkt->pvp,
            "urlProducto" => $objMediamarkt->urlProducto,
            "encontrado"=> $objMediamarkt->encontrado
        ];
        return  json_encode($respuesta);
    
    });

    $app->post('/producto', function (Request $request, Response $response) {
        
              $allPostPutVars = $request->getParsedBody();
              //var_dump($allPostPutVars);
              $postParam = $allPostPutVars['productos'];
              //var_dump($postParam);
            
              $obj = json_decode($postParam);  
              
              $total=[];
              foreach ($obj as $producto){
                  
                  $objMediamarkt = new src\models\Mediamarkt($producto);
                  $objWorten = new src\models\Worten($producto);
                  $objCarrefour = new src\models\Carrefour($producto);
                  $objCorte = new src\models\Elcorteingles($producto);
                  $objMediamarkt->buscarPvp();
                  $objWorten->buscarPvp();
                  $objCarrefour->buscarPvp();
                  $objCorte->buscarPvp();

                  $prod[0] = [
                      "comercio" => "mediamarkt",
                      "pvp" =>$objMediamarkt->pvp,
                      "urlProducto" => $objMediamarkt->urlProducto,
                      "encontrado"=> $objMediamarkt->encontrado
                  ];
                  $prod[1] = [
                    "comercio" => "worten",
                    "pvp" =>$objWorten->pvp,
                    "urlProducto" => $objWorten->urlProducto,
                    "encontrado"=> $objWorten->encontrado
                  ];
                  
                  $prod[2] = [
                    "comercio" => "Carrefour",
                    "pvp" =>$objCarrefour->pvp,
                    "urlProducto" => $objCarrefour->urlProducto,
                    "encontrado"=> $objCarrefour->encontrado
                 ];
                 
                 $prod[3] = [
                    "comercio" => "CorteIngles",
                    "pvp" =>$objCorte->pvp,
                    "urlProducto" => $objCorte->urlProducto,
                    "encontrado"=> $objCorte->encontrado
                 ];
                  $respuesta["producto"]=$producto;
                  $respuesta["datos"]=$prod;
                  $total[]=$respuesta;
                  sleep(0);
              }
              return  json_encode($total);
              
      
      
      
     });
/*************** ESTO ESTA CORRECTO ******************* 
    $app->post('/producto', function (Request $request, Response $response) {
  
        $allPostPutVars = $request->getParsedBody();
        //var_dump($allPostPutVars);
        $postParam = $allPostPutVars['productos'];
        //var_dump($postParam);
      
        $obj = json_decode($postParam);  
        
        $total=[];
        foreach ($obj as $producto){
            
            $objMediamarkt = new src\models\Mediamarkt($producto);
            $objWorten = new src\models\Worten($producto);
            $objMediamarkt->buscarPvp();
           // var_dump(objMediamarkt);
           // $objWorten->buscarPvp();
            $respuesta = [
                "producto" => $objMediamarkt->producto,
                "pvp" =>$objMediamarkt->pvp,
                "urlProducto" => $objMediamarkt->urlProducto,
                "encontrado"=> $objMediamarkt->encontrado
            ];
            
            $total[]=$respuesta;
            sleep(3);
        }
        return  json_encode($total);

    });
    /****************************************************** */
    
    $app->post('/grabar', function (Request $request, Response $response) {

        
        
        $datos = ($request->getParsedBody())['datos'];
        $total=json_decode($datos);
        
        
        //Opcion al uaurio de Abrirlo o guardarlo directamente
        header("Content-type: application/eml");
        header("Content-Disposition: attachment; filename="."datos.csv"."");
        $manejador=fopen("datos.csv", "wa");
        $val[0]="producto";
        $val[1]="Mediamarkt";
        $val[2]="Worten";
        $val[3]="Carrefour";
        $val[4]="Elcorteingles";
    ;
        fputcsv($manejador, $val,";");
        foreach($total as $val) {
            $linea[0]=$val->producto;
            $linea[1]=$val->datos[0]->pvp;    //pvp mediamarkt
            $linea[2]=$val->datos[1]->pvp;
            $linea[3]=$val->datos[2]->pvp;
            $linea[4]=$val->datos[3]->pvp;
            fputcsv($manejador, $linea,";");
        }
        fclose($manejador);
  
       
    });
    $app->run();