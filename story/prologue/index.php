<?php
	
	$currentPage = "prologue";
	
	require("../../scripts/story_details.php");
		
	$pageSpecs = array("title" => $title . " _ Prologue", "description" => $title . " _ Prologue : " . substr($prologue, 0, 150) . " . . . About : " . substr($about, 0, 150) . " . . . ", "keywords" => $genre . ", " . implode(", ", $tags) );
	
	include("../../templates/header.php");
	
	$originalAuthorProfilePicture = "../../images/profile_pictures/" . $writer_usercode . ".jpg";
	
	$authorProfilePicture = file_exists($originalAuthorProfilePicture) ? $originalAuthorProfilePicture : $root . "images/templates/avatars/" . $authorGender . ".jpg";
	
?>
	
<link rel="stylesheet" href="../../styles/story_page.css">

<style>
	
	#main {
		text-align: center;
	}
	
	#aboutHolder {
		width: 96%;
		margin: 1cm 0;
		display: inline-block;
		text-align: left;
		position: relative;
		overflow: hidden;
		border-radius: 2%;
		box-shadow: 0 0 1mm 0 black;
		background-color: #FFF0E0;
	}
	
	#aboutHolder p {
		font-size: 25px;
		text-indent: 1cm;
	}
	
	#aboutHolder #lblMore {
		font-size: 35px;
		color: blue;
		position: absolute;
		bottom: 1cm;
		right: 1cm;
		display: block;
		font-weight: 700;
	}

	#aboutHolder #lblAbout {
		font-size: 40px;
		color: #250030;
		font-weight: 300;
		display: block;
		margin: 1cm;
	}

	#storyHolder {
		width: 96%;
		margin: 1cm 0;
		display: inline-block;
		text-align: left;
	}
	
	#storyHolder p {
		font-size: 25px;
		text-indent: 1cm;
	}
	
	#storyStatsHolder {
		width: 96%;
		margin: 1cm 0;
		display: inline-block;
		text-align: left;
		position: relative;
		overflow: hidden;
		border-radius: 2%;
		box-shadow: 0 0 1mm 0 black;
		background-color: #FFF0E0;
	}
	
	.heading {
		font-size: 40px;
		font-weight: 300;
		color: black;
		display: block;
		margin: 1cm;
	}
	
	#tagsHolder .tag {
		height: 1.5cm;
		line-height: 1.5cm;
		min-width: 3cm;
		text-align: center;
		border-radius: 10%;
		margin: 2mm;
		font-size: 25px;
		font-weight: 700;
		color: white;
		display: inline-block;
		background-color: #8D7B98;
	}
	
	#tagsHolder .tag:active {
		background-color: purple;
	}
	
	#tagsHolder #lblTags {
		background-color: indigo;
	}
	
	#authorBioHolder {
		height: 8cm;
		width: 96%;
		margin: 0 2%;
		display: inline-block;
		box-shadow: 0 0 3mm 0 black;
	}
	
	#imageHolder {
		height: 100%;
		width: 30%;
		position: relative;
		display: inline-block;
	}
	
	#imageHolder img {
		height: 5cm;
		width: 5cm;
		border-radius: 50%;
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translateX(-50%) translateY(-50%);
		display: inline-block;
		box-shadow: 0 0 1mm 0 black;
	}
	
	#bioHolder {
		height: 100%;
		width: 68%;
		display: inline-block;
		float: right;
		overflow: hidden;
	}
	
	#bioHolder #authorName {
		font-size: 40px;
		font-weight: 700;
		line-height: 2cm;
		color: black;
		display: block;
	}
	
	#bioHolder #authorBio p {
		font-size: 25px;
		color: black;
		display: block;
		text-indent: 1cm;
	}
	
	#tblStoryDescription {
		width: 90%;
		margin: 0 5%;
		font-size: 25px;
	}
	
</style>
	
