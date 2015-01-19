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
        <script src="jquery-2.1.3.min.js" type="text/javascript"></script>
                
        <script>
            var i = 0;
            function addField() {
                i++;
            formFieldsDiv = document.getElementById('form');
            formFieldsDiv.innerHTML =  formFieldsDiv.innerHTML+'<input type="text" name="imie['+ i +']"/> <br/>';
            }
           
        $(document).ready(function(){
            $("#add").click(function(){
                addField();
            });
        })
        
        </script>    
    </head>
    
    
    
    <body>
            <?php  
                var_dump($_POST);
            echo '  
                    <div id="formFields">
                    <Input type="Button" id="add" onclick="return false;">
                    <form id="form" method="post">
                        <input type="submit"/><br />
                        <input type="text" name="imie[0]"/><br />
                        
                    </form>
                    
                    </div>';
            ?>
        </body>
</html>