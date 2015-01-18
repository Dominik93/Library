<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


?>

<!DOCTYPE html>
<html
    <head>
        <title> Standardy kodowania</title>
    </head>
    <body>
            <?php  
            if(isset($_POST['test'])){
                echo $_POST['test'];
            }
            echo '<form method="post" action="test.php">
                    <input type="text" name="test" value="ćś">
                    <input type="submit">
                </form>';
            ?>
        </body>
</html>