<div id="main">
		
	<h1 id="title"><?php echo $title ?>  _ Prologue</h1>
	
	<h2 id="nick">~~<?php echo $nick ?>~~</h2>
	
	<div id="aboutHolder">
	
		<label id="lblAbout">About</label>
		
			<?php echo "<p>" . str_replace("\n", "</p><p>", $about) . "</p>" ?>
			
		<label id="lblMore">More</label>
		
	</div>
		
	<div id="storyHolder">
	
		<?php echo "<p>" . str_replace("\n", "</p><p>", $prologue) . "</p>" ?>
			
	</div>
	
	<hr>
	<!--
	<div id="menuBar">
		
		<table>
		
			<tr>
			
				<td id="icnUpvote"> <span id="svgHolder"> </span> <span id="upvotesNo" class="number"></span></td>
			
				<td id="icnSubscribe"> <span id="svgHolder"> </span> </td>
			
			</tr>
		
		</table>
		
	</div>
	
	<hr>
	-->
	<br><br>
	
	<?php
		
		if($storyHasBegun) {
		
			echo '<a href="../?id=' . $story_code . '&c=1">
		
				<button class="navigationBtn">Start Reading >></button>
			
			</a>';
			
		}
		
		else {
		
			echo '<div id="divPendingUpdate">Pending Update</div><hr>';
			
		}
		
	?>
	
	<div id="storyStatsHolder">
		
		<label class="heading">Story Description</label>
				
		<div id="description">
			
			<table id="tblStoryDescription">
			
				<tr>
				
					<td>Name:</td>
					
					<td><?php echo $title ?></td>
					
				</tr>
				
				<tr>
				
					<td>Genre:</td>
					
					<td><?php echo $genre ?></td>
					
				</tr>
				
				<tr>
				
					<td>Views:</td>
					
					<td><?php echo $views ?> views</td>
					
				</tr>
				
				<tr>
				
					<td>Upvotes:</td>
					
					<td><label id="aboutUpvoteNo"></label> upvotes</td>
					
				</tr>
				
				<tr>
				
					<td>Status:</td>
					
					<td><?php echo $status ?></td>
					
				</tr>
				
				<tr>
				
					<td>Date Posted:</td>
					
					<td><?php echo $accept_date ?></td>
					
				</tr>
				
				<tr>
				
					<td>Last Updated:</td>
					
					<td><?php echo $lastUpdateDate . " " . $lastUpdateTime ?></td>
					
				</tr>
				
			</table>
		
		</div>
		
		<br><br>
			
		<label class="heading">About the author</label>
				
		<div id="authorBioHolder">
			
			<div id="imageHolder">
		
				<a href="../../profile?id=<?php echo $writer_usercode ?>">
		
					<img src="<?php echo $authorProfilePicture; ?>"></img>
					
				</a>
				
			</div>
			
			<div id="bioHolder">
		
				<label class="tag" id="authorName"><?php echo $authorFirstName . " " . $authorLastName; ?></label>
				
				<label class="tag" id="authorBio"> <p><?php echo str_replace("\n", "</p><p>", $authorBio); ?></p> </label>
				
			</div>
	
		</div>
		
		<br><br>
			
		<label class="heading">Tags</label>
				
		<div id="tagsHolder">
		
			<label class="tag" id="lblTags">Tags</label>
	
			<?php
			
				foreach($tags as $tag) {
				
					echo '<a href="../../all_stories?q=' . $tag . '"> <label class="tag">' . $tag . '</label> </a>';
			
				}
				
			?>
		
		</div>
			
	</div>
	
	<div id="divMoreFromAuthor">
	
		<label class="heading">More from this author</label>
				
		<?php
		
			$boxSpecs = array("type" => "author", "usercode" => $writer_usercode, "limit" => 6);
		
			include("../../scripts/box_lister.php");
	
		?>
		
		<br><br>
		
		<a href="../../profile?id=<?php echo $writer_usercode ?>#stories">
		
			<button class="navigationBtn">More >></button>
			
		</a>
	
		<br><br><br><br><br><br><br><br><br><br><br>
		
	</div>
		
</div>

<script>
	
	<?php
		
