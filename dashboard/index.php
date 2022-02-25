<?php
		
	isset($_GET["type"]) or die(header("Location: ?type=reader"));
	
	$dashboardType = $_GET["type"];
	
	$dashboardType == "reader" || $dashboardType == "writer" or die(header("Location: ?type=reader"));
	
	require("../scripts/connection.php");
	
	require("../scripts/account_details.php");
	
	if($dashboardType == "writer") {
	
		$user["isWriter"] or die(header("Location: ?type=reader"));
		
	}
	
	$pageSpecs = array("title" => "User dashboard", "restricted" => true);
	
	include("../templates/header.php");
	
?>
	
<link rel="stylesheet" href="../styles/dashboard.css">
	
<style>
	
</style>

<div id="dashboardTypeSwitcher"><?php echo (!$user["isWriter"]) ? '<div class="typeHolder" id="selected">Reader</div>' : '<a href="?type=reader"> <div class="typeHolder" id="' . (($dashboardType == "reader") ? "selected" : "") . '">Reader</div> </a> <a href="?type=writer"> <div class="typeHolder" id="' . (($dashboardType == "writer") ? "selected" : "") . '">Writer</div> </a>'; ?></div>

<div id="main">
	
	<br><br><br>
		
	<h1 id="title">Dashboard</h1>
	
	<?php
	
		include ($dashboardType == "reader") ? "reader_dashboard.php" : "writer_dashboard.php";
		
	?>
	
	<br><br><br>

</div>

<?php
	
	include("../templates/footer.php");
	
?>