<?php
	
	$path = $_SERVER["REQUEST_URI"];
	
	$rootSelection = array("", "../", "../../", "../../../");
	/* Original 
	$root = $rootSelection[count( explode("/", $path) ) - 2];
*/
// temporary
	$root = $rootSelection[count( explode("/", $path) ) - 3];
	
	include($root . "scripts/register.php");
	
	$currentUrl = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

	$domain = file_get_contents($root . "templates/domain.txt");

	$fullUrl = file_get_contents($root . "templates/fullUrl.txt");
	
	$iconPath = $root . "images/favicon.jpg";
	
	date_default_timezone_set("Africa/Lagos");
	
	include($root . "scripts/account_details.php");
	
	isset($pageSpecs["restricted"]) ? ($pageSpecs["restricted"] && !$isLoggedIn ? die(header("Location: " . $root . "login?return=" . urlencode($currentUrl))) : "") : "";
	
	
	if($isLoggedIn) {
	
		$originalProfilePic = $root . "images/profile_pictures/" . $usercode . ".jpg";
	
		$profilePic = file_exists($originalProfilePic) ? $originalProfilePic : $root . "images/templates/avatars/" . $gender . ".jpg";
		
	}
		
	if($isLoggedIn) {
	
		require($root . "scripts/connection.php");
		
		$sql = "SELECT * FROM notifications WHERE receiver_usercode = '$usercode' AND seen = 'false' ";
		
		if($result = mysqli_query($conn, $sql)) {
		
			$unreadNotifications = mysqli_num_rows($result);
		
		}
	
		$accountContent = '
		
		<a class="sideLinks" id="slkAccount">Account</a>
		
		<a href="' . $root . 'profile?id=' . $usercode . '" class="sideLinks" category="accountSideLinks">My Profile</a>
		
		<a href="' . $root . 'dashboard?id=' . $_COOKIE["247rdsck"] . '" class="sideLinks" category="accountSideLinks">My Dashboard</a>
		
		<a href="' . $root . 'notifications" class="sideLinks" category="accountSideLinks">Notifications(' . $unreadNotifications . ')</a>
	
		<a href="' . $root . 'logout?n=' . urlencode($currentUrl) . '" class="sideLinks" category="accountSideLinks">Logout</a>';
	
	}
	
	else {
	
		$accountContent = '<a href="' . $root . '/login" class="sideLinks">Login</a>';
	
	}
	
	$topBar = '<div id="topBar">

	 	<span id="navIcon">&#9776;</span>' .

	 	(isset($pageSpecs["chapterNav"]) ? ($pageSpecs["chapterNav"] ? '<span id="chapterNavIcon">&#9776;</span>' : "") : "")

	  	. '<label id="heading">' . $domain . '</label>'
	  	
	  	. ($isLoggedIn ? '<a href="' . $root . 'profile?id=' . $usercode . '"> <img id="topProfilePic" src="' . $profilePic . '"></img> </a>' : "") .
	  	
	  	($isLoggedIn ? ($unreadNotifications !== 0 ? '<a href="' . $root . 'notifications"> <span id="notificationIcon"> <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"><path d="M10.771 22c-.646.646-1.535 1-2.422 1-.874 0-1.746-.346-2.376-.976-1.27-1.27-1.308-3.563-.024-4.846l4.822 4.822zm11.887-15.617c-.217-.817.023-1.696.627-2.299l.002-.003c.475-.474.713-1.095.713-1.713 0-1.313-1.057-2.368-2.369-2.368-.617 0-1.238.238-1.713.712l-.003.003c-.604.605-1.48.845-2.299.627-5.93-1.572-11.012 7.819-16.211 5.177l-1.405 1.406 16.075 16.075 1.405-1.406c-2.64-5.198 6.751-10.279 5.178-16.211zm-15.096 4.282l-1.511-1.512c3.202-1.204 7.949-6.537 11.676-5.451-3.078.245-6.794 5.267-10.165 6.963zm13.334-7.562c-.442-.443-.444-1.164 0-1.606s1.164-.444 1.607-.001c.444.444.444 1.166 0 1.608s-1.162.442-1.607-.001z"/></svg> <button class="iconNumber">' . $unreadNotifications . '</button> </span> </a>' : "") : "") . 
	 	
 	'</div>';
	
	$sideNav = '<div id="sideNav">
	
		<br><br><br><br><br><br><br>
	
		<a href="' . $root . '" class="sideLinks">Home</a>
		
		<a href="' . $root . '/genres" class="sideLinks">Genres</a>'
		
		. $accountContent . 
		
		'<a href="' . $root . '/publish" class="sideLinks">Publish</a>
	
	</div>';
	
	if(isset($pageSpecs["chapterNav"])) {
	
		if($pageSpecs["chapterNav"]) {

			$chapterNav = '<div id="chapterNav"> <br><br><br><br><br><br><br>';
	
			for($i = 0; $i < $lastChapter; $i++) {
			
				$sideChapter = $i + 1;
		
				$chapterNav .= '<a href="' . $root . 'story?id=' . $id . '&c=' . $sideChapter . '" class="sideLinks">Chapter ' . $sideChapter . '</a>';
		
			}
	
			$chapterNav .= '</div>';
	
		}
	
	}
	
	$description = (isset($pageSpecs["description"]) ? $pageSpecs["description"] : "Read stories at " . $fullUrl . " for free. All genres.");
	
	$keywords = (isset($pageSpecs["keywords"]) ? "story, " . $pageSpecs["keywords"] : "story, stories, read, write, publish, all genres, genres, action, adventure, mystery, thriller, love, romance, teenage fiction, science fiction, sci-fi, fantasy, short story, short stories, humour, emotional, nigerian stories");

?>

<!DOCTYPE html>

  <html> 

	<head>

		<link rel="stylesheet" href="<?php echo $root ?>styles/index.css">
		
		<link rel="icon" href="<?php echo $iconPath; ?>">

		<title><?php echo $pageSpecs["title"] . " - " . $fullUrl; ?></title>
		
		<meta charset="utf-8">
		
		<meta name="description" content="<?php echo $description; ?>">
		
		<meta name=”keywords” content="<?php echo $keywords; ?>">
		
		<meta name=”robots” content="index, follow">
		
		<script src="<?php echo $root ?>scripts/JQuery.js"></script>

		<script src="<?php echo $root ?>templates/templates.js"></script>

		<script src="<?php echo $root ?>scripts/main.js"></script>

	</head> 

	<body>
	
	<?php
	
		echo isset($pageSpecs["sideNav"]) ? ($pageSpecs["sideNav"] ? $sideNav : "") : $sideNav;
		
		echo isset($pageSpecs["topBar"]) ? ($pageSpecs["topBar"] ? $topBar : "") : $topBar;
		
		echo isset($pageSpecs["chapterNav"]) ? ($pageSpecs["chapterNav"] ? $chapterNav : "") : "";
		
	?>