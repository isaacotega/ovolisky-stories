<?php
		
	$pageSpecs = array("title" => "About us");
	
	include("../templates/header.php");
	
?>
	
<style>
	
	#container {
		width: 100%;
		text-align: center;
	}

	#reservedRight {
		font-weight: 700;
		font-size: 15px;
		color: red;
	}

</style>

<div id="main">
		
<h1 id="title">About</h1>
	  
<br><br>

<label class="statement"><?php echo $domain; ?> is an online library dedicated to helping expert and guest authors publish their stories with ease. It provides an interactive platform by which writers can share their stories and get feedback in form of comments from readers.</label>

<br><br>

<label class="statement">Whether young or old, beginner or expert, you can find a place in this wonderful storyland!</label>

<br><br><br><br><br><br>

<div id="container">

	<label class="statement"><b><?php echo $domain; ?></b></label>
	
	<br><br>

	<label class="statement"><b>Copyright © <?php echo Date("Y") ?> <?php echo $domain; ?></b></label>
	
	<br><br>

	<label class="statement"><a href="<?php echo "http://" . $fullUrl; ?>"><?php echo $fullUrl; ?></a></label>
	
	<br><br>

	<label id="reservedRight">All Rights Reserved</label>
	
	<br><br>

</div>

<br><br><br><br>

</div>

<?php
	
	include("../templates/footer.php");
	
?>