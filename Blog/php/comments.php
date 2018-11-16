<?php 

	require_once('../databaseConnection/database.php');

	switch($_POST['function']){
        case "insertComment":
            insertComment($db, $_POST['postId'], $_POST['username'], $_POST['date'], $_POST['comment']);
            break;
        case "loadComments":
            loadComments($db, $_POST['postId']);
            break;
        case "enableComments":
            enableComments($db, $_POST['enableComments'], $_POST['postId']);
            break;
        case "checkEnable":
        	checkEnable($db, $_POST['postId']);
        	break;
    }

    function insertComment(PDO $pdo, $postId, $username, $date, $comment ){ # inserts comment into database

    	try{

			$insertQuery = 'INSERT INTO comment (postId, username, date, comment) VALUES (:postId, :username, :date, :comment)';
			$statement = $pdo -> prepare($insertQuery);
			$statement -> execute(
				array(
					':postId' => $postId, 
					':username' => $username, 
					':date' => $date, 
					':comment' => $comment
				));
			$statement -> closeCursor();
			
			loadInsertedComment($pdo, $username);

		}catch(PDOException $e){
			echo $e;
		}
    }

    function loadInsertedComment(PDO $pdo, $username){ # selects the latest comment for blog entry

    	$loadQuery = 'SELECT c.*, u.avatar FROM comment c, userDetails u 
    				  WHERE u.username = c.username AND c.username =  :username ORDER BY 
    				  commentId DESC LIMIT 1';
    	$statement = $pdo -> prepare($loadQuery);
    	$statement -> execute(array(':username' => $username));
    	$latestComment = $statement -> fetch();
    	$statement -> closeCursor();

    	$comment = fillCommentBox($latestComment);

    	echo $comment;
    }

    function fillCommentBox($argument){ # fills out appropriate html wth latest comment to insert into blog 
    	$comment = '';
    	$comment .= 
				'<li class = "commentHolder"' . $argument['commentId'] . '>
					<div class = "commentBody">
						<h3 class = "usernameField">' .
						$argument['username'] . '
						</h3>
						<div class = "userImage"> 
							<img src="data:image/png;base64,'.$argument['avatar'].'"width="55px"/>
						</div>
						<div class = "commentText">'
							. $argument['comment'] . '
						</div>
					</div>
					<div class = "commentButtonsHolder">
						<ul>
							<li class = "deleteBtn">X</li>
						</ul>
					</div>
				</li>';

		return $comment;
    }

    function loadComments($pdo, $postId){

    	try{

    		$output = '';
    		$loadQuery = 'SELECT c.*, u.avatar FROM comment c, userDetails u, posts p
    					  WHERE c.postId = p.postId and c.postId = :postId GROUP BY c.commentId
    					  ORDER BY commentId DESC';
    		$statement = $pdo -> prepare($loadQuery);
	    	$statement -> execute(array(':postId' => $postId));
	    	$results = $statement -> fetchAll(PDO::FETCH_ASSOC);
	    	$statement -> closeCursor();

			foreach($results as $row)
				$output .= fillCommentBox($row);

	    	echo $output;

    	}catch(PDOException $e){
    		echo $e;
    	}

    }

    function enableComments($pdo, $enable, $postId){
    	try{
    		$updateQuery = 'UPDATE posts SET commentsEnable = :enable WHERE postId = :postId';
    		$statement = $pdo -> prepare($updateQuery);
    		$statement -> execute(array(':enable' => $enable, ':postId' => $postId));
    		$statement -> closeCursor();

    		echo $enable;

    	}catch(PDOException $e){
    		echo $e;
    	}
    }

    function checkEnable($pdo, $postId){
    	try{
    		$updateQuery = 'SELECT commentsEnable from posts WHERE postId = :postId';
    		$statement = $pdo -> prepare($updateQuery);
    		$statement -> execute(array(':postId' => $postId));
    		$status = $statement -> fetch();
    		$statement -> closeCursor();

    		echo $status['commentsEnable'];

    	}catch(PDOException $e){
    		echo $e;
    	}
    }
?>