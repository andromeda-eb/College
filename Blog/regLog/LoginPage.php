<?php 
	require_once("../databaseConnection/database.php");
	include('../php/functions.php');

	if(isset($_POST["submit"])){
		session_start();
		$_SESSION["user"] = loadUser($db, $_POST['username']);
		header('Location: ../main/index.php');
        exit();
	}

?>
<!DOCTYPE html>
<head>
	<link rel="stylesheet" type="text/css" href="../css/main.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script 
    	src="https://code.jquery.com/ui/1.12.0/jquery-ui.js" 
    	integrity="sha256-0YPKAwZP7Mp3ALMRVB2i8GXeEndvCq3eSl/WsAl1Ryk="
  		crossorigin="anonymous">		
  	</script>
	<script src="../js/regLog.js"></script>
</head>
<body>
	<div class = "container">
		<header class = "header">
			
		</header>
		
		<div class = "stickyNavWrapper">
			<nav class = "stickyNav">
				<div class = "logo">Login</div>
				<ul>
					<li> <a class = "active" href="./RegistrationPage.php">Register</a> </li>
					<li> <a class = "active" href="./LoginPage.php">Login</a> </li>
				</ul>
		</nav>
		</div>

		<section>
			<div class = "regLogForm">
				<h2>Login Form</h2>
				<form method = "POST" action = "#">
					<img src = "../Images/blank_user.png" id = "preview" alt = "Image Preview" height = "200" width = "200 "><br>
					<label>Username:</label><br>
					<input type="text" placeholder = "Enter username" id="username" name = "username" id = "username"/><br>
					<label>Email:</label><br>
					<input type="email" placeholder = "Enter email" id="email" name = "email" id = "email"/><br>
					<label>Password:</label><br>
					<input type="password" placeholder = "Enter password" id="password" name = "password"/><br>
					<input type = "submit" value = "Login" class = "submit" id = "login" name = "submit">
				</form>
				
				<div class = "regLogError">
						
				</div>
			</div>
		</section>
	</div>
</body>
</html>