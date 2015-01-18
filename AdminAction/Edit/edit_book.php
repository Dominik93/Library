<?php
	
    include "../../config.php";	

    function Content(){
        $user = unserialize($_SESSION['user']);
        if(isset($_POST['edit'])){
            echo '<div id="content">'.$user->editBook($_POST['edit'], $_POST['isbn'],
                    $_POST['title'], $_POST['publisher_house'], $_POST['nr_page'],
                    $_POST['edition'], $_POST['premiere'], $_POST['number'], $_POST['authors']).'</div>';
        }
        else{
            echo '<div id="content">'.$user->showEditBook($_GET['id']).'</div>';
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