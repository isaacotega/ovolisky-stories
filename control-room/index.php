<?php
	
	$pageSpecs = array("title" => "Control room", "restricted" => true);
	
	include("../templates/header.php");
	
	require("../scripts/account_details.php");
		
	require("../scripts/connection.php");
	
	$sql = "SELECT * FROM accounts WHERE usercode = '$usercode' ";
	
	if($result = mysqli_query($conn, $sql)) {
		
		$row = mysqli_fetch_array($result);
	
		$membership = $row["membership"];
		
		$membership == "admin" || $membership == "moderator" or die(header("Location: ../"));
	
	}
	
 ?>
 
 <link rel="stylesheet" href="../styles/control_room.css">
 
 <div id="main">
 
 	<h2></h2>
 
 <div id="container"></div>
 
 <div id="foot">
 
 	<button class="navigators" id="register">Register</button>
   
 	<button class="navigators" id="members">Members</button>
 
 	<button class="navigators" id="postsManager">Stories</button>
 
 </div>
 
 </div>
 
 <script>
 	
 	requestData("register", "JSON");
 	
 	$(".navigators").click(function() {
 		
 		$("h2").html("Loading . . .");
 				
 		smallLoader();
 		
 		requestData($(this).attr("id"), "JSON");
 		
 	});
 	
 	function requestData(request, dataType) {
 	
 		$.ajax({
 			type: "POST",
 			url: "../scripts/control-room.php",
 			dataType: dataType,
 			data: {
 				request: request
 			},
 			success: function(response) {
 				
 				var request = response[0].request;
 				
 				$(".navigators").css("backgroundColor", "#EDF4C3");
 				
 				$("#" + request).css("backgroundColor", "blue");
 			
 				if(request == "register") {
 					
 					$("h2").html("Register");
 				
 					var table = "";
 					
 					table += '<table id="tblRegister" class="table"><thead> <tr> <th>S/N</th> <th>Date</th> <th>Pages opened</th> <th>Visitors</th> <th>Non visitors</th> <th>Total</th> </tr> </thead> <tbody>';
 			
 					for(var i = 1; i < response.length; i++) {
 						
 						var totalUsers = Number(response[i]["visitors"]) + Number(response[i]["non_visitors"]);
 						
 						table += "<tr> <td>" + i + "</td>";
 			
 						for(var prop in response[i]) {
 						
 							table += "<td>" + response[i][prop] + "</td>";
 							
 						}
 						
 						table += "<td>" + totalUsers + "</td> </tr>";
 			
 					}
 					
 					table += "</tbody> </table>";
 						 			 
 					$("#container").html( table );
 				
 				}
 				
 				if(request == "members") {
 					
 					$("h2").html("Members");
 				
 					var table = "";
 					
 					table += '<table id="tblRegister" class="table"><thead> <tr> <th>S/N</th> <th>First name</th> <th>Last name</th> <th>Usercode</th> <th>Email address</th> <th>Date registered</th> <th>Time registered</th> <th>Full Details</a> </tr> </thead> <tbody>';
 			
 					for(var i = 1; i < response.length; i++) {
 						
 						table += "<tr> <td>" + i + "</td>";
 			
 						for(var prop in response[i]) {
 						
 							table += "<td>" + response[i][prop] + "</td>";
 							
 						}
 						
 						table += "<td>View</td> </tr>";
 			
 					}
 					
 					table += "</tbody> </table>";
 						 			 
 					$("#container").html( table );
 				
 				}
 				
 				if(request == "postsManager") {
 					
 					$("h2").html("Stories");
 				
 					var table = "";
 					
 				//	table += '<table id="tblPostsManager" class="table"><thead> <tr> <th>S/N</th> <th>Post Id</th> <th>Title</th> <th>Market 1</th> <th>Market 2</th> <th>Date Posted</th> <th>Time Posted</th> <th>Last Update (Date)</th> <th>Last Update (Time)</th> <th>Links</th> </tr> </thead> <tbody>';
 			
 					table += '<table id="tblPostsManager" class="table"><thead> <tr>';
 					
 					for(var prop in response[1]) {
 							
 						table += "<th>" + prop + "</th>";
 								
 					}
 						
 					table += '</tr> </thead> <tbody>';
 			
 					for(var i = 1; i < response.length; i++) {
 						
 						table += "<tr> <td>" + i + "</td>";
 			
 						for(var prop in response[i]) {
 						
 							if(prop !== "id") {
 							
 								var value = "";

 								value = response[i][prop];

 								table += "<td>" + value + "</td>";
 								
 							}
 								
 						}
 						
 						table += '</tr>';
 			
 					}
 					
 					table += "</tbody> </table>";
 						 			 
 					$("#container").html( table );
 				
 				}
 				
 			},
 			error: function(response) {
 				alert(JSON.stringify(response));
 			}
 		});
 
 	}
 	
 	function smallLoader() {
 	
 		$("#container").html('<div id="loaderHolder"><div id="loader1" class="loader"></div><div id="loader2" class="loader"></div></div>');
 		
 	}

 </script>