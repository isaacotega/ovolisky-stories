<?php
	
//	isset($_COOKIE["247rdsck"]) or die(header("Location: ../"));
	
	$pageSpecs = array("title" => "Chat", "footer" => false, "restricted" => true);
	
	include("../templates/header.php");
	
	require("../scripts/connection.php");
	
	require("../scripts/account_details.php");
	
	if(isset($_GET["unknown"])) {
		
		$participantUsercode = $_GET["partner"];
	
		$sql = "SELECT thread_code FROM single_message_threads WHERE first_participant = '$participantUsercode' OR second_participant = '$participantUsercode' ";
		
		if($result = mysqli_query($conn, $sql)) {
		
			if(mysqli_num_rows($result) !== 0) {
			
				$row = mysqli_fetch_array($result);
				
				$threadCode = $row["thread_code"];
				
				die('<script> window.location.href = "?thread=' . $threadCode . '"; </script>');
				
			}
			
			else {
			
				$sql = "SELECT * FROM accounts WHERE usercode = '$participantUsercode' ";
				
				if($result = mysqli_query($conn, $sql)) {
		
					mysqli_num_rows($result) !== 0 or die('<script> window.location.href = "../"; </script>');
					
				}
				
				$digitsNo = 10;
				
				$threadCode = "";
				
				for($i = 0; $i < $digitsNo; $i++) {
				
					$threadCode .= rand(0, 9);
				
				}
				
				$date = date("Y m d");
				
				$time = date("H:i A");
				
				$sql = "INSERT INTO single_message_threads (first_participant, second_participant, thread_code, date_created, time_created) VALUES ('$usercode', '$participantUsercode', '$threadCode', '$date', '$time') ";
				
				if(mysqli_query($conn, $sql)) {
				
					die('<script> window.location.href = ""; </script>');
				
				}
			
			}
		
		}
	
	}
	
	else {
	
		isset($_GET["thread"]) or die('<script> window.location.href = "../"; </script>');
		
		$threadCode = $_GET["thread"];
		
		$sql = "SELECT * FROM single_message_threads WHERE thread_code = '$threadCode' ";
		
		if($result = mysqli_query($conn, $sql)) {
		
			mysqli_num_rows($result) !== 0 or die('<script> window.location.href = ""; </script>');
			
			$row = mysqli_fetch_array($result);
			
			$firstParticipantUsercode = $row["first_participant"];
			
			$secondParticipantUsercode = $row["second_participant"];
			
		}
	
	}
		
?>

<link rel="stylesheet" href="../styles/chat_page.css">
	
<div id="main">
	
	<div id="head"></div>
	
	<div id="messageHolder"></div>
	
	<div id="inputHolder">
		
		<form id="frmMessage">
	
			<input type="message" id="inpMessage" placeholder="Enter message">
			
		</form>
			
	</div>
	
</div>

<script>
	
	getMessages()

	function getMessages() {
	
		$.ajax({
			type: "POST",
			url: "../scripts/chat.php",
			dataType: "JSON",
			data: {
				request: "getMessages",
				threadCode: '<?php echo $threadCode; ?>'
			},
			success: function(response) {
				
				$("#messageHolder").html("");
			
				for(var i = 0; i < response["messageObj"].length; i++) {
				
					var senderUsercode = JSON.stringify( JSON.parse(response["messageObj"][i])["sender_usercode"] );
					
					var message = JSON.stringify( JSON.parse(response["messageObj"][i])["message"] );
					
					var date = JSON.stringify( JSON.parse(response["messageObj"][i])["date"] );
					
					var time = JSON.stringify( JSON.parse(response["messageObj"][i])["time"] );
					
					$("#messageHolder").append(('<?php echo str_replace("\n", "", file_get_contents("../templates/message_box.html")); ?>').replace(/@message/, message).replace(/@time/, time).replace("", ""));
					
				}
			
				$("#messageHolder").animate({
					'scrollTop': 1000000000000
				});
		
			},
			error: function(response) {
				
				alert(JSON.stringify(response));
			
			}
		});
		
	}
		
	$("#frmMessage").submit(function() {
	
		event.preventDefault();
		
		var message = $("#inpMessage").val();
		
		$("#inpMessage").val("");
			
		$.ajax({
			type: "POST",
			url: "../scripts/chat.php",
			dataType: "JSON",
			data: {
				request: "sendMessage",
				threadCode: '<?php echo $threadCode; ?>',
				message: message
			},
			success: function(response) {
				
				getMessages();
			
			},
			error: function(response) {
				
			//	alert(JSON.stringify(response));
			
			}
		});
		
		
	
	});

</script>

<?php
	
	include("../templates/footer.php");
	
?>