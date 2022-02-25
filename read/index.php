<?php
	
	require("../scripts/account_details.php");
	
	!$isLoggedIn or die(header("Location: ../story?id=" . $_GET["id"]));
	
	isset($_GET["c"]) && !empty($_GET["c"]) or die(header("Location: ?id=" . $_GET["id"] . "&c=1"));
	
	$chapter = $_GET["c"];
		
	$currentPage = "story";
		
	require("../scripts/story_details.php");
	
	$sql = "UPDATE
 story_stats SET views = views + 1 WHERE story_code = '$story_code' ";
	
	mysqli_query($conn, $sql);
	
	$pageSpecs = array("title" => $title . " _ Chapter " . $chapter, "topBar" => true, "chapterNav" => true, "chapterNo" => $lastChapter, "description" => $title . " _ Chapter " .$chapter . " : " . substr($body, 0, 150) . " . . . About : " . substr($about, 0, 150) . " . . . ", "keywords" => $genre . ", " . implode(", ", $tags) );
	
	include("../templates/header.php");
	
?>
	
<link rel="stylesheet" href="../styles/story_page.css">
	
<div id="main">
		
	<a href="prologue?id=<?php echo $story_code ?>">
		
		<h1 id="title"><?php echo $title ?>  _ Chapter <?php echo $chapter ?></h1>
		
	</a>
	
	<?php
		
		echo '<div id="storyHolder"> <p>' . str_replace("\n", "</p><p>", $body) . '</p> </div>';
		
		if($chapter !== "1") {
		
			echo '<a href="?id=' . $story_code . '&c=' . ($chapter - 1) . '">
		
			<button class="navigationBtn" id="prevBtn"><< Previous Chapter</button>
			
		</a>';
		
		}
		
		else {
		
			echo '<a href="../story/prologue?id=' . $story_code . '">
		
			<button class="navigationBtn" id="prevBtn"><< Prologue</button>
			
		</a>';
		
		}
			
		if(!$isLatestChapter) {
		
			echo '<a href="?id=' . $story_code . '&c=' . ($chapter + 1) . '">
		
			<button class="navigationBtn">Next Chapter >></button>
			
		</a>';
		
		}
			
		else if($isLatestChapter && $status == "ended") {
		
			echo '<a href="../story/epilogue?id=' . $story_code . '">
		
			<button class="navigationBtn">Epilogue >></button>
			
		</a>';
		
		}
		
		else {}
			
	?>
	
	<br><br><br><br><br><br><br><br><br><br>
	
	<hr>
	
	<div id="menuBar">
		
		<table>
		
			<tr>
			
				<td id="icnUpvote" class="btnQuickLink" scrollto="commentBox"> <span id="svgHolder"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21.406 9.558c-1.21-.051-2.87-.278-3.977-.744.809-3.283 1.253-8.814-2.196-8.814-1.861 0-2.351 1.668-2.833 3.329-1.548 5.336-3.946 6.816-6.4 7.401v-.73h-6v12h6v-.904c2.378.228 4.119.864 6.169 1.746 1.257.541 3.053 1.158 5.336 1.158 2.538 0 4.295-.997 5.009-3.686.5-1.877 1.486-7.25 1.486-8.25 0-1.648-1.168-2.446-2.594-2.506zm-17.406 10.442h-2v-8h2v8zm15.896-5.583s.201.01 1.069-.027c1.082-.046 1.051 1.469.004 1.563l-1.761.099c-.734.094-.656 1.203.141 1.172 0 0 .686-.017 1.143-.041 1.068-.056 1.016 1.429.04 1.551-.424.053-1.745.115-1.745.115-.811.072-.706 1.235.109 1.141l.771-.031c.822-.074 1.003.825-.292 1.661-1.567.881-4.685.131-6.416-.614-2.239-.965-4.438-1.934-6.959-2.006v-6c3.264-.749 6.328-2.254 8.321-9.113.898-3.092 1.679-1.931 1.679.574 0 2.071-.49 3.786-.921 5.533 1.061.543 3.371 1.402 6.12 1.556 1.055.059 1.024 1.455-.051 1.584l-1.394.167s-.608 1.111.142 1.116z"/></svg> </span> <span id="upvotesNo" class="number"></span></td>
			
			</tr>
		
		</table>
		
	</div>
	
	<hr>
	
	<h2 id="lblComments">Comments</h2>
		
	<div id="commentsHolder"></div>
	
	<div id="commentBox"></div>
		
</div>

