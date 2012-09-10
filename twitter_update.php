<?php

require("../secret.php");
require("twitteroauth/twitteroauth-xml.php");
session_start();

echo "You've been authenticated. Now let's import your friends and home_timeline!\r\n";

if(!empty($_SESSION['username'])){  
    $twitteroauth = new TwitterOAuth($tOauth_apiKey, $tOauth_apiSecret, $_SESSION['oauth_token'], $_SESSION['oauth_secret']);  
	$session_username = $_SESSION['username'];
}  else {
	header('Location: welcome.html'); 
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


/* TESTING OUT CREATING A NEW TABLE FOR EACH USER */

$new_friends_table = "friends_" . $session_username;
$new_temp_timeline = "temp_timeline_" . $session_username;

if (!($mysqli->query("CREATE TABLE {$new_friends_table} LIKE friends"))) {
	echo "Welcome back, " . $session_username;
}
if (!($mysqli->query("CREATE TABLE {$new_temp_timeline} LIKE temp_timeline"))) {
	echo "We'll just add your latest friend updates to your history.";
}

/* NEW TABLE CREATION END */

foreach($home_timeline->status as $status) {
	$user = $status->user;
	$tweet = $status->text;
	$tweet = $mysqli->real_escape_string($tweet);
	$date_time = date("Y-m-d H:i:s", strtotime($status->created_at)); 

	if (($query = $mysqli->query("INSERT INTO {$new_friends_table} (user_handle, user_image_URL) VALUES ('{$user->screen_name}', '{$user->profile_image_url}')"))) {
			echo "{$user->screen_name} has been added to your list of friends";
		}
	if (($query = $mysqli->query("INSERT INTO {$new_temp_timeline} (user_handle, status_id, date_time, tweet) VALUES ('{$user->screen_name}', '{$status->id}', '{$date_time}', '{$tweet}')"))) {
			echo "{$user->screen_name} has a new status update";
		}
	/* mysqli_free_result($mysqli); -- is this needed?*/
}

print 'The most recent tweets from your timeline have been added to our database.';

if(!empty($_SESSION['username'])){  
	// User is logged in, redirect  
	header('Location: home.html');
}

?>

<html>


<p>

</p>

<p>
When you're ready, <a href="db-test.php">let's analyze those tweets!</a>
</p>

</html>