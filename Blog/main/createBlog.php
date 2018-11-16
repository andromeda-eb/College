<?php 
	session_start();
	require("../databaseConnection/database.php");
	$logo = 'Create';
	include('../php/functions.php');

	if(isset($_SESSION["user"]))
		$user = $_SESSION["user"];

	if(isset($_POST['submit']))
		insertPost($db, $user['userId'],$_POST);

	include('../includes/header.php');
?>

<section>
	<main>
		<div class = "createBoxWrapper">
			<div class = "createBox">
				<form method = "POST" action = "createBlog.php">
					<img src="data:image/png;base64,<?php echo $user['avatar']; ?>" width = "200" height = "200"/> <br>
					<input type = "text" name = "title" placeholder = "Title" class = "createBoxTitle"> <br>
					<textarea name = "content" placeholder = "Enter information" class = "createBoxTextarea"></textarea> <br>
					<div class="tags-input" data-name="tags-input"></div><br>
					<input type = "submit" value = "Create Blog" name = "submit" class = "submit">
				</form>
			</div>
		</div>
	</main>
</section>

<?php include('../includes/footer.php'); ?>
