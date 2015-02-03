<?php

	include "../../config.php";	
	
	
	function Content(){
            $user = unserialize($_SESSION['user']);
            echo '<div id="content">'.$user->showAddBookForm();
            if(isset($_POST['isbn'])){
                var_dump($_POST);
                echo $user->addBook(
                        $_POST['isbn'],
                        $_POST['original_title'],
                        $_POST['title'],
                        $_POST['original_publisher_house'],
                        $_POST['country_original_publisher_house'],
                        $_POST['publisher_house'],
                        $_POST['country_publisher_house'],
                        $_POST['nr_page'],
                        $_POST['edition'],
                        $_POST['premiere'],
                        $_POST['number'],
                        $_POST['cover'],
                        $_POST['authorName'],
                        $_POST['authorSurname'],
                        $_POST['translatorName'],
                        $_POST['translatorSurname'],
                        $_POST['filePath']);
            }
            echo '</div>';
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
                    var i = 0;
                    var j = 0;
                    function addFieldAuthor() {
                        i++;
                    formFieldsDiv = document.getElementById('authotsTable');
                    formFieldsDiv.innerHTML =  formFieldsDiv.innerHTML+
                                '<tr>'+
                                    '<td><input type="text" value="" name="authorName['+ i +']" placeholder="Imie" required/></td>'+
                                    '<td><input type="text" value="" name="authorSurname['+ i +']" placeholder="Nazwisko" required/></td>'+
                                '</tr>';
                    }
                    
                    function addFieldTranslators() {
                        j++;
                    formFieldsDiv = document.getElementById('translatorsTable');
                    formFieldsDiv.innerHTML =  formFieldsDiv.innerHTML+
                                '<tr>'+
                                    '<td><input type="text" value="" name="translatorName['+ j +']" placeholder="Imie"/></td>'+
                                    '<td><input type="text" value="" name="translatorSurname['+ j +']" placeholder="Nazwisko"/></td>'+
                                '</tr>';
                    }


                $(document).ready(function(){
                    $("#addAuthor").click(function(){
                        addFieldAuthor();
                    });
                    $("#addTranslator").click(function(){
                        addFieldTranslators();
                    });
                })

                </script>  
</html>