<?php
	
	$defaultSearchText = "Search for a story";
	
	$defaultGenre = "All";
	
	isset($_GET["q"]) or die(header("Location: ?q=" . $defaultSearchText . "&sort=popular&genre=" . $defaultGenre));
		
//	!empty($_GET["q"]) or die(header("Location: ?q=" . $defaultSearchText . "&sort=popular&genre=" . $defaultGenre));
		
	$q = $_GET["q"];
		
	isset($_GET["sort"]) or die(header("Location: ?q=" . $q . "&sort=popular&genre=" . $defaultGenre));
		
	!empty($_GET["sort"]) or die(header("Location: ?sort=" . $q . "&sort=popular&genre=" . $defaultGenre));
	
	$sort = $_GET["sort"];
		
	isset($_GET["genre"]) or die(header("Location: ?q=" . $q . "&sort=" . $sort . "&genre=" . $defaultGenre));
		
	!empty($_GET["genre"]) or die(header("Location: ?sort=" . $q . "&sort=" . $sort . "&genre=" . $defaultGenre));
	
	$genre = $_GET["genre"];
		
	$pageSpecs = array("title" => "All Stories");
	
	include("../templates/header.php");
	
	require("../scripts/connection.php");
	
?>
	
<style>
	
	#main {
		text-align: center;
	}
	
	.lblSlt {
		display: block;
		width: 100%;
		height: 3cm;
		background-color: #FFF0F0;
		box-shadow: 0 0 5px 0 black;
		font-size: 30px;
		font-weight: 700;
		color: black;
		line-height: 3cm;
	}

	.slt {
		width: 70%;
		height: 90%;
		background-color: white;
		font-size: 30px;
		font-weight: 700;
		color: black;
		float: right;
		margin: 2mm;
	}

</style>
	
<div id="main">
		
	<h1 id="title">All Stories</h1>
	
	<div id="toolBox">
	
		<form>
		
		<input class="searchInput" id="inpSearch" type="search" name="q" placeholder="<?php echo $defaultSearchText; ?>" value="<?php echo $q; ?>">
		
		</form>
	
		<label id="lblSort" class="lblSlt">Sort by:
	
			<select id="sltSort" class="slt">
				
				<option <?php echo strtolower($sort) == "popular" ? "selected" : ""; ?>>Popular</option>
				
				<option <?php echo strtolower($sort) == "trending" ? "selected" : ""; ?>>Trending</option>
				
				<option <?php echo strtolower($sort) == "ongoing" ? "selected" : ""; ?>>Ongoing</option>
				
				<option <?php echo strtolower($sort) == "completed" ? "selected" : ""; ?>>Completed</option>
				
				<option <?php echo strtolower($sort) == "random" ? "selected" : ""; ?>>Random</option>
				
			</select>
			
		</label>
		
		<br>
	
		<label id="lblGenre" class="lblSlt">Genre:
	
			<select id="sltGenre" class="slt">
				
				<option>All</option>
				
				<?php
				
					$sql = "SELECT * FROM genres";
					
					if($result = mysqli_query($conn, $sql)) {
					
						while($row = mysqli_fetch_array($result)) {
							
							$sltAttr = strtolower($row["genre"]) == strtolower($genre) ? "selected" : "";
						
							echo '<option ' . $sltAttr . '>' . $row["genre"] . '</option>';
						
						}
					
					}
				
				?>

			</select>
			
		</label>
	
	</div>
	
	<br><hr>
	
	<?php
	
		echo ($q !== $defaultSearchText && $q !== "") ? '<h2> Search results for "' . $q . '"</h2>' : "";
	
	?>
	
	<div id="storyHolder">
	
	<?php
		
		$boxSpecs = array("type" => "allStories", "sort" => $sort, "genre" => $genre);
	
		include("../scripts/box_lister.php");
	
	?>
	
	</div>
		
</div>

<script>
	
	

	$("#sltSort").change(function() {
	
		window.location.href = "?q=<?php echo $q; ?>&sort=" + $(this).val() + "&genre=<?php echo $genre; ?>";
	
	});

	$("#sltGenre").change(function() {
	
		window.location.href = "?q=<?php echo $q; ?>&sort=<?php echo $sort; ?>&genre=" + $(this).val();
	
	});

</script>

<?php
	
	include("../templates/footer.php");
	
?>