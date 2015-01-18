<?php
	
	include "../config.php";	

    function Content(){
        $user = unserialize($_SESSION['user']);
	echo '<div id="content">'.$user->showAdmin($_GET['id']).'</div>';
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
                        $("#editAdmin").click(function(){
                            var adminID = <?php echo json_encode($_GET); ?>;
                            window.location.href = "https://torus.uck.pk.edu.pl/~dslusarz/Library/AdminAction/Edit/edit_admin.php?id="+adminID['id']+"";
                        });
                         
                       $("#deleteAdmin").click(function(){
                           var adminID = <?php echo json_encode($_GET); ?>;
                           $("#content").load("../ajax.php", {deleteAdmin: adminID['id']},
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