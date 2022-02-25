<?php
	
	isset($_GET["id"]) or die(header("Location: ../"));
	
	$profiler = array();
	
	$profiler["usercode"] = $_GET["id"];
	
	include("../scripts/connection.php");
	
	$sql = "SELECT * FROM accounts WHERE usercode = '" . $profiler["usercode"] . "' ";
	
	if($result = mysqli_query($conn, $sql)) {
	
		mysqli_num_rows($result) !== 0 or die(header("Location: ../"));
		
		$row = mysqli_fetch_array($result);
		
		$profiler["firstName"] = $row["first_name"];
		
		$profiler["lastName"] = $row["last_name"];
		
		$profiler["fullName"] = $profiler["firstName"] . " " . $profiler["lastName"];
		
		$profiler["gender"] = $row["gender"];
		
		$profiler["bio"] = $row["bio"];
		
		$sql = "SELECT * FROM story_stats WHERE writer_usercode = '" . $profiler["usercode"] . "' AND state = 'approved' ";
	
		if($result = mysqli_query($conn, $sql)) {
	
			$profiler["isWriter"] = (mysqli_num_rows($result) !== 0) ? true : false;
	
		}
		
		$sql = "SELECT * FROM followers WHERE follower_usercode = '" . $profiler["usercode"] . "' ";
			
		if($result = mysqli_query($conn, $sql)) {
				
			$profiler["followingNo"] = mysqli_num_rows($result);
			
		}
			
		$profiler["originalProfilePicture"] = "../images/profile_pictures/" . $profiler["usercode"] . ".jpg";
		
		$profiler["profilePicture"] = file_exists($profiler["originalProfilePicture"]) ? $profiler["originalProfilePicture"] : "../images/templates/avatars/" . $profiler["gender"] . ".jpg";
	
	}
	
	
	$pageSpecs = array("title" => $profiler["fullName"]);
	
	include("../templates/header.php");
	
?>

<link rel="stylesheet" href="../styles/profile.css">

<div id="main">
	
	<div id="profilePictureHolder">
	
		<img src="<?php echo $profiler["profilePicture"]; ?>" id="profilePicture"></img>
	
	</div>
	
	<div id="detailsHolder">
		
		<h2 id="username"><?php echo $profiler["fullName"]; ?></h2>
		
		<div id="bioHolder">
	
			<p><?php echo str_replace("\n", "</p><p>", $profiler["bio"]); ?></p><hr>
			
		</div>
		
		<?php $isLoggedIn ? include("../templates/profile_actions.php") : ""; ?>
	
	
		<table id="tblDetails">
		
			<tr>
				
				<td>Type</td>
				
				<td><?php echo (($profiler["isWriter"]) ? "Writer" : "Reader"); ?></td>
			
			</tr>
		
			<tr>
				
				<td>Followers</td>
				
				<td id="tdFollowers"></td>
			
			</tr>
		
			<tr>
				
				<td>Following</td>
				
				<td id="tdFollowing"><?php echo $profiler["followingNo"]; ?></td>
			
			</tr>
		
		</table>
	
	</div>
	
	<br><br><hr><br><br>
	
	<?php
		
		if($profiler["isWriter"]) {
	
			echo '<h2 class="headStmt" id="stories">Stories by this author</h2> <br><br>';
			
			$boxSpecs = array("type" => "author", "usercode" => $profiler["usercode"], "limit" => 1000000);
		
			include("../scripts/box_lister.php");
		
			echo '  ';
			
		}
		
	?>
	
	
	
</div>

