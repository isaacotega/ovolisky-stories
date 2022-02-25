<?php
	
	include("connection.php");
	
	include("account_details.php");
	
	$date = Date("d m Y");
	
	$sql = "SELECT * FROM register WHERE date = '$date' ";
	
	if($result = mysqli_query($conn, $sql)) {
	
		function setRegisterCookie() {
		
			global $date;
		
			setcookie("ovoliskyStoriesAttendance",  $date, time() + (86400), "/");
			
		}
		
		if(mysqli_num_rows($result) == 0) {
		
			if($isLoggedIn) {
			
				$sql = "INSERT INTO register (date, opened_pages, visitors, non_visitors) VALUES ('$date', '1', '0', '1')";
			
			}
			
			else {
		
				$sql = "INSERT INTO register (date, opened_pages, visitors, non_visitors) VALUES ('$date', '1', '1', '0')";
				
			}
		
			if(mysqli_query($conn, $sql)) {
			
				setRegisterCookie();
			
			}
	
		}
		
		else {
			
			$row = mysqli_fetch_array($result);
		
			if(isset($_COOKIE["ovoliskyStoriesAttendance"])) {
			
				$sql = "UPDATE register SET opened_pages = opened_pages + 1 WHERE date = '$date' ";
				
			}
			
			else {
			
				if($isLoggedIn) {
				
					$sql = "UPDATE register SET opened_pages = opened_pages + 1, non_visitors = non_visitors + 1 WHERE date = '$date' ";
					
				}
				
				else {
		
					$sql = "UPDATE register SET opened_pages = opened_pages + 1, visitors = visitors + 1 WHERE date = '$date' ";
					
				}
				
				setRegisterCookie();
			
			}
		
			mysqli_query($conn, $sql);
	
		}
		
	}
	
 ?>