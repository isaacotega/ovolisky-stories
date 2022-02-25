 <?php
		
  	session_start();
  
	include("../../scripts/account_details.php");
	
	include("../../scripts/story_requirements.php");
	
	$sql = "SELECT * FROM genres ";
	
	$genres = mysqli_query($conn, $sql);
	
	$pageSpecs = array("restricted" => true, "title" => "Publish a new story", "footer" => false);
	
	include("../../templates/header.php");
	
?>

<style>

	#tagsHolder {
		overflow-x: auto;
		width: 90%;
		display: inline-block;
	}
	
	#tagsHolder .tag {
		height: 1.5cm;
		line-height: 1.5cm;
		min-width: 3cm;
		text-align: center;
		margin: 2mm;
		display: inline-block;
		background-color: #8D7B98;
	}
	
	.tag #tagName {
		font-size: 25px;
		font-weight: 700;
		color: white;
	}
	
	.tag #lblDeleteTag {
		font-size: 40px;
		font-weight: 300;
		color: red;
		float: right;
		margin: 0 2mm;
	}
	
	#inpTag {
		width: 60%;
		height: 2cm;
		border-radius: 5%;
		font-size: 30px;
		margin: none;
	}
	
	#btnTag {
		width: 20%;
		height: 2cm;
		border-radius: 5%;
		font-size: 30px;
		margin: none;
		background-color: #8D7B98;
		color: white;
	}
	
</style>

 <div id="main">
 
  <form method="post" class="form" id="frmDetails">
 
 	<br><br>
 
 	<label class="formHeading">Publish a new story on <?php echo $domain ?></label>
 	
 	<br>
 	
	 <div class="formError">
	 
	 	<label></label>
	 
	 </div>
 	
 	<br>
 
 	<input name="storyName" placeholder="Enter your Story's Name" class="input" value='<?php echo isset($_POST["storyName"]) ? htmlspecialchars($_POST["storyName"]) : "" ?>'>
 
 	<br>
 
 	<input name="nick" placeholder="Enter a Nick Title for your story" class="input" value='<?php echo isset($_POST["nick"]) ? htmlspecialchars($_POST["nick"]) : "" ?>'>
 
 	<br>
 
 	<select name="storyGenre" placeholder="Enter your Story's Name" class="slt">
 		
 		<option hidden>Select a genre</option>
 		
 		<?php
 			
 			while($row = mysqli_fetch_array($genres)) {
 				
 				$selectedOrNot = isset($_POST["storyGenre"]) ? (htmlspecialchars($_POST["storyGenre"]) == $row["genre"] ? "selected" : "") : "";
 			
 				echo '<option ' . $selectedOrNot . '>' . $row["genre"] . '</option>';
 			
 			}
 		
 		?>
 	
 	</select>
 
 	<br>
 
 	<label class="lengthIndicator" for="inpStoryDescription" minimum="<?php echo $minStoryDescription ?>" maximum="<?php echo $maxStoryDescription ?>">0</label>
 
 	<textarea name="storyDescription" placeholder="Enter a brief description of your story" class="txt" id="inpStoryDescription"><?php echo isset($_POST["storyDescription"]) ? htmlspecialchars($_POST["storyDescription"]) : "" ?></textarea>
 
 	<br>
 
 	<label class="lengthIndicator" for="inpStoryPrologue" minimum="<?php echo $minStoryPrologue ?>" maximum="<?php echo $maxStoryPrologue ?>">0</label>
 
 	<textarea name="prologue" placeholder="Enter your Story's Prologue" class="txt" id="inpStoryPrologue"><?php echo isset($_POST["prologue"]) ? htmlspecialchars($_POST["prologue"]) : "" ?></textarea>
 
 	<br><br>
 	
 	<input class="hidden" name="tags">
 	
 	<div id="tagsHolder"></div>
 	
 	<br><br>
	
	<div id="divTag">
 	
 		<input id="inpTag" placeholder="Add tags">
 	
 		<button type="button" id="btnTag">Add</button>
 	
 	<br><br>
 	
 	<input type="submit" class="submit" name="submit" value="Submit">
 	
 	<br><br><br>
 	
 </form>
 
 </div>
 
 <script>
 	
 	function alertInForm(text) {
 	
 		$(".formError").css("display", "table");
 	
 		$(".formError label").html(text)
 	
 	}
 	
 	function compileTags() {
 		
 		var tagsArray = [];
 		
 		for(var i = 0; i < $("#tagsHolder").children(".tag").length; i++) {
 			
 			tagsArray.push($("#tagsHolder").children(".tag").eq(i).children("#tagName").html());
 		
 		}
 	
 		$("[name=tags]").val(tagsArray.join("+"));
 		
 	}
 	
 	$("#btnTag").click(function() {
 		
 		if($("#inpTag").val() !== "") {
 			
 			if($("#tagsHolder").children(".tag").length < 21) {
 		
 				var tagName = $("#inpTag").val();
 				
 				var removeEvent = '$(this).parent(".tag").remove(); compileTags()';
 		
 				var tag = '<label class="tag" id="lblTags"> <label id="tagName">' + tagName + '</label> <label id="lblDeleteTag" onclick=\'' + removeEvent + '\'>x</label></label>';
 	
 				$("#tagsHolder").append(tag);
 			
 				$("#inpTag").val("");
 				
 				compileTags();
 				
 			}
 			
 			else {
 			
 				alertInForm("You can have a maximum of twenty tags");
 			
 			}
 			
 		}
 	
 	});
 	
 </script>
 
 <?php
		
	include("../../templates/footer.php");
	
