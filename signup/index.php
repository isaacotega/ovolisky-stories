  <?php
  
 	$returnPage = isset($_GET["return"]) ? urlencode($_GET["return"]) : "none";
 
	$pageSpecs = array("title" => "Sign Up", "footer" => false);
	
	include("../templates/header.php");
	
 ?>
 
 <div id="main">
 
 <form method="post" class="form" id="frmSignUp">
 
	<?php echo isset($_GET["return"]) ? "<br><br><h2>Please signup to view this page</h2>" : "" ?>
 
 	<br><br>
 
 	<label class="formHeading">Sign up for <?php echo $domain ?></label>
 	
 	<br>
 	
	 <div class="formError">
	 
	 	<label></label>
	 
	 </div>
 	
 	<br>
 
 	<input type="text" name="firstName" placeholder="Enter First Name" class="input" value='<?php echo isset($_POST["firstName"]) ? htmlspecialchars($_POST["firstName"]) : "" ?>'>
 	
 	<br>
 
 	<input type="text" name="lastName" placeholder="Enter Last Name" class="input" value='<?php echo isset($_POST["lastName"]) ? htmlspecialchars($_POST["lastName"]) : "" ?>'>
 	
 	<br>
 
 	<input type="email" name="email" placeholder="Enter Email Address" class="input" value='<?php echo isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : "" ?>'>
 
 	<br>
 	
 	<br>
 	
 	<div class="radioHolder">
 
	 	<label class="formLabel">Select Gender</label>
	 	
	 	<br>
 	
 		<input type="radio" name="gender" value="male" id="male" class="radio" <?php echo isset($_POST["gender"]) ? ( $_POST["gender"] == "male" ? "checked" : "") : "" ?>>
 	
	 	<label for="male">Male</label>
 
	 	<br>
 
		<input type="radio" name="gender" value="female" id="female" class="radio" <?php echo isset($_POST["gender"]) ? ( $_POST["gender"] == "female" ? "checked" : "") : "" ?>>
 
 		<label for="female">Female</label>
 		
 	</div>
 
 	<br>
 
 	<input type="password" name="password" placeholder="Enter Password" class="input" value='<?php echo isset($_POST["password"]) ? htmlspecialchars($_POST["password"]) : "" ?>'>
 
 	<br>
 
 	<input type="password" name="confirmPassword" placeholder="Re-enter Password" class="input" value='<?php echo isset($_POST["confirmPassword"]) ? htmlspecialchars($_POST["confirmPassword"]) : "" ?>'>
 
 	<br><br>
 	
 	<input type="submit" name="submit" class="submit" value="Sign Up">
 	
 	<br><br><br>
 	<!--
	 <label class="formLabel">or</label>
	 	
 	<br><br>
 	
 	<div id="fb-root"></div>
 	
	<div class="fb-login-button" style="padding: 10cm " data-width="" data-size="large" data-button-type="continue_with" data-layout="default" data-auto-logout-link="false" data-use-continue-as="true"></div>

 	<br><br><br>
 	-->
	 <label class="formLabel">Already have an account?</label>
	 	
 	<br><br>
 	
 	<a href="../login<?php echo $returnPage == "none" ? "" : '?return=' . $returnPage; ?>">
 	
 		<button type="button" class="otherButton">Log In</button>
 		
 	</a>
 	
 	<br><br>
 
 </form>
 
 </div>
 <!--
<div id="fb-root"></div>

<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v13.0&appId=627634718537567&autoLogAppEvents=1" nonce="AIj7cuBs"></script>
-->
 <script>
 
 	function alertInForm(text) {
 	
 		$(".formError").css("display", "table");
 	
 		$(".formError label").html(text);
 	
 	}
 	
 	function displayError() {}
 	
 </script>
 
 <?php
		
	include("../templates/footer.php");
	
