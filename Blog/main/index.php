<?php 
	session_start();
	$logo = 'Index';
	require("../databaseConnection/database.php");
	include('../php/functions.php');

	if(isset($_SESSION["user"]))
		$user = $_SESSION["user"];

	include('../includes/header.php');
?>

<section>
	<main>
		<?php 
			$loadedPosts = loadPosts($db);
			foreach($loadedPosts as $post):
				$tags = loadTags($db, $post['postId']);
		?>

			<div class = "indexBox">
				<a href="viewBlog.php?postId=<?php echo $post['postId'] ?>">
					 <h3> 
					 	<?php echo $post['title']; ?>
					 		
					 </h3>
				</a> <br>
				
				<p><?php echo $post['date']; ?></p><br>
				
				<?php foreach($tags as $tag)
					echo '<span class = "tag">' . $tag['tag'] .  '</span>';
				?>
			</div>

		<?php endforeach; ?>
	</main>
</section>

<?php include('../includes/footer.php'); ?>