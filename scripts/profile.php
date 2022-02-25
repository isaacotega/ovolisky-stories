<?php
	
	isset($_POST["request"]) or die();
	
	require("account_details.php");
	
	require("connection.php");
	
	$request = $_POST["request"];
	
	$profiler = json_decode($_POST["profiler"], true);
	
	
	
	
	if($request == "checkIfFollowing") {
		
		$sql = "SELECT * FROM followers WHERE followed_usercode = '" . $profiler["usercode"] . "' ";
			
		if($result = mysqli_query($conn, $sql)) {
				
			$followersNo = mysqli_num_rows($result);
				
		}
		
		$sql = "SELECT * FROM followers WHERE follower_usercode = '$usercode' AND followed_usercode = '" . $profiler["usercode"] . "' ";
			
		if($result = mysqli_query($conn, $sql)) {
				
			$isFollowing = ((mysqli_num_rows($result) == 0) ? "false" : "true");
			
			$data = array("status" => "success", "isFollowing" => $isFollowing, "followersNo" => $followersNo);
			
			exit(json_encode($data));
			
		}
		
	}
	
	if($request == "follow") {
		
		$sql = "SELECT * FROM followers WHERE follower_usercode = '$usercode' AND followed_usercode = '" . $profiler["usercode"] . "' ";
			
		if($result = mysqli_query($conn, $sql)) {
			
			$followersNo = mysqli_num_rows($result);
			
			$isFollowing = (($followersNo == 0) ? false : true);
			
		}
		
		if($isFollowing) {
			
			$sql = "DELETE FROM followers WHERE follower_usercode = '$usercode' AND followed_usercode = '" . $profiler["usercode"] . "' ";
			
			if(mysqli_query($conn, $sql)) {
				
				$data = array("status" => "success");
			
				exit(json_encode($data));
				
			}
			
		}
		
		else if(!$isFollowing) {
		
			$date = date("Y m d");
			
			$time = date("H:i A");
		
			$sql = "INSERT INTO followers(follower_usercode, followed_usercode, date, time) VALUES('$usercode', '" . $profiler["usercode"] . "', '$date', '$time')";
			
			if(mysqli_query($conn, $sql)) {
				
				$data = array("status" => "success");
			
				exit(json_encode($data));
				
			}
			
		}
		
	}
	
	
 ?>