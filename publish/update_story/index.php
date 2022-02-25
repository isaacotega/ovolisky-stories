 <?php
 	
  	session_start();
  
 	isset($_GET["id"]) && !empty($_GET["id"]) or die(header("Location: ../"));
 	
 	$id = $_GET["id"];
		
	include("../../scripts/account_details.php");
	
	include("../../scripts/story_requirements.php");
	
	$sql = "SELECT * FROM story_stats WHERE story_code = '$id' AND writer_usercode = '$usercode' AND state = 'approved' ";
	
	if($result = mysqli_query($conn, $sql)) {
	
		mysqli_num_rows($result) !== 0 or die(header("Location: ../"));
		
		$row = mysqli_fetch_array($result);
		
		$name = $row["title"];
	
	}
	
	$chapterSql = "SELECT * FROM chapters WHERE story_code = '$id' ORDER BY chapter DESC LIMIT 1";
					
	if($chapterResult = mysqli_query($conn, $chapterSql)) {
					
		if(mysqli_num_rows($chapterResult) !== 0) {
						
			$row = mysqli_fetch_array($chapterResult);
					
			$nextChapter = $row["chapter"] + 1;
							
		}
						
		else {
						
			$nextChapter = 1;
							
		}
					
	}
				
	$pageSpecs = array("restricted" => true, "title" => "Update story", "footer" => false);
	
	include("../../templates/header.php");
	
	
?>

<style>
	
	#storyDetails #name {
		display: block;
		line-height: 1cm;
		color: #250030;
		font-size: 40px;
		font-weight: 700;
		font-family: cursive;
		margin: 1cm;
	}
	
	#storyDetails #chapter {
		display: block;
		line-height: 1cm;
		color: indigo;
		font-size: 40px;
		font-weight: 700;
		font-family: times;
	}
	
</style>

 <div id="main">
 
  <form method="post" class="form" id="frmDetails">
 
 	<br><br>
 
 	<label class="formHeading">Update your story</label>
 	
 	<br><br>
 	
 	<div id="storyDetails">
	 
	 	<label id="name"><?php echo $name ?></label>
	 
	 	<label id="chapter">Chapter <?php echo $nextChapter ?></label>
	 
	 </div>
 	
 	<br>
 	
	 <div class="formError">
	 
	 	<label></label>
	 
	 </div>
 	
 	<br>
 	
 	<label class="lengthIndicator" for="inpStoryBody" minimum="<?php echo $minStoryBody ?>" maximum="<?php echo $maxStoryBody ?>">0</label>
 
 	<textarea name="storyBody" id="inpStoryBody" placeholder="Enter the body of your story" class="txt"><?php echo isset($_POST["storyBody"]) ? htmlspecialchars($_POST["storyBody"]) : "" ?></textarea>
 
 	<br><br>
 	
 	<input type="submit" class="submit" name="submit" id="btnSubmit" value="Update">
 	
 	<br><br>
 	
 </form>
 
 </div>
 
 <script>
 
 	function alertInForm(text) {
 	
 		$(".formError").css("display", "table");
 	
 		$(".formError label").html(text)
 	
 	}
 	
 </script>
 
 <?php
		
	include("../../templates/footer.php");
	
?>

  <?php
  
	if(isset($_POST["submit"])) {
	
		$storyBody = mysqli_real_escape_string($conn, $_POST["storyBody"]);
	
		if(!empty($storyBody)) {
		
			// validate story length and others
			
			if(strlen($storyBody) < $minStoryBody) {
			
				echo '<script> alertInForm("Please increase your story") </script>';
			
			}
		
			else if(strlen($storyBody) > $maxStoryBody) {
			
				echo '<script> alertInForm("Please shorten your story") </script>';
			
			}
			
			else {
		
				publish();
				
			}
		
		}
	
		else {
	
			echo '<script> alertInForm("Please enter a story") </script>';
				
		}
	
	}
	
	
	function publish() {
		
		global $conn, $usercode, $nextChapter, $id, $storyBody, $root, $name;
	
		if($conn) {
			
			$date = date("Y m d");
			
			$time = date("h:i A");
			
			$storyCode = $id;
			
			$sql = "INSERT INTO chapters ( story_code, chapter, body, date, time, last_update_date, last_update_time ) VALUES ('$storyCode', '$nextChapter', '$storyBody', '$date', '$time', '$date', '$time') ";
			
			if(mysqli_query($conn, $sql)) {
				
				$subscribersSql = "SELECT * FROM update_subscribes WHERE story_code = '$storyCode' ";
				
				if($subscribersResult = mysqli_query($conn, $subscribersSql)) {
					
					while($subscribersRow = mysqli_fetch_array($subscribersResult)) {
						
						$receiverUsercode = $subscribersRow["subscriber_usercode"];
				
						$notifySql = "INSERT INTO notifications (story_code, chapter, receiver_usercode, notification_id, seen, date, time) VALUES ('$storyCode', '$nextChapter', '$receiverUsercode', '1', 'false', '$date', '$time') ";
						
						mysqli_query($conn, $notifySql);
						
					}
					
					$_SESSION["hasUpdatedStory"] = true;
			
					die('<script> window.location.href = ""; </script>');
			 
				}
				
			}
			
		}
	
	}
	
	if(isset($_SESSION["hasUpdatedStory"])) {
	
		$successBarSpecs = array("type" => "success", "message" => '<p>Update successful</p> <p>You have successfully updated your story, ' . $name . '. <a href="../../story?id=' . $id . '&c=' . ($nextChapter - 1) . '">View.</a></p>');
				
		echo '<script> $("#frmDetails").hide(); </script>';
				
		include("../../templates/success_bar.php");
		
		session_destroy();
			 
	}

 ?>
 				