<?php

require("../secret.php");

include "module/AlchemyAPI_CURL.php";
include "module/AlchemyAPIParams.php";

$alchemyObj = new AlchemyAPI();
$alchemyObj->loadAPIKey("../alchemy_api_key.txt");

$a = "kindle is amazing";
/*
$result = xmlrpc_encode($alchemyObj->TextGetTextSentiment($a, "xml"));
*/
$result = $alchemyObj->TextGetTextSentiment($a, "xml");
echo $a;
$test = simpleXML_load_string($result);
$test2 = $test->docSentiment;
print_r($test2);



  
?>

