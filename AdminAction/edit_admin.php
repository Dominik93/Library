<?php
	
    include "../config.php";	

    function Content(){
        $user = unserialize($_SESSION['user']);
        if(isset($_POST['name'])){
            echo '<div id="content">'.$user->editAdmin($_GET['id'], $_POST['name'],
                    $_POST['surname'], $_POST['email'], $_POST['login']).'</div>';
        }
        else
            echo '<div id="content">'.$user->showEditAdmin($_GET['id']).'</div>';
    }   
?>
<a href="../Classes/Admin.php"></a>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<link rel="stylesheet" type="text/css" href="<?php echo backToFuture() ?>Library/Layout/layout.css">
                <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js" type="text/javascript"></script>
		<title>Biblioteka PAI</title>
                
        </head>
	<body>
		<?php
			Logo();
			Menu();
			Canvas();
		?>
	</body>
</html>