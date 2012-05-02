<?php

require("../secret.php");
require("twitteroauth/twitteroauth-xml.php");
session_start();

echo "You've been authenticated. Now let's import your friends and home_timeline!\r\n";

if(!empty($_SESSION['username'])){  
    $twitteroauth = new TwitterOAuth($tOauth_apiKey, $tOauth_apiSecret, $_SESSION['oauth_token'], $_SESSION['oauth_secret']);  
}  

$home_timeline = $twitteroauth->get('statuses/home_timeline', array('count' => 200));  


foreach($home_timeline->status as $status) {
	$user = $status->user;
	$date_time = date("Y-m-d H:i:s", strtotime($status->created_at)); 
	$query = mysql_query("INSERT INTO friends (user_handle, user_image_URL) VALUES ('{$user->screen_name}', '{$user->profile_image_url}')");  
	$query = mysql_query("INSERT INTO temp_timeline (user_handle, status_id, date_time, tweet) VALUES ('{$user->screen_name}', '{$status->id}', '{$date_time}', '{$status->text}')");  
	mysql_free_result($query);
}

print 'The most recent tweets from your timeline have been added to our database.';

?>

<html>

<h2>Hello <?=(!empty($_SESSION['username']) ? '@' . $_SESSION['username'] : 'Guest'); ?></h2>

<p>
<?= 
	$query = mysql_query("SELECT user_handle FROM friends");  
	$a = array();
	while ($result = mysql_fetch_assoc($query)) {
		$a[] = $result;
	}
	print_r($a);
?>
</p>

<p>
When you're ready, <a href="db-test.php">let's analyze those tweets!</a>
</p>

</html>