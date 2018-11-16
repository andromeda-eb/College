<?php
     $dsn = 'mysql:host=localhost;dbname=CA4_Blog';
     $username = 'root';
     $password = '';
         
     try{
        $db = new PDO($dsn,$username,$password);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        error_reporting(E_ALL);
    }catch(PDOException $e){
        include('databaseError.php');
        exit();
    }
?>
