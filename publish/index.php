<?php
		
	$pageSpecs = array("restricted" => true, "title" => "Publish", "footer" => false);
	
	include("../templates/header.php");
	
?>

<style>
	
	#container {
		text-align: center;
	}

	.chooseBox {
		background-color: #250030;
		color: white;
		width: 80%;
		height: 7cm;
		line-height: 7cm;
		margin: 1cm 0;
		transform: translateX(10%);
		border-radius: 5%;
		box-shadow: 0 0 5px 0 black;
		font-size: 40px;
		font-family: monaco;
		font-weight: 700;
	}

</style>

 <div id="main">
 
	<h1 id="title">What do you want to do?</h1>
	
	<div id="container">
		
		<a href="new_story">
	
			<div class="chooseBox">Publish a new story</div>
			
		</a>
		
		<a href="update_story/select_story">
	
			<div class="chooseBox">Update your story</div>
	
		</a>
		
		<a href="manage_story/select_story">
	
			<div class="chooseBox">Manage story</div>
	
		</a>
		
	</div>
	
 
 </div>
 
<?php
		
	include("../templates/footer.php");
	
?>