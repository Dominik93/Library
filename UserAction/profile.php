<?php

include "../config.php";	


function Content(){
    $user = unserialize($_SESSION['user']);
    echo '<div id="content">'.$user->showAccount().'</div>';
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
                        $("#changePassword").click(function(){
                            window.location.href = "https://torus.uck.pk.edu.pl/~dslusarz/Library/UserAction/Edit/edit_pass.php";
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