<script>

	placeholder($("#commentBox"), '<a href="../login?return=<?php echo urlencode($currentUrl . "#commentBox"); ?>">Sign in to like or comment</a>');
	
	$(".btnQuickLink").click(function() {
		
		$(document.body).animate({
			'scrollTop': $("#" + $(this).attr("scrollto")).offset().top - 150
		}, 800);
		
	});
	
	var commentBox = '<?php echo str_replace("\n", "", file_get_contents("../templates/comment_box.html")); ?>';
	
	var replyBox = '<?php echo str_replace("\n", "", file_get_contents("../templates/reply_box.html")); ?>';
	
	loadUpvotes();
	
	loadComments();
	
	function loadComments() {
		
		$.ajax({
			type: "POST",
			url: "../scripts/comment.php",
			dataType: "JSON",
			data: {
				request: "loadComment",
				storyCode: '<?php echo $story_code ?>',
				chapter: '<?php echo $chapter ?>'
			},
			success: function(response) {
				
				$("#commentsHolder").html("");
			
				for(var i = 0; i < response.eachComment.length; i++) {
				
					var commenterUsercode = response.commenterUsercode[i];
				
					var commenterName = response.commenterName[i];
				
					var profilePicture = response.profilePicture[i];
				
					var commentId = response.commentId[i];
				
					var comment = response.eachComment[i]["comment"].replace(/\n/g, "</p><p>");
				
					var date = response.eachComment[i]["date"];
				
					var time = response.eachComment[i]["time"];
				
					$("#commentsHolder").append(commentBox.replace(/@src/g, profilePicture).replace(/@commentId/g, commentId).replace(/@name/g, commenterName).replace(/@comment/g, comment).replace(/@date/g, date).replace(/@time/g, time));
			
				}
				
				$("[id=lblReply]").hide();
				
				loadReplies();
	
			},
			error: function(response) {
				
				alert();
			
			}
		});
	
	}

	function loadReplies() {
		
		$.ajax({
			type: "POST",
			url: "../scripts/comment.php",
			dataType: "JSON",
			data: {
				request: "loadReplies",
				storyCode: '<?php echo $story_code ?>',
				chapter: '<?php echo $chapter ?>'
			},
			success: function(response) {
				
				$("[id=replyHolder]").html("");
				
				for(var i = 0; i < response.eachReply.length; i++) {
				
					var replierUsercode = response.replierUsercode[i];
				
					var replierName = response.replierName[i];
				
					var commentId = response.commentId[i];
				
					var profilePicture = response.profilePicture[i];
				
					var reply = response.eachReply[i]["reply"].replace(/\n/g, "</p><p>");
				
					var date = response.eachReply[i]["date"];
				
					var time = response.eachReply[i]["time"];
					
					$("#" + commentId + " #replyHolder").append(replyBox.replace(/@src/g, profilePicture).replace(/@name/g, replierName).replace(/@reply/g, reply).replace(/@date/g, date).replace(/@time/g, time));
			
				}
				
			},
			error: function(response) {
				
				alert(JSON.stringify(response));
			
			}
		});
	
	}
	
	function loadUpvotes() {
			
		$.ajax({
			type: "POST",
			url: "../scripts/comment.php",
			dataType: "JSON",
			data: {
				request: "loadUpvotes",
				storyCode: '<?php echo $story_code ?>',
				chapter: '<?php echo $chapter ?>',
				usercode: 'none'
			},
			success: function(response) {
				
				if(response.status == "success") {
				
					var upvotes = response.upvotes;
					
					$("#upvotesNo").html(upvotes);
					
				}
				
			}
		});
	
	}

</script>

	<?php
		
		if($chapter !== "1") {
		
			echo '<a href="?id=' . $story_code . '&c=' . ($chapter - 1) . '">
		
			<button class="navigationBtn" id="prevBtn"><< Previous Chapter</button>
			
		</a>';
		
		}
		
		else {
		
			echo '<a href="prologue?id=' . $story_code . '">
		
			<button class="navigationBtn" id="prevBtn"><< Prologue</button>
			
		</a>';
		
		}
			
		if(!$isLatestChapter) {
		
			echo '<a href="?id=' . $story_code . '&c=' . ($chapter + 1) . '">
		
			<button class="navigationBtn">Next Chapter >></button>
			
		</a>';
		
		}
			
		else if($isLatestChapter && $status == "ended") {
		
			echo '<a href="epilogue?id=' . $story_code . '">
		
			<button class="navigationBtn">Epilogue >></button>
			
		</a>';
		
		}
		
		else {}
			
	?>
	
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		
<?php
	
	include("../templates/footer.php");
	
?>