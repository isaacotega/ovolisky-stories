<?php
	
	include("connection.php");
	
	$request = $_POST["request"];
	
	if($request == "register") {
	
		$sql = "SELECT date, opened_pages, visitors, non_visitors FROM register";
		
		if($result = mysqli_query($conn, $sql)) {
			
			$data = array(["request" => $request]);
		
			while($row = mysqli_fetch_assoc($result)) {
				
				$data[] = $row;
			
			}
		
			echo json_encode($data);
			
		}
	
	}
	
	if($request == "members") {
	
		$sql = "SELECT first_name, last_name, usercode, email, date_registered, time_registered FROM accounts";
		
		if($result = mysqli_query($conn, $sql)) {
			
			$data = array(["request" => $request]);
		
			while($row = mysqli_fetch_assoc($result)) {
				
				$data[] = $row;
			
			}
		
			echo json_encode($data);
			
		}
	
	}
	
	if($request == "postsManager") {
	
		$sql = "SELECT * FROM story_stats";
		
		if($result = mysqli_query($conn, $sql)) {
			
			$data = array(["request" => $request]);
		
			while($row = mysqli_fetch_assoc($result)) {
				
				$data[] = $row;
			
			}
		
			echo json_encode($data);
			
		}
	
	}
	
	else {}
	
 ?>