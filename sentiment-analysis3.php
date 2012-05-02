<?php

require("../secret.php");

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

$tweet = mysql_query("SELECT tweet, status_ID FROM temp_timeline WHERE user_handle='bergatron'");  

$text = array();
$status_id = array();

foreach($tweet->tweet as $text) {
	$result = mysql_fetch_assoc($tweet);
	$text[] = $result['tweet'];
	$status_id[] = $result['status_ID'];
	$text2 = current($text);
	$status_id2 = current($status_id);
	$query = mysql_query("INSERT INTO test_import (field1, field2) VALUES ('{$text2}', '{$status_id2}')");
	mysql_free_result($query);
}
print_r($text);
print_r($status_id);





$url = "http://www.viralheat.com/"




  
?>