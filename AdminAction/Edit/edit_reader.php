<?php
	
    include "../../config.php";	

    function Content(){
        $user = unserialize($_SESSION['user']);
        if(isset($_POST['edit'])){
            var_dump($_POST);
            echo '<div id="content">'.$user->editReader(
                    $_POST['edit'], 
                    $_POST['login'],
                    $_POST['email'],
                    $_POST['name'],
                    $_POST['surname'],
                    $_POST['country'],
                    $_POST['city'],
                    $_POST['street'],
                    $_POST['post_code'],
                    $_POST['nr_house']).'</div>';
        }
        else
            echo '<div id="content">'.$user->showEditReader($_GET['id']).'</div>';
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