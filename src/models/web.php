<?php
 include 'Elcorteingles.php';
 include 'Carrefour.php';

 

 $objCarrefour = new src\models\Elcorteingles("ue32j5200");
 // $objCarrefour = new src\models\Carrefour("49UJ630V");

 $objCarrefour->buscarPvp();

 /*

 $respuesta = [
    "producto" => $objWorten->producto,
    "pvp" =>$objWorten->pvp,
    "urlProducto" => $objWorten->urlProducto,
    "encontrado"=> $objWorten->encontrado
];
var_dump($respuesta);
*/