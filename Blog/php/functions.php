<?php 
    # set max_allowed_packets = 5;

    require_once("../databaseConnection/database.php");

    function regUser(PDO $pdo,$uName, $mail, $pass, $image){

        $username = $uName;
        $email = $mail;
        $password = password_hash($pass, PASSWORD_DEFAULT);
        $avatar = $image;

        try{
            $regQuery ="INSERT INTO userDetails(username, email, password, avatar) VALUES (:a, :b,:c,:d)";
            $statement = $pdo -> prepare($regQuery);
            $success = $statement->execute(array(':a' => $username,':b' => $email,':c' => $password,':d' => $avatar)); # store boolean in $success. If successfull then redirect
            $success = $statement -> rowCount();
            $statement -> closeCursor();

            if($success){
                session_start();
                $_SESSION["user"] = loadUser($pdo, $username);
                header('Location: ../main/index.php');
                exit();
            }
        }catch(PDOException $e){
            echo $e;
        }
    }

    function loadUser(PDO $pdo, $username){

        try{
            $loadQuery= "SELECT * FROM userDetails WHERE username = :username";
            $statement = $pdo -> prepare($loadQuery);
            $statement -> execute(array(':username' => $username));
            $user = $statement ->fetch();
            $statement -> closeCursor();
            return $user;
        }catch(PDOException $e){
            echo $e;
        }
    }

    function loadPosts(PDO $pdo){
        try{

            $loadQuery = "SELECT * from posts ORDER BY postId DESC"; # latest ones appear first
            $statement = $pdo -> prepare($loadQuery);
            $statement -> execute();
            $posts = $statement -> fetchAll();
            $statement -> closeCursor();
            return $posts;
        }catch(PDOException $e){
            echo $e;
        }
    }

    function insertTags(PDO $pdo, $tags){ # unique index on tag column in tags table
       try{

            foreach($tags as $tag){ # will only insert into table if tag doesn't exist in table
                $insertQuery = 'INSERT IGNORE INTO tags (tag) VALUES (:t)';
                $statement = $pdo -> prepare($insertQuery);
                $statement -> execute(array(':t' => $tag));
                $statement -> closeCursor();   
            }

       }catch(PDOException $e){
            echo $e;
       }
    }

    function insertPost(PDO $pdo, $userId, $postData){
        try{
            
            $tags = explode(',', $postData['tags-input']); # split into array by delimiter comma

            insertTags($pdo, $tags); # function for inserting unique tags in db
            $inputArr = array(':a' => $userId, ':b' => $postData['title'], ':c' => date("Y-m-d H:i:s"), ':d' => $postData['content']);
            # insert values in columns and value of 1 for commentsEnable (comments are automatically enabled when making a post)
            $insertQuery = 'INSERT INTO posts (userId, title, date, content, commentsEnable) VALUES (:a, :b, :c, :d, 1)';
            $statement = $pdo -> prepare($insertQuery);
            $statement -> execute($inputArr);
            $postId = $pdo -> lastInsertId(); # get's the last inserted id for postTags table
            $statement -> closeCursor();

            insertPostTags($pdo, $postId, $tags); 

        }catch(PDOException $e){
            echo $e;
        }
    }

     function insertPostTags(PDO $pdo, $postId, $tags){ # 

        try{
            # query to insert into junction table postTags (both postId and tagId are primary)
            # 
            $junctionQuery = 'INSERT INTO postTags(tagId,postId) 
                                VALUES ((SELECT tagId FROM tags WHERE tag = :tag),
                                (SELECT postId FROM posts WHERE postId = :postId))';

             foreach($tags as $tag){ #create relationship for each tag in post
                $statement = $pdo -> prepare($junctionQuery);
                $statement -> execute(array(':tag' => $tag,':postId' => $postId));
                $statement -> closeCursor();   
            }
        }catch(PDOException $e){
            echo $e;
        }
    }

    function loadTags(PDO $pdo, $postId){
        try{
            
            $loadQuery = 'SELECT tags.tag FROM tags, postTags, posts WHERE postTags.tagId = tags.tagId AND postTags.postId = posts.postId AND posts.postId = :postId';
            $statement = $pdo -> prepare($loadQuery);
            $statement -> execute(array(':postId' => $postId));
            $tags = $statement -> fetchAll();
            $statement -> closeCursor();
            return $tags;
        }catch(PDOException $e){
            echo $e;
        }
    }

    function loadPost(PDO $pdo, $postId){
        try{

            $loadQuery = "SELECT p.postId, p.userId, p.title, p.date, p.content, u.username, u.avatar FROM posts p, userDetails u WHERE p.userId = u.userId AND p.postId = :postId"; # select relevant blog data via selected post id
            $statement = $pdo -> prepare($loadQuery);
            $statement -> execute(array(':postId' => $postId));
            $post = $statement -> fetch();
            $statement -> closeCursor();
            return $post;
        }catch(PDOException $e){
            echo $e;
        }
    }

?>