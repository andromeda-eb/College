<?php
	require_once('../databaseConnection/database.php');
	
	switch($_POST['function']){
		case 'votePost':
			votePost($db, $_POST['postId'], $_POST['userId'], $_POST['vote']);
			break;
		case 'loadVotes':
			loadVotes($db, $_POST['postId']);
			break;
	}
	
	function votePost($pdo, $postId, $userId, $vote){
		
		try{
			# insert if it doesn't exist or replace vote value if it does ( unique indexes must be applied beforehand )
			$voteQuery = 'REPLACE INTO postLikes(userId, postId, vote) VALUES (:userId, :postId, :vote)';
			$statement = $pdo -> prepare($voteQuery); 
			$statement -> execute(array(
				':userId' => $userId,
				':postId' => $postId,
				':vote' => $vote,
			));
			$statement -> closeCursor();

		}catch(PDOException $e){
			echo $e;
		}
	}

	function loadVotes($pdo, $postId){ // queries both like and dislikes for post then sends it back to webpage

		try{

			$likeCountQuery = 'SELECT COUNT(vote) FROM postLikes WHERE vote = 1 AND postId = :postId';
			$statement = $pdo -> prepare($likeCountQuery); 
			$statement -> execute(array(
				':postId' => $postId
			));
			$likeCount = $statement -> fetch();
			$statement -> closeCursor();

			$dislikeCountQuery = 'SELECT COUNT(vote) FROM postLikes WHERE vote = 0 AND postId = :postId';
			$statement = $pdo -> prepare($dislikeCountQuery); 
			$statement -> execute(array(
				':postId' => $postId
			));
			$dislikeCount = $statement -> fetch();
			$statement -> closeCursor();

			$voteArr = array('like' => $likeCount['COUNT(vote)'], 'dislike' => $dislikeCount['COUNT(vote)']);

			echo json_encode($voteArr);

		}catch(PDOException $e){
			echo $e;
		}

	}

 ?>