<?php 
$username="alfonso";
$password="1234";
$process = curl_init("localhost/prueba/info.php");
curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
curl_setopt($process, CURLOPT_HEADER, 1);
curl_setopt($process, CURLOPT_USERPWD, $username . ":" . $password);
curl_setopt($process, CURLOPT_TIMEOUT, 30);
curl_setopt($process, CURLOPT_POST, 1);
//curl_setopt($process, CURLOPT_POSTFIELDS, $payloadName);
curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
$return = curl_exec($process);
echo $return;
curl_close($process);
?>