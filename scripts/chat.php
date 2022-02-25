<?php
	
	isset($_POST["request"]) or die();
	
	require("account_details.php");
	
	require("connection.php");
	
	date_default_timezone_set("Africa/Lagos");
	
	$request = $_POST["request"];
	
	$threadCode = $_POST["threadCode"];
	
	
	if($request == "getMessages") {
		
		$sql = "SELECT * FROM messages WHERE thread_code = '$threadCode' ";
			
		if($result = mysqli_query($conn, $sql)) {
			
			$messageObj = array();
			
			while($row = mysqli_fetch_assoc($result)) {
			
				$messageObj[] = json_encode($row);
				
			}
			
			$data = array("status" => "success", "messageObj" => $messageObj);
			
			exit(json_encode($data));
			
		}
		
		else {
		
			$data = array("status" => "error");
			
			exit(json_encode($data));
			
		}
		
	}
	
	if($request == "sendMessage") {
		
		$message = $_POST["message"];
	
		$date = date("Y m d");
				
		$time = date("H:i");
				
		$sql = "INSERT INTO messages (thread_code, sender_usercode, message, seen, date, time) VALUES ('$threadCode', '$usercode', '$message', 'false', '$date', '$time')";
			
		if($result = mysqli_query($conn, $sql)) {
				
			$data = array("status" => "success");
			
			exit(json_encode($data));
			
		}
		
		else {
		
			$data = array("status" => "error");
			
			exit(json_encode($data));
			
		}
		
	}
	
 ?>