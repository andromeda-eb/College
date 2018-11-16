<?php 
	
	/* Search function operates as an inclusive or so it searches 
	   by filter one or filter two not by filter one and filter 2
	*/

	require_once("../databaseConnection/database.php");
	
	$searchQuery = 'SELECT p.postId, p.title, p.date, p.content
					FROM posts p, tags t, postTags pt, userDetails u 
					WHERE p.userId = u.userId and p.postId = pt.postId and t.tagId = pt.tagId AND';

	$groupBy = ' GROUP BY p.postId ORDER BY p.postId DESC';

	switch($_REQUEST){
		case isset($_POST['keyword']) && isset($_POST['tags']):
			$searchQuery .= keywordAndTags($_POST['keyword'], $_POST['tags']) . $groupBy;
			break;
		case isset($_POST['keyword']) && isset($_POST['username']):
			$searchQuery .= keywordAndUsername($_POST['keyword'], $_POST['username']) . $groupBy;
			break;
		case isset($_POST['startdate']) && isset($_POST['enddate']) && isset($_POST['keyword']):
			$searchQuery .= dateAndKeyword($_POST['startdate'], $_POST['enddate'], $_POST['keyword']) . $groupBy;
			break;
		case isset($_POST['startdate']) && isset($_POST['enddate']) && isset($_POST['username']):
			$searchQuery .= dateAndUsername($_POST['startdate'], $_POST['enddate'], $_POST['username']) . $groupBy;
			break;
		case isset($_POST['tags']) && isset($_POST['username']):
			$searchQuery .= tagsAndUsername($_POST['tags'], $_POST['username']) . $groupBy;
			break;
		case isset($_POST['startdate']) && isset($_POST['enddate']) && isset($_POST['tags']):
			$searchQuery .= dateAndTags($_POST['startdate'], $_POST['enddate'], $_POST['tags']) . $groupBy;
			break;
	}

	function keywordAndTags($keywords, $tags){  # These functions just prepare the query string for database retrieval
		$whereExtension = ' (';
		$keywordArr = explode(',', $keywords);
		$tagArr = explode(',', $tags);

		foreach($keywordArr as $word)
			$whereExtension .= ' p.content LIKE "%' . $word . '%" OR ';

		foreach($tagArr as $tag)
			$whereExtension .= ' t.tag = "' . $tag . '" OR';

		$whereExtension = rtrim($whereExtension, 'OR') . ' )';

		return $whereExtension;
	}

	function keywordAndUsername($keywords, $username){
		$whereExtension = ' (';
		$keywordArr = explode(',', $keywords);

		foreach($keywordArr as $word)
			$whereExtension .= ' p.content LIKE "%' . preg_replace('/\s+/', '', $word) . '%" OR ';

		$whereExtension .= 'u.username = "' . $username . '" )';

		return $whereExtension;
	}

	function dateAndKeyword($startdate, $enddate, $keywords){
		$whereExtension = ' (';
		$keywordArr = explode(',', $keywords);

		foreach($keywordArr as $word)
			$whereExtension .= ' p.content LIKE "%' . preg_replace('/\s+/', '', $word) . '%" OR ';

		$whereExtension .= 'p.date >= "' . $startdate . '" AND p.date <= "' . $enddate . '")';

		return $whereExtension; 
	}

	function dateAndUsername($startdate, $enddate, $username){
		$whereExtension = '(p.date >= "' . $startdate . '" AND p.date <= "' . $enddate . '" OR ';
		$whereExtension .= 'u.username = "' . $username . '" )';

		return $whereExtension;
	}

	function tagsAndUsername($tags, $username){
		$whereExtension = ' (';
		$tagArr = explode(',', $tags);

		foreach($tagArr as $tag)
			$whereExtension .= ' t.tag = "' . $tag . '" OR ';

		$whereExtension .= 'u.username = "' . $username . '")';

		return $whereExtension;
	}

	function dateAndTags($startdate, $enddate, $tags){
		$whereExtension = ' (';
		$tagArr = explode(',', $tags);

		foreach($tagArr as $tag)
			$whereExtension .= ' t.tag = "' . $tag . '" OR ';

		$whereExtension .= ' p.date >= "' . $startdate . '" AND p.date <= "' . $enddate . '")';

		return $whereExtension;
	}

	try{ // manipulated query string from above is put into this to fetch results from database
		$output = '';

        $statement = $db -> prepare($searchQuery);
        $success = $statement -> execute();
        $results = $statement -> fetchAll();
        $statement -> closeCursor();

        foreach($results as $post)
        	$output .= fillSearchBox($db, $post);

        echo $output;

	}catch(PDOException $e){
		echo $e;
	}

	function fillSearchBox($pdo, $argument){ // fills out search results with appropriate html
		$searchBox = '<div class = "indexBox">' .
					 '<a href="viewBlog.php?postId=' . $argument['postId'] . '">' .
					 '<h3>' . $argument['title'] . '</h3> </a> </br>' .
					 '<p> ' . $argument['date'] . '</p> <br>' . 
					  loadSearchPostTags($pdo, $argument['postId']) . ' </div>';

		return $searchBox;

	}

	function loadSearchPostTags($pdo, $postId){ // seperate function for getting tags associated with results
		try{

			$tags = '';
            
            $loadQuery = 'SELECT tags.tag FROM tags, postTags, posts WHERE postTags.tagId = tags.tagId AND postTags.postId = posts.postId AND posts.postId = :postId';
            $statement = $pdo -> prepare($loadQuery);
            $statement -> execute(array(':postId' => $postId));
            $results = $statement -> fetchAll();
            $statement -> closeCursor();

            foreach($results as $result)
            	$tags .= '<span class = "tag">' . $result['tag'] .  '</span>';

            return $tags;
        }catch(PDOException $e){
            echo $e;
        }
	}


?>