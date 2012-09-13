<?php

require("../secret.php");
require("twitteroauth/twitteroauth-xml.php");
session_start();

/* Authenticating session */
if(!empty($_SESSION['username'])){  
    $twitteroauth = new TwitterOAuth($tOauth_apiKey, $tOauth_apiSecret, $_SESSION['oauth_token'], $_SESSION['oauth_secret']);  
	$session_username = $_SESSION['username'];
}  

/*Alchemy API SDK */
include "module/AlchemyAPI_CURL.php";
include "module/AlchemyAPIParams.php";

$alchemyObj = new AlchemyAPI();
$alchemyObj->loadAPIKey("../alchemy_api_key.txt");

/* Updating user's friends and timeline tables */
$new_friends_table = "friends_" . $session_username;
$new_temp_timeline = "temp_timeline_" . $session_username; 
  
/* Selecting user's friends */
if (!($stmt = $mysqli->prepare("SELECT user_handle FROM {$new_friends_table}"))) {
	 echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if (!$stmt->execute()) {
	 echo "Execution failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
$res = $stmt->get_result();
while($row = $res->fetch_assoc()) {
	$user = $row['user_handle'];
/* Selecting each friend's tweets, NEED TO ADD DATE SELECTION? */
		if(!($stmt2 = $mysqli->prepare("SELECT tweet, status_ID FROM {$new_temp_timeline} WHERE user_handle='{$user}' AND sentiment_score IS NULL"))) {
				 echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
			}
		if (!$stmt2->execute()) {
				 echo "Execution failed: (" . $mysqli->errno . ") " . $mysqli->error;
			}
		$res2 = $stmt2->get_result();
/* Running each tweet through Alchemy API sentiment analysis */
		while($row2 = $res2->fetch_assoc()) {
			$a = $row2['tweet'];
			$b = $row2['status_ID'];
			$b = $mysqli->real_escape_string($b);
			$response = $alchemyObj->TextGetTextSentiment($a);
			$result = simpleXML_load_string($response);
			$sentiment = $result->docSentiment;
			$mood = $sentiment->type;
			$score = $sentiment->score;
			echo $score . "\n";
			$score = $mysqli->real_escape_string($score);
/* Writing sentiment score to timeline table */
			if(!($stmt3 = $mysqli->query("UPDATE {$new_temp_timeline} set sentiment_score='{$score}' WHERE status_ID='{$b}'"))) {
					 echo "Statement failed: (" . $mysqli->errno . ") " . $mysqli->error;
				}
		}
	
}




/*
$a = "kindle is amazing" . "\n";
$response = $alchemyObj->TextGetTextSentiment($a, "xml");
echo $a;
$result = simpleXML_load_string($response);
$sentiment = $result->docSentiment;
$mood = $sentiment->type;
$score = $sentiment->score;
echo $mood . "\n";
echo $score . "\n";

$stmt->close();
*/

  
?>

