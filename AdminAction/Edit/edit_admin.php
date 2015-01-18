<?php
	
    include "../../config.php";	

    function Content(){
        $user = unserialize($_SESSION['user']);
        var_dump($_POST);
        if(isset($_POST['edit'])){
            echo 'd';
            echo '<div id="content">'.$user->editAdmin($_POST['edit'],
                    $_POST['name'],
                    $_POST['surname'],
                    $_POST['email'], 
                    $_POST['login']).'</div>';
        }
        else{
            echo '<div id="content">'.$user->showEditAdmin($_GET['id']).'</div>';
        }
    }   
?>

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