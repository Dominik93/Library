<?php
	
    include "../config.php";	

    function Content(){
        $user = unserialize($_SESSION['user']);
        echo '<div id="content">'.$user->showReader($_GET['id']).'</div>';
    }   
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<link rel="stylesheet" type="text/css" href="<?php echo backToFuture() ?>Library/Layout/layout.css">
                  
		<script src="<?php echo backToFuture() ?>Library/jquery-2.1.3.min.js" type="text/javascript"></script>
                <title>Biblioteka PAI</title>
                
        </head>
	<body>
		<?php
			Logo();
			Menu();
			Canvas();
		?>
	</body>
        
        <script>
                    
                    $(document).ready(function(){
                        $("#editReader").click(function(){
                            var readerID = <?php echo json_encode($_GET); ?>;
                            window.location.href = "https://torus.uck.pk.edu.pl/~dslusarz/Library/AdminAction/Edit/edit_reader.php?id="+readerID['id']+"";
                        });
                         
                       $("#deleteReader").click(function(){
                           var readerID = <?php echo json_encode($_GET); ?>;
                           $("#content").load("../ajax.php", {deleteReader: readerID['id']},
                           function(responseTxt,statusTxt,xhr){
                                if(statusTxt=="success"){
                                }
                                if(statusTxt=="error")
                                    alert("Error: "+xhr.status+": "+xhr.statusText);
                            });                  
                       });
                       $("#extendAccount").click(function(){
                           var readerID = <?php echo json_encode($_GET); ?>;
                           $("#content").load("../ajax.php", {extendAccount: readerID['id']},
                           function(responseTxt,statusTxt,xhr){
                                if(statusTxt=="success"){
                                }
                                if(statusTxt=="error")
                                    alert("Error: "+xhr.status+": "+xhr.statusText);
                            }); 
                       });
                       $("#newPassword").click(function(){
                           var readerID = <?php echo json_encode($_GET); ?>;
                           $("#content").load("../ajax.php", {newPassword: readerID['id']},
                           function(responseTxt,statusTxt,xhr){
                                if(statusTxt=="success"){
                                }
                                if(statusTxt=="error")
                                    alert("Error: "+xhr.status+": "+xhr.statusText);
                            }); 
                       });
                    });
                </script>
</html>