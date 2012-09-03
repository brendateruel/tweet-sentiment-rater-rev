<?php

require("../secret.php");
require("twitteroauth/twitteroauth-xml.php");
session_start();

if(!empty($_SESSION['username'])){  
    $twitteroauth = new TwitterOAuth($tOauth_apiKey, $tOauth_apiSecret, $_SESSION['oauth_token'], $_SESSION['oauth_secret']);  
	$session_username = $_SESSION['username'];
}  

$text = "is this working yet?";

$url = "http://www.viralheat.com/api/sentiment/review.xml?text=" . urlEncode($text) . "&api_key=" . $vh_apiKEY;
echo $url;

  /**
   * GET wrapper for Viralheat.
   */
class ViralHeat{
   function get($url, $parameters = array()) {
    $response = $this->OAuthRequest($url, 'GET', $parameters);
    if ($this->format === 'xml' && $this->decode_xml) {
      return simplexml_load_string($response);
    }
    return $response;
  }
}

$viralheat = new ViralHeat();
$result = $viralheat->get($url);

print_r($result);

$new_friends_table = "friends_" . $session_username;
$new_temp_timeline = "temp_timeline_" . $session_username; 
  
  
if(!($stmt = $mysqli->prepare("SELECT tweet, status_ID FROM {$new_temp_timeline} WHERE user_handle='adactio'"))) {
	     echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
if (!$stmt->execute()) {
	     echo "Execution failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	



/*
print_r($text);
print_r($status_id);
*/








  
?>