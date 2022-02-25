 <?php
		
 	$returnPage = isset($_GET["return"]) ? urlencode($_GET["return"]) : "none";
 
	$pageSpecs = array("title" => "Log In", "footer" => false);
	
	include("../templates/header.php");
	
?>

 <div id="main">

  <form method="post" class="form" id="frmLogin">
 
	<?php echo isset($_GET["return"]) ? "<br><br><h2>Please login to view this page</h2>" : "" ?>
 
 	<br><br>
 
 	<label class="formHeading">Log In to <?php echo $domain ?></label>
 	
 	<br>
 	
	 <div class="formError">
	 
	 	<label></label>
	 
	 </div>
 	
 	<br>
 
 	<input type="email" name="email" placeholder="Enter Email Address" class="input" value='<?php echo isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : "" ?>'>
 
 	<br>
 	
 	<input type="password" name="password" placeholder="Enter Password" class="input" value='<?php echo isset($_POST["password"]) ? htmlspecialchars($_POST["password"]) : "" ?>'>
 
 	<br><br>
 	
 	<input type="submit" class="submit" name="submit" value="Log In">
 	
 	<br><br><br>
 	
	 <label class="formLabel">Don't have an account?</label>
	 	
 	<br><br>
 	
 	<a href="../signup<?php echo $returnPage == "none" ? "" : '?return=' . $returnPage; ?>">
 	
 		<button type="button" class="otherButton">Sign Up</button>
 		
 	</a>
 	
 	<br><br>
 
 </form>
 
 </div>
 
 <?php
		
	include("../templates/footer.php");
	
?>

 <script>
 
 	function alertInForm(text) {
 	
 		$(".formError").css("display", "table");
 	
 		$(".formError label").html(text)
 	
 	}
 	
 	function displayError() {}
 	
 </script>
 
  <?php
		
	if(isset($_POST["submit"])) {
	
		if(!empty($_POST["email"]) && !empty($_POST["password"])) {
		
			login();
		
		}
	
		else {
	
			echo '<script> alertInForm("Please fill in the details") </script>';
				
		}
	
	}
	
	
	function login() {
	
		global $returnPage;
	
		include("../scripts/connection.php");
			
		$email = $_POST["email"];
		
		$password = $_POST["password"];
		
		// ensure connection to bloggers accounts database is secured 
		
		if($conn) {
		
			// ensure email address exists in the database 
		
			$check = "SELECT * FROM accounts WHERE email = '$email' ";
		
			if($rs = mysqli_query($conn, $check)) {
			
				$data = mysqli_fetch_array($rs);
			
				if(empty($data)) {
			
					echo '<script> alertInForm("No account exists with this information") </script>';
				
				}
			
				else {
			
					// if so confirm password
				
					$sql = "SELECT * FROM accounts WHERE email = '$email' ";
			
					if($result = mysqli_query($conn, $sql)) {
					
						$row = mysqli_fetch_array($result);
					
						if($row["password"] == $password) {
						
							// if it matches 
							
							$cookieCode = $row["cookie_code"];
							
							echo '<script> window.location.href = "../scripts/ckstr.php?r=s&c=' . $cookieCode . ($returnPage == "none" ? "" : '&n=' .$returnPage) . '"; </script>';
							
						}
						
						else {
						
							echo '<script> alertInForm("No account exists with this information") </script>';
							
						}
					
					}
					
					else {
					
						echo '<script> alertInForm("Error processing request. Please try again") </script>';
					
					}
			
				}
				
			}
			
		}
		
		else 	{
		
			echo "<script>displayError()</script>";
		
		}
	
	}
	
 ?>
 