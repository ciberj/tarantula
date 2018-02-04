<?php
$json='{"products":[],"categories":[],"brands":[]}';
echo $json."<br>";
$json=json_decode($json);
var_dump($json);
var_dump($json->products);
if (!empty($json->products)){
	echo "no esta vacio";
}else{
	echo "esta vacio";
}