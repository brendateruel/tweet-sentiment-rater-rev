<?php

require("../secret.php");

include "module/AlchemyAPI_CURL.php";
include "module/AlchemyAPIParams.php";

$alchemyObj = new AlchemyAPI();
$alchemyObj->loadAPIKey("../alchemy_api_key.txt");

$a = "kindle is amazing";

$result = $alchemyObj->TextGetTextSentiment($a);
echo $a;
echo $result;


  
?>

