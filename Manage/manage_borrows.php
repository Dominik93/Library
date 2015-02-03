<?php
    include "../config.php";
    function Content(){
        $user = unserialize($_SESSION['user']);
        echo '<div id="content">'.$user->showAjaxBoorowsSearch().$user->showAllBorrows($_POST).'</div>';
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
                        var idK = $("#id_book").val();
                        var idC = $("#id_reader").val();
                        var dateW = $("#date_borrow").val();
                        var dateZ = $("#date_return").val();
                        $("#borrowsTable").load("../ajax.php", {borrows:1, id: id, bookId: idK, $readerId: idC, $dateBorrow: dateW, $dateReturn: dateZ},
                        function(responseTxt,statusTxt,xhr){
                            if(statusTxt=="success"){
                                
                            }
                            if(statusTxt=="error")
                                alert("Error: "+xhr.status+": "+xhr.statusText);
                        });
                    });
                    $("#id_book").change(function(){
                        var id = $("#id").val();
                        var idK = $("#id_book").val();
                        var idC = $("#id_reader").val();
                        var dateW = $("#date_borrow").val();
                        var dateZ = $("#date_return").val();
                        $("#borrowsTable").load("../ajax.php", {borrows:1, id: id, bookId: idK, $readerId: idC, $dateBorrow: dateW, $dateReturn: dateZ},
                        function(responseTxt,statusTxt,xhr){
                            if(statusTxt=="success"){
                                
                            }
                            if(statusTxt=="error")
                                alert("Error: "+xhr.status+": "+xhr.statusText);
                        });
                    });
                    $("#id_reader").change(function(){
                        var id = $("#id").val();
                        var idK = $("#id_book").val();
                        var idC = $("#id_reader").val();
                        var dateW = $("#date_borrow").val();
                        var dateZ = $("#date_return").val();
                        $("#borrowsTable").load("../ajax.php", {borrows:1, id: id, bookId: idK, $readerId: idC, $dateBorrow: dateW, $dateReturn: dateZ},
                        function(responseTxt,statusTxt,xhr){
                            if(statusTxt=="success"){
                                
                            }
                            if(statusTxt=="error")
                                alert("Error: "+xhr.status+": "+xhr.statusText);
                        });
                    });
                    $("#date_borrow").change(function(){
                        var id = $("#id").val();
                        var idK = $("#id_book").val();
                        var idC = $("#id_reader").val();
                        var dateW = $("#date_borrow").val();
                        var dateZ = $("#date_return").val();
                        $("#borrowsTable").load("../ajax.php", {borrows:1, id: id, bookId: idK, $readerId: idC, $dateBorrow: dateW, $dateReturn: dateZ},
                        function(responseTxt,statusTxt,xhr){
                            if(statusTxt=="success"){
                                
                            }
                            if(statusTxt=="error")
                                alert("Error: "+xhr.status+": "+xhr.statusText);
                        });
                    });
                    $("#date_return").change(function(){
                        var id = $("#id").val();
                        var idK = $("#id_book").val();
                        var idC = $("#id_reader").val();
                        var dateW = $("#date_borrow").val();
                        var dateZ = $("#date_return").val();
                        $("#borrowsTable").load("../ajax.php", {borrows:1, id: id, bookId: idK, $readerId: idC, $dateBorrow: dateW, $dateReturn: dateZ},
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