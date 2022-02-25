<?php
	
	require("connection.php");
	
	require("account_details.php");
	
	$followersArray = json_decode($_POST["array"], true);
	
	$storyCode = $_POST["info"];
	
	$chapter = $_POST["info2"];
	
	$digitsNo = 10;
	
	$notificationId = "";
	
	$notificationId = 2;
	
	$date = date("Y m d");
	
	$time = date("H:i A");
	
	foreach($followersArray as $eachUsercode) {
	
		$sql = "INSERT INTO notifications (story_code, chapter, sender_usercode, receiver_usercode, notification_id, seen, date, time) VALUES ('$storyCode', '$chapter', '$usercode', '$eachUsercode', '$notificationId', 'false', '$date', '$time') ";
		
		mysqli_query($conn, $sql);
	
	}
	
	header("Location: ../story?id=" . $storyCode . "&c=" . $chapter);
	
 ?>