?>

  <?php
  	
	if(isset($_POST["submit"])) {
	
		$title = mysqli_real_escape_string($conn, $_POST["storyName"]);
			
		$nick = mysqli_real_escape_string($conn, $_POST["nick"]);
			
		$genre = mysqli_real_escape_string($conn, $_POST["storyGenre"]);
			
		$storyDescription = mysqli_real_escape_string($conn, $_POST["storyDescription"]);
			
		$prologue = mysqli_real_escape_string($conn, $_POST["prologue"]);
			
		$tags = mysqli_real_escape_string($conn, $_POST["tags"]);
			
		if(!empty($title) && !empty($nick) && $genre !== "Select a genre" && !empty($storyDescription) && !empty($prologue)) {
		
		// validate prologue length and others
		
			if(strlen($storyDescription) < $minStoryDescription) {
			
				echo '<script> alertInForm("Please increase your story description") </script>';
			
			}
			
			else if(strlen($storyDescription) > $maxStoryDescription) {
			
				echo '<script> alertInForm("Please shorten your story description") </script>';
			
			}
			
			else if(strlen($prologue) < $minStoryPrologue) {
			
				echo '<script> alertInForm("Please increase your story prologue") </script>';
			
			}
			
			else if(strlen($prologue) > $maxStoryPrologue) {
			
				echo '<script> alertInForm("Please shorten your story prologue") </script>';
			
			}
			
			else {
		
				publish();
				
			}
		
		}
	
		else {
	
			echo '<script> alertInForm("Please fill in the details") </script>';
				
		}
	
	}
	
	
	function publish() {
		
		global $conn, $usercode, $title, $nick, $genre, $storyDescription, $prologue, $tags, $root;
			
		if($conn) {
			
			$date = date("Y m d");
			
			$time = date("h:i A");
			
			$digitsNo = 10;
	
			$storyCode = "";
	
			for($x = 0; $x < $digitsNo; $x++) {
	
				$storyCode .= rand(0, 9);
		
			}
	
			$sql = "INSERT INTO story_stats (writer_usercode, story_code, title, nick, about, prologue, genre, tags, views, upvotes, status, state, request_date, request_time ) VALUES ('$usercode', '$storyCode', '$title', '$nick', '$storyDescription', '$prologue', '$genre', '$tags', '0', '0', 'ongoing', 'approved', '$date', '$time') ";
			
			if(mysqli_query($conn, $sql)) {
				
				$_SESSION["hasPostedNewStory"] = true;
				
				$_SESSION["title"] = $title;
				
				die('<script> window.location.href = ""; </script>');
			
			}
			
		}
	
	}

	if(isset($_SESSION["hasPostedNewStory"])) {
	
		$successBarSpecs = array("type" => "success", "message" => '<p>Publish successful</p> <p>You have successfully published your new story, ' . $_SESSION["title"] . '. Your story is currently pending approval by the admins. You can check its status <a href="../../dashboard?type=writer#pending_stories">here.</a></p>');
				
		echo '<script> $("#frmDetails").hide(); </script>';
				
		include("../../templates/success_bar.php");
			 
		session_destroy();
			 
	}

 ?>
 