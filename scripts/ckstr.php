<?php
	
	isset($_GET["r"]) or die(header("Location: ../"));
	
	$returnPage = isset($_GET["n"]) ? $_GET["n"] : "../";
	
	$returnPage = !empty($_GET["n"]) ? $_GET["n"] : "../";
	
	if($_GET["r"] == "s") {
		
		isset($_GET["c"]) or die(header("Location: ../"));
	
		setcookie("247rdsck", $_GET["c"], time() + (86400 * 30), "/");
	
		header("Location: " . $returnPage);
		
	}
					
	if($_GET["r"] == "d") {
	
		setcookie("247rdsck", $_GET["c"], time() - 1, "/");
	
		header("Location: " . $returnPage);
		
	}
					
 ?>