<?php
		
	$pageSpecs = array("title" => "Mystery and Thriller");
	
	include("../../templates/header.php");
	
?>
	
<style>
	
	#main {
		text-align: center;
	}
	
	#btnPrev {
		float: left;
	}

	</style>
	
<div id="main">
		
	<h1 id="title">Mystery and Thriller</h1>
	
	<div id="storyHolder">
	
	<?php
		
		$boxSpecs = array("genre" => "Mystery and Thriller");
		
		if(include("../../scripts/box_lister.php")) {
		
			echo "<br><br><br><br><br><div>";
		
			if($start !== 0) {
			
				echo '<a href="?p=' . ($start / 10) . '">
		
					<button class="navigationBtn" id="btnPrev"><< Previous page</button>
			
				</a>';
			
			}
		
			if($numRows == $boxLimit) {
			
				echo '<a href="?p=' . (($start / 10) + 2) . '">
		
					<button class="navigationBtn" id="btnNext">Next page >></button>
			
				</a>';
			
			}
		
			echo "</div>";
		
		}
	
	?>
	
	</div>
	
	<br><br><br><br><br><br><br><br><br><br>
		
</div>

<?php
	
	include("../../templates/footer.php");
	
?>