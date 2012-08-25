<?php

require("../secret.php");
require("twitteroauth/twitteroauth-xml.php");
session_start();

echo "You've been authenticated. Now let's import your friends and home_timeline!\r\n";

if(!empty($_SESSION['username'])){  
    $twitteroauth = new TwitterOAuth($tOauth_apiKey, $tOauth_apiSecret, $_SESSION['oauth_token'], $_SESSION['oauth_secret']);  
	$session_username = $_SESSION['username'];
}  

$home_timeline = $twitteroauth->get('statuses/home_timeline', array('count' => 200));  

/*multi-query statement not working...
foreach($home_timeline->status as $status) {
	$user = $status->user;
	$date_time = date("Y-m-d H:i:s", strtotime($status->created_at)); 
	$query = "INSERT INTO friends (user_handle, user_image_URL) VALUES ('{$user->screen_name}', '{$user->profile_image_url}');";
	$query.= "INSERT INTO temp_timeline (user_handle, status_id, date_time, tweet) VALUES ('{$user->screen_name}', '{$status->id}', '{$date_time}', '{$status->text}');";
	if (!$mysqli->multi_query($query)) {
		echo "Multi-query failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
}
$mysqli->close();*/

foreach($home_timeline->status as $status) {
	$user = $status->user;
	$tweet = $status->text;
	$tweet = $mysqli->real_escape_string($tweet);
	$date_time = date("Y-m-d H:i:s", strtotime($status->created_at)); 
	if (!($query = $mysqli->query("INSERT INTO friends (user_handle, user_image_URL, session_username) VALUES ('{$user->screen_name}', '{$user->profile_image_url}', '{$session_username}')"))) {
		echo "Insert friends failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	if (!($query = $mysqli->query("INSERT INTO temp_timeline (user_handle, status_id, date_time, tweet, session_username) VALUES ('{$user->screen_name}', '{$status->id}', '{$date_time}', '{$tweet}', '{$session_username}')"))) {
		echo "Insert temp_timeline failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	/* mysqli_free_result($mysqli); -- is this needed?*/
}

print 'The most recent tweets from your timeline have been added to our database.';

?>

<html>

<h2>Hello <?=(!empty($_SESSION['username']) ? '@' . $_SESSION['username'] : 'Guest'); ?></h2>

<p>
<?php
	/*$query = "SELECT user_handle FROM friends";
	$a = array();
	$result = $mysqli->query($query);
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$a[] = $row["user_handle"];
	}
	print_r($a);
	$result->free();*/
	
	if (!($stmt = $mysqli->prepare("SELECT user_handle FROM friends"))) {
	     echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	if (!$stmt->execute()) {
	     echo "Execution failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	$res = $stmt->get_result();
	while($row = $res->fetch_assoc()) {
		echo $row['user_handle'] . "\n";
	}
	$stmt->close();
	?>
</p>

<p>
When you're ready, <a href="db-test.php">let's analyze those tweets!</a>
</p>

</html>