//		$usercode = $isLoggedIn ? $usercode : "none";
	
	?>

	var aboutHolderHeight = $("#aboutHolder").css("height");
	
	$("#aboutHolder").css("height", "10cm");
	
	$("#lblMore").click(function() {
		
		$(this).hide();
	
		$("#aboutHolder").css("height", aboutHolderHeight);
	
	});
	/*
	checkSubscribe();
	
	loadUpvotes();
	
	function loadUpvotes() {
			
		$.ajax({
			type: "POST",
			url: "../../scripts/comment.php",
			dataType: "JSON",
			data: {
				request: "loadUpvotes",
				storyCode: '<?php echo $story_code ?>',
				chapter: '0',
				usercode: '<?php echo $usercode ?>'
			},
			success: function(response) {
				
				if(response.status == "success") {
				
					var upvotes = response.upvotes;
					
					$("#upvotesNo").html(upvotes);
					
					$("#aboutUpvoteNo").html(upvotes);
					
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
				
				alert(JSON.stringify(response))
			
			}
		});
	
	}

	function checkSubscribe() {
			
		$.ajax({
			type: "POST",
			url: "../../scripts/comment.php",
			dataType: "JSON",
			data: {
				request: "checkSubscribe",
				storyCode: '<?php echo $story_code ?>',
				usercode: '<?php echo $usercode ?>'
			},
			success: function(response) {
				
				if(response.status == "success") {
				
					if(response.isSubscribed == "true") {
						
						$("#icnSubscribe #svgHolder").html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: blue"><path d="M15.137 3.945c-.644-.374-1.042-1.07-1.041-1.82v-.003c.001-1.172-.938-2.122-2.096-2.122s-2.097.95-2.097 2.122v.003c.001.751-.396 1.446-1.041 1.82-4.667 2.712-1.985 11.715-6.862 13.306v1.749h20v-1.749c-4.877-1.591-2.195-10.594-6.863-13.306zm-3.137-2.945c.552 0 1 .449 1 1 0 .552-.448 1-1 1s-1-.448-1-1c0-.551.448-1 1-1zm3 20c0 1.598-1.392 3-2.971 3s-3.029-1.402-3.029-3h6z"/></svg>');
					
					}
				
					else if(response.isSubscribed == "false") {
						
						$("#icnSubscribe #svgHolder").html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: black"><path d="M15.137 3.945c-.644-.374-1.042-1.07-1.041-1.82v-.003c.001-1.172-.938-2.122-2.096-2.122s-2.097.95-2.097 2.122v.003c.001.751-.396 1.446-1.041 1.82-4.667 2.712-1.985 11.715-6.862 13.306v1.749h20v-1.749c-4.877-1.591-2.195-10.594-6.863-13.306zm-3.137-2.945c.552 0 1 .449 1 1 0 .552-.448 1-1 1s-1-.448-1-1c0-.551.448-1 1-1zm3 20c0 1.598-1.392 3-2.971 3s-3.029-1.402-3.029-3h6z"/></svg>');
					
					}
				
					else {}
				
				}
				
			},
			error: function(response) {
				
				alert(JSON.stringify(response))
			
			}
		});
	
	}
	
	$("#icnUpvote").click(function() {
		
		$("#icnUpvote #svgHolder").html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M6 12c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zm9 0c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zm9 0c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z"/></svg>');
					
		$.ajax({
			type: "POST",
			url: "../../scripts/comment.php",
			dataType: "JSON",
			data: {
				request: "upvote",
				usercode: '<?php echo $usercode ?>',
				storyCode: '<?php echo $story_code ?>',
				chapter: '0'
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
	$("#icnSubscribe").click(function() {
		
		$("#icnSubscribe #svgHolder").html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M6 12c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zm9 0c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zm9 0c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z"/></svg>');
					
		$.ajax({
			type: "POST",
			url: "../../scripts/comment.php",
			dataType: "JSON",
			data: {
				request: "subscribeForUpdate",
				usercode: '<?php echo $usercode ?>',
				storyCode: '<?php echo $story_code ?>',
				chapter: '0'
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
*/
</script>

<?php
	
	include("../../templates/footer.php");
	
?>