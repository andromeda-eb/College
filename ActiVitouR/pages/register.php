<?php 
	$title = "Register";
	include('../includes/header.php');
?>

<main>
	<div id="main_box">
		<div id ="authentication_box">
			<form>
			<label>Username: </label>
			<input type="text" name="username"> <br><br>

			<label>Email: </label>
			<input type="text" name="email"> <br><br>

			<label>Confirm Email: </label>
			<input type="text" name="confirm_email"> <br><br>

			<label>Password:</label>
			<input type="password" name="password"> <br><br>

			<label>Confirm Password: </label>
			<input type="password" name="confirm_password"> <br><br>

			<input type="submit">
		</form>
		</div>
	</div>
</main>

<?php 
	include('../includes/footer.php');
?>