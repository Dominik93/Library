<?php
include_once "User.php";

class Reader extends User{
    private $active;

    public function __construct($c, $u = -1){
	parent::__construct($c, $u);
        $this->active = $this->isActive($u);
    }
    
    private function book($rowBookClean, $resultAuthors, $resultTranslators){
        if($rowBookClean['free_books'] == null){
            $freeBook = $rowBookClean['book_number'];
        }
        else{
            $freeBook = $rowBookClean['free_books'];
        }
        return '<div id="cover">'
        . '<img height="300" width="200" src="'.backToFuture().'Library/getImage.php?image='.$rowBookClean['book_cover_path'].'" alt="okładka"/>
            </div>
            <div id="book">
			ISBN: '.$rowBookClean['book_isbn'].'<br>
                        Oryginalny tytuł: '.$rowBookClean['book_original_title'].'<br>
			Tytuł: '. $rowBookClean['book_title'].'<br>
			Autorzy: '. $this->controller->authorsToString($resultAuthors).'<br>
                        Tłumacze: '.$this->controller->translatorsToString($resultTranslators).'<br>
                        Oryginalne wydawnictwo: '. $rowBookClean['original_publisher_house_name'].'<br>
                        Wydawnictwo: '. $rowBookClean['publisher_house_name'].'<br>
			Premiera: '. $rowBookClean['book_premiere'].'<br>
			Wydanie: '. $rowBookClean['book_edition'].'<br>
			Ilość stron: '. $rowBookClean['book_nr_page'].'<br>
                        Okładka: '. $rowBookClean['book_cover'].'<br>
                        Ilość wszsytkich egzemplarzy: '. $rowBookClean['book_number'].'<br>
                        <button id="editBook">Edytuj</button>
                        <button id="deleteBook">Usuń</button>
		<div>';
    }
    private function account($userDataClean){
        return '<p>
                            ID: '.$userDataClean['reader_id'].'<br>
                            Imie: '.$userDataClean['reader_name'].'<br>
                            Nazwisko: '.$userDataClean['reader_surname'].'<br>
                            Login: '.$userDataClean['reader_login'].'<br>
                            Email: '.$userDataClean['reader_email'].'<br>
                            Konto aktywne do: '.$userDataClean['reader_active_account'].'<br>
                            Adres: '.$userDataClean['country_name'].', '.$userDataClean['city_name'].' '.$userDataClean['post_code_name'].', ul. '.$userDataClean['street_name'].' '.$userDataClean['house_number_name'].'<br>	
                            <button id="changePassword">Zmien hasło</button>
			</p>';
    }
    
    public function showOptionPanel(){
        if(!$this->checkSession()){
            $this->timeOut();
            return parent::showOptionPanel();
        }
        $this->session();
        
        $userData = $this->getData($this->userID);
        return '<div id="panelName">Panel użytkownika</div>
			<p align="center">
				Witamy '.$userData['reader_name'].'!
			</p>
			<ul>
				<li><a href="'.backToFuture().'Library/UserAction/profile.php">Twój profil</a></li>
				<li><a href="'.backToFuture().'Library/UserAction/my_borrows.php">Twoje wypożyczenia</a></li>
				<li><a href="'.backToFuture().'Library/UserAction/logout.php">Wyloguj</a></li>
			</ul>';
	}
        
    public function session(){
        $this->controller->connect();
        do{
            session_regenerate_id();
        }while(!$this->controller->updateTableRecordValuesWhere(false,"sessions", 
                array(
                    array("session_id", session_id())
                    ),
                array(
                    array("session_user","=", $this->userID, "AND"),
                    array("session_acces_right","=", "reader", "")
                    )));
        $_SESSION['id'] = session_id();
        
        $this->controller->updateTableRecordValuesWhere(false,"sessions", 
                array(
                    array("session_id", session_id()),
                    array("session_last_action", date('Y-m-d H:i:s'))
                    ),
                array(
                    array("session_user", "=", $this->userID, "AND"),
                    array("session_acces_right","=", "reader", "")
                    ));
        $this->controller->close();
    }
    public function checkSession(){
            $this->controller->connect();
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "sessions", null, null, 
                    array(array("session_id", "=" , session_id(),"")));
            
            if(mysqli_num_rows($result) != 1){
                $this->controller->close();
                return false;
            }
            $row = mysqli_fetch_assoc($result);
            $rowClean = $this->controller->clearArray($row, array_keys($row));
            if($rowClean['session_ip'] != $_SERVER['REMOTE_ADDR']){
                $this->controller->close();
                return false;
            }
            if($rowClean['session_user_agent'] != $_SERVER['HTTP_USER_AGENT']){
                $this->controller->close();
                return false;
            }
            if(!$_SESSION['logged']){
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
	$userData = $this->getData($this->userID);  
        $this->controller->connect();
        $userDataClean = $this->controller->clearArray($userData, array_keys($userData));
        $return = $this->account($userDataClean);
        $this->controller->close();
        return $return;
    }
    
