<?php
    include "../config.php";
	function Content(){
            $user = unserialize($_SESSION['user']);
            echo '<div id="content">'.$user->showAjaxBooksSearch().$user->showAllBooks($_POST).'</div>';  
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
                
                <script type="text/javascript">
                $(document).ready(function(){
                    $("#id").change(function(){
                        var id = $("#id").val();
                        var isbn = $("#isbn").val();
                        var title = $("#title").val();
                        var authorName = $("#authorName").val();
                        var authorSurname = $("#authorSurname").val();
                        var publHou = $("#publisher_house").val();
                        var edition = $("#edition").val();
                        var premiere = $("#premiere").val();
                        var number = $("#number").val();
                        $("#booksTable").load("../ajax.php", 
                        {book:1, id: id, idbn : isbn, title: title, authorName: authorName, authorSurname:authorSurname , publisher_house: publHou, edition:edition, premiere:premiere, number:number},
                        function(responseTxt,statusTxt,xhr){
                            if(statusTxt=="success"){
                                
                            }
                            if(statusTxt=="error")
                                alert("Error: "+xhr.status+": "+xhr.statusText);
                        });
                    });
                    $("#isbn").change(function(){
                        var id = $("#id").val();
                        var isbn = $("#isbn").val();
                        var title = $("#title").val();
                        var authorName = $("#authorName").val();
                        var authorSurname = $("#authorSurname").val();
                        var publHou = $("#publisher_house").val();
                        var edition = $("#edition").val();
                        var premiere = $("#premiere").val();
                        var number = $("#number").val();
                        $("#booksTable").load("../ajax.php", 
                        {book:1, id: id, idbn : isbn, title: title, authorName: authorName, authorSurname:authorSurname , publisher_house: publHou, edition:edition, premiere:premiere, number:number},
                        function(responseTxt,statusTxt,xhr){
                            if(statusTxt=="success"){
                                
                            }
                            if(statusTxt=="error")
                                alert("Error: "+xhr.status+": "+xhr.statusText);
                        });
                    });
                    $("#title").change(function(){
                        var id = $("#id").val();
                        var isbn = $("#isbn").val();
                        var title = $("#title").val();
                        var authorName = $("#authorName").val();
                        var authorSurname = $("#authorSurname").val();
                        var publHou = $("#publisher_house").val();
                        var edition = $("#edition").val();
                        var premiere = $("#premiere").val();
                        var number = $("#number").val();
                        $("#booksTable").load("../ajax.php", 
                        {book:1, id: id, idbn : isbn, title: title, authorName: authorName, authorSurname:authorSurname , publisher_house: publHou, edition:edition, premiere:premiere, number:number},
                        function(responseTxt,statusTxt,xhr){
                            if(statusTxt=="success"){
                                
                            }
                            if(statusTxt=="error")
                                alert("Error: "+xhr.status+": "+xhr.statusText);
                        });
                    });
                    $("#authorName").change(function(){
                        var id = $("#id").val();
                        var isbn = $("#isbn").val();
                        var title = $("#title").val();
                        var authorName = $("#authorName").val();
                        var authorSurname = $("#authorSurname").val();
                        var publHou = $("#publisher_house").val();
                        var edition = $("#edition").val();
                        var premiere = $("#premiere").val();
                        var number = $("#number").val();
                        $("#booksTable").load("../ajax.php", 
                        {book:1, id: id, idbn : isbn, title: title, authorName: authorName, authorSurname:authorSurname , publisher_house: publHou, edition:edition, premiere:premiere, number:number},
                        function(responseTxt,statusTxt,xhr){
                            if(statusTxt=="success"){
                                
                            }
                            if(statusTxt=="error")
                                alert("Error: "+xhr.status+": "+xhr.statusText);
                        });
                    });
                    $("#authorSurname").change(function(){
                        var id = $("#id").val();
                        var isbn = $("#isbn").val();
                        var title = $("#title").val();
                        var authorName = $("#authorName").val();
                        var authorSurname = $("#authorSurname").val();
                        var publHou = $("#publisher_house").val();
                        var edition = $("#edition").val();
                        var premiere = $("#premiere").val();
                        var number = $("#number").val();
                        $("#booksTable").load("../ajax.php", 
                        {book:1, id: id, idbn : isbn, title: title, authorName: authorName, authorSurname:authorSurname , publisher_house: publHou, edition:edition, premiere:premiere, number:number},
                        function(responseTxt,statusTxt,xhr){
                            if(statusTxt=="success"){
                                
                            }
                            if(statusTxt=="error")
                                alert("Error: "+xhr.status+": "+xhr.statusText);
                        });
                    });
                    $("#publisher_house").change(function(){
                        var id = $("#id").val();
                        var isbn = $("#isbn").val();
                        var title = $("#title").val();
                        var authorName = $("#authorName").val();
                        var authorSurname = $("#authorSurname").val();
                        var publHou = $("#publisher_house").val();
                        var edition = $("#edition").val();
                        var premiere = $("#premiere").val();
                        var number = $("#number").val();
                        $("#booksTable").load("../ajax.php", 
                        {book:1, id: id, idbn : isbn, title: title, authorName: authorName, authorSurname:authorSurname , publisher_house: publHou, edition:edition, premiere:premiere, number:number},
                        function(responseTxt,statusTxt,xhr){
                            if(statusTxt=="success"){
                                
                            }
                            if(statusTxt=="error")
                                alert("Error: "+xhr.status+": "+xhr.statusText);
                        });
                    });
                    $("#number_page").change(function(){
                        var id = $("#id").val();
                        var title = $("#title").val();
                        var authors = $("#authors").val();
                        var isbn = $("#isbn").val();
                        var publHou = $("#publisher_house").val();
                        var nrPa = $("#number_page").val();
                        var edition = $("#edition").val();
                        var premiere = $("#premiere").val();
                        var number = $("#number").val();
                        $("#booksTable").load("../ajax.php", 
                        {book:1, ID: id, ISBN : isbn, T: title, A: authors, PH: publHou, NP:nrPa, E:edition, P:premiere, N:number},
                        function(responseTxt,statusTxt,xhr){});
                    });
                    $("#edition").change(function(){
                        var id = $("#id").val();
                        var isbn = $("#isbn").val();
                        var title = $("#title").val();
                        var authorName = $("#authorName").val();
                        var authorSurname = $("#authorSurname").val();
                        var publHou = $("#publisher_house").val();
                        var edition = $("#edition").val();
                        var premiere = $("#premiere").val();
                        var number = $("#number").val();
                        $("#booksTable").load("../ajax.php", 
                        {book:1, id: id, idbn : isbn, title: title, authorName: authorName, authorSurname:authorSurname , publisher_house: publHou, edition:edition, premiere:premiere, number:number},
                        function(responseTxt,statusTxt,xhr){
                            if(statusTxt=="success"){
                                
                            }
                            if(statusTxt=="error")
                                alert("Error: "+xhr.status+": "+xhr.statusText);
                        });
                    });
                    $("#premiere").change(function(){
                        var id = $("#id").val();
                        var isbn = $("#isbn").val();
                        var title = $("#title").val();
                        var authorName = $("#authorName").val();
                        var authorSurname = $("#authorSurname").val();
                        var publHou = $("#publisher_house").val();
                        var edition = $("#edition").val();
                        var premiere = $("#premiere").val();
                        var number = $("#number").val();
                        $("#booksTable").load("../ajax.php", 
                        {book:1, id: id, idbn : isbn, title: title, authorName: authorName, authorSurname:authorSurname , publisher_house: publHou, edition:edition, premiere:premiere, number:number},
                        function(responseTxt,statusTxt,xhr){
                            if(statusTxt=="success"){
                                
                            }
                            if(statusTxt=="error")
                                alert("Error: "+xhr.status+": "+xhr.statusText);
                        });
                    });
                    $("#number").change(function(){
                        var id = $("#id").val();
                        var isbn = $("#isbn").val();
                        var title = $("#title").val();
                        var authorName = $("#authorName").val();
                        var authorSurname = $("#authorSurname").val();
                        var publHou = $("#publisher_house").val();
                        var edition = $("#edition").val();
                        var premiere = $("#premiere").val();
                        var number = $("#number").val();
                        $("#booksTable").load("../ajax.php", 
                        {book:1, id: id, idbn : isbn, title: title, authorName: authorName, authorSurname:authorSurname , publisher_house: publHou, edition:edition, premiere:premiere, number:number},
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