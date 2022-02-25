<?php
		
	require("../scripts/connection.php");
	
	function dropCard($row, $infoParams) {
	
		$storyCode = $row["story_code"];
				
		$genre = $row["genre"];
			
		$title = $row["title"];
			
		$upvotes = $row["upvotes"];
			
		$views = $row["views"];
			
		$info = '<label id="storyName">' . $title . '</label> <label id="storyGenre">' . $genre . '</label> <label id="upvotes">' . $upvotes . ' upvotes</label> <label id="views">' . $views . ' views</label>' . (isset($infoParams["lastUpdate"]) ? '<label id="lastUpdate">' . $infoParams["lastUpdate"] . '</label>' : '');
		
		$anc = "../story/prologue?id=" . $storyCode;
				
		$originalSrc = "../images/stories/". str_replace(" ", "_", strtolower($title)) . "_" .  $storyCode . ".jpg";
				
		$src = file_exists($originalSrc) ? $originalSrc : "../images/templates/story_cover.jpg";
		
		$items = array("@anc", "@src", "@alt", "@info");
				
		$replacements = array($anc, $src, $title, $info);
		
		echo '<li>';

		echo str_replace($items, $replacements, file_get_contents("../templates/card.html"));
				
		echo '</li>';

	}
	
	function dropGenre($row) {
	
		$genre = $row["genre"];
			
		$info = '<label id="genreName">' . $genre . '</label>';
				
		$anc = "../genres/" . str_replace(" ", "_", strtolower($row["genre"]));
		
		$originalSrc = "../images/genres/" . str_replace(" ", "_", strtolower($row["genre"])) . ".jpg";
				
		$src = file_exists($originalSrc) ? $originalSrc : "../images/genres/default.jpg";
		
		$items = array("@anc", "@src", "@alt", "@info");
				
		$replacements = array($anc, $src, $genre, $info);
		
		echo '<li>';

		echo str_replace($items, $replacements, file_get_contents("../templates/card.html"));
				
		echo '</li>';

	}
	
	$pageSpecs = array("title" => "Home");
	
	include("../templates/header.php");
	
