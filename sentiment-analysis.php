<?php

require("../secret.php");
require("twitteroauth/twitteroauth-xml.php");
session_start();

if(!empty($_SESSION['username'])){  
    $twitteroauth = new TwitterOAuth($tOauth_apiKey, $tOauth_apiSecret, $_SESSION['oauth_token'], $_SESSION['oauth_secret']);  
	$session_username = $_SESSION['username'];
}  

  /**
   * GET wrapper for oAuthRequest.
   */
  function get($url, $parameters = array()) {
    $response = $this->oAuthRequest($url, 'GET', $parameters);
    if ($this->format === 'xml' && $this->decode_xml) {
      return simplexml_load_string($response);
    }
    return $response;
  }
 

$new_friends_table = "friends_" . $session_username;
$new_temp_timeline = "temp_timeline_" . $session_username; 
  
  
if(!($stmt = $mysqli->prepare("SELECT tweet, status_ID FROM {$new_temp_timeline} WHERE user_handle='adactio'"))) {
	     echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
if (!$stmt->execute()) {
	     echo "Execution failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	
/*
$text = array();
$status_id = array();
$tweet = array();

*/

$tweet = $stmt->get_result();
while ($result = $tweet->fetch_row()) {
	while ($result2 = $result->fetch_assoc()) {
		echo $result2;
	}
	$text[] = $result['0'];
	print_r($result);
	print_r($text);
	echo count($text);
/*	echo is_array($result) ? 'Array' : 'Not an Array';
	echo count($result);
	echo count($text);
*/
/*	$status_id[] = $result['status_ID'];
	$text2 = current($text);
	$status_id2 = current($status_id);
	$query = $mysqli->query("INSERT INTO test_import (field1, field2) VALUES ('{$text2}', '{$status_id2}')");
	mysql_free_result($query);
*/
$url = "http://www.viralheat.com/api/sentiment/review.xml?text=" . urlEncode($text) . "&api_key=" . $vh_apiKEY;
echo $url;

}

/*
print_r($text);
print_r($status_id);
*/








  
?>