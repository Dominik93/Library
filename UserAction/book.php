<?php

	include "../config.php";	
	
	
	function Content(){
            $user = unserialize($_SESSION['user']);
            if(@$_POST['orderHidden'] == 1){
                echo '<div id="content">'.$user->orderBook(@$_POST['orderHidden']).'</div>';
            }
            else{
                echo '<div id="content">'.$user->showBook($_GET['book']).'</div>';
            }
        }
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<link rel="stylesheet" type="text/css" href="<?php echo backToFuture() ?>Library/Layout/layout.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js" type="text/javascript"></script>
		<script src="<?php echo backToFuture() ?>Library/jquery-2.1.3.min.js" type="text/javascript"></script>
                <title>Biblioteka PAI</title>
                
                <script>
                    
                    $(document).ready(function(){
                        $("#editBook").click(function(){
                            var bookID = <?php echo json_encode($_GET); ?>;
                            window.location.href = "https://torus.uck.pk.edu.pl/~dslusarz/Library/AdminAction/Edit/edit_book.php?id="+bookID['book']+"";
                        });
                         
                       $("#deleteBook").click(function(){
                           var bookID = <?php echo json_encode($_GET); ?>;
                           $("#content").load("../ajax.php", {deleteBook: bookID['book']},
                           function(responseTxt,statusTxt,xhr){
                                if(statusTxt=="success"){
                                }
                                if(statusTxt=="error")
                                    alert("Error: "+xhr.status+": "+xhr.statusText);
                            });                  
                       });
                    });
                </script>
                
	</head>
	<body>
		<?php
			Logo();
			Menu();
			Canvas();
		?>
	</body>
</html>