<div class="container">
	
	<h3>Ongoing Stories</h3>
	
	<div id="content">
	
		<?php
		
			$boxSpecs = array("type" => "writerDashboard", "sort" => "ongoing", "anc" => "story/prologue?id=");
	
			include("../scripts/box_lister.php");
	
		?>
		
	</div>
	
</div>

<div class="container">
	
	<h3>Completed Stories</h3>
	
	<div id="content">
	
		<?php
		
			$boxSpecs = array("type" => "writerDashboard", "sort" => "completed", "anc" => "story/prologue?id=");
	
			include("../scripts/box_lister.php");
	
		?>
		
	</div>
	
</div>

<div class="container">
	
	<h3>Pending Stories</h3>
	
	<div id="content">
	
		<?php
		
			$boxSpecs = array("type" => "writerDashboard", "sort" => "pending", "anc" => "story/prologue?id=");
	
			include("../scripts/box_lister.php");
	
		?>
		
	</div>
	
</div>



<script>

</script>