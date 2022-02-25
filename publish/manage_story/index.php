 <?php
 	
 	isset($_GET["id"]) && !empty($_GET["id"]) or die(header("Location: ../"));
 	
 	$id = $_GET["id"];
		
 	isset($_GET["c"]) && !empty($_GET["c"]) or die(header("Location: ?id=" . $id . "&c=1"));
 	
 	$chapter = $_GET["c"];
		
	include("../../scripts/account_details.php");
	
	include("../../scripts/story_requirements.php");
	
	$sql = "SELECT * FROM story_stats WHERE story_code = '$id' AND writer_usercode = '$usercode' AND state = 'approved' ";
	
	if($result = mysqli_query($conn, $sql)) {
	
		mysqli_num_rows($result) !== 0 or die(header("Location: ../"));
		
		$row = mysqli_fetch_array($result);
		
		$name = $row["title"];
	
		$storyDescription = $row["about"];
	
		$storyPrologue = $row["prologue"];
	
		$storyEpilogue = $row["epilogue"];
		
		$status = $row["status"];
	
	}
	
	$chapterSql = "SELECT * FROM chapters WHERE story_code = '$id' AND chapter = '$chapter' ";
					
	if($chapterResult = mysqli_query($conn, $chapterSql)) {
					
		if(mysqli_num_rows($chapterResult) !== 0) {
						
			$row = mysqli_fetch_array($chapterResult);
					
			$storyBody = $row["body"];
	
		}
						
		else {
						
			$chapter = "none";
							
			$storyBody = "No chapter published yet!";
	
		}
					
	}
				
	$latestChapterSql = "SELECT * FROM chapters WHERE story_code = '$id' ORDER BY chapter DESC ";
					
	if($latestChapterResult = mysqli_query($conn, $latestChapterSql)) {
					
		if(mysqli_num_rows($latestChapterResult) !== 0) {
						
			$row = mysqli_fetch_array($latestChapterResult);
					
			$latestChapter = $row["chapter"];
	
		}
						
		else {
						
			$latestChapter = "none";
							
		}
					
	}
				
	$pageSpecs = array("restricted" => true, "title" => "Edit story", "footer" => false);
	
	include("../../templates/header.php");
	
	$originalSrc = "../../images/stories/". str_replace(" ", "_", strtolower($name)) . "_" .  $id . ".jpg";
				
	$src = file_exists($originalSrc) ? $originalSrc : $root . "images/templates/story_cover.jpg";
	
	
		
	// update script 
	
	
  	function alertInForm($message) {
  	
  		echo '
  		
  			<script>
  			
  				$(document).ready(function() {
  				
  					alertInForm("' . addslashes($message) . '");
  				
  				});
  				
  			</script>
  			
  		';
  	
  	}
  
	if(isset($_POST["updateCoverPicture"])) {
	
		$image = $_FILES["coverPicture"]["tmp_name"];
		
		if(file_exists($image)) {
		
			if(move_uploaded_file($image, "../../images/stories/" . str_replace(" ", "_", strtolower($name)) . "_" .  $id . ".jpg")) {
			
				alertInForm("Your story\'s cover image has been uploaded successfully");
			
			}
		
			else {
			
				alertInForm("Error uploading image. Please try again");
			
			}
			
		}
	
		else {
			
			alertInForm("Please choose an image");
			
		}
			
	}
	
	if(isset($_POST["storyBody"])) {
	
		$newStoryBody = mysqli_real_escape_string($conn, $_POST["storyBody"]);
	
		if(!empty($newStoryBody)) {
		
			if(strlen($newStoryBody) < $minStoryBody) {
			
				alertInForm("Please increase your story");
			
			}
		
			else if(strlen($newStoryBody) > $maxStoryBody) {
			
				alertInForm("Please shorten your story");
			
			}
			
			else {
		
				update("storyBody", $newStoryBody);
				
			}
		
		}
	
		else {
	
			alertInForm("Please enter a story");
				
		}
	
	}
	
	if(isset($_POST["storyDescription"])) {
	
		$storyDescription = mysqli_real_escape_string($conn, $_POST["storyDescription"]);
	
		if(!empty($storyDescription)) {
		
			if(strlen($storyDescription) < $minStoryDescription) {
			
				alertInForm("Please increase your story description");
			
			}
		
			else if(strlen($storyDescription) > $maxStoryDescription) {
			
				alertInForm("Please shorten your story description");
			
			}
			
			else {
		
				update("storyDescription", $storyDescription);
				
			}
		
		}
	
		else {
	
			alertInForm("Please enter a description for your story");
				
		}
	
	}
	
	if(isset($_POST["storyPrologue"])) {
	
		$storyPrologue = mysqli_real_escape_string($conn, $_POST["storyPrologue"]);
	
		if(!empty($storyPrologue)) {
		
			if(strlen($storyPrologue) < $minStoryPrologue) {
			
				alertInForm("Please increase your story prologue");
			
			}
		
			else if(strlen($storyPrologue) > $maxStoryPrologue) {
			
				alertInForm("Please shorten your story prologue");
			
			}
			
			else {
		
				update("storyPrologue", $storyPrologue);
				
			}
		
		}
	
		else {
	
			alertInForm("Please enter a prologue for your story");
				
		}
	
	} 
	
	if(isset($_POST["storyEpilogue"])) {
	
		$storyEpilogue = mysqli_real_escape_string($conn, $_POST["storyEpilogue"]);
	
		if(!empty($storyEpilogue)) {
		
			if(strlen($storyEpilogue) < $minStoryEpilogue) {
			
				alertInForm("Please increase your story epilogue");
			
			}
		
			else if(strlen($storyEpilogue) > $maxStoryEpilogue) {
			
				alertInForm("Please shorten your story epilogue");
			
			}
			
			else {
		
				update("storyEpilogue", $storyEpilogue);
				
			}
		
		}
	
		else {
	
			alertInForm("Please enter an epilogue for your story");
				
		}
	
	}
	
	
	function update($par1, $par2) {
		
		global $conn, $usercode, $id, $chapter;
	
		if($conn) {
			
			$date = date("Y m d");
			
			$time = date("h:i A");
			
			$storyCode = $id;
			
			if($par1 == "storyBody") {
				
				$newStoryBody = $par2;
			
				$sql = "UPDATE chapters SET body = '$newStoryBody', last_update_date = '$date', last_update_time = '$time' WHERE chapter = '$chapter' AND story_code = '$id' ";
				
				if(mysqli_query($conn, $sql)) {
			
					alertInForm("Chapter " . $chapter . " edited successfully");
			
				}
				
				else {
				
					alertInForm(mysqli_error($conn));
				
				}
				
			}
			
			else if($par1 == "storyDescription") {
				
				$storyDescription = $par2;
			
				$sql = "UPDATE story_stats SET about = '$storyDescription' WHERE story_code = '$id' ";
				
				if(mysqli_query($conn, $sql)) {
			
					alertInForm("Story description edited successfully");
			
				}
				
			}
			
			else if($par1 == "storyPrologue") {
				
				$storyPrologue = $par2;
			
				$sql = "UPDATE story_stats SET prologue = '$storyPrologue' WHERE story_code = '$id' ";
				
				if(mysqli_query($conn, $sql)) {
			
					alertInForm("Story prologue edited successfully");
			
				}
				
			}
			
			else if($par1 == "storyEpilogue") {
				
				$storyEpilogue = $par2;
			
				$sql = "UPDATE story_stats SET epilogue = '$storyEpilogue' WHERE story_code = '$id' ";
				
				if(mysqli_query($conn, $sql)) {
			
					alertInForm("Story epilogue edited successfully");
			
				}
				
			}
			
			else {}
				
		}
	
	}
	
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
	
	#frmEditStoryContent #chapter {
		display: block;
		line-height: 3cm;
		color: indigo;
		font-size: 40px;
		font-weight: 700;
		font-family: times;
	}
	
	#frmEditStoryStatus #lblStatus {
		display: block;
		line-height: 3cm;
		color: indigo;
		font-size: 40px;
		font-weight: 700;
		font-family: times;
	}
	
	#frmEditStoryStatus #btnEndStory {
		background-color: red;
	}
	
	#imageHolder {
		width: 80%;
		display: inline-block;
		position: relative;
	}
	
	#imageHolder img {
		width: 100%;
		opacity: 0.8;
		box-shadow: 0 0 10px 0 black;
	}
	
	#imageHolder #inpUploadCoverPicture + label {
		position: absolute;
		display: block;
		top: 50%;
		left: 50%;
		transform: translateX(-50%) translateY(-50%);
		line-height: 2cm;
		background-color: indigo;
		border-radius: 5%;
		cursor: pointer;
		
	}
	
	#filename {
		color: white;
		font-size: 25px;
		font-weight: 700;
		margin: 0 3mm;
	}
	
	#imageHolder #inpUploadCoverPicture + label:active {
		background-color: #250030;
	}
	
	#chapterSelection a {
		font-size: 40px;
		margin: 0 2px;
	}
	
