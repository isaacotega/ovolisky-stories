<div class="container">
	
	<h3>Recently read</h3>
	
	<div id="content">
	
		<?php
		
			$boxSpecs = array("type" => "readerDashboard", "sort" => "history");
	
			include("../scripts/box_lister.php");
	
		?>
		
	</div>
	
</div>

<div class="container">
	
	<h3>Your favourites</h3>
	
	<div id="content">
	
		<?php
		
			$boxSpecs = array("type" => "readerDashboard", "sort" => "favourites");
	
			include("../scripts/box_lister.php");
	
		?>
		
	</div>
	
</div>

<div class="container">
	
	<h3>Bookmarks</h3>
	
	<div id="content">
	
		<?php
		
			$boxSpecs = array("type" => "readerDashboard", "sort" => "bookmarks");
	
			include("../scripts/box_lister.php");
	
		?>
		
	</div>
	
</div>

<div class="container">
	
	<h3>Awaiting updates</h3>
	
	<div id="content">
	
		<?php
		
			$boxSpecs = array("type" => "readerDashboard", "sort" => "subscribes");
	
			include("../scripts/box_lister.php");
	
		?>
		
	</div>
	
</div>