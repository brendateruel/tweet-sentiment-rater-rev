<?php

require("../secret.php");
require("twitteroauth/twitteroauth-xml.php");
session_start();

if(!empty($_SESSION['username'])){  
    $twitteroauth = new TwitterOAuth('JlVI5JLcRgiHOX8LhUhCmw', 'AzFZeQZ7zhhN397iLSPNC36MUryUBPufvqt8i1NI', $_SESSION['oauth_token'], $_SESSION['oauth_secret']);  
}  

$res = $mysqli->query("SELECT COUNT(*) AS `Rows`, `user_handle` FROM `temp_timeline` GROUP BY `user_handle` ORDER BY `user_handle`");

if (!$res) {
    $message  = 'Invalid query: ' . mysqli_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}

// Use result
// Attempting to print $result won't allow access to information in the resource
// One of the mysql result functions must be used
// See also mysql_result(), mysql_fetch_array(), mysql_fetch_row(), etc.
while ($row = mysqli_fetch_assoc($result)) {
    echo $row['user_handle'];
	echo "\n";
}

	echo "\n";

mysqli_free_result();

$all = $mysqli->query("SELECT sentiment_score FROM temp_timeline WHERE user_handle='bergatron'");
$solution=array();

function average($solution){
  return array_sum($solution)/count($solution) ;
}

while ($array = mysqli_fetch_array($all)) {
$solution[]=$array['sentiment_score'];
}

print_r($solution);
echo array_sum($solution);
echo "sum(a) = " . array_sum($solution) . "\n";
echo "Average of array:".average($solution);


	
if (mysql_num_rows($all) > 0) {
	echo "we're good";
} else {
	echo 'no values to fetch';
}


?>

<html>

<h2>Hello <?=(!empty($_SESSION['username']) ? '@' . $_SESSION['username'] : 'Guest'); ?></h2>
<p></p>

</html>