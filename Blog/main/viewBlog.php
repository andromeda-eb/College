<?php 
	session_start();
	require("../databaseConnection/database.php");
	include('../php/functions.php');

	if(isset($_SESSION["user"]))
		$user = $_SESSION["user"];

	$post = loadPost($db, $_GET['postId']);
	$date = new DateTime;

	$logo = $post['username'] . '\'s blog';

	include('../includes/header.php');
?>

<section>
	<main>
		<div class = "viewBox">
			<?php 
				echo '<img src="data:image/png;base64,'.$post['avatar'].'"width = "250" height = "250"/> <br>';

				echo '<h1>' . $post['title'] . '</h1><br>';
				echo $post['date'] . '<br>';
				echo '<p>' . $post['content'] . '</p><br>';

				if($post['userId'] == $user['userId'])
					echo '<span class = "commentsEnable"> Enable Comments
					 	  <input type="checkbox" name="checkbox"class ="checkbox">
					  	  </span>';
			 ?>

			 <div class = "vote">
			 	<span class = "like" >Like  
			 		<span class = "likeCount"> 0 </span> 
			 	</span>
			 	<span class = "dislike" >Dislike  
			 		<span class = "dislikeCount"> 0 </span> 
			 	</span>
			 </div>
		</div>
		<div class = "wrapper">				
			<div class = "pageData">
				<p>Comments</p>
			</div>

			<div class = "commentWrapper">

				<h3 class = "commentTitle">User feedback...
					<span class = "error"></span>
				</h3>

					<div class = "commentInsert">

						<h3 class = "whoSays"> <?php echo $user['username']; ?> </h3>

						<div class = "commentInsertContainer">
							<textarea id = "commentPostText" class = "commentInsertText"></textarea>
						</div>
						
						<div id = "commentPost" class = "commentPost">
							<input type="button" value="post" id = "commentPostBtnWrapper" class = "commentPostBtnWrapper">	
						</div>

					</div>

					<div class="commentsList">
						<ul class = "commentsHolder-ul">
							
						</ul>
				</div>
			</div>
		</div>
	</main>
</section>

<input type="hidden" id = "postId" value = "<?php echo $post['postId']; ?>">
<input type="hidden" id = "userId" value = "<?php echo $user['userId']; ?>">
<input type="hidden" id = "username" value = "<?php echo $user['username']; ?>">
<input type="hidden" name="date" id ="date" value = "<?php echo date("Y-m-d");?>">

<?php include('../includes/footer.php');?>
