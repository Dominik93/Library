<?php
// łączenie się z bazą danych
include 'config.php';
$user = unserialize($_SESSION['user']);
$controller = new Controller();

if(isset($_POST['editReader'])){
    echo $user->showEditReader($_POST['id']);
}

if(isset($_POST['book'])){
    $book = "";
    $authorDetail = array();
    $authorDetail[0] = "%".$authorDetail[0]."%";
    $authorDetail[1] = "%".$authorDetail[1]."%"; 
    if(empty($_POST['ID'])) 
        $id = "%";
    else 
        $id = '%'.$_POST['ID'].'%';
    if(empty($_POST['ISBN'])) 
        $isbn = "%";
    else 
        $isbn = '%'.$_POST['ISBN'].'%';
    if(empty($_POST['T'])) 
        $title = "%";
    else 
        $title = '%'.$_POST['T'].'%';
    if(empty($_POST['PH'])) 
        $publisher_house = "%";
    else 
        $publisher_house = '%'.$_POST['PH'].'%';
    if(empty($_POST['E'])) 
        $edition = "%";
    else
        $edition = $_POST['E'];
    if(empty($_POST['P'])) 
        $premiere = "%";
    else 
        $premiere = '%'.$_POST['P'].'%';
    if(empty($_POST['N']))
        $number = "%";
    else 
        $number = '%'.$_POST['N'].'%';
    if(empty($_POST['NP']))
        $nrPage = "%";
    else 
        $nrPage = '%'.$_POST['NP'].'%';
    if(empty($author))
        $author = "%";
    else{
        $authorDetail = explode(" ", $author);
        $authorDetail[0] = "%".$authorDetail[0]."%";
        $authorDetail[1] = "%".$authorDetail[1]."%";    
    }
    $isbn = $controller->clear($isbn);
    $title = $controller->clear($title);
    $publisher_house = $controller->clear($publisher_house);
    $edition = $controller->clear($edition);
    $premiere = $controller->clear($premiere);
    $number = $controller->clear($number);
    $author =  $controller->clear($author);
    $nrPage =  $controller->clear($nrPage);
    $result = $controller->selectTableWhatJoinWhereGroupOrderLimit("books",
                    array("*"),
                    array(
                        array("publisher_houses","publisher_houses.publisher_house_id","books.book_publisher_house_id"),
                        array("authors_books","authors_books.book_id","books.book_id"),
                        array("authors","authors_books.author_id","authors.author_id")
                        ),
            array(
                array("books.book_id","like",$id,"and"),
                array("book_isbn","like",$isbn,"and"),
                array("book_title","like",$title,"and"),
                array("publisher_houses.publisher_house_name","like",$publisher_house,"and"),
                array("book_nr_page","like",$nrPage,"and"),
                array("book_edition","like",$edition,"and"),
                array("book_premiere","like",$premiere,"and"),
                array("book_number","like",$number,"and"),
                array("authors.author_name","LIKE",$authorDetail[0],"and"),
                array("authors.author_surname","LIKE",$authorDetail[1],"")
                )
            
            );
            if(mysqli_num_rows($result) == 0) {
			$books = $books.'Brak książek';
            }
            else{
			$books = $books.'
				<div id="booksTable" align="center">
				<p><table>
					<tr> <td>ID</td> <td>ISBN</td> <td>Tytył</td> <td>Autorzy</td> <td>Wydawca</td> <td>Ilość stron</td> <td>Wydanie</td> <td>Premiera</td> <td>Ilość egzemplarzy</td> </tr>
				';
			while($row = mysqli_fetch_assoc($result)) {
				$resultAuthors = $controller->selectTableWhatJoinWhereGroupOrderLimit("authors", 
                                    array("authors.*"),
                                    array(
                                                array("authors_books", "authors_books.author_id", "authors.author_id"),
                                                array("books", "books.book_id", "authors_books.book_id")
                                                ),
                                    array(
                                                array("books.book_id", "=", $row['book_id'], "")
                                                )
                                    );
				$books = $books.'<tr onClick="location.href=\'http://torus.uck.pk.edu.pl/~dslusarz/Library/UserAction/book.php?book='.$row['book_id'].'\'" /> '
                                                    . '<td>'.$row['book_id'].'</td> '
                                                    . '<td>'.$row['book_isbn'].'</td> '
                                                    . '<td>'.$row['book_title'].'</td> '
                                                    . '<td>'.$controller->authorsToString($resultAuthors).'</td> '
                                                    . '<td>'.$row['publisher_house_name'].'</td>'
                                                    . ' <td>'.$row['book_nr_page'].'</td>'
                                                    . ' <td>'.$row['book_edition'].'</td> '
                                                    . '<td>'.$row['book_premiere'].'</td>'
                                                    . ' <td>'.$row['book_number'].'</td>'
                                                . ' </tr>';
			}
			$books = $books.'</table><p><a href="'.backToFuture().'Library/AdminAction/add_book.php">Dodaj</a></p></div>';
		}     
    echo '<p>'.$books.'</p>';
}

