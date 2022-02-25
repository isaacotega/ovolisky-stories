<?php
		
	$pageSpecs = array("restricted" => true, "title" => "End story");
	
	include("../../scripts/account_details.php");
	
	include("../../templates/header.php");
	
	$id = $_GET["id"];
	
	$sql = "SELECT * FROM story_stats WHERE story_code = '$id' AND writer_usercode = '$usercode' AND state = 'approved' AND NOT status = 'ended' ";
	
	if($result = mysqli_query($conn, $sql)) {
	
		mysqli_num_rows($result) !== 0 or die(header("Location: ../manage_story?id=" . $id));
		
		$row = mysqli_fetch_array($result);
		
		$name = $row["title"];
	
	}
	
	$chapterSql = "SELECT * FROM chapters WHERE story_code = '$id' ORDER BY chapter DESC LIMIT 1";
					
	if($chapterResult = mysqli_query($conn, $chapterSql)) {
					
		if(mysqli_num_rows($chapterResult) !== 0) {
						
			$row = mysqli_fetch_array($chapterResult);
					
			$chapterNo = $row["chapter"];
							
		}
						
		else {
						
			$chapterNo = "None";
							
		}
					
	}
	
	if(isset($_POST["submit"])) {
		
		require("../../scripts/connection.php");
	
		$sql = "UPDATE story_stats SET status = 'ended' WHERE story_code = '$id' ";
		
		if(mysqli_query($conn, $sql)) {
		
			header("Location: ../manage_story?id=" . $id . "#edit_epilogue");
		
		}
	
	}
				
?>
	
<style>
	
	#main {
		text-align: center;
	}

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
	
	#btnEndStory {
		background-color: red;
	}
	
</style>

 <div id="main">
 
  <form method="post" class="form" id="frmEndStory">
 
 	<br><br>
 
 	<label class="formHeading">End story?</label>
 	
 	<br><br>
 
 	<label class="formLabel">Do you really want to end this story? Please note that this action is irreversible.</label>
 	
 	<br><br>
 	
 	<div id="storyDetails">
	 
	 	<label id="name"><?php echo $name ?></label>
	 
	 	<label id="chapter">Chapters: <?php echo $chapterNo ?></label>
	 
	 </div>
 	
 	<br>
 	
	 <div class="formError">
	 
	 	<label></label>
	 
	 </div>
 	
 	<br><br>
 	
 	<input type="submit" class="submit" name="submit" id="btnEndStory" value="End Story">
 	
 	<br><br>
 	
 	<br><br>
 
 	<label class="formLabel">Don't forget to <a href="../manage_story?id=<?php echo $id; ?>#edit_epilogue">write your epilogue</a> if you haven't!</label>
 	
 	<br><br>
 	
 </form>
 
 </div>
 