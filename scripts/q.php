<?php
	
	include ("connection.php");
	/*
	$sql = "INSERT INTO story_stats (story_code, title, about, genre, tags, views, status, state) VALUES ('35656295356235682562', 'The Lost Kin', 'hdhls xid ishxu duje xurn dujr cujd ue jd.
	udj dirbrj dijd di fif if. cikahd djd id idm. 
	idjkf xkks xid dud fhf hfjfb dujd ufbf finnf idm cid fhjd cu', 'Mystery and Thriller', 'hdh+kdk+kdkj+kfk+kem+msb+ndnh+kd+kndbfuu+jej+kdkj+jfjx', '3868346', 'ongoing', 'approved') ";
	
	for($i = 0; $i < 35; $i++) {
	
	if(mysqli_query($conn, $sql)) {
	
		echo($i . " Inserted<br><br>");
	
	}
	
	}
	
	*/
	
	
	for($i = 0; $i < 15; $i++) {
	
	$sql = "INSERT INTO chapters (story_code, chapter, body, date, time) VALUES ('35656295356235682562', '$i + 1', 'hdhls xid ishxu duje xurn dujr cujd ue jd.
	udj dirbrj dijd di fif if. cikahd djd id idm. 
	idjkf xkks xid dud fhf hfjfb dujd ufbf finnf idm cid fhjd cu
	hdhls xid ishxu duje xurn dujr cujd ue jd.
	udj dirbrj dijd di fif if. cikahd djd id idm. 
	idjkf xkks xid dud fhf hfjfb dujd ufbf finnf idm cid fhjd cu', '2021 01 26', '16:04') ";
	
	if(mysqli_query($conn, $sql)) {
	
		echo($i . " Inserted<br><br>");
	
	}
	
	}
	
 ?>