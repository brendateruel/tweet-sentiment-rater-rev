<?php

if(!empty($_SESSION['username'])){  
	echo "{$session_username}'s Friends";
	} else {
			header('Location: ../welcome.html'); 
		}

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
?>
<?php
while($row = $res->fetch_assoc()) {
	echo "<div id='user' style='margin:10px; color:#d6d6d6'>";
	echo $row['user_handle'] . "\n";
	echo "</div>";
}
?>