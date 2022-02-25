<?php
	
	isset($_POST["request"]) or die();
	
//	$_POST["usercode"] !== "none" or die(json_encode(array("status" => "error", "cause" => "notLoggedIn")));
	
	include("connection.php");
	
	$request = $_POST["request"];
	
	
	if($request == "loadUpvotes") {
		
		$storyCode = $_POST["storyCode"];
		
		$chapter = $_POST["chapter"];
		
		$usercode = $_POST["usercode"];
		
		$sql = "SELECT * FROM upvotes WHERE story_code = '$storyCode' AND chapter = '$chapter' ";
		
		if($result = mysqli_query($conn, $sql)) {
		
			$upvotes = mysqli_num_rows($result);
			
			$sql = "SELECT * FROM upvotes WHERE story_code = '$storyCode' AND chapter = '$chapter' AND upvoter_usercode = '$usercode' ";
			
			if($result = mysqli_query($conn, $sql)) {
				
				$hasUpvoted = (mysqli_num_rows($result) == 0) ? "false" : "true";
					
				$data = array("status" => "success", "upvotes" => $upvotes, "hasUpvoted" => $hasUpvoted);
			
				exit(json_encode($data));
				
			}
				
		}
		
	}
	
	if($request == "checkSubscribe") {
		
		$storyCode = $_POST["storyCode"];
		
		$usercode = $_POST["usercode"];
		
		$sql = "SELECT * FROM update_subscribes WHERE story_code = '$storyCode' AND subscriber_usercode = '$usercode' ";
		
		if($result = mysqli_query($conn, $sql)) {
		
			$isSubscribed = (mysqli_num_rows($result) == 0) ? "false" : "true";
					
			$data = array("status" => "success", "isSubscribed" => $isSubscribed);
			
			exit(json_encode($data));
			
		}
		
	}
	
	if($request == "checkIfFavourite") {
		
		$storyCode = $_POST["storyCode"];
		
		$chapter = $_POST["chapter"];
		
		$usercode = $_POST["usercode"];
		
		$sql = "SELECT * FROM favourites WHERE story_code = '$storyCode' AND saver_usercode = '$usercode' ";
			
		if($result = mysqli_query($conn, $sql)) {
				
			$isFavourite = (mysqli_num_rows($result) == 0) ? "false" : "true";
			
			$data = array("status" => "success", "isFavourite" => $isFavourite);
			
			exit(json_encode($data));
			
		}
		
	}
	
	if($request == "checkIfBookmarked") {
		
		$storyCode = $_POST["storyCode"];
		
		$chapter = $_POST["chapter"];
		
		$usercode = $_POST["usercode"];
		
		$sql = "SELECT * FROM bookmarks WHERE story_code = '$storyCode' AND chapter = '$chapter' AND saver_usercode = '$usercode' ";
			
		if($result = mysqli_query($conn, $sql)) {
				
			$isBookmarked = (mysqli_num_rows($result) == 0) ? "false" : "true";
			
			$data = array("status" => "success", "isBookmarked" => $isBookmarked);
			
			exit(json_encode($data));
			
		}
		
	}
	
	if($request == "loadComment") {
		
		$storyCode = $_POST["storyCode"];
		
		$chapter = $_POST["chapter"];
		
		$sql = "SELECT * FROM comments WHERE story_code = '$storyCode' AND chapter = '$chapter' ORDER BY date, time";
		
		if($result = mysqli_query($conn, $sql)) {
			
			$eachComment = array();
			
			$commenterUsercode = array();
			
			$commenterName = array();
			
			$profilePicture = array();
			
			$commentId = array();
			
			while($row = mysqli_fetch_array($result)) {
		
				$eachComment[] = $row;
				
				$usercode = $row["commenter_usercode"];
			
				$commenterUsercode[] = $row["commenter_usercode"];
			
				$commentId[] = $row["comment_id"];
				
				$originalProfilePicture = "../images/profile_pictures/" . $row["commenter_usercode"] . ".jpg";
				
				$commenterNameSql = "SELECT * FROM accounts WHERE usercode = '$usercode' ";
				
				if($commenterNameResult = mysqli_query($conn, $commenterNameSql)) {
				
					$commenterNameRow = mysqli_fetch_array($commenterNameResult);
					
					$commenterName[] = $commenterNameRow["first_name"] . " " . $commenterNameRow["last_name"];
			
					$commenterGender = $commenterNameRow["gender"];
			
					$profilePicture[] = file_exists($originalProfilePicture) ? $originalProfilePicture : "../images/templates/avatars/" . $commenterGender . ".jpg";
			
				}
				
			}
		
			$data = array("status" => "success", "eachComment" => $eachComment, "commenterName" => $commenterName, "commenterUsercode" => $commenterUsercode, "commentId" => $commentId, "profilePicture" => $profilePicture);
			
			echo json_encode($data);
		
		}
		
		else {
		
			$data = array("status" => "error");
			
			echo json_encode($data);
		
		}
	
	}
	
	if($request == "loadReplies") {
		
		$storyCode = $_POST["storyCode"];
		
		$chapter = $_POST["chapter"];
		
		$sql = "SELECT * FROM replies WHERE story_code = '$storyCode' AND chapter = '$chapter' ORDER BY date, time";
		
		if($result = mysqli_query($conn, $sql)) {
			
			$eachReply = array();
			
			$replierUsercode = array();
			
			$replierName = array();
			
			$commentId = array();
			
			$profilePicture = array();
			
			while($row = mysqli_fetch_array($result)) {
		
				$eachReply[] = $row;
				
				$usercode = $row["replier_usercode"];
			
				$replierUsercode[] = $row["replier_usercode"];
			
				$commentId[] = $row["comment_id"];
			
				$originalProfilePicture = "../images/profile_pictures/" . $row["replier_usercode"] . ".jpg";
				
				$replierNameSql = "SELECT * FROM accounts WHERE usercode = '$usercode' ";
				
				if($replierNameResult = mysqli_query($conn, $replierNameSql)) {
				
					$replierNameRow = mysqli_fetch_array($replierNameResult);
					
					$replierName[] = $replierNameRow["first_name"] . " " . $replierNameRow["last_name"];
			
					$replierGender = $replierNameRow["gender"];
			
					$profilePicture[] = file_exists($originalProfilePicture) ? $originalProfilePicture : "../images/templates/avatars/" . $replierGender . ".jpg";
			
				}
				
			}
		
			$data = array("status" => "success", "eachReply" => $eachReply, "replierName" => $replierName, "replierUsercode" => $replierUsercode, "commentId" => $commentId, "profilePicture" => $profilePicture, "$sql" => "");
			
			echo json_encode($data);
		
		}
		
		else {
		
			$data = array("status" => "error");
			
			echo json_encode($data);
		
		}
	
	}
	
	if($request == "postComment") {
		
		$storyCode = $_POST["storyCode"];
		
		$chapter = $_POST["chapter"];
		
		$digitsNo = 10;
		
		$commentId = "";
	
		for($x = 0; $x < $digitsNo; $x++) {
	
			$commentId .= rand(0, 9);
		
		}
	
		$commenterUsercode = $_POST["usercode"];
		
		$comment = mysqli_real_escape_string($conn, $_POST["comment"]);
		
		$date = date("Y m d");
		
		$time = date("h:i A");
		
		$sql = "INSERT INTO comments (story_code, chapter, comment_id, commenter_usercode, comment, date, time) VALUES ('$storyCode', '$chapter', '$commentId', '$commenterUsercode', '$comment', '$date', '$time')";
		
		if(mysqli_query($conn, $sql)) {
		
			$data = array("status" => "success");
			
			echo json_encode($data);
		
		}
		
		else {
		
			$data = array("status" => "error");
			
			echo json_encode($data);
		
		}
	
	}
	
	if($request == "postReply") {
		
		$storyCode = $_POST["storyCode"];
		
		$chapter = $_POST["chapter"];
		
		$commentId = $_POST["commentId"];
		
		$replierUsercode = $_POST["usercode"];
		
		$reply = mysqli_real_escape_string($conn, $_POST["reply"]);
		
		$date = date("Y m d");
		
		$time = date("h:i A");
		
		$sql = "INSERT INTO replies (story_code, chapter, comment_id, replier_usercode, reply, date, time) VALUES ('$storyCode', '$chapter', '$commentId', '$replierUsercode', '$reply', '$date', '$time')";
		
		if(mysqli_query($conn, $sql)) {
		
			$data = array("status" => "success");
			
			echo json_encode($data);
		
		}
		
		else {
		
			$data = array("status" => "error");
			
			echo json_encode($data);
		
		}
	
	}
	
	if($request == "upvote") {
	
		$storyCode = $_POST["storyCode"];
		
		$usercode = $_POST["usercode"];
		
		$chapter = $_POST["chapter"];
		
		$date = date("Y m d");
		
		$time = date("H:i A");
		
		$sql = "SELECT * FROM upvotes WHERE story_code = '$storyCode' AND chapter = '$chapter' AND upvoter_usercode = '$usercode' ";
		
		if($result = mysqli_query($conn, $sql)) {
		
			if(mysqli_num_rows($result) == 0) {
			
				$sql = "INSERT INTO upvotes (story_code, chapter, upvoter_usercode, date, time) VALUES ('$storyCode', '$chapter', '$usercode', '$date', '$time') ";
			
			}
			
			else {
			
				$sql = "DELETE FROM upvotes WHERE upvoter_usercode = '$usercode' AND story_code = '$storyCode' AND chapter = '$chapter' ";
			
			}
			
			if(mysqli_query($conn, $sql)) {
			
				$data = array("status" => "success");
			
				echo json_encode($data);
			
			}
			
			else {
			
				$data = array("status" => "error");
			
				echo json_encode($data);
				
			}
		
		}
	
	}
	
	if($request == "favourite") {
	
		$storyCode = $_POST["storyCode"];
		
		$usercode = $_POST["usercode"];
		
		$chapter = $_POST["chapter"];
		
		$date = date("Y m d");
		
		$time = date("H:i A");
		
		$sql = "SELECT * FROM favourites WHERE story_code = '$storyCode' AND saver_usercode = '$usercode' ";
		
		if($result = mysqli_query($conn, $sql)) {
		
			if(mysqli_num_rows($result) == 0) {
			
				$sql = "INSERT INTO favourites (story_code, chapter, saver_usercode, date, time) VALUES ('$storyCode', '$chapter', '$usercode', '$date', '$time') ";
			
			}
			
			else {
			
				$sql = "DELETE FROM favourites WHERE saver_usercode = '$usercode' AND story_code = '$storyCode' ";
			
			}
			
			if(mysqli_query($conn, $sql)) {
			
				$data = array("status" => "success");
			
				echo json_encode($data);
			
			}
			
			else {
			
				$data = array("status" => "error");
			
				echo json_encode($data);
				
			}
		
		}
	
	}
	
	if($request == "bookmark") {
	
		$storyCode = $_POST["storyCode"];
		
		$usercode = $_POST["usercode"];
		
		$chapter = $_POST["chapter"];
		
		$date = date("Y m d");
		
		$time = date("H:i A");
		
		$sql = "SELECT * FROM bookmarks WHERE story_code = '$storyCode' AND chapter = '$chapter' AND saver_usercode = '$usercode' ";
		
		if($result = mysqli_query($conn, $sql)) {
		
			if(mysqli_num_rows($result) == 0) {
			
				$sql = "INSERT INTO bookmarks (story_code, chapter, saver_usercode, date, time) VALUES ('$storyCode', '$chapter', '$usercode', '$date', '$time') ";
			
			}
			
			else {
			
				$sql = "DELETE FROM bookmarks WHERE saver_usercode = '$usercode' AND story_code = '$storyCode' AND chapter = '$chapter' ";
			
			}
			
			if(mysqli_query($conn, $sql)) {
			
				$data = array("status" => "success");
			
				echo json_encode($data);
			
			}
			
			else {
			
				$data = array("status" => "error");
			
				echo json_encode($data);
				
			}
		
		}
	
	}
	
	if($request == "subscribeForUpdate") {
	
		$storyCode = $_POST["storyCode"];
		
		$usercode = $_POST["usercode"];
		
		$chapter = $_POST["chapter"];
		
		$date = date("Y m d");
		
		$time = date("H:i A");
		
		$sql = "SELECT * FROM update_subscribes WHERE story_code = '$storyCode' AND chapter = '$chapter' AND subscriber_usercode = '$usercode' ";
		
		if($result = mysqli_query($conn, $sql)) {
		
			if(mysqli_num_rows($result) == 0) {
			
				$sql = "INSERT INTO update_subscribes (story_code, chapter, subscriber_usercode, date, time) VALUES ('$storyCode', '$chapter', '$usercode', '$date', '$time') ";
			
			}
			
			else {
			
				$sql = "DELETE FROM update_subscribes WHERE subscriber_usercode = '$usercode' AND story_code = '$storyCode' ";
			
			}
			
			if(mysqli_query($conn, $sql)) {
			
				$data = array("status" => "success");
			
				echo json_encode($data);
			
			}
			
			else {
			
				$data = array("status" => "error");
			
				echo json_encode($data);
				
			}
		
		}
	
	}
	
 ?>