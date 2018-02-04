<?php

// example of how to use basic selector to retrieve HTML contents
include('./src/simple_html_dom.php');
 $busqueda = "3TS986BT";


 $html_corte = str_get_html(file_get_contents('http://media.flixcar.com/delivery/js/inpage/179/es/mpn/3TS986BT/ean/4242006275594?&=179&=es&mpn=3TS986BT&ean=4242006275594&brand=Balay&ext=.js'));
print_r($html_corte->root);








/*

// get DOM from URL or file
$html_mediamarkt = str_get_html(file_get_contents('https://api.empathybroker.com/search/v1/query/mediamarkt/search?jsonCallback=angular.callbacks._0&lang=es&q='.$busqueda));
//$result = json_decode($html);

///////////////////////// worten
//var_dump($html->root->nodes[0]->parent->nodes[0]->_[4]);

$rest = substr($html_mediamarkt, 21, -1);
//echo $rest;
$result = json_decode($rest);
$contenido=$result->content->docs;
//var_dump($contenido);
echo $contenido[0]->name;
echo "     precio: ";
echo $contenido[0]->price;

echo "<br><br>";

$html_worten = str_get_html(file_get_contents('https://api.empathybroker.com/search/v1/query/worten/search?jsonCallback=angular.callbacks._a&lang=es&origin=default&q='.$busqueda));
///////////////////////// worten
$html_worten=$html_worten->root->nodes[0]->parent->nodes[0]->_[4];

$rest = substr($html_worten, 21, -1);
//echo $rest;
$result = json_decode($rest);
$contenido=$result->content->docs;
//var_dump($contenido);
echo $contenido[0]->name;
echo "     precio: ";
echo $contenido[0]->price;


//print_r($result->docs);
//print_r($result);




//var_dump($html);
//echo "<br><br>---------------"; 
//echo $html;



*/
?>