    public function showLoginForm(){
        return "<p>Jesteś już zalogowany!</p>";
    }
    public function showChangePassForm(){
        $this->controller->connect();
        $return = '<div id="changePass" align="center">
			<form action="'.backToFuture().'Library/UserAction/Edit/edit_pass.php" method="post">
				<table>
					<tr><td>Aktualne hasło:</td><td><input id="oldPassword" type="password" value="" name="oldPassword"  required/><span id="status_email"></span></td></tr>
					<tr><td>Nowe hasło:</td><td><input id="newPassword1" type="password" value="" name="newPassword1" required/></td></tr>
					<tr><td>Powtórz nowe hasło:</td><td><input id="newPassword2" type="password" value="" name="newPassword2" required/><span id="status_password"></span></td></tr>
				</table>
				<input type="submit" id="submit" value="Zmien">
			</form>
		</div>';
        $this->controller->close();
        return $return;
    }    
            
    public function showBook($bookID){
        $this->controller->connect();
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "view_books", 
                    null,
                    null,
                    array(
                        array("book_id","=", $bookID, "")));
            $row = mysqli_fetch_assoc($result);
            $rowClean = $this->controller->clearArray($row, array_keys($row));
            $resultAuthors = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "authors", 
                            array("authors.*"),
                            array(
                                        array("authors_books", "authors_books.author_id", "authors.author_id"),
                                        array("books", "books.book_id", "authors_books.book_id")
                                        ),
                            array(
                                        array("books.book_id","=", $rowClean['book_id'], "")
                                        )
                            );
            $resultTranslators = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "translators", 
                            array("translators.*"),
                            array(
                                        array("translators_books", "translators_books.translator_id", "translators.translator_id"),
                                        array("books", "books.book_id", "translators_books.book_id")
                                        ),
                            array(
                                        array("books.book_id","=", $rowClean['book_id'], "")
                                        )
                            );
            
            if($this->active == true){ 
                $active = "";
            }
            else{ 
                $active = "disabled";
            }
            $return = $this->book($rowClean,$resultAuthors,$resultTranslators).'<button name="orderBook" id="orderBook" '.$active.'>Zamów</button>';
            $this->controller->close();
            return $return;
        }
        
    public function showBorrow($borrowID){
        $borrow = "";
        $borrowResult = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "view_borrows",
                null, null,
                array(array("borrow_id","=", $borrowID, "")));
        $row = mysqli_fetch_array($borrowResult);
        $rowClean = $this->controller->clearArray($row, array_keys($row));
        
        if($row['borrow_delay'] > 0){
            $delay = $rowClean['borrow_delay'];
        }
        else{ 
            $delay = 0;
        }
        $borrow .= '<p>Data wypożyczenia: '.$rowClean['borrow_date_borrow'].'<br>'
                . 'Data zwrotu: '.$rowClean['borrow_return'].'<br>'
                . 'Opóźnienie: '.$delay.' dni<br>'
                . 'Kwota do zapłaty za opóźnienie: '.$delay*0.25.' </p>';
        $borrow .= '<div id="book" align="center">Książka:<br>'.$this->showBookLight($rowClean['borrow_book_id']).'</div>';
        return $borrow;
    }
    public function showMyBorrows(){
        $myBorrows = "";
        $this->controller->connect();
        $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "borrows", null, null, array(array("borrow_reader_id","=", $this->userID, "")));
        if(mysqli_num_rows($result) == 0){
            return "<p>Aklutalnie brak wypożyczeń</p>";
        }
        else{
            while($row = mysqli_fetch_array($result)){
                $myBorrows = $myBorrows.$this->showBorrow($row['borrow_id']);
                $myBorrows = $myBorrows.'<p>------------------------------------------</p>';
            }
        }
        $this->controller->close();
        return $myBorrows;
    }
    
    public function addBorrow($bookID) {
        $this->controller->connect();
        $date = date('Y-m-d');
        $dateReturn = date_create(date('Y-m-d'));
	date_add($dateReturn, date_interval_create_from_date_string('60 days'));
        $this->controller->insertTableRecordValue(false,"borrows",
                array("borrow_book_id", "borrow_reader_id", "borrow_date_borrow", "borrow_return"),
                array($bookID, $this->userID, $date, date_format($dateReturn,"y-m-d")));
        echo '<p>Zamówiono książke. Odbiór w najbliższych 3 dniach</p>';
        $this->controller->close();
        }
   
    public function isActive($ID){
        $this->controller->connect();
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "readers",
                    array("acces_right_name"),
                    array(array("acces_rights", "acces_rights.acces_right_id", "readers.reader_acces_right_id")),
                    array(array("readers.reader_id", "=", $ID, "")));
            
            $row = mysqli_fetch_array($result);
            $rowClean = $this->controller->clearArray($row, array_keys($row));
            $this->controller->close();
            if($rowClean['acces_right_name'] == 'activeReader'){
                return true;
            }
            else{
                return false;
            }
        }    
        
    public function getData($ID){
        $this->controller->connect();
        $ID = $this->controller->clear($ID);
        $data = $this->controller->getReaderData($ID);
        $dateClear = $this->controller->clearArray($data, array_keys($data));
        $this->controller->close();
	return $dateClear;
        
    }
    
    public function changePass($oldPass, $newPass){
        $this->controller->connect();
        $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "readers",array("reader_password"),null,
                array(array("reader_id","=",$this->userID,"")),null,null,null);
        $row = mysqli_fetch_assoc($result);
        if($row["reader_password"] != $this->controller->codepass($oldPass)){
            return "<p>Podano błedne hasło<p>";
        }
        $this->controller->updateTableRecordValuesWhere(false,"readers",
                array(array("reader_password", $this->controller->codepass($newPass))),
                array(array("reader_id","=",$this->userID,"")));
        $this->controller->close();
        return "<p>Zmieniono hasło<p>";
    }
    
}
?>