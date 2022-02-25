<?php
	
	isset($_GET["id"]) or die(header("Location: ../"));
	
	$id = $_GET["id"];
	
	include("connection.php");
	
	$sql = "SELECT * FROM story_stats WHERE story_code = '$id' AND state = 'approved' ";
	
	$nextCheckSql = "SELECT * FROM chapters WHERE story_code = '$id'
 ";

	$lastUpdateSql = "SELECT * FROM chapters WHERE story_code = '$id' ORDER BY chapter DESC LIMIT 1";
					
	if($result = mysqli_query($conn, $sql)) {
	
		mysqli_num_rows($result) !== 0 or die(header("Location: ../"));
	
		$row = mysqli_fetch_array($result);
	
		$writer_usercode = $row["writer_usercode"];
	
		$story_code = $row["story_code"];
	
		$title = $row["title"];
	
		$nick = $row["nick"];
	
		$about = $row["about"];
	
		$prologue = $row["prologue"];
	
		$epilogue = $row["epilogue"];
	
		$genre = $row["genre"];
	
		$tags = explode("+", $row["tags"]);
	
		$views = $row["views"];
	
		$upvotes = $row["upvotes"];
	
		$status = $row["status"];
	
	
		$accept_date = $row["accept_date"];
			
		$authorInfoSql = "SELECT * FROM accounts WHERE usercode = '$writer_usercode'
 ";
	
		if($authorInfoResult = mysqli_query($conn, $authorInfoSql)) {
			
			$row = mysqli_fetch_array($authorInfoResult);
			
			$authorFirstName = $row["first_name"];
		
			$authorLastName = $row["last_name"];
		
			$authorGender = $row["gender"];
		
			$authorBio = $row["bio"];
		
		}
		
		if($nextCheckResult = mysqli_query($conn, $nextCheckSql)) {
		
			if(mysqli_num_rows($nextCheckResult) !== 0) {
		
				$storyHasBegun = true;
				
			}
			
			else {
		
				$storyHasBegun = false;
				
			}
			
		}
	
		if($lastUpdateResult = mysqli_query($conn, $lastUpdateSql)) {
					
			if(mysqli_num_rows($lastUpdateResult) !== 0) {
						
				$row = mysqli_fetch_array($lastUpdateResult);
					
					$currentChapter = $row["chapter"];
							
					$lastUpdateDate = $row["date"];
							
					$lastUpdateTime = $row["time"];
							
				}
						
				else {
						
					$currentChapter = "None";
							
					$lastUpdateDate = "";
							
					$lastUpdateTime = "";
							
				}
					
			}
				
	}
	
	if($currentPage == "story") {
	
		$sql = "SELECT * FROM chapters WHERE story_code = '$id' AND chapter = '$chapter' ";
	
		$nextChapterSql = "SELECT * FROM chapters WHERE story_code = '$id' AND chapter = '$chapter' ";
	
		$lastChapterSql = "SELECT * FROM chapters WHERE story_code = '$id' ORDER BY chapter DESC ";
		
		if($lastChapterResult = mysqli_query($conn, $lastChapterSql)) {
		
			$lastChapterRow = mysqli_fetch_array($lastChapterResult);
		
			$lastChapter = $lastChapterRow["chapter"];

			$isLatestChapter = $lastChapter == $chapter;

		}
	
		if($result = mysqli_query($conn, $sql)) {
			
			mysqli_num_rows($result) !== 0 or die(
			
				header("Location: ?id=" . $id . "&c=" . $lastChapter)
				
			);
	 
			$row = mysqli_fetch_array($result);
	
			$body = $row["body"];
	
			$date = $row["story_code"];
	
		}
		
		if($nextChapterResult = mysqli_query($conn, $nextChapterSql)) {
		
		}
		
	}
	
 ?>