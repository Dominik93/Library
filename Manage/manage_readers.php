<?php
    include "../config.php";
	
	function Content(){
                $user = unserialize($_SESSION['user']);
		echo '<div id="content">'.$user->showAjaxReadersSearch().$user->showAllReaders($_POST).'</div>';
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
                    $("#id").change(function(){
                        var id = $("#id").val();
                        var login = $("#login").val();
                        var email = $("#email").val();
                        var imie = $("#name").val();
                        var nazwisko = $("#surname").val();
                        $("#usersTable").load("../ajax.php", {reader:1, id: id, login: login, email: email, name: imie, surname: nazwisko},
                        function(responseTxt,statusTxt,xhr){
                            if(statusTxt=="success"){
                                
                            }
                            if(statusTxt=="error")
                                alert("Error: "+xhr.status+": "+xhr.statusText);
                        });
                    });
                    $("#login").change(function(){
                        var id = $("#id").val();
                        var login = $("#login").val();
                        var email = $("#email").val();
                        var imie = $("#name").val();
                        var nazwisko = $("#surname").val();
                        $("#usersTable").load("../ajax.php", {reader:1, id: id, login: login, email: email, name: imie, surname: nazwisko},
                        function(responseTxt,statusTxt,xhr){
                            if(statusTxt=="success"){
                                
                            }
                            if(statusTxt=="error")
                                alert("Error: "+xhr.status+": "+xhr.statusText);
                        });
                    });
                    $("#email").change(function(){
                       var id = $("#id").val();
                        var login = $("#login").val();
                        var email = $("#email").val();
                        var imie = $("#name").val();
                        var nazwisko = $("#surname").val();
                        $("#usersTable").load("../ajax.php", {reader:1, id: id, login: login, email: email, name: imie, surname: nazwisko},
                        function(responseTxt,statusTxt,xhr){
                            if(statusTxt=="success"){
                                
                            }
                            if(statusTxt=="error")
                                alert("Error: "+xhr.status+": "+xhr.statusText);
                        });
                    });
                    $("#name").change(function(){
                        var id = $("#id").val();
                        var login = $("#login").val();
                        var email = $("#email").val();
                        var imie = $("#name").val();
                        var nazwisko = $("#surname").val();
                        $("#usersTable").load("../ajax.php", {reader:1, id: id, login: login, email: email, name: imie, surname: nazwisko},
                        function(responseTxt,statusTxt,xhr){
                            if(statusTxt=="success"){
                                
                            }
                            if(statusTxt=="error")
                                alert("Error: "+xhr.status+": "+xhr.statusText);
                        });
                    });
                    $("#surname").change(function(){
                        var id = $("#id").val();
                        var login = $("#login").val();
                        var email = $("#email").val();
                        var imie = $("#name").val();
                        var nazwisko = $("#surname").val();
                        $("#usersTable").load("../ajax.php", {reader:1, id: id, login: login, email: email, name: imie, surname: nazwisko},
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