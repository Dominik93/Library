<?php

include_once backToFuture()."Library/Interface/userInterface.php";

class User implements IUser{
    protected $userID;
    protected $controller;
	
    public function __construct($c, $u = -1){
		$this->userID = $u;
		$this->controller = $c;
	}
        
    public function showMainPage(){
        return '<p>Witaj na stronie Biblioteki PAI!<br> Życzymy miłej zabawy z książkami☺</p>';
    }
    public function showHours(){
	return '<p>Godziny otwarcia:<br>
		Pon - Pt: 7:00 - 18:00<br>
		Sob: 9:00 - 15:00<br>
		Nd: Nieczynne</p>';
    }
    public function showSearch(){
            return '<div id="search" align="center">
		<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
			<table>
				<tr> <td colspan = 2 align="center">Szukaj książki:</td><tr>
				<tr><td>ISBN:</td><td><input type="text" value="'.@$_POST['isbn'].'" name="isbn" placeholder="ISBN"/></td></tr>
				<tr><td>Tytuł:</td><td><input type="text" value="'.@$_POST['title'].'" name="title" placeholder="Tytuł"/></td></tr>
				<tr><td>Wydawca:</td><td><input type="text" value="'.@$_POST['publisher_house'].'" name="publisher_house" placeholder="Wydawca"/></td></tr>
				<tr><td>Wydanie:</td><td><input type="text" value="'.@$_POST['edition'].'" name="edition" placeholder="Wydanie"/></td></tr>
				<tr><td>Rok wydania:</td><td><input type="text" value="'.@$_POST['premiere'].'" name="premiere" placeholder="Rok Wydania"/></td></tr>
				<tr><td>Autor:</td><td><input type="text" value="'.@$_POST['author'].'" name="author" placeholder="Imie Nazwisko"/></td></tr>
			</table>
			<input type="submit" value="Szukaj ksiażki">
                        
		</form>
                <button id="advancedSearch">Szukanie zaawansowane</button>
	</div>';
	}
    public function showAdvancedSearch() {
    }
    public function showContact(){
		return '<p>
					Biblioteka PAI<br>
					Adres: ul. Ulica Miasto<br> 000-000 Miasto<br>
					Telefon: 123456789<br>
					E-mail: mail@bpai.com
				</p>';
	}
    public function showRegulation(){
	return '<p><ul>'
                . '<li>1. Rejestracja w stacjonarnym punkcie biblioteki</li>'
                . '<li>2. Możliwość wypożyczenia książki tylko przez użytkowników z aktywnymi kontami</li>'
                . '<li>3. Jeżel książka nie będzie odebrana w 3 dni zostanie odesłana do magazynu</li>'
                . '<li>4. Za opóźnienie w oddaniu książki naliczana jest kara, 0,25 gr za dzień</li>'
                . '</ul></p>';
    }
    public function showOptionPanel(){
		return '
			<div id="panelName">Panel użytkownika</div>
				<p align="center">
					Nie jesteś zalogowany!
				</p>
				<ul>
					<li><a href="'.  backToFuture().'Library/UserAction/login.php">Zaloguj się</a></li>
				</ul>';
	}
    public function showNews(){
        $this->controller->connect();
                $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "news");
                
