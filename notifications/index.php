<?php
		
	$pageSpecs = array("title" => "Notifications", "restricted" => true);
	
	include("../templates/header.php");
	
	include("../scripts/notification_builder.php");
	
?>

<style>

.notificationBox {
	width: 94%;
	text-align: center;
	border: 1px solid cyan;
	padding: 1cm 3%;
}

.notificationBox #iconHolder {
	width: 5cm;
	height: 5cm;
	float: left;
	margin: 0 1cm 0 0; 
}

.notificationBox #iconHolder img {
	width: 100%;
	height: 100%;
	border-radius: 50%;
}

.notificationBox #messageHolder {
	height: 5cm;
	overflow-y: auto;
	text-align: left;
}

.notificationBox #messageHolder p {
	font-size: 20px;
	text-indent: 1cm;
	line-height: 5mm;
}

#unread {
	background-color: #FFF0E0;
}

</style>
	
<div id="main">
		
	<h1 id="title">Notifications</h1>
	
	<div id="container">
	
	<?php
		
		require("../scripts/connection.php");
	
		require("../scripts/account_details.php");
	
		$sql = "SELECT * FROM notifications WHERE receiver_usercode = '$usercode' ORDER BY date DESC, time DESC LIMIT 100";
		
		if($result = mysqli_query($conn, $sql)) {
		
			if(mysqli_num_rows($result) == 0) {
				
				echo '<script> placeholder($("#container"), "You have no notifications"); </script>';
				
			}
			
			else {
			
			while($notificationRow = mysqli_fetch_array($result)) {
			
				$notificationId = $notificationRow["notification_id"];
				
				$templateSql = "SELECT * FROM notification_templates WHERE notification_id = '$notificationId' ";
				
				if($templateResult = mysqli_query($conn, $templateSql)) {
				
					$templateRow = mysqli_fetch_array($templateResult);
					
					processNotification($notificationRow, $templateRow);
				
				}
			
			}
			
			}
		
		}
		
		
		
		
		$sql = "UPDATE notifications SET seen = 'true' WHERE receiver_usercode = '$usercode' ";
		
		mysqli_query($conn, $sql);
		
	?>
	
	</div>
	
</div>

<?php
	
	include("../templates/footer.php");
	
?>