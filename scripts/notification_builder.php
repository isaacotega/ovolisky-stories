<?php
	
		function processNotification($notificationRow, $templateRow) {
		
			global $conn;
	
			$notificationId = $notificationRow["notification_id"];
			
			$seen = $notificationRow["seen"];
			
			if($notificationId == 1) {
			
				$storyCode = $notificationRow["story_code"];
			
				$chapter = $notificationRow["chapter"];
				
				$anchorLink = "../story?id=" . $storyCode . "&c=" . $chapter;
			
				$snippetSql = "SELECT * FROM chapters WHERE story_code = '$storyCode' AND chapter = '$chapter' ";
				
				if($snippetResult = mysqli_query($conn, $snippetSql)) {
				
					$snippetRow = mysqli_fetch_array($snippetResult);
					
					$snippet = substr($snippetRow["body"], 0, 50) . " . . .";
					
				}
			
				$statsSql = "SELECT * FROM story_stats WHERE story_code = '$storyCode' ";
				
				if($statsResult = mysqli_query($conn, $statsSql)) {
				
					$statsRow = mysqli_fetch_array($statsResult);
					
					$storyTitle = $statsRow["title"];
					
					$items = array("@storyName", "@chapter", "\n");
					
					$replacements = array($storyTitle, $chapter, "</p><p>");
					
					$message = "<p>" . str_replace($items, $replacements, $templateRow["message"]) . ": " .$snippet . "</p>";
					
				}
				
				echo '<a href="' . $anchorLink . '"> <div id="' . (($seen == "false") ? "unread" : "") . '" class="notificationBox"> <div id="iconHolder"><img src="../images/icons/story_update.jpg"></img></div> <div id="messageHolder">' . $message . '</div> </div> </a>';
				
			}
		
			if($notificationId == 2) {
			
				$storyCode = $notificationRow["story_code"];
			
				$chapter = $notificationRow["chapter"];
				
				$senderUsercode = $notificationRow["sender_usercode"];
				
				$anchorLink = "../story?id=" . $storyCode . "&c=" . $chapter;
			
				$accountSql = "SELECT * FROM accounts WHERE usercode = '$senderUsercode' ";
				
				if($accountResult = mysqli_query($conn, $accountSql)) {
				
					$accountRow = mysqli_fetch_array($accountResult);
					
					$inviterName = $accountRow["first_name"];
					
				}
			
				
				$snippetSql = "SELECT * FROM chapters WHERE story_code = '$storyCode' AND chapter = '$chapter' ";
				
				if($snippetResult = mysqli_query($conn, $snippetSql)) {
				
					$snippetRow = mysqli_fetch_array($snippetResult);
					
					$snippet = substr($snippetRow["body"], 0, 50) . " . . .";
					
				}
			
				$statsSql = "SELECT * FROM story_stats WHERE story_code = '$storyCode' ";
				
				if($statsResult = mysqli_query($conn, $statsSql)) {
				
					$statsRow = mysqli_fetch_array($statsResult);
					
					$storyTitle = $statsRow["title"];
					
				}
					
				if($snippetResult = mysqli_query($conn, $snippetSql)) {
				
					$snippetRow = mysqli_fetch_array($snippetResult);
					
					$snippet = substr($snippetRow["body"], 0, 50) . " . . .";
					
				}
			
				$items = array("@inviterName", "@storyName", "@chapter", "@snippet", "\n");
					
					$replacements = array($inviterName, $storyTitle, $chapter, $snippet, "</p><p>");
					
				$message = "<p>" . str_replace($items, $replacements, $templateRow["message"]) . "</p>";
					
				echo '<a href="' . $anchorLink . '"> <div id="' . (($seen == "false") ? "unread" : "") . '" class="notificationBox"> <div id="iconHolder"><img src="../images/icons/story_invitation.jpg"></img></div> <div id="messageHolder">' . $message . '</div> </div> </a>';
			
			}
			
		}
		
 ?>