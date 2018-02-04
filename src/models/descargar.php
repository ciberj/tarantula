<?php


function get_contents() {
  file_get_contents("http://www.elcorteingles.es/search/?s=TV+LED+124,46+cm+(49%27%27)+LG+49UJ750V+Premium+UHD+4K,+HDR,+Smart+TV+Wi-Fi");
  var_dump($http_response_header);
}
get_contents();
//var_dump($http_response_header);

?>
