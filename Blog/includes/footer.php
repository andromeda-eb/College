
	<div class = "chatScreen">
		<div class = "chatScreenHeader">
			<span class = "chatScreenHeaderText">
				<?php echo $user['username']; ?>
			</span>
		</div>
		
		<div class = "log">

		</div>

		<div class="chatScreenInput">
			<input type="text" class = "chatMessage">
			<button class = "chatSubmit">Post</button>
		</div>
	</div>

	<input type = "hidden" class = "chatName" value = "<?php echo $user['username']?>">

</div>
</body>
</html>