?>
	
	<link rel="stylesheet" href="../styles/homepage.css">
	
	<div id="main">
		
		<h1>The Home of Mind-Blowing Stories</h1>
					
		<div id="topQuickLinks">
			
			<a>
		
				<button class="btnQuickLink" scrollto="divLatestStories">Latest Stories</button>
				
			</a>
		
			<a>
		
				<button class="btnQuickLink" scrollto="divTrendingStories">Trending Stories</button>
				
			</a>
		
			<a>
		
				<button class="btnQuickLink" scrollto="divOngoingStories">Ongoing Stories</button>
				
			</a>
		
			<a>
		
				<button class="btnQuickLink" scrollto="divCompletedStories">Completed Stories</button>
				
			</a>
		
			<a href="../all_stories">
		
				<button class="btnQuickLink">All Stories</button>
				
			</a>
		
			<a>
		
				<button class="btnQuickLink" scrollto="divGenres">Genres</button>
				
			</a>
		
			<a>
		
				<button class="btnQuickLink" scrollto="divSearchForStories">Search</button>
				
			</a>
		
			<a>
		
				<button class="btnQuickLink" scrollto="divBecomeAnAuthor">Publish</button>
				
			</a>
		
		</div>
		
		<hr>
	
		<div class="container" id="divLatestStories">
			
			<ul class="undotted">
							
			<h3>Latest Stories</h3>
					
			<?php
			
				$info = array();
			
				$sql = "SELECT * FROM story_stats WHERE state = 'approved' ORDER BY accept_date LIMIT 10 ";
	
				if($result = mysqli_query($conn, $sql)) {
	
					while($row = mysqli_fetch_array($result)) {	
					
						dropCard($row, $info);
					
					}
	
				}
			
			?>
		
			</ul><br><br>

		</div>
		
		<hr>
	
		<div class="container" id="divRecentlyUpdatedStories">
			
			<ul class="undotted">
							
			<h3>Recently Updated Stories</h3>
					
			<?php
				
				$sql = "SELECT DISTINCT story_code FROM chapters ORDER BY date DESC, time DESC LIMIT 15 ";
	
				if($result = mysqli_query($conn, $sql)) {
	
					while($row = mysqli_fetch_array($result)) {
						
						$storyCode = $row["story_code"];
						
						$sql3 = "SELECT date, time FROM chapters WHERE story_code = '$storyCode' ORDER BY date DESC, time DESC LIMIT 1 ";
						
						if($result3 = mysqli_query($conn, $sql3)) {
						
							$row3 = mysqli_fetch_array($result3);
						
							$lastUpdate = $row3["date"] . " | " . $row3["time"];
						
						}
						
						$info = array("lastUpdate" => $lastUpdate);
			
						$sql2 = "SELECT * FROM story_stats WHERE story_code = '$storyCode' ";
	
						if($result2 = mysqli_query($conn, $sql2)) {
	
							if($row2 = mysqli_fetch_array($result2)) {	
					
								dropCard($row2, $info);
					
							}
					
						}
						
					}
	
				}
			
			?>
		
			</ul><br><br>

		</div>
		
		<hr>
	
		<div class="container" id="divTrendingStories">
			
			<ul class="undotted">
							
			<h3>Trending Stories</h3>
					
			<?php
			
				$info = array();
			 
				$sql = "SELECT * FROM story_stats WHERE state = 'approved' ORDER BY upvotes LIMIT 10 ";
	
				if($result = mysqli_query($conn, $sql)) {
	
					while($row = mysqli_fetch_array($result)) {	
					
						dropCard($row, $info);
					
					}
	
				}
			
			?>
		
			</ul><br><br>

		</div>
		
		<hr>
	
		<div class="container" id="divOngoingStories">
			
			<ul class="undotted">
							
			<h3>Ongoing Stories</h3>
					
			<?php
			
				$info = array();
			
				$sql = "SELECT * FROM story_stats WHERE status = 'ongoing' AND state = 'approved' ORDER BY views LIMIT 10 ";
	
				if($result = mysqli_query($conn, $sql)) {
	
					while($row = mysqli_fetch_array($result)) {	
					
						dropCard($row, $info);
					
					}
	
				}
			
			?>
		
			</ul><br><br>

		</div>
		
		<hr>
	
		<div class="container" id="divCompletedStories">
			
			<ul class="undotted">
							
			<h3>Completed Stories</h3>
					
			<?php
			
				$info = array();
			
				$sql = "SELECT * FROM story_stats WHERE status = 'ended' AND state = 'approved' ORDER BY views LIMIT 10 ";
	
				if($result = mysqli_query($conn, $sql)) {
	
					while($row = mysqli_fetch_array($result)) {	
					
						dropCard($row, $info);
					
					}
	
				}
			
			?>
		
			</ul><br><br>

		</div>
		
		<hr>
	
		<div class="container" id="divGenres">
			
			<ul class="undotted">
							
			<h3>By Genre</h3>
					
			<?php
			
				$info = array("isGenre" => true);
			
				$sql = "SELECT * FROM genres";
	
				if($result = mysqli_query($conn, $sql)) {
	
					while($row = mysqli_fetch_array($result)) {	
					
						dropGenre($row, $info);
					
					}
	
				}
			
			?>
		
			</ul><br><br>

		</div>
		
		<hr>
	
		<div class="container" id="divSearchForStories">
			
			<h3>Search for stories</h3>
					
			<form action="../all_stories">
		
				<input class="searchInput" id="inpSearch" type="search" name="q" placeholder="Search for a story">
		
			</form>
	
		</div>

		<br><br><hr>
		
		<div class="container" id="divBecomeAnAuthor">
			
			<ul class="undotted">
							
			<h3>Become an Author Today</h3>
					
			<p class="statement">Are you an aspiring author seeking for a place to put your talent to use? Or are you just a reader of novels who feels you have what it takes to be a great writer?</p>
			
			<p class="statement">Join a team of authors who turn their imaginations into realities.</p>

			<br>

			<a href="../publish/new_story">
				
				<button class="navigationBtn" id="btnStartPublishing">Start Publishing</button>
			
			</a>
			
			<br><br><br><br><br><br>
	
		</div>

		<hr>
	
	</div>
	
	<script>
		
		$(".btnQuickLink").click(function() {
		
			$(document.body).animate({
				'scrollTop': $("#" + $(this).attr("scrollto")).offset().top - 150
			}, 800);
		
		});
	
	</script>
	
<?php
	
	include("../templates/footer.php");
	
?>