		$news = '';
		if(mysqli_num_rows($result) == 0) {
                    $news = $news.'Brak newsów';
		}
                else{
                    while($row = mysqli_fetch_assoc($result)) {
                        $news .= '<div align="center"><table>'
                                . '<tr>'
                                . '<td align="center">'.$row['new_title'].'</td>'
                                . '<td align="right">'.$row['new_date'].'</td>'
                                . '</tr>'
                                . '<tr>'
                                . '<td colspan="2">'.$row['new_text'].'</td>'
                                . '</tr></table></div>';
                    }
                }
                $this->controller->close(); 
		return $news;
	}
   
    public function search($isbn, $title, $publisher_house, $edition, $premiere, $author){
            $books = "";
            $this->controller->connect();
            $authorDetail = array();
            $authorDetail[0] = "%".$authorDetail[0]."%";
            $authorDetail[1] = "%".$authorDetail[1]."%";  
            
            if(empty($isbn)) $isbn = "%";
            else $isbn = '%'.$isbn.'%';
            if(empty($title)) $title = "%";
            else $title = '%'.$title.'%';
            if(empty($publisher_house)) $publisher_house = "%";
            else $publisher_house = '%'.$publisher_house.'%';
            if(empty($edition)) $edition = "%";
            if(empty($premiere)) $premiere = "%";
            if(empty($author)) $author = "%";
            else{
                $authorDetail = explode(" ", $author);
                $authorDetail[0] = "%".$authorDetail[0]."%";
                $authorDetail[1] = "%".$authorDetail[1]."%";    
            }
            
            $isbn = $this->controller->clear($isbn);
            $title = $this->controller->clear($title);
            $publisher_house = $this->controller->clear($publisher_house);
            $edition = $this->controller->clear($edition);
            $premiere = $this->controller->clear($premiere);
            $author =  $this->controller->clear($author);
            
            $resultBook = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "view_books", 
                    null,
                    null,
                    array(
                        array("book_isbn","LIKE",$isbn,"AND"),
                        array("book_title","LIKE",$title,"AND"),
                        array("publisher_house_name","LIKE",$publisher_house,"AND"),
                        array("book_premiere","LIKE",$premiere,"AND"),
                        array("book_edition","LIKE",$edition,"")
                    ),
                    null,null,null);
            
            $bool = false;
            while($rowB = mysqli_fetch_assoc($resultBook)){
                $resultAuthor = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "authors",
                        null,null,
                        array(
                            array("authors.author_name","LIKE",$authorDetail[0],"AND"),
                            array("authors.author_surname","LIKE",$authorDetail[1],"")
                            ),
                    null,null,null);
                while($rowA = mysqli_fetch_assoc($resultAuthor)){
                    $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "authors_books",null,null,
                            array(array("author_id","=",$rowA['author_id'],"AND"),
                                array("book_id","=",$rowB['book_id'],"")
                                ),null,null,null); 
                    if(mysqli_num_rows($result)>0){
                        $bool = true;
                    }
                }
                if($bool){
                    $bool = false;
                    $resultA = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "authors", 
                            null,
                            array(
                                array("authors_books", "authors_books.author_id", "authors.author_id"),
                                array("books", "books.book_id", "authors_books.book_id")
                                ),
                            array(
                                array("books.book_id","=", $rowB['book_id'], " ")
                                ),null,null,null);
                    if(mysqli_num_rows($resultA) == 0) {
                        die('Brak autorów bład');
                    }
                    else{	
                        $books .= '<p>
                        ISBN: '.$rowB['book_isbn'].'<br>
                        Autor: '.$this->controller->authorsToString($resultA).'<br>
                        Tytuł: '.$rowB['book_title'].'<br>
                        Wydawca: '.$rowB['publisher_house_name'].'<br>
                        Ilość stron: '.$rowB['book_nr_page'].'<br>
                        Wydanie: '.$rowB['book_edition'].'<br>
                        Rok wydania: '.$rowB['book_premiere'].'<br>
                        <a href="'.backToFuture().'Library/UserAction/book.php?book='.$rowB['book_id'].'">Przejdź do książki</a>
                        </p>';
                    }
                }
            }
            $this->controller->close();
            return $books;
        }
    public function advancedSearch() {
        
    }
    
    public function logout(){
        $this->controller->connect();
        $this->controller->deleteTableWhere(false,"sessions", array(array("session_id","=", session_id(), "")));
        $this->controller->close();
        $_SESSION['id'] = session_regenerate_id(true);
        $_SESSION['logged'] = false;
        $_SESSION['user_id'] = -1;
        $_SESSION['acces_right'] = "user";
        $_SESSION['ip'] = null;
        $_SESSION['user'] = serialize(new User(new Controller()));
        return '<p>Zostałeś wylogowany. Przejdz na <a href="'.backToFuture().'Library/index.php">strone główną</a>.</p>';       
    }
    public function login($login, $password) {
        $this->controller->connect();
            $login = $this->controller->clear($login);
            $password = $this->controller->clear($password);
            $result = $this->controller->validationLoginAdmin($login, $password);
            if(mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
                
                do{
                    $r = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false,
                            "sessions",null,null,
                            array(
                                array("session_id","=",  session_regenerate_id(),"")));
                }while(mysqli_num_rows($r) > 0);
                
                $_SESSION['id'] = session_id();
		$_SESSION['logged'] = true;
		$_SESSION['user_id'] = $row['admin_id'];
		$_SESSION['acces_right'] = "admin";
                $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['user'] = serialize(new Admin(new Controller(), $u = $row['admin_id']));
                
                $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(TRUE,"sessions",null,null,
                        array(array("session_user","=", $row['admin_id'],"AND"),
                            array("session_acces_right","=", "admin" ,"")
                            ));
                if(mysqli_num_rows($result) > 0){
                    $this->controller->deleteTableWhere(true,"sessions", array(array("session_user","=", $row['admin_id'],"AND"),
                            array("session_acces_right","=", "admin" ,"")
                            ));
                }
                $this->controller->insertTableRecordValue(true,"sessions", 
                        array("session_id", "session_ip", "session_user", "session_user_agent","session_logged", "session_acces_right"),
                        array(session_id(), $_SESSION['ip'], $row['admin_id'],$_SESSION['user_agent'], 1, "admin" ));
                $this->controller->close();
                return '<p>Witaj jesteś adminem, zostałeś poprawnie zalogowany! Możesz teraz przejść na <a href="'.backToFuture().'Library/index.php">stronę główną</a>.</p>';
            }
            else{
                
		$result = $this->controller->validationLoginReader($login, $password);
		if(mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    
                    do{
                    $r = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false,
                            "sessions",null,null,
                            array(
                                array("session_id","=",  session_regenerate_id(),"")));
                    }while(mysqli_num_rows($r) > 0);
                    
                    $_SESSION['id'] = session_id();
                    $_SESSION['logged'] = true;
                    $_SESSION['user_id'] = $row['reader_id'];
                    $_SESSION['acces_right'] = "reader";
                    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
                    $_SESSION['user'] = serialize(new Reader($this->isActive($row['reader_id']), new Controller(), $u = $row['reader_id']));
                    $this->controller->connect();
                    $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(true,"sessions",null,null,
                        array(array("session_user","=", $row['reader_id'],"AND"),
                            array("session_acces_right","=", "reader" ,"")
                            ));
                    if(mysqli_num_rows($result) > 0){
                        $this->controller->deleteTableWhere(TRUE, "sessions", array(array("session_user","=", $row['reader_id'],"AND"),
                                array("session_acces_right","=", "admin" ,"")
                                ));
                    }
                    
                    $this->controller->insertTableRecordValue(true,"sessions", 
                            array("session_id", "session_ip","session_user_agent", "session_user", "session_logged", "session_acces_right"),
                            array(session_id(), $_SESSION['ip'], $_SESSION['user_agent'], $row['reader_id'], 1, "reader" ));
                    $this->controller->close();
                    return '<p>Witaj jesteś czytelnikiem, zostałeś poprawnie zalogowany! Możesz teraz przejść na <a href="'.backToFuture().'Library/index.php">stronę główną</a>.</p>';
		}
                else{
                    $this->controller->close();
                    return '<p>Podany login i/lub hasło jest nieprawidłowe.</p>';
		}
            }
        }
        
    public function session(){
    }    
    public function checkSession(){
            $this->controller->connect();
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(true, "sessions", null, null, 
                    array(array("session_id", "=" , session_id(),"")));
            
            if(mysqli_num_rows($result) != 1){
                $this->controller->close();
                return false;
            }
            $row = mysqli_fetch_assoc($result);
            if($row['session_ip'] != $_SERVER['REMOTE_ADDR']){
                $this->controller->close();
                return false;
            }
            if($row['session_user_agent'] != $_SERVER['HTTP_USER_AGENT']){
                $this->controller->close();
                return false;
            }
            $this->controller->close();
            return true;
        }
    public function timeOut(){
            $_SESSION['id'] = session_regenerate_id(true);
            $_SESSION['logged'] = false;
            $_SESSION['user_id'] = -1;
            $_SESSION['acces_right'] = "user";
            $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            $_SESSION['user'] = serialize(new User(new Controller()));
        }

    public function showAccount(){
            return '<p>Brak dostępu</p>';
	}
    public function extendAccount($id) {
        return '<p>Brak dostępu</p>';
    }
    
    public function showLoginForm(){
        return '<div align="center" id="login">' 
                    . '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">'
                        . '<table>'
                            . '<tr align="center">'
                                . '<td>Logowanie</td>'
                            . '</tr>'
                            . '<tr>'
                                . '<td><input type="text" required placeholder="Login" name="login" value=""></td>'
                            . '</tr>'
                            . '<tr>'
                                . '<td><input type="password" required placeholder="Hasło" name="password" value=""></td>'
                            . '</tr>'
                        . '</table>'
                        . '<input type="submit" value="Zaloguj się">'
                    . '</form>'
                . '</div>';
	}    
    public function showAddBookForm() {
            return '<p>Brak dostępu</p>';
        }
    public function showAddNewsForm(){
            return '<p>Brak dostępu</p>';
        }
    public function showAddReaderForm(){
        return '<p>Brak dostępu</p>';
    }
    public function showAddAdminForm() {
        return '<p>Brak dostępu</p>';
    }
    
    public function showAllReaders($id, $login, $email, $name, $surname) {
            return '<p>Brak dostępu</p>';
        }
    public function showAllBooks($id, $isbn, $title, $publisher_house, $premiere, $edition) {
            return '<p>Brak dostępu</p>';
        }
    public function showAllAdmins($id, $login, $email, $name, $surname) {
            return '<p>Brak dostępu</p>';
        }
    public function showAllBorrows($id, $bookId, $readerId, $dateBorrow, $dateReturn){
            return '<p>Brak dostępu</p>';
        }
    public function showAllLogged(){
        return '<p>Brak dostępu</p>';
    }
    
    public function showAdmin($adminID){
            return '<p>Brak dostępu</p>';
        }
    public function showEditAdmin($readerID) {
        return '<p>Brak dostępu</p>';
    }
    
    public function showReader($readerID){
            return '<p>Brak dostępu</p>';
        } 
    public function showReaderLight($readerID){
            return '<p>Brak dostępu</p>';
        }
    public function showEditReader($readerID){
            return '<p>Brak dostępu</p>';
        }
    
    public function showBook($bookID, $active = "disabled") {
        $this->controller->connect();
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "books", 
                    array("books.*", "publisher_houses.publisher_house_name"),
                    array(array("publisher_houses", "publisher_houses.publisher_house_id", "books.book_publisher_house_id")),
                    array(array("books.book_id","=", $bookID, "")));
            $row = mysqli_fetch_assoc($result);
            $resultAuthors = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "authors", 
                            array("authors.*"),
                            array(
                                        array("authors_books", "authors_books.author_id", "authors.author_id"),
                                        array("books", "books.book_id", "authors_books.book_id")
                                        ),
                            array(
                                        array("books.book_id","=", $row['book_id'], "")
                                        )
                            );

            if($row['free_books'] == null){
                $freeBook = $row['book_number'];
            }
            else{
                $freeBook = $row['free_books'];
            }
            
            $return = '<p>
					ISBN: '.$row['book_isbn'].'<br>
					Tytuł: '.$row['book_title'].'<br>
					Autorzy: '.$this->controller->authorsToString($resultAuthors).'<br>
					Wydawnictwo: '.$row['publisher_house_name'].'<br>
					Premiera: '.$row['book_premiere'].'<br>
					Wydanie: '.$row['book_edition'].'<br>
					Ilość stron: '.$row['book_nr_page'].'<br>
					Ilość dostępnych egzemplarzy: '.$freeBook.'<br>
					<form align="center" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?book='.$row['book_id'].'" method="post">
                                        <p><input type="hidden" name="orderHidden" value="'.$row['book_id'].'" />		
                                        <input type="submit" name="order" '.$active.' value="Zamów">
					</form>
				</p>';
            $this->controller->close();
            return $return;
        }
    public function showEditBook($bookID) {
        return '<p>Brak dostępu</p>';
    }
    public function showBookLight($bookID) {
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "books", 
                    array("books.*", "publisher_houses.publisher_house_name"),
                    array(array("publisher_houses", "publisher_houses.publisher_house_id", "books.book_publisher_house_id")),
                    array(array("books.book_id","=", $bookID, "")));
            $row = mysqli_fetch_assoc($result);
            $resultAuthors = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "authors", 
                            array("authors.*"),
                            array(
                                        array("authors_books", "authors_books.author_id", "authors.author_id"),
                                        array("books", "books.book_id", "authors_books.book_id")
                                        ),
                            array(
                                        array("books.book_id","=", $row['book_id'], "")
                                        )
                            );
            return '<p>
					ID: '.$this->controller->clear($row['book_id']).'<br>
					ISBN: '.$this->controller->clear($row['book_isbn']).'<br>
					Tytuł: '.$this->controller->clear($row['book_title']).'<br>
					Autorzy: '.$this->controller->clear($this->controller->authorsToString($resultAuthors)).'<br>
					Wydawnictwo: '.$this->controller->clear($row['publisher_house_name']).'<br>
				</p>';
        }
        
    public function showBorrow($borrowID){
            return '<p>Brak dostępu</p>';
        }
    public function showMyBorrows(){
            return '<p>Brak dostępu</p>';
        }
        
    public function addReader($login, $email, $name, $surname, $password1, $password2, $country, $city, $street, $post_code, $nr_house){
            return '<p>Brak dostępu</p>';
	}
    public function editReader($id, $login, $email, $name, $surname, $country, $city, $street, $post_code, $nr_house) {
            return '<p>Brak dostępu</p>';
        }
    public function deleteReader($id) {
        return '<p>Brak dostępu</p>';
    }
        
    public function addBook($isbn, $original_title, $title, $original_punblisher_house, $original_country, $publisher_house, $country, $nr_page, $edition, $premiere, $number, $cover, $authorName, $authorSurname, $translatorName, $translatorSurname) {
            return '<p>Brak dostępu</p>';
        }
    public function editBook($id, $isbn, $original_title, $title, $original_punblisher_house, $original_country, $publisher_house, $country, $nr_page, $edition, $premiere, $number, $cover, $authorName, $authorSurname, $translatorName, $translatorSurname) {
        return '<p>Brak dostępu</p>';
    }
    public function deleteBook($id) {
        return '<p>Brak dostępu</p>';
    }
    
    public function addAdmin($name, $surname, $password1, $password2, $email, $login) {
            return '<p>Brak dostępu</p>';
        }
    public function editAdmin($id, $name, $surname, $email, $login) {
        return '<p>Brak dostępu</p>';
    }
    public function deleteAdmin($id) {
        return '<p>Brak dostępu</p>';
    }
    
    public function addNews($title, $text){
            return '<p>Brak dostępu</p>';
        }
    public function deleteNews($id){
            return '<p>Brak dostępu</p>';
        }
    
    public function addBorrow($bookID) {
            return '<p>Brak dostępu</p>';
        }
    public function deleteBorrow($id) {
        return '<p>Brak dostępu</p>';
    }
    public function receiveBorrow($id) {
        return '<p>Brak dostępu</p>';
    }    
   
    public function isActive($ID){
        $this->controller->connect();
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "readers",
                    array("acces_right_name"),
                    array(array("acces_rights", "acces_rights.acces_right_id", "readers.reader_acces_right_id")),
                    array(array("readers.reader_id", "=", $ID, "")));
            $this->controller->close();
            $row = mysqli_fetch_array($result);
            if($row['acces_right_name'] == 'activeReader')
                return 1;
            else
                return 0;
        }
        
    public function getData($ID){
            return $this->Data;
	}
    
    public function changePass($oldPass, $newPass) {
        return '<p>Brak dostępu</p>';
    }
    public function showChangePassForm() {
        return '<p>Brak dostępu</p>';
    }
    public function generateNewPas($id) {
        return '<p>Brak dostępu</p>';
    }

}
?>