</style>

 <div id="main">
 
	<div class="form" id="container">
 
 		<br><br>
 
	 	<label class="formHeading">Edit your story</label>
 	
 		<br><br>
 	
 		<div id="storyDetails">
	 
	 		<label id="name"><?php echo $name ?></label>
	 
		</div>
 	
 		<br>
 	
		 <div class="formError">
	 
	 		<label></label>
	 
	 	</div>

		<hr>

 		<br><br>
 	
	 	<label class="formLabel">Edit story's cover image</label>
	 		
	 	<form method="post" id="frmEditCoverPicture" enctype="multipart/form-data">
 	 	
 			<br><br>
 	
 	 		<div id="imageHolder">
 	 		
 	 			<img src="<?php echo $src; ?>"></img>
 	 			
 	 			<input type="file" id="inpUploadCoverPicture" name="coverPicture" class="hidden">
 	 			
 	 			<label for="inpUploadCoverPicture"><span id="filename">Choose image<span></label>
 	 		
 	 		</div>
 	 	
 			<br><br>
 	
 			<input type="submit" class="submit" name="updateCoverPicture" id="btnSubmit" value="Upload">
 	
 			<br><br>
 	
 	 	</form>
 	 	
		<hr>

 		<br><br>
 	
	 	<label class="formLabel">Edit story description</label>
	 		
	 	<form method="post" id="frmEditStoryDescription">
 	 
			 <br><br>
			 
 			<textarea name="storyDescription" id="inpStoryDescription" placeholder="Enter a description for your story" class="txt"><?php echo $storyDescription ?></textarea>
 
 			<br><br>
 	
 			<input type="submit" class="submit" id="btnSubmit" value="Update">
 	
 			<br><br>
 	
 		</form>
 
		<hr>

 		<br><br>
 	
	 	<label class="formLabel">Edit story Prologue</label>
	 		
	 	<form method="post" id="frmEditStoryPrologue">
 	 
			 <br><br>
			 
 			<textarea name="storyPrologue" id="inpStoryPrologue" placeholder="Enter a prologue for your story" class="txt"><?php echo $storyPrologue ?></textarea>
 
 			<br><br>
 	
 			<input type="submit" class="submit" id="btnSubmit" value="Update">
 	
 			<br><br>
 	
 		</form>
 
		<hr>

 		<br><br>
 	
	 	<label class="formLabel" id="edit_epilogue">Edit story epilogue</label>
	 		
	 	<form method="post" id="frmEditStoryEpilogue">
 	 
			 <br><br>
			 
 			<textarea name="storyEpilogue" id="inpStoryEpilogue" placeholder="Enter an epilogue for your story" class="txt"><?php echo $storyEpilogue ?></textarea>
 
 			<br><br>
 	
 			<input type="submit" class="submit" id="btnSubmit" value="Update">
 	
 			<br><br>
 	
 		</form>
 
		<hr>

 		<br><br>
 	
	 	<label class="formLabel">Edit story body</label>
	 		
	 	<form method="post" id="frmEditStoryContent">
 	 
	 		<label id="chapter">Chapter <?php echo $chapter ?></label>
	 		
	 		<div id="chapterSelection">
	 		
			 <?php
			 
			 	for($i = 0; $i < $latestChapter; $i++) {
			 		
			 		echo ($i + 1) == $chapter ? "<u>" : "";
			 	
			 		echo '<a href="?id=' . $id . '&c=' . ($i + 1) . '">[' . ($i + 1) . ']</a>';
			 	
			 		echo ($i + 1) == $chapter ? "</u>" : "";
			 	
			 	}
			 
			 ?>
			 
			 </div>
			 
			 <br><br>
			 
 			<textarea name="storyBody" id="inpStoryBody" placeholder="Enter the body of your story" class="txt"><?php echo $storyBody ?></textarea>
 
 			<br><br>
 	
 			<input type="submit" class="submit" id="btnSubmit" value="Update">
 	
 			<br><br>
 	
 		</form>
 
		<hr>

 		<br><br>
 	
	 	<label class="formLabel">Status</label>
	 		
	 	<form id="frmEditStoryStatus">
	 		
	 		<label id="lblStatus"><?php echo $status ?></label>
	 		
	 		<?php
	 		
	 			if($status == "ongoing") {
	 		
	 				echo '<a href="../end_story?id=' . $id . '">
	 		
	 					<input type="button" class="submit" id="btnEndStory" value="End Story">
	 			
	 				</a>';
	 				
	 			}
	 				
	 		?>
 	
 			<br><br>
	 	
	 	</form>
 	 
		<hr>

	</div>
 
 </div>
 
 <script>
 
 	function alertInForm(text) {
 	
 		$(".formError").css("display", "table");
 	
 		$(".formError label").html(text)
 	
 	}
 	
 	$("#inpUploadCoverPicture").change(function(e) {
 	
 		var fileName = e.target.value.split("\\").pop();
 		
 		if(fileName) {
 			
 			$("#filename").html(fileName);
 		
 		}
 		 
 		else {
 		
 			$("#filename").html("Choose image");
 		
 		}
 	
	});
 	
 </script>
 
 <?php
		
	include("../../templates/footer.php");
	
?>