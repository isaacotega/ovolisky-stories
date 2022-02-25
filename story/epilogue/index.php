<?php
	
	$currentPage = "epilogue";
	
	require("../../scripts/story_details.php");
		
	$pageSpecs = array("title" => $title . " _ Epilogue", "description" => $title . " _ Epilogue : " . substr($epilogue, 0, 150) . " . . . About : " . substr($about, 0, 150) . " . . . ", "keywords" => $genre . ", " . implode(", ", $tags) );
	
	include("../../templates/header.php");
	
	$originalAuthorProfilePicture = "../../images/profile_pictures/" . $writer_usercode . ".jpg";
	
	$authorProfilePicture = file_exists($originalAuthorProfilePicture) ? $originalAuthorProfilePicture : $root . "images/templates/avatars/" . $authorGender . ".jpg";
	
?>
	
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
		
	<h1 id="title"><?php echo $title ?>  _ Epilogue</h1>
	
	<div id="aboutHolder">
	
		<label id="lblAbout">About</label>
		
			<?php echo "<p>" . str_replace("\n", "</p><p>", $about) . "</p>" ?>
			
		<label id="lblMore">More</label>
		
	</div>
		
	<div id="storyHolder">
	
		<?php echo "<p>" . str_replace("\n", "</p><p>", $epilogue) . "</p>" ?>
			
	</div>
	
	<br><br>
	
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
					
					<td><?php echo $upvotes ?> upvotes</td>
					
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

	var aboutHolderHeight = $("#aboutHolder").css("height");
	
	$("#aboutHolder").css("height", "10cm");
	
	$("#lblMore").click(function() {
		
		$(this).hide();
	
		$("#aboutHolder").css("height", aboutHolderHeight);
	
	});

</script>

<?php
	
	include("../../templates/footer.php");
	
?>