if(isset($_POST['borrows'])){
    echo '<p>'.templateTable($controller, array('ID','ID książki','ID czytelnika', 'Data wypożyczenia', 'Data zwrotu'),
                              array('borrow_id','borrow_book_id','borrow_reader_id', 'borrow_date_borrow', 'borrow_return'),
                                    "borrows", "borrowsTable", "borrow.php?id", null, null,
            array(
                array("borrow_id", "like", $_POST["ID"], "and"),
                array("borrow_book_id", "like", $_POST["IDK"], "and"),
                array("borrow_reader_id", "like", $_POST["IDC"], "and"),
                array("borrow_date_borrow", "like", $_POST["DW"], "and"),
                array("borrow_return", "like", $_POST["DZ"], "")
                )).'</p>';
}

if (isset($_POST['reader'])){
    echo '<p>'.templateTable($controller, array("ID", "Login", "Email", "Imie", "Nazwisko"),
                                        array("reader_id", "reader_login", "reader_email", "reader_name", "reader_surname"),
                                        "readers", "usersTable", "profile_readers.php?id", null, null,
            array(
                array("reader_id","like",$_POST['ID'],"and"),
                array("reader_login","like",$_POST['L'],"and"),
                array("reader_email","like",$_POST['E'],"and"),
                array("reader_name","like",$_POST['I'],"and"),
                array("reader_surname","like",$_POST['N'],"")
            )).'</p>';
}

if (isset($_POST['admin'])){
    echo '<p>'.templateTable($controller, array("ID", "Login", "Email", "Imie", "Nazwisko"),
                                        array("admin_id", "admin_login", "admin_email", "admin_name", "admin_surname"),
                                        "admins", "usersTable", "profile_admin.php?id", null, null,
            array(
                array("admin_id","like",$_POST['ID'],"and"),
                array("admin_login","like",$_POST['L'],"and"),
                array("admin_email","like",$_POST['E'],"and"),
                array("admin_name","like",$_POST['I'],"and"),
                array("admin_surname","like",$_POST['N'],"")
            )).'</p>';
}

if(isset($_POST['deleteBorrow'])){
    $controller->deleteTableWhere("borrows", array(array("borrow_id", "=", $_POST['delete'], "")));
    echo "<p>Książka została zwrócona</p>";
}

if(isset($_POST['deleteReader'])){
    $result = $controller->selectTableWhatJoinWhereGroupOrderLimit("borrows",
            null, null, array(array("borrow_reader_id","=",$_POST['deleteReader'],"")));
    if(mysqli_num_rows($result) > 0){
        echo "<p>Nie można usunąć czytelnika</p>";
    }
    else{
        $controller->deleteTableWhere("readers", array(array("reader_id", "=", $_POST['deleteReader'], "")));
        echo "<p>Usunięto czytelnika</p>";
    }
}

