<?php
	
	require("../scripts/account_details.php");
	
	$isLoggedIn or die(header("Location: ../read?id=" . $_GET["id"] . "&c=" . $_GET["c"]));
	
	isset($_GET["c"]) && !empty($_GET["c"]) or die(header("Location: ?id=" . $_GET["id"] . "&c=1"));
	
	$chapter = $_GET["c"];
	
	$currentPage = "story";
		
	require("../scripts/story_details.php");
	
	$sql = "UPDATE
 story_stats SET views = views + 1 WHERE story_code = '$story_code' ";
	
	mysqli_query($conn, $sql);
	
	$sql = "SELECT * FROM history WHERE story_code = '$story_code' AND viewer_usercode = '$usercode' ";
	
	if($result = mysqli_query($conn, $sql)) {
		
		$currentDate = date("Y m d");
	
		$currentTime = date("H:i A");
	
		if(mysqli_num_rows($result) == 0) {
		
			$sql = "INSERT INTO history (story_code, viewer_usercode, chapter, date, time) VALUES ('$story_code', '$usercode', '$chapter', '$currentDate', '$currentTime') ";
			
		}
		
		else {
			
			$sql = "UPDATE history SET chapter = '$chapter',  date = '$currentDate', time = '$currentTime' WHERE story_code = '$story_code' AND viewer_usercode = '$usercode' ";
		
		}
	
		mysqli_query($conn, $sql);
		
	}
	
	$pageSpecs = array("title" => $title . " _ Chapter " . $chapter, "topBar" => true, "chapterNav" => true, "chapterNo" => $lastChapter, "description" => $title . " _ Chapter " .$chapter . " : " . substr($body, 0, 150) . " . . . About : " . substr($about, 0, 150) . " . . . ", "keywords" => $genre . ", " . implode(", ", $tags) );
	
	include("../templates/header.php");
	
	// originalStoryImage also assisting pinterest share dont remove it
	
	$originalStoryImage = $root . "images/stories/". str_replace(" ", "_", strtolower($title)) . "_" .  $story_code . ".jpg";
				
	$storyImage = file_exists($originalStoryImage) ? $originalStoryImage : $root . "images/templates/story_cover.jpg";
		
?>
	
<link rel="stylesheet" href="../styles/story_page.css">
	
<div id="main">
		
	<a href="prologue?id=<?php echo $story_code ?>">
		
		<h1 id="title"><?php echo $title ?>  _ Chapter <?php echo $chapter ?></h1>
		
	</a>
	
	<h2 id="nick">~~<?php echo $nick ?>~~</h2>
	
	<?php
		
		echo '<div id="storyHolder"> <p>' . str_replace("\n", "</p><p>", $body) . '</p> </div>';
		
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
	
	<br><br><br><br><br><br><br><br>
	
	<hr>
	
	<div id="menuBar">
		
		<table>
		
			<tr>
			
				<td id="icnUpvote"> <span id="svgHolder"> </span> <span id="upvotesNo" class="number"></span> <br> <label class="tip">Upvote</label> </td>
			
				<td id="icnComment" class="btnQuickLink" scrollto="commentBox"> <span id="svgHolder"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M22 3v13h-11.643l-4.357 3.105v-3.105h-4v-13h20zm2-2h-24v16.981h4v5.019l7-5.019h13v-16.981z"/></svg> </span> <span id="upvotesNo" class="number"></span> <br> <label class="tip">Comment</label> </td>
			
				<td id="icnFavourite"> <span id="svgHolder"> </span> <br> <label class="tip">Favourite</label> </td>
			
				<td id="icnBookmark"> <span id="svgHolder"> </span> <br> <label class="tip">Bookmark</label> </td>
			
				<td id="icnShare"> <span id="svgHolder"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-6 17c1.513-6.587 7-7.778 7-7.778v-2.222l5 4.425-5 4.464v-2.223c0 .001-3.78-.114-7 3.334z"/></svg> </span> <br> <label class="tip">Share</label> </td>
			
			</tr>
		
		</table>
		
	</div>
	
	<hr>
	
	<?php
	
		if($isLatestChapter && $status !== "ended") {
		
			echo '<div id="divPendingUpdate">Pending Update</div><hr>';
			
		}
	
	?>
			
	<div id="notifyMeHolder">
	
		<input type="checkbox" id="chkNotifyMe">
		
		<label for="chkNotifyMe">Notify me when updates are published</label>
	
	</div>
	
	<hr>
	
	<h2 id="lblComments">Comments</h2>
		
	<div id="commentsHolder"></div>
	
	<div id="commentBox">
		
		<label class="heading">What do you think about this chapter?</label>
		
		 <form method="post" class="form" id="frmComment">
 
		 	<br>
 	
			 <div class="formError">
	 
	 		<label></label>
	 
		 </div>
 	
 		<br><br>
 
 		<textarea id="txtComment" placeholder="Enter your comment" class="txt"></textarea>
 
	 	<br><br>
 	
 		<button type="submit" class="submit" id="btnComment">Comment</button>
 	
 		<br><br>
 	
	 </form>
 
	</div>
	
	<div id="shareContainer"><?php include("../templates/share_story.php"); ?></div>
		
