<?php
		
	$pageSpecs = array("restricted" => true, "title" => "Select story for editing");
	
	include("../../../scripts/account_details.php");
	
	include("../../../templates/header.php");
	
?>
	
<style>
	
	#main {
		text-align: center;
	}

	</style>
	
<div id="main">
		
	<h1 id="title">Select the story you wish to manage</h1>
	
	<?php
		
		$boxSpecs = array("type" => "myStories", "sort" => "ongoing", "anc" => "publish/manage_story?id=");
	
		include("../../../scripts/box_lister.php");
	
	?>
		
</div>

<?php
	
	include("../../../templates/footer.php");
	
?>