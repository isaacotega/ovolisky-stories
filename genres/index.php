<?php
		
	$pageSpecs = array("title" => "Genres");
	
	include("../templates/header.php");
	
?>
	
<style>
	
	#main {
		text-align: center;
	}

	</style>
	
<div id="main">
		
	<h1 id="title">Genres</h1>
	
	<?php
		
		$boxSpecs = array("type" => "genre");
	
		include("../scripts/box_lister.php");
	
	?>
		
</div>

<?php
	
	include("../templates/footer.php");
	
?>