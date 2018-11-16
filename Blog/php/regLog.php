<?php   
    require_once("../databaseConnection/database.php");

    switch($_POST['function']){
        case "register":
            regUser($db, $_POST['username'], $_POST['email']);
            break;
        case "login":
            loginUser($db, $_POST["username"],$_POST["email"],$_POST["password"]);
            break;
    }

    function regUser(PDO $pdo, $username, $email){
        try{
            $result = array();

            $regLogQuery = "SELECT username FROM userDetails WHERE username = :username";
            $statement = $pdo -> prepare($regLogQuery);
            $statement->execute(array(':username' => $username));
            $resUsername = $statement -> fetch();
            $statement -> closeCursor();
            $result['username'] = $resUsername['username'];

            $regLogQuery = "SELECT email FROM userDetails WHERE email = :email";
            $statement = $pdo -> prepare($regLogQuery);
            $statement->execute(array(':email' => $email));
            $resEmail = $statement -> fetch();
            $statement -> closeCursor();
            $result['email'] = $resEmail['email'];

            echo json_encode($result);

        }catch(Exception $e){
            echo "Error executing query" . $e;
        }
    }

    function loginUser(PDO $pdo, $username, $email, $password){
        try{

            $regLogQuery = "SELECT username, email, password FROM userDetails WHERE username = :a AND email = :b";
            $statement = $pdo -> prepare($regLogQuery);
            $statement->execute(array(':a' => $username, ':b' => $email));
            $userDetails = $statement -> fetch();
            $statement -> closeCursor();
            
            $passwordMatch = password_verify($password, $userDetails['password']);

            if($passwordMatch && $username == $userDetails['username'] && $userDetails['password'])
                echo json_encode(true);


        }catch(Exception $e){
            echo "Error executing query" . $e;
        }
    }
    
?>