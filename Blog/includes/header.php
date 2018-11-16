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
	<script src="../js/comments.js"></script>
	<script src="../js/tags.js"></script>
	<script src="../js/search.js"></script>
	<script src="../js/vote.js"></script>
	<script src = "../js/chat.js"></script>
</head>
<body>
	<div class = "container">
		<header class = "header">
			
		</header>
	
		<div class = "stickyNavWrapper">
			<nav class = "stickyNav">
				<div class = "logo"> <?php echo $logo ?></div>
				<ul>
					<li> <a  href="searchBlog.php">Search Blog</a> </li>
					<li> <a  href="createBlog.php">Create Blog</a> </li>
					<li> <a href="index.php">Index</a> </li>
					<li> <a class = "active" href="../regLog/LoginPage.php">Logout</a> </li>
				</ul>
			</nav>
		</div>