<?php
    include_once("functions/functions.php");
    
    
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Storog</title>
        <link rel="stylesheet" type="text/css" href="css/main.css">
    </head>
    
    <body>
        <?php include "includes/header.php"; ?>
        
        <main>
            <?php
            if (!$games_found){
                echo "<p>No games found.</p>";
            }else{
                foreach ($games as $game) : ?>
                    <a href="game.php?game_id=<?php echo $game["steam_id"] ?>">
                        <?php echo $game["title"] ?>
                    </a><br>
                <?php endforeach;
            }?>
        </main>
    </body>
</html>
