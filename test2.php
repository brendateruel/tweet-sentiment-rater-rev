<?php

require("../secret.php");
require("twitteroauth/twitteroauth-xml.php");
session_start();


if(!($all = $mysqli->prepare("SELECT sentiment_score FROM temp_timeline_little_bg WHERE user_handle='bergatron'"))) {
	 echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
if(!$all->execute()) {
	 echo "Execution failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}	
	$res = $all->get_result();
	while($row = $res->fetch_assoc()) {
		print_r($row);
		$a = $row['sentiment_score'];
		echo $a;
/*		function average($a){
			return array_sum($a)/count($a);
		}
		echo array_sum($a);
		echo "sum(a) = " . array_sum($a) . "\n";
		echo "Average of array:". average($a); */
	}
/*
		$solution = array();
	function average($solution){
		return array_sum($solution)/count($solution) ;
	}
	while ($array = mysqli_fetch_array($all)) {
	$solution[]=$array['sentiment_score'];
	}
	$solution2 = simpleXML_load_string($solution);



/*
		if(!($stmt2 = $mysqli->prepare("SELECT tweet, status_ID FROM {$new_temp_timeline} WHERE user_handle='{$user}' AND sentiment_score IS NULL"))) {
				 echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
			}
		if (!$stmt2->execute()) {
				 echo "Execution failed: (" . $mysqli->errno . ") " . $mysqli->error;
			}
		$res2 = $stmt2->get_result();
 Running each tweet through Alchemy API sentiment analysis 
		while($row2 = $res2->fetch_assoc()) {
			$a = $row2['tweet'];
			$b = $row2['status_ID'];
			
*/

?>