?>

 
  <?php
		
	if(isset($_POST["submit"])) {
	
		if(!empty($_POST["firstName"]) && !empty($_POST["lastName"]) && !empty($_POST["email"]) && !empty($_POST["gender"]) && !empty($_POST["password"]) && !empty($_POST["confirmPassword"])) {
		
			if($_POST["password"] == $_POST["confirmPassword"]) {
			
				if(strlen($_POST["firstName"]) > 10) {
				
					echo '<script> alertInForm("Please shorten your first name") </script>';
				
				}
				
				if(strlen($_POST["lastName"]) > 10) {
				
					echo '<script> alertInForm("Please shorten your last name") </script>';
				
				}
				
				if(strlen($_POST["email"]) < 10) {
				
					echo '<script> alertInForm("Invalid email") </script>';
				
				}
				
				else {
	
					if(strlen($_POST["password"]) > 20) {
				
						echo '<script> alertInForm("Please shorten your password") </script>';
				
					}
				
					else {
	
						insertValues();
						
					}
				
				}
			
			}
			
			else {
			
				echo '<script> alertInForm("Incorrect passwords") </script>';
				
			}
	
		}
	
		else {
	
			echo '<script> alertInForm("Please fill in the details") </script>';
				
		}
	
	}
	
	
	function insertValues() {
		
		global $returnPage;
	
		include("../scripts/connection.php");
			
		$firstName = $_POST["firstName"];
		
		$lastName = $_POST["lastName"];
		
		$email = $_POST["email"];
		
		$gender = $_POST["gender"];
		
		$password = $_POST["password"];
		
		$date = date("Y m d");
			
		$time = date("h:i A");
			
		$digitsNo = 20;
	
		$x = 0;
		
		$emailConfirmationCode = "";
		
		$cookieCode = "";
	
		for($usercode = ""; $x < $digitsNo; $x++) {
	
			$usercode .= rand(0, 9);
		
			$emailConfirmationCode .= rand(0, 9);
		
			$cookieCode .= rand(0, 9);
		
		}
	
		// ensure connection to bloggers accounts database is secured 
		
		if($conn) {
		
			// ensure email address does not already exists in the database 
		
			$check = "SELECT * FROM accounts WHERE email = '$email' ";
		
			if($rs = mysqli_query($conn, $check)) {
			
				$data = mysqli_fetch_array($rs);
			
				if(!empty($data)) {
			
					echo '<script> alertInForm("This email address has been registered already") </script>';
				
				}
			
				else {
			
					// if not insert users data into the accountsInfo database 
				
					$sql = "INSERT INTO accounts (first_name, last_name, email, gender,  password, usercode, bio, email_confirmed, email_confirmation_code, cookie_code, date_registered, time_registered) VALUES ('$firstName', '$lastName', '$email', '$gender', '$password', '$usercode', 'Just a fan of stories', 'false', '$emailConfirmationCode', '$cookieCode', '$date', '$time')";
			
					if(mysqli_query($conn, $sql)) {
					
						// after creating account 
						
						$subject = "Confirm Email";
						
						$items = array("username", "emailConfirmationCode");
						
						$replacements = array($firstName . " " . $lastName, $emailConfirmationCode);
						
						$message = str_replace($items, $replacements, file_get_contents("../templates/email.html"));
						
						$headers = "From: " . strip_tags("admin@" . $fullUrl) . "\r\n";
						
						$headers .= "Reply-To: ". strip_tags("admin@" . $fullUrl) . "\r\n";
						
						$headers .= "CC: admin@" . $fullUrl . "\r\n";
						
						$headers .= "MIME-Version: 1.0\r\n";
						
						$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
					
					//	mail($email, $subject, $message, $headers);
						
							echo '<script> window.location.href = "../scripts/ckstr.php?r=s&c=' . $cookieCode . ($returnPage == "none" ? "" : '&n=' .$returnPage) . '"; </script>';
							
					}
					
					else {
					
						echo '<script> alertInForm("Error creating account. Please try again") </script>';
					
					}
			
				}
				
			}
			
		}
		
		else 	{
		
			echo "<script>displayError()</script>";
		
		}
	
	}
	
 ?>
 