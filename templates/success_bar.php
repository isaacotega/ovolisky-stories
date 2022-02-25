<?php
	
	$backgroundColor = $successBarSpecs["type"] == "success" ? "lightgreen" : $successBarSpecs["backgroundColor"];
	
	$imgSrc = $successBarSpecs["type"] == "success" ? $root . "images/templates/success_mark.jpg" : $successBarSpecs["imgSrc"];
	
	$message = $successBarSpecs["message"];
	
?>

<div class="successBar" style="background-color: <?php echo $backgroundColor; ?>">
 	
 	<div id="iconHolder">
 	
 		<img src="<?php echo $imgSrc; ?>"></img>
 	
 	</div>
 	
 	<div id="messageHolder"><?php echo $message; ?></div>
 	
 </div>