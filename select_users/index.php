<?php
	
	require("../scripts/account_details.php");
	
	isset($_GET["type"]) && isset($_GET["p"]) or die(header("Location: ../"));
	
	$headings = array("followers" => "Select followers");
	
	$formActions = array("sharestory" => "../scripts/share_story.php");
	
	$type = $_GET["type"];
	
	$purpose = $_GET["p"];
		
	$pageSpecs = array("title" => "Select users", "restricted" => true);
	
	include("../templates/header.php");
	
?>

<script>
	
	var defaultArray = [];

	sessionStorage.setItem("sessionArray", JSON.stringify(defaultArray));

</script>

<link rel="stylesheet" href="../styles/select_user.css">

<div id="main">

	<div id="container">

		<div id="head">
		
			<label id="heading"><?php echo $headings[$type]; ?></label>
			
			<input id="inpSearch" placeholder="Search for followers">
			
			<div id="svgHolder">
			
				<label for="inpSearch">
					
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M23.809 21.646l-6.205-6.205c1.167-1.605 1.857-3.579 1.857-5.711 0-5.365-4.365-9.73-9.731-9.73-5.365 0-9.73 4.365-9.73 9.73 0 5.366 4.365 9.73 9.73 9.73 2.034 0 3.923-.627 5.487-1.698l6.238 6.238 2.354-2.354zm-20.955-11.916c0-3.792 3.085-6.877 6.877-6.877s6.877 3.085 6.877 6.877-3.085 6.877-6.877 6.877c-3.793 0-6.877-3.085-6.877-6.877z"/></svg>
					
				</label>
			
				<svg id="icnBack" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm3.222 18.917c5.666-5.905-.629-10.828-5.011-7.706l1.789 1.789h-6v-6l1.832 1.832c7.846-6.07 16.212 4.479 7.39 10.085z"/></svg>
				
				<form method="post" id="frmSubmit" action="<?php echo $formActions[$purpose]; ?>">
					
					<input name="array">
				
					<input name="info">
				
					<input name="info2">
				
					<button type="submit">
						
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M10.024 4h6.015l7.961 8-7.961 8h-6.015l7.961-8-7.961-8zm-10.024 16h6.015l7.961-8-7.961-8h-6.015l7.961 8-7.961 8z"/></svg>
						
					</button>
					
				</form>
				
			</div>
		
		</div>

		<div id="body">
		
			<?php
			
				require("../scripts/connection.php");
				
				if($type == "followers") {
				
					$sql = "SELECT * FROM followers WHERE follower_usercode = '$usercode' ";
				
					if($result = mysqli_query($conn, $sql)) {
						
						if(mysqli_num_rows($result) == 0) {
						
							echo '<script> placeholder($("#container #body"), "You have no followers"); </script>';
						
						}
					
						while($row = mysqli_fetch_array($result)) {
							
							$follower = array();
					
							$follower["usercode"] = $row["followed_usercode"];
						
							$accountSql = "SELECT * FROM accounts WHERE usercode = '" . $follower["usercode"] . "'  ";
						
							if($accountResult = mysqli_query($conn, $accountSql)) {
							
								$accountRow = mysqli_fetch_array($accountResult);
						
								$follower["name"] = $accountRow["first_name"] . " " . $accountRow["last_name"];
								
								$follower["gender"] = $accountRow["gender"];
						
								$originalProfilePicture = "../images/profile_pictures/" . $follower["usercode"] . ".jpg";
	
								$profilePicture = file_exists($originalProfilePicture) ? $originalProfilePicture : "../images/templates/avatars/" . $follower["gender"] . ".jpg";
	
							}
					
							echo '<div class="option" id="' . $follower["usercode"] . '">
								
								<a target="_blank" href="../profile?id=' . $follower["usercode"] . '">
							
									<img src="' . $profilePicture . '" id="profilePicture"></img>
								</a>
								
								<label id="name">' . $follower["name"] . '</label>
							
							</div>';
					
						}
				
					}
				
				}
			
			?>
			
			<div id="errorHolder"></div>
		
		</div>

	</div>
	
</div>
	
<script>
	
	$(".option").click(function() {
		
		var sessionArray = JSON.parse(sessionStorage.getItem("sessionArray"));
		
		var value = $(this).attr("id");
		
		if(sessionArray.indexOf(value) == -1) {
		
		 	$(this).css("backgroundColor", "rgba(0, 0, 0, 0.2)");
		
			var newSessionArray = sessionArray.concat(value);
			
		}
		
		else {
		
		 	$(this).css("backgroundColor", "rgba(0, 0, 0, 0)");
		 	
		 	var index = (sessionArray.indexOf(value));
			
			sessionArray.splice(index, 1);
		
			var newSessionArray = sessionArray;
			
		}

		sessionStorage.setItem("sessionArray", JSON.stringify(newSessionArray));
		
	});
	
	$("#icnBack").click(function() {
	
		window.close();
	
	});
	
	$("#inpSearch").focus(function() {
	
		$(this).css({
			opacity: "1",
			width: "96%",
		});
	
	});

	$("#inpSearch").blur(function() {
	
		$(this).css({
			opacity: "0",
			width: "0%",
		});
	
	});

	$("#inpSearch").keyup(function() {
	
		var searchWord = $(this).val();
		
		var foundAMatch = false;
		
		for(var i = 0; i < $(".option").length; i++) {
		
			if( (($(".option").eq(i).children("#name").html()).toLowerCase()).indexOf(searchWord.toLowerCase()) !== -1) {
				
				foundAMatch = true;
			
				$(".option").eq(i).css("display", "block");
			
			}
			
			else {
			
				$(".option").eq(i).css("display", "none");
			
			}
		
		}
		
		if(foundAMatch == false) {
		
			placeholder($("#container #body #errorHolder"), "No match");
		
		}
		
		else {
		
			placeholder($("#container #body #errorHolder"), "");
		
		}
	
	});
	
	$("#frmSubmit").submit(function() {
	
		$(this).children("[name=array]").val(sessionStorage.getItem("sessionArray"));
		
		var purpose = "<?php echo $purpose; ?>";
		
		if(purpose == "sharestory") {
		
			$(this).children("[name=info]").val("<?php echo (isset($_GET["sc"]) ? $_GET["sc"] : ""); ?>");
		
			$(this).children("[name=info2]").val("<?php echo (isset($_GET["c"]) ? $_GET["c"] : ""); ?>");
		
		}
	
	});

</script>