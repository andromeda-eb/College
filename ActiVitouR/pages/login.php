<?php 
	$title = "Login";
	include('../includes/header.php');
?>

<main>
	<div id="main_box">
		<div id="authentication_box">
			<form>
				<label>Email:
				<input type="text" name="email"> <br><br>

				<label>Password:</label>
				<input type="password" name="password"> <br><br>

				<input type="submit">
			</form>
		</div>
	</div>
</main>

<?php 
	include('../includes/footer.php');
?>