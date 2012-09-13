<?php

if(!empty($_SESSION['username'])){  
	echo "{$session_username}'s Friends";
	} else {
			header('Location: ../welcome.html'); 
		}
		
echo "<div id='button'><a href=sentiment-ratings.php>Analyze now</a></div>";

	/*$query = "SELECT user_handle FROM friends";
	$a = array();
	$result = $mysqli->query($query);
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$a[] = $row["user_handle"];
	}
	print_r($a);
	$result->free();*/
	
if (!($stmt = $mysqli->prepare("SELECT user_handle FROM {$new_friends_table}"))) {
	 echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if (!$stmt->execute()) {
	 echo "Execution failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
$res = $stmt->get_result();

while($row = $res->fetch_assoc()) {
	$user = $row['user_handle'];
		echo "<div id='default_friends'>";
	echo $user . "\n";
	echo "</div>";
}
?>