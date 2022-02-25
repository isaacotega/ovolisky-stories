<?php
	
	require("connection.php");
	
	$type = isset($boxSpecs["type"]) ? $boxSpecs["type"] : "story";
	
	
	if($type == "genre") {
	
		$sql = "SELECT * FROM genres ";
		
		if($result = mysqli_query($conn, $sql)) {
		
			while($row = mysqli_fetch_array($result)) {
			
				$genre = $row["genre"];
				
				$info = '<label id="lblCategory">' . $genre . '</label>';
		
				$originalSrc = $root . "images/genres/" . str_replace(" ", "_", strtolower($genre)) . ".jpg";
				
				$src = file_exists($originalSrc) ? $originalSrc : "../images/genres/default.jpg";
		
				$items = array("@anc", "@src", "@alt", "@info");
				
				$replacements = array(str_replace(" ", "_", strtolower($genre)), $src, $genre, $info);
		
				echo str_replace($items, $replacements, file_get_contents($root . "templates/box.html"));
				
			}
		
		}
	
	}
	
	else if($type == "allStories") {
		
		$boxLimit = 50;
		
		$start = isset($_GET["p"]) ? ($_GET["p"] - 1) * $boxLimit  : 0;
		
		$searchWord = ($q !== $defaultSearchText ? mysqli_real_escape_string($conn, trim($q)) : "");
		
		$sql = "SELECT * FROM story_stats WHERE state = 'approved' AND title LIKE '%$searchWord%' OR tags LIKE '%$searchWord%'  " . ((strtolower($sort) == "ongoing") ? 'AND status = \'ongoing\' ' : "") . ((strtolower($sort) == "completed") ? 'AND status = \'ended\' ' : "") . ((strtolower($genre) !== "all") ? 'AND genre = \'' . $genre . '\' ' : "") .  ((strtolower($sort) == "trending") ? 'ORDER BY upvotes, views ' : "") .  ((strtolower($sort) == "popular") ? 'ORDER BY views, upvotes ' : "") .  ((strtolower($sort) == "random") ? 'ORDER BY RAND() ' : "") . " LIMIT $start, $boxLimit ";
		
	//	echo $sql;
		
		if($result = mysqli_query($conn, $sql)) {
			
			$numRows = mysqli_num_rows($result);
			
			if($numRows == 0) {
				
				echo '<script> placeholder("#storyHolder", "No story found!"); </script>';
			
				return;
				
			}
		
			while($row = mysqli_fetch_array($result)) {
				
				$storyCode = $row["story_code"];
			
				$title = $row["title"];
			
				$storyGenre = $row["genre"];
			
				$upvotes = $row["upvotes"];
			
				$views = $row["views"];
			
				$info = '<label id="storyName">' . $title . '</label> <label id="storyGenre">' . $storyGenre . '</label> <label id="upvotes">' . $upvotes . ' upvotes</label> <label id="views">' . $views . ' views</label>';
				
				$originalSrc = $root . "images/stories/". str_replace(" ", "_", strtolower($title)) . "_" .  $storyCode . ".jpg";
				
				$src = file_exists($originalSrc) ? $originalSrc : $root . "images/templates/story_cover.jpg";
		
				$items = array("@anc", "@src", "@alt", "@info");
				
				$replacements = array($root . "story/prologue?id=" . $storyCode, $src, $title, $info);
		
				echo str_replace($items, $replacements, file_get_contents($root . "templates/box.html"));
				
			}
			
		}
			
	}
	
	else if($type == "story") {
		
		$boxLimit = 10;
		
		$start = isset($_GET["p"]) ? ($_GET["p"] - 1) * $boxLimit  : 0;
		
		$genre = $boxSpecs["genre"];
	
		$sql = "SELECT * FROM story_stats WHERE genre = '$genre' AND state = 'approved' LIMIT $start, $boxLimit ";
		
		if($result = mysqli_query($conn, $sql)) {
			
			$numRows = mysqli_num_rows($result);
		
			if($numRows == 0) {
				
				echo '<script> placeholder("#storyHolder", \'No stories in this genre. <br><br> <a href="' . $root . 'publish/new_story">Be the first to publish!</a>\'); </script>';
			
				return;
				
			}
		
			while($row = mysqli_fetch_array($result)) {
				
				$storyCode = $row["story_code"];
			
				$title = $row["title"];
			
				$upvotes = $row["upvotes"];
			
				$views = $row["views"];
			
				$info = '<label id="storyName">' . $title . '</label> <label id="storyGenre">' . $genre . '</label> <label id="upvotes">' . $upvotes . ' upvotes</label> <label id="upvotes">' . $views . ' views</label>';
				
				$originalSrc = $root . "images/stories/". str_replace(" ", "_", strtolower($title)) . "_" .  $storyCode . ".jpg";
				
				$src = file_exists($originalSrc) ? $originalSrc : $root . "images/templates/story_cover.jpg";
		
				$items = array("@anc", "@src", "@alt", "@info");
				
				$replacements = array($root . "story/prologue?id=" . $storyCode, $src, $title, $info);
		
				echo str_replace($items, $replacements, file_get_contents($root . "templates/box.html"));
				
			}
			
		}
		
	}
	
	else if($type == "author") {
		
		$usercode = $boxSpecs["usercode"];
		
		$limit = $boxSpecs["limit"];
	
		$sql = "SELECT * FROM story_stats WHERE writer_usercode = '$usercode' AND state = 'approved' ORDER BY upvotes LIMIT $limit";
		
		if($result = mysqli_query($conn, $sql)) {
		
			while($row = mysqli_fetch_array($result)) {
				
				$storyCode = $row["story_code"];
			
				$title = $row["title"];
			
				$upvotes = $row["upvotes"];
			
				$views = $row["views"];
				
				$genre = $row["genre"];
			
				$info = '<label id="storyName">' . $title . '</label> <label id="storyGenre">' . $genre . '</label> <label id="upvotes">' . $upvotes . ' upvotes</label> <label id="upvotes">' . $views . ' views</label>';
		
				$originalSrc = $root . "images/stories/". str_replace(" ", "_", strtolower($title)) . "_" .  $storyCode . ".jpg";
				
				$src = file_exists($originalSrc) ? $originalSrc : $root . "images/templates/story_cover.jpg";
		
				$items = array("@anc", "@src", "@alt", "@info");
				
				$replacements = array($root . "story/prologue?id=" . $storyCode, $src, $title, $info);
		
				echo str_replace($items, $replacements, file_get_contents($root . "templates/box.html"));
				
			}
			
		}
			
	}
	
	else if($type == "myStories") {
		
		$sort = isset($boxSpecs["sort"]) ? $boxSpecs["sort"] : "all";
		
		$anc = $boxSpecs["anc"];
				
		if($sort == "ongoing") {
	
			$sql = "SELECT * FROM story_stats WHERE writer_usercode = '$usercode' AND state = 'approved' ";
		
			if($result = mysqli_query($conn, $sql)) {
		
				while($row = mysqli_fetch_array($result)) {
			
					$storyCode = $row["story_code"];
				
					$title = $row["title"];
				
					$genre = $row["genre"];
				
					$acceptDate = $row["accept_date"];
							
					$chapterSql = "SELECT * FROM chapters WHERE story_code = '$storyCode' ORDER BY chapter DESC LIMIT 1";
					
					if($chapterResult = mysqli_query($conn, $chapterSql)) {
					
						if(mysqli_num_rows($chapterResult) !== 0) {
						
							$row = mysqli_fetch_array($chapterResult);
					
							$currentChapter = $row["chapter"];
							
							$date = $row["date"];
							
						}
						
						else {
						
							$currentChapter = "None";
							
							$date = $acceptDate;
							
						}
					
					}
					
					$subscribersSql = "SELECT * FROM update_subscribes WHERE story_code = '$storyCode' ";
					
					if($subscribersResult = mysqli_query($conn, $subscribersSql)) {
					
						$subscribers = mysqli_num_rows($subscribersResult);
					
					}
				
					$info = '<label id="storyName">' . $title . '</label> <label id="storyGenre">' . $genre . '</label> <label id="chapter">Current chapter: ' . $currentChapter . '</label> <label id="chapter">Subscribers: ' . $subscribers . '</label> <label id="chapter">Last update: ' . $date . '</label>';
		
					$originalSrc = $root . "images/stories/". str_replace(" ", "_", strtolower($title)) . "_" .  $storyCode . ".jpg";
				
					$src = file_exists($originalSrc) ? $originalSrc : $root . "images/templates/story_cover.jpg";
		
					$items = array("@anc", "@src", "@alt", "@info");
				
					$replacements = array($root . $anc . $storyCode, $src, $title, $info);
		
					echo str_replace($items, $replacements, file_get_contents($root . "templates/box.html"));
					
				}
				
			}
		
		}		
	
	}
	
	else if($type == "writerDashboard") {
		
		$sort = isset($boxSpecs["sort"]) ? $boxSpecs["sort"] : "all";
		
		$anc = $boxSpecs["anc"];
				
		if($sort == "ongoing") {
	
			$sql = "SELECT * FROM story_stats WHERE writer_usercode = '$usercode' AND state = 'approved' AND status = 'ongoing' ";
		
			if($result = mysqli_query($conn, $sql)) {
				
				if(mysqli_num_rows($result) == 0) {
				
					echo '<div id="placeholder"> <div id="message">You have no ongoing stories</div> </div>';
					
					return;
				
				}
		
				while($row = mysqli_fetch_array($result)) {
			
					$storyCode = $row["story_code"];
				
					$title = $row["title"];
				
					$genre = $row["genre"];
				
					$acceptDate = $row["accept_date"];
							
					$chapterSql = "SELECT * FROM chapters WHERE story_code = '$storyCode' ORDER BY chapter DESC LIMIT 1";
					
					if($chapterResult = mysqli_query($conn, $chapterSql)) {
					
						if(mysqli_num_rows($chapterResult) !== 0) {
						
							$row = mysqli_fetch_array($chapterResult);
					
							$currentChapter = $row["chapter"];
							
							$date = $row["date"];
							
						}
						
						else {
						
							$currentChapter = "None";
							
							$date = $acceptDate;
							
						}
					
					}
				
					$info = '<label id="storyName">' . $title . '</label> <label id="storyGenre">' . $genre . '</label> <label id="chapter">Current chapter: ' . $currentChapter . '</label> <label id="chapter">Last update: ' . $date . '</label> <a href="../publish/manage_story?id=' . $storyCode . '"> <span id="icnEdit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M18.363 8.464l1.433 1.431-12.67 12.669-7.125 1.436 1.439-7.127 12.665-12.668 1.431 1.431-12.255 12.224-.726 3.584 3.584-.723 12.224-12.257zm-.056-8.464l-2.815 2.817 5.691 5.692 2.817-2.821-5.693-5.688zm-12.318 18.718l11.313-11.316-.705-.707-11.313 11.314.705.709z"/></svg></span> </a>';
		
					$originalSrc = $root . "images/stories/". str_replace(" ", "_", strtolower($title)) . "_" .  $storyCode . ".jpg";
				
					$src = file_exists($originalSrc) ? $originalSrc : $root . "images/templates/story_cover.jpg";
		
					$items = array("@anc", "@src", "@alt", "@info");
				
					$replacements = array($root . $anc . $storyCode, $src, $title, $info);
		
					echo str_replace($items, $replacements, file_get_contents($root . "templates/box.html"));
					
				}
				
			}
		
		}		
	
		if($sort == "completed") {
	
			$sql = "SELECT * FROM story_stats WHERE writer_usercode = '$usercode' AND state = 'approved' AND status = 'ended' ";
		
			if($result = mysqli_query($conn, $sql)) {
			
				if(mysqli_num_rows($result) == 0) {
				
					echo '<div id="placeholder"> <div id="message">You have no completed stories</div> </div>';
					
					return;
				
				}
		
				while($row = mysqli_fetch_array($result)) {
			
					$storyCode = $row["story_code"];
				
					$title = $row["title"];
				
					$genre = $row["genre"];
				
					$acceptDate = $row["accept_date"];
							
					$acceptTime = $row["accept_time"];
							
					$chapterSql = "SELECT * FROM chapters WHERE story_code = '$storyCode' ORDER BY chapter DESC LIMIT 1";
					
					if($chapterResult = mysqli_query($conn, $chapterSql)) {
					
						if(mysqli_num_rows($chapterResult) !== 0) {
						
							$row = mysqli_fetch_array($chapterResult);
					
							$currentChapter = $row["chapter"];
							
							$date = $row["date"];
							
							$time = $row["time"];
							
						}
						
						else {
						
							$currentChapter = "None";
							
							$date = $acceptDate;
							
							$time = $acceptTime;
							
						}
					
					}
				
					$info = '<label id="storyName">' . $title . '</label> <label id="storyGenre">' . $genre . '</label> <label id="chapter">No of chapters: ' . $currentChapter . '</label> <label id="chapter">Date completed: ' . $date . " | " . $time . '</label> <a href="../publish/manage_story?id=' . $storyCode . '"> <span id="icnEdit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M18.363 8.464l1.433 1.431-12.67 12.669-7.125 1.436 1.439-7.127 12.665-12.668 1.431 1.431-12.255 12.224-.726 3.584 3.584-.723 12.224-12.257zm-.056-8.464l-2.815 2.817 5.691 5.692 2.817-2.821-5.693-5.688zm-12.318 18.718l11.313-11.316-.705-.707-11.313 11.314.705.709z"/></svg></span> </a>';
		
					$originalSrc = $root . "images/stories/". str_replace(" ", "_", strtolower($title)) . "_" .  $storyCode . ".jpg";
				
					$src = file_exists($originalSrc) ? $originalSrc : $root . "images/templates/story_cover.jpg";
		
					$items = array("@anc", "@src", "@alt", "@info");
				
					$replacements = array($root . $anc . $storyCode, $src, $title, $info);
		
					echo str_replace($items, $replacements, file_get_contents($root . "templates/box.html"));
					
				}
				
			}
		
		}		
	
		if($sort == "pending") {
	
			$sql = "SELECT * FROM story_stats WHERE writer_usercode = '$usercode' AND state = 'pending' ";
		
			if($result = mysqli_query($conn, $sql)) {
			
				if(mysqli_num_rows($result) == 0) {
				
					echo '<div id="placeholder"> <div id="message">You have no story pending approval</div> </div>';
					
					return;
				
				}
		
				while($row = mysqli_fetch_array($result)) {
			
					$storyCode = $row["story_code"];
				
					$title = $row["title"];
				
					$genre = $row["genre"];
				
					$requestDate = $row["request_date"];
							
					$requestTime = $row["request_time"];
							
					$info = '<label id="storyName">' . $title . '</label> <label id="storyGenre">' . $genre . '</label> <label id="chapter">Date: ' . $requestDate . " | " . $requestTime . '</label>';
		
					$originalSrc = $root . "images/stories/". str_replace(" ", "_", strtolower($title)) . "_" .  $storyCode . ".jpg";
				
					$src = file_exists($originalSrc) ? $originalSrc : $root . "images/templates/story_cover.jpg";
		
					$items = array("@anc", "@src", "@alt", "@info");
				
					$replacements = array($root . $anc . $storyCode, $src, $title, $info);
		
					echo str_replace($items, $replacements, file_get_contents($root . "templates/box.html"));
					
				}
				
			}
		
		}		
	
	}
	
	else if($type == "readerDashboard") {
		
		$sort = isset($boxSpecs["sort"]) ? $boxSpecs["sort"] : "all";
		
		if($sort == "history") {
	
			$sql = "SELECT * FROM history WHERE viewer_usercode = '$usercode' ORDER BY date, time DESC ";
		
			if($result = mysqli_query($conn, $sql)) {
			
				if(mysqli_num_rows($result) == 0) {
				
					echo '<div id="placeholder"> <div id="message">You have no story in your history</div> </div>';
					
					return;
				
				}
		
				while($row = mysqli_fetch_array($result)) {
			
					$storyCode = $row["story_code"];
				
					$chapter = $row["chapter"];
				
					$dateVisited = $row["date"];
				
					$timeVisited = $row["time"];
				
					$statsSql = "SELECT * FROM story_stats WHERE story_code = '$storyCode' AND state = 'approved' ";
					
					if($statsResult = mysqli_query($conn, $statsSql)) {
					
						if(mysqli_num_rows($statsResult) !== 0) {
						
							$statsRow = mysqli_fetch_array($statsResult);
					
							$title = $statsRow["title"];
							
							$genre = $statsRow["genre"];
							
						}
						
					}
				
					$info = '<label id="storyName">' . $title . '</label> <label id="storyGenre">' . $genre . '</label> <label id="chapter">Chapter ' . $chapter . '</label> <label id="chapter">Date: ' . $dateVisited . " | " . $timeVisited . '</label>';
		
					$originalSrc = $root . "images/stories/". str_replace(" ", "_", strtolower($title)) . "_" .  $storyCode . ".jpg";
				
					$src = file_exists($originalSrc) ? $originalSrc : $root . "images/templates/story_cover.jpg";
		
					$items = array("@anc", "@src", "@alt", "@info");
				
					$replacements = array($root . "story?id=" . $storyCode . "&c=" . $chapter, $src, $title, $info);
		
					echo str_replace($items, $replacements, file_get_contents($root . "templates/box.html"));
					
				}
				
			}
		
		}		
		
		if($sort == "favourites") {
	
			$sql = "SELECT * FROM favourites WHERE saver_usercode = '$usercode' ";
		
			if($result = mysqli_query($conn, $sql)) {
			
				if(mysqli_num_rows($result) == 0) {
				
					echo '<div id="placeholder"> <div id="message">You have no story in your favourites list</div> </div>';
					
					return;
				
				}
		
				while($row = mysqli_fetch_array($result)) {
			
					$storyCode = $row["story_code"];
				
					$date = $row["date"];
				
					$time = $row["time"];
				
					$statsSql = "SELECT * FROM story_stats WHERE story_code = '$storyCode' AND state = 'approved' ";
					
					if($statsResult = mysqli_query($conn, $statsSql)) {
					
						if(mysqli_num_rows($statsResult) !== 0) {
						
							$statsRow = mysqli_fetch_array($statsResult);
					
							$title = $statsRow["title"];
							
							$genre = $statsRow["genre"];
							
							$views = $statsRow["views"];
							
							$upvotes = $statsRow["upvotes"];
							
						}
						
					}
				
					$info = '<label id="storyName">' . $title . '</label> <label id="views">' . $views . " views | " . $upvotes . ' upvotes</label> <label id="chapter">Date: ' . $date . " | " . $time . '</label>';
		
					$originalSrc = $root . "images/stories/". str_replace(" ", "_", strtolower($title)) . "_" .  $storyCode . ".jpg";
				
					$src = file_exists($originalSrc) ? $originalSrc : $root . "images/templates/story_cover.jpg";
		
					$items = array("@anc", "@src", "@alt", "@info");
				
					$replacements = array($root . "story/prologue?id=" . $storyCode, $src, $title, $info);
		
					echo str_replace($items, $replacements, file_get_contents($root . "templates/box.html"));
					
				}
				
			}
		
		}		
	
		if($sort == "bookmarks") {
	
			$sql = "SELECT * FROM bookmarks WHERE saver_usercode = '$usercode' ";
		
			if($result = mysqli_query($conn, $sql)) {
			
				if(mysqli_num_rows($result) == 0) {
				
					echo '<div id="placeholder"> <div id="message">You have no story in your bookmarks</div> </div>';
					
					return;
				
				}
		
				while($row = mysqli_fetch_array($result)) {
			
					$storyCode = $row["story_code"];
				
					$chapter = $row["chapter"];
				
					$date = $row["date"];
				
					$time = $row["time"];
				
					$statsSql = "SELECT * FROM story_stats WHERE story_code = '$storyCode' AND state = 'approved' ";
					
					if($statsResult = mysqli_query($conn, $statsSql)) {
					
						if(mysqli_num_rows($statsResult) !== 0) {
						
							$statsRow = mysqli_fetch_array($statsResult);
					
							$title = $statsRow["title"];
							
							$genre = $statsRow["genre"];
							
							$views = $statsRow["views"];
							
							$upvotes = $statsRow["upvotes"];
							
						}
						
					}
				
					$info = '<label id="storyName">' . $title . '</label> <label id="storyGenre">' . $genre . '</label> <label id="chapter">Chapter ' . $chapter . '</label> <label id="views">' . $views . " views | " . $upvotes . ' upvotes</label>';
		
					$originalSrc = $root . "images/stories/". str_replace(" ", "_", strtolower($title)) . "_" .  $storyCode . ".jpg";
				
					$src = file_exists($originalSrc) ? $originalSrc : $root . "images/templates/story_cover.jpg";
		
					$items = array("@anc", "@src", "@alt", "@info");
				
					$replacements = array($root . "story?id=" . $storyCode . "&c=" . $chapter, $src, $title, $info);
		
					echo str_replace($items, $replacements, file_get_contents($root . "templates/box.html"));
					
				}
				
			}
		
		}		
	
		if($sort == "subscribes") {
	
			$sql = "SELECT * FROM update_subscribes WHERE subscriber_usercode = '$usercode' ORDER BY date, time ";
		
			if($result = mysqli_query($conn, $sql)) {
			
				if(mysqli_num_rows($result) == 0) {
				
					echo '<div id="placeholder"> <div id="message">You have not subscribed to be notified of new updates of any story</div> </div>';
					
					return;
				
				}
		
				while($row = mysqli_fetch_array($result)) {
			
					$storyCode = $row["story_code"];
				
					$date = $row["date"];
				
					$time = $row["time"];
				
					$statsSql = "SELECT * FROM story_stats WHERE story_code = '$storyCode' AND state = 'approved' ";
					
					if($statsResult = mysqli_query($conn, $statsSql)) {
					
						if(mysqli_num_rows($statsResult) !== 0) {
						
							$statsRow = mysqli_fetch_array($statsResult);
					
							$title = $statsRow["title"];
							
							$genre = $statsRow["genre"];
							
							$views = $statsRow["views"];
							
							$upvotes = $statsRow["upvotes"];
							
							$acceptDate = $statsRow["accept_date"];
							
							$acceptTime = $statsRow["accept_time"];
							
							
							$chapterSql = "SELECT * FROM chapters WHERE story_code = '$storyCode' ORDER BY chapter DESC LIMIT 1";
					
							if($chapterResult = mysqli_query($conn, $chapterSql)) {
					
								if(mysqli_num_rows($chapterResult) !== 0) {
						
									$row = mysqli_fetch_array($chapterResult);
					
									$currentChapter = $row["chapter"];
							
									$lastUpdateDate = $row["date"];
							
									$lastUpdateTime = $row["time"];
							
								}
						
								else {
						
									$currentChapter = "None";
							
									$lastUpdateDate = $acceptDate;
							
									$lastUpdateTime = $acceptTime;
							
								}
					
							}
							
						}
						
					}
				
					$info = '<label id="storyName">' . $title . '</label> <label id="storyGenre">' . $genre . '</label> <label id="chapter">Current chapter: ' . $currentChapter . '</label> <label id="views">LastUpdate: ' . $lastUpdateDate . " | " . $lastUpdateTime . '</label> <label id="views">' . $views . " views | " . $upvotes . ' upvotes</label>';
		
					$originalSrc = $root . "images/stories/". str_replace(" ", "_", strtolower($title)) . "_" .  $storyCode . ".jpg";
				
					$src = file_exists($originalSrc) ? $originalSrc : $root . "images/templates/story_cover.jpg";
		
					$items = array("@anc", "@src", "@alt", "@info");
				
					$replacements = array($root . "story?id=" . $storyCode . "&c=" . $currentChapter, $src, $title, $info);
		
					echo str_replace($items, $replacements, file_get_contents($root . "templates/box.html"));
					
				}
				
			}
		
		}		
	
	}
	
	else {}
	
 ?>