<script>
	
	checkIfFollowing();

	function checkIfFollowing() {
			
		$.ajax({
			type: "POST",
			url: "../scripts/profile.php",
			dataType: "JSON",
			data: {
				request: "checkIfFollowing",
				profiler: '<?php echo json_encode($profiler) ?>'
			},
			success: function(response) {
				
				if(response.status == "success") {
				
					$("#tdFollowers").html(response.followersNo);
						
					if(response.isFollowing == "true") {
						
						$(".followerOnlyIcons").css("display", "block");
						
						$("#icnFollow #svgHolder").html('<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 24 24"><path d="M4.781 24h-.001c-.603 0-1.097-.475-1.123-1.079-.129-3.12-.492-11.95-.492-11.95l-1.716 3.106c-.186.339-.593.486-.953.347l-.001-.001c-.304-.118-.495-.407-.495-.72l.029-.21 1.659-5.856c.163-.574.687-.97 1.284-.97h18.056c.597 0 1.121.396 1.284.97l1.659 5.856.029.21c0 .313-.191.602-.495.72l-.001.001c-.36.139-.767-.008-.953-.347l-1.716-3.106s-.363 8.83-.492 11.95c-.026.604-.52 1.079-1.123 1.079h-.001c-.591 0-1.075-.459-1.12-1.047-.102-1.297-.374-4.4-.456-5.628-.034-.51-.407-.81-.812-.81-.363 0-.771.3-.804.81-.083 1.228-.355 4.331-.456 5.628-.046.588-.53 1.047-1.12 1.047h-.002c-.602 0-1.097-.475-1.122-1.079-.13-3.12-.644-12.921-.644-12.921h-1.348s-.532 9.801-.662 12.921c-.025.604-.52 1.079-1.122 1.079h-.002c-.59 0-1.074-.459-1.12-1.047-.101-1.297-.373-4.4-.456-5.628-.033-.51-.441-.81-.804-.81-.405 0-.778.3-.812.81-.082 1.228-.354 4.331-.456 5.628-.045.588-.529 1.047-1.12 1.047zm2.384-24c1.656 0 3 1.344 3 3s-1.344 3-3 3c-1.655 0-3-1.344-3-3s1.345-3 3-3zm9.67 0c-1.656 0-3 1.344-3 3s1.344 3 3 3c1.655 0 3-1.344 3-3s-1.345-3-3-3z"/></svg>');
					
						$("#icnFollow .tip").html('Following');
						
					}
				
					else if(response.isFollowing == "false") {
						
						$(".followerOnlyIcons").css("display", "none");
						
						$("#icnFollow #svgHolder").html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M9.602 3.7c-1.154 1.937-.635 5.227 1.424 9.025.93 1.712.697 3.02.338 3.815-.982 2.178-3.675 2.799-6.525 3.456-1.964.454-1.839.87-1.839 4.004h-1.995l-.005-1.241c0-2.52.199-3.975 3.178-4.663 3.365-.777 6.688-1.473 5.09-4.418-4.733-8.729-1.35-13.678 3.732-13.678 3.321 0 5.97 2.117 5.97 6.167 0 3.555-1.949 6.833-2.383 7.833h-2.115c.392-1.536 2.499-4.366 2.499-7.842 0-5.153-5.867-4.985-7.369-2.458zm13.398 15.3h-3v-3h-2v3h-3v2h3v3h2v-3h3v-2z"/></svg>');
					
						$("#icnFollow .tip").html('Follow');
						
					}
				
					else {}
				
				}
				
			},
			error: function(response) {
				
				//alert(JSON.stringify(response));
			
			}
		});
	
	}
	
	$("#icnFollow").click(function() {

		$.ajax({
			type: "POST",
			url: "../scripts/profile.php",
			dataType: "JSON",
			data: {
				request: "follow",
				profiler: '<?php echo json_encode($profiler) ?>'
			},
			success: function(response) {
				
				checkIfFollowing();
			
			},
			error: function(response) {
				
			//	alert(JSON.stringify(response));
			
			}
		});
		
	});
	
	$("#icnChatUp").click(function() {
	
		window.location.href = "../chat?type=single&partner=<?php echo $profiler["usercode"]; ?>&unknown";
	
	});
				

</script>

<?php
	
	include("../templates/footer.php");
	
?>