if(isset($_POST['deleteBook'])){
    $result = $controller->selectTableWhatJoinWhereGroupOrderLimit("borrows",
            null, null, array(array("borrow_book_id","=",$_POST['deleteBook'],"")));
    if(mysqli_num_rows($result) > 0){
        echo "<p>Nie można usunąć książki</p>";
    }
    else{
        $controller->deleteTableWhere("authors_books", array(array("book_id", "=", $_POST['deleteBook'], "")));
        $controller->deleteTableWhere("books", array(array("book_id", "=", $_POST['deleteBook'], "")));
        echo "<p>Usunięto książke</p>";
    }
}

if(isset($_POST['deleteAdmin'])){
    $controller->deleteTableWhere("admins", array(array("admin_id", "=", $_POST['deleteAdmin'], "")));
    echo "<p>Usunięto admina</p>";
}

if(isset($_POST['newPassword'])){
    $pass = uniqid("reader".$_POST['newPassword'].'.');
    $controller->updateTableRecordValuesWhere("readers",
            array(array("reader_password", Codepass($pass))),
            array(array("reader_id", "=", $_POST['newPassword'], "")));
    echo "<p>Nowe hasło to: ".$pass.'</p>';
}

if(isset($_POST['extendAccount'])){
    $date = date_create(date('Y-m-d'));
    date_add($date, date_interval_create_from_date_string('365 days')); 
    $resultAccessRgihts = $controller->selectTableWhatJoinWhereGroupOrderLimit("acces_rights", 
                            array("*"),
                            null,
                            array(array("acces_right_name","=", "activeReader", "")));
    if(mysqli_num_rows($resultAccessRgihts) == 0) {
        die('<p>Błąd</p>');
    }
    $rowAR = mysqli_fetch_assoc($resultAccessRgihts);
    $controller->updateTableRecordValuesWhere("readers",
            array(array("reader_acces_right_id", $rowAR['acces_right_id'] )),
            array(array("reader_id", "=", $_POST['extendAccount'], ""))
            );
    $controller->updateTableRecordValuesWhere("readers", 
            array(array("reader_active_account", date_format($date,"y-m-d"))),
            array(array("reader_id", "=", $_POST['extendAccount'], ""))
            );
    echo "<p>Przedłużono konto</p>";
}

if(isset($_POST['receiveBorrow'])){
    $controller->updateTableRecordValuesWhere("borrows",
            array(array("borrow_received", "1")),
            array(array("borrow_id", "=", $_POST['receiveBorrow'], "")));
    echo "<p>Odebrano książke<p>";
}

if(isset($_POST['login'])){
	$login = $_POST['login'];
	$login = $controller->clear($login);
	$dostepny = true;
	$result = $controller->selectTableWhatJoinWhereGroupOrderLimit("readers", null, null,
                array(array("reader_login","=",$login,"")));
	
	if(mysqli_num_rows($result)){
		$dostepny = false;
	}
	$result = $controller->selectTableWhatJoinWhereGroupOrderLimit("admins", null, null,
                array(array("admin_login","=",$login,"")));
	if(mysqli_num_rows($result)){
		$dostepny = false;
	}
	if(!$dostepny){
		echo 'Niedostępny';
	}else{
		echo 'OK';
	}
}

if(isset($_POST['email'])){
	$email = $_POST['email'];
	$email = $controller->clear($email);
	$dostepny = true;
	$poprawny = true;
	if (filter_var($email, FILTER_VALIDATE_EMAIL) == false){
		$poprawny = false;
	}
	$result = $controller->selectTableWhatJoinWhereGroupOrderLimit("readers", null, null,
                array(array("reader_email","=",$email,"")));
	if(mysqli_num_rows($result) > 0){
		$dostepny = false;
	}
	$result = $controller->selectTableWhatJoinWhereGroupOrderLimit("admins", null, null,
                array(array("admin_email","=",$email,"")));
	if(mysqli_num_rows($result) > 0){
		$dostepny = false;
	}
	if(!$poprawny){
		echo 'Niepoprawny';
	}else if(!$dostepny){
		echo 'Niedostepny';
	}else{
		echo 'OK';
	}
}
?>