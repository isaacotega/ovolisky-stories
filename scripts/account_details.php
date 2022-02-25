<?php
	
	include("connection.php");
	
	if(!isset($_COOKIE["247rdsck"])) {
	
		$isLoggedIn = false;
		/*
		// value none is important especially in story page dont change it
		
		$usercode = "none";
		*/
		return;
		
	}
	
	$user = array();
	
	$isLoggedIn = true;
	
	$cookieCode = $_COOKIE["247rdsck"];
	
	$sql = "SELECT * FROM accounts WHERE cookie_code = '$cookieCode' ";
	
	if($result = mysqli_query($conn, $sql)) {
		
		// ensure account exists
		
		if(mysqli_num_rows($result) == 0) {
		
			header("Location: ../scripts/ckstr.php?r=d&n=" . "http://" . urlencode($_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]));
		
		}
		
		$row = mysqli_fetch_array($result);
	
		$usercode = $row["usercode"];
	
		$firstName = $row["first_name"];
	
		$lastName = $row["last_name"];
	
		$gender = $row["gender"];
	
		$sql = "SELECT * FROM story_stats WHERE writer_usercode = '$usercode' AND state = 'approved' ";
	
		if($result = mysqli_query($conn, $sql)) {
	
			$user["isWriter"] = (mysqli_num_rows($result) !== 0) ? true : false;
	
		}
		
	}
	
 ?>