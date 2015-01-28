<?php

	include "../config.php";
	function Content(){
		$user = unserialize($_SESSION['user']);
                echo '<div id="content">'.$user->showBorrow($_GET['id']).'</div>';
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
        
        <script type="text/javascript">
                    
                $(document).ready(function(){
                    $("#delete").click(function(){
                        var borrowID = <?php echo json_encode($_GET); ?>;
                        $("#content").load("../ajax.php", {deleteBorrow: borrowID['id']},
                            function(responseTxt,statusTxt,xhr){
                                if(statusTxt=="success"){
                                }
                                else if(statusTxt=="error")
                                    alert("Error: "+xhr.status+": "+xhr.statusText);
                                });
                    });
                    $("#receive").click(function(){
                        var borrowID = <?php echo json_encode($_GET); ?>;
                        $("#content").load("../ajax.php", {receiveBorrow: borrowID['id']},
                            function(responseTxt,statusTxt,xhr){
                                if(statusTxt=="success"){
                                }
                                else if(statusTxt=="error")
                                    alert("Error: "+xhr.status+": "+xhr.statusText);
                                });
                    });
                });
                </script>
</html>