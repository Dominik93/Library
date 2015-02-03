<?php

	include '../../config.php';

	function Content(){
		$user = unserialize($_SESSION['user']);
		
                if(isset($_POST['newPassword1'])){
                    echo '<div id="content">'.$user->changePass($_POST['oldPassword'], $_POST['newPassword1'], $_POST['newPassword2']).'</div>';
                }
                else {
                    echo '<div id="content">'.$user->showChangePassForm().'</div>';
                }
                
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<link rel="stylesheet" type="text/css" href="<?php echo backToFuture() ?>Library/Layout/layout.css">
		  
		<script src="<?php echo backToFuture() ?>Library/jquery-2.1.3.min.js" type="text/javascript"></script>
                <title>Biblioteka PAI</title>
                <script>
                    $(document).ready(function(){
                       $("#newPassword1").change(function(){
                                msg = $("#status_password");
				if(document.getElementById("newPassword1").value == document.getElementById("newPassword2").value){
					$("#newPassword1").removeClass("red");
					$("#newPassword1").addClass("green");
					$("#newPassword2").removeClass("red");
					$("#newPassword2").addClass("green");
					msg.html('<font color="Green">Prawidołowy</font>');
					$password = true;
				}else{
					$("#newPassword1").removeClass("green");
					$("#newPassword1").addClass("red");
					$("#newPassword2").removeClass("green");
					$("#newPassword2").addClass("red");
					msg.html('<font color="Red">Nieprawidłowy</font>');
				}
                            });
                        $("#newPassword2").change(function(){
				msg = $("#status_password");
				if(document.getElementById("newPassword1").value == document.getElementById("newPassword2").value){
					$("#newPassword1").removeClass("red");
					$("#newPassword1").addClass("green");
					$("#newPassword2").removeClass("red");
					$("#newPassword2").addClass("green");
					msg.html('<font color="Green">Prawidołowy</font>');
					$password = true;
				}else{
					$("#newPassword1").removeClass("green");
					$("#newPassword1").addClass("red");
					$("#newPassword2").removeClass("green");
					$("#newPassword2").addClass("red");
					msg.html('<font color="Red">Nieprawidłowy</font>');
				}
				
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