</div>

<script>
	
	$(".btnQuickLink").click(function() {
		
		$(document.body).animate({
			'scrollTop': $("#" + $(this).attr("scrollto")).offset().top - 150
		}, 800);
		
	});
	
	$("#icnShare").click(function() {
		
		$("#shareContainer").css("display", "block");
		
	});
	
	$("#shareContainer").click(function() {
	
		$(this).css("display", "none");
	
	});
	
	var commentBox = '<?php echo str_replace("\n", "", file_get_contents("../templates/comment_box.html")); ?>';
	
	var replyBox = '<?php echo str_replace("\n", "", file_get_contents("../templates/reply_box.html")); ?>';
	
	checkIfFavourite();
	
	checkIfBookmarked();
	
	checkSubscribe();
	
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
				
				$("#icnComment .number").html(response.eachComment.length);
			
				for(var i = 0; i < response.eachComment.length; i++) {
				
					var commenterUsercode = response.commenterUsercode[i];
				
					var commenterName = response.commenterName[i];
				
					var profilePicture = response.profilePicture[i];
					
					var profilePath = "../profile?id=" + commenterUsercode;
				
					var commentId = response.commentId[i];
				
					var comment = response.eachComment[i]["comment"].replace(/\n/g, "</p><p>");
				
					var date = response.eachComment[i]["date"];
				
					var time = response.eachComment[i]["time"];
				
					$("#commentsHolder").append(commentBox.replace(/@src/g, profilePicture).replace(/@profile/g, profilePath).replace(/@commentId/g, commentId).replace(/@name/g, commenterName).replace(/@comment/g, comment).replace(/@date/g, date).replace(/@time/g, time));
			
				}
				
				$("[id=lblReply]").click(function() {
					
					var replyPortal = $(replyBox.replace(/@src/g, '<?php echo $root ?>images/profile_pictures/<?php echo $usercode ?>.jpg').replace(/@name/g, "<?php echo $firstName . " " . $lastName ?>").replace(/@reply/g, "f").replace(/@date/g, "").replace(/@time/g, ""));
					
					var replyForm = $('<form id="frmReply"> <textarea id="txtReply" placeholder="Enter Reply"></textarea> <button id="btnReply" type="submit">Reply</button> </form>');
					
					$(replyForm).submit(function() {
					
						postReply(this, $(this).children("#txtReply").val());
					
					});
					
					$(replyPortal).children("#body").html(replyForm);
					
					$("#frmReply").parents(".replyBox").remove();
				
					$(this).parents(".commentBox").children("#replyHolder").append(replyPortal);
				
				});
				
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
				
					var profilePath = "../profile?id=" + replierUsercode;
				
					var reply = response.eachReply[i]["reply"].replace(/\n/g, "</p><p>");
				
					var date = response.eachReply[i]["date"];
				
					var time = response.eachReply[i]["time"];
					
					$("#" + commentId + " #replyHolder").append(replyBox.replace(/@src/g, profilePicture).replace(/@profile/g, profilePath).replace(/@name/g, replierName).replace(/@reply/g, reply).replace(/@date/g, date).replace(/@time/g, time));
			
				}
				
			},
			error: function(response) {
				
				alert(JSON.stringify(response))
			
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
				usercode: '<?php echo $usercode ?>'
			},
			success: function(response) {
				
				if(response.status == "success") {
				
					var upvotes = response.upvotes;
					
					$("#upvotesNo").html(upvotes);
					
					if(response.hasUpvoted == "true") {
						
						$("#icnUpvote #svgHolder").html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M5 22h-5v-12h5v12zm17.615-8.412c-.857-.115-.578-.734.031-.922.521-.16 1.354-.5 1.354-1.51 0-.672-.5-1.562-2.271-1.49-1.228.05-3.666-.198-4.979-.885.906-3.656.688-8.781-1.688-8.781-1.594 0-1.896 1.807-2.375 3.469-1.221 4.242-3.312 6.017-5.687 6.885v10.878c4.382.701 6.345 2.768 10.505 2.768 3.198 0 4.852-1.735 4.852-2.666 0-.335-.272-.573-.96-.626-.811-.062-.734-.812.031-.953 1.268-.234 1.826-.914 1.826-1.543 0-.529-.396-1.022-1.098-1.181-.837-.189-.664-.757.031-.812 1.133-.09 1.688-.764 1.688-1.41 0-.565-.424-1.109-1.26-1.221z"/></svg>');
					
					}
				
					else if(response.hasUpvoted == "false") {
						
						$("#icnUpvote #svgHolder").html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21.406 9.558c-1.21-.051-2.87-.278-3.977-.744.809-3.283 1.253-8.814-2.196-8.814-1.861 0-2.351 1.668-2.833 3.329-1.548 5.336-3.946 6.816-6.4 7.401v-.73h-6v12h6v-.904c2.378.228 4.119.864 6.169 1.746 1.257.541 3.053 1.158 5.336 1.158 2.538 0 4.295-.997 5.009-3.686.5-1.877 1.486-7.25 1.486-8.25 0-1.648-1.168-2.446-2.594-2.506zm-17.406 10.442h-2v-8h2v8zm15.896-5.583s.201.01 1.069-.027c1.082-.046 1.051 1.469.004 1.563l-1.761.099c-.734.094-.656 1.203.141 1.172 0 0 .686-.017 1.143-.041 1.068-.056 1.016 1.429.04 1.551-.424.053-1.745.115-1.745.115-.811.072-.706 1.235.109 1.141l.771-.031c.822-.074 1.003.825-.292 1.661-1.567.881-4.685.131-6.416-.614-2.239-.965-4.438-1.934-6.959-2.006v-6c3.264-.749 6.328-2.254 8.321-9.113.898-3.092 1.679-1.931 1.679.574 0 2.071-.49 3.786-.921 5.533 1.061.543 3.371 1.402 6.12 1.556 1.055.059 1.024 1.455-.051 1.584l-1.394.167s-.608 1.111.142 1.116z"/></svg>');
					
					}
				
					else {}
				
				}
				
			},
			error: function(response) {
				
				//alert(JSON.stringify(response))
			
			}
		});
	
	}

	function checkIfFavourite() {
			
		$.ajax({
			type: "POST",
			url: "../scripts/comment.php",
			dataType: "JSON",
			data: {
				request: "checkIfFavourite",
				storyCode: '<?php echo $story_code ?>',
				chapter: '<?php echo $chapter ?>',
				usercode: '<?php echo $usercode ?>'
			},
			success: function(response) {
				
				if(response.status == "success") {
				
					if(response.isFavourite == "true") {
						
						$("#icnFavourite #svgHolder").html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 4.435c-1.989-5.399-12-4.597-12 3.568 0 4.068 3.06 9.481 12 14.997 8.94-5.516 12-10.929 12-14.997 0-8.118-10-8.999-12-3.568z"/></svg>');
					
					}
				
					else if(response.isFavourite == "false") {
						
						$("#icnFavourite #svgHolder").html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 9.229c.234-1.12 1.547-6.229 5.382-6.229 2.22 0 4.618 1.551 4.618 5.003 0 3.907-3.627 8.47-10 12.629-6.373-4.159-10-8.722-10-12.629 0-3.484 2.369-5.005 4.577-5.005 3.923 0 5.145 5.126 5.423 6.231zm-12-1.226c0 4.068 3.06 9.481 12 14.997 8.94-5.516 12-10.929 12-14.997 0-7.962-9.648-9.028-12-3.737-2.338-5.262-12-4.27-12 3.737z"/></svg>');
					
					}
				
					else {}
				
				}
				
			},
			error: function(response) {
				
				//alert(JSON.stringify(response))
			
			}
		});
	
	}

	function checkIfBookmarked() {
			
		$.ajax({
			type: "POST",
			url: "../scripts/comment.php",
			dataType: "JSON",
			data: {
				request: "checkIfBookmarked",
				storyCode: '<?php echo $story_code ?>',
				chapter: '<?php echo $chapter ?>',
				usercode: '<?php echo $usercode ?>'
			},
			success: function(response) {
				
				if(response.status == "success") {
				
					if(response.isBookmarked == "true") {
						
						$("#icnBookmark #svgHolder").html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0l3.668 8.155 8.332 1.151-6.064 5.828 1.48 8.866-7.416-4.554-7.417 4.554 1.481-8.866-6.064-5.828 8.332-1.151z"/></svg>');
					
					}
				
					else if(response.isBookmarked == "false") {
						
						$("#icnBookmark #svgHolder").html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 5.173l2.335 4.817 5.305.732-3.861 3.71.942 5.27-4.721-2.524-4.721 2.525.942-5.27-3.861-3.71 5.305-.733 2.335-4.817zm0-4.586l-3.668 7.568-8.332 1.151 6.064 5.828-1.48 8.279 7.416-3.967 7.416 3.966-1.48-8.279 6.064-5.827-8.332-1.15-3.668-7.569z"/></svg>');
					
					}
				
					else {}
				
				}
				
			},
			error: function(response) {
				
				//alert(JSON.stringify(response))
			
			}
		});
	
	}

	function checkSubscribe() {
			
		$.ajax({
			type: "POST",
			url: "../scripts/comment.php",
			dataType: "JSON",
			data: {
				request: "checkSubscribe",
				storyCode: '<?php echo $story_code ?>',
				usercode: '<?php echo $usercode ?>'
			},
			success: function(response) {
				
				if(response.status == "success") {
				
					if(response.isSubscribed == "true") {
						
						$("#chkNotifyMe").attr("checked", "true");
					
					}
				
					else if(response.isSubscribed == "false") {
						
						$("#chkNotifyMe").removeAttr("checked");
					
					}
					
					else {}
				
				}
				
			},
			error: function(response) {
				
				alert(JSON.stringify(response))
			
			}
		});
	
	}

	$("#chkNotifyMe").change(function() {
		
		$.ajax({
			type: "POST",
			url: "../scripts/comment.php",
			dataType: "JSON",
			data: {
				request: "subscribeForUpdate",
				usercode: '<?php echo $usercode ?>',
				storyCode: '<?php echo $story_code ?>',
				chapter: '<?php echo $chapter ?>'
			},
			success: function(response) {
				
				if(response.status == "success") {
					
					checkSubscribe();
					
				}
				
			},
			error: function(response) {
				alert(JSON.stringify(response) );
			}
		});
	
	});

	$("#icnUpvote").click(function() {
		
		$("#icnUpvote #svgHolder").html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M6 12c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zm9 0c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zm9 0c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z"/></svg>');
					
		$.ajax({
			type: "POST",
			url: "../scripts/comment.php",
			dataType: "JSON",
			data: {
				request: "upvote",
				usercode: '<?php echo $usercode ?>',
				storyCode: '<?php echo $story_code ?>',
				chapter: '<?php echo $chapter ?>'
			},
			success: function(response) {
				
				if(response.status == "success") {
					
					loadUpvotes();
					
				}
				
			},
			error: function(response) {
				alert(JSON.stringify(response) );
			}
		});
	
	});

	$("#icnFavourite").click(function() {
		
		$("#icnFavourite #svgHolder").html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M6 12c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zm9 0c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zm9 0c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z"/></svg>');
					
		$.ajax({
			type: "POST",
			url: "../scripts/comment.php",
			dataType: "JSON",
			data: {
				request: "favourite",
				usercode: '<?php echo $usercode ?>',
				storyCode: '<?php echo $story_code ?>',
				chapter: '<?php echo $chapter ?>'
			},
			success: function(response) {
				
				if(response.status == "success") {
					
					checkIfFavourite();
					
				}
				
			},
			error: function(response) {
			//	alert(JSON.stringify(response) );
			}
		});
	
	});

	$("#icnBookmark").click(function() {
		
		$("#icnBookmark #svgHolder").html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M6 12c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zm9 0c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zm9 0c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z"/></svg>');
					
		$.ajax({
			type: "POST",
			url: "../scripts/comment.php",
			dataType: "JSON",
			data: {
				request: "bookmark",
				usercode: '<?php echo $usercode ?>',
				storyCode: '<?php echo $story_code ?>',
				chapter: '<?php echo $chapter ?>'
			},
			success: function(response) {
				
				if(response.status == "success") {
					
					checkIfBookmarked();
					
				}
				
			},
			error: function(response) {
				alert(JSON.stringify(response) );
			}
		});
	
	});

	$("#frmComment").submit(function() {
		
		event.preventDefault();
		
		$.ajax({
			type: "POST",
			url: "../scripts/comment.php",
			dataType: "JSON",
			data: {
				request: "postComment",
				usercode: '<?php echo $usercode ?>',
				storyCode: '<?php echo $story_code ?>',
				chapter: '<?php echo $chapter ?>',
				comment: $("#txtComment").val()
			},
			success: function(response) {
				
				if(response.status == "success") {
					
					$("#txtComment").val("");
			
					loadComments();
					
				}
				
				else {
				
					alertInForm("Error uploading comment. Please try again");
				
				}
			
			},
			error: function(response) {
				
				alertInForm("Error uploading comment. Please try again");
				
			}
		});
	
	});

	function postReply(e, reply) {
	
		var commentId = $(e).parents(".commentBox").attr("id");
		
		event.preventDefault();
		
		$.ajax({
			type: "POST",
			url: "../scripts/comment.php",
			dataType: "JSON",
			data: {
				request: "postReply",
				usercode: '<?php echo $usercode ?>',
				storyCode: '<?php echo $story_code ?>',
				chapter: '<?php echo $chapter ?>',
				commentId: commentId,
				reply: reply
			},
			success: function(response) {
				
				if(response.status == "success") {
					
					loadReplies();
					
				}
				
				else {
				
					alertInForm("Error uploading reply. Please try again");
				
				}
			
			},
			error: function(response) {
				
				alertInForm("Error uploading reply. Please try again");
				
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