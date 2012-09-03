<?php

require("../secret.php");

include "module/AlchemyAPI_CURL.php";
include "module/AlchemyAPIParams.php";

$alchemyObj = new AlchemyAPI();
$alchemyObj->loadAPIKey("../alchemy_api_key.txt");

$a = "kindle is amazing" . "\n";
$response = $alchemyObj->TextGetTextSentiment($a, "xml");
echo $a;
$result = simpleXML_load_string($response);
$sentiment = $result->docSentiment;
$mood = $sentiment->type;
$score = $sentiment->score;
echo $mood . "\n";
echo $score . "\n";



  
?>

