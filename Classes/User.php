<?php

include_once backToFuture()."Library/Interface/userInterface.php";

class User implements IUser{
    protected $userID;
    protected $controller;
	
    public function __construct($c, $u = -1){
		$this->userID = $u;
		$this->controller = $c;
	}
    
    private function bookLight($rowBookClean, $resultAuthors){
        return '<p>
                        ISBN: '.$rowBookClean['book_isbn'].'<br>
                        Autor: '.$this->controller->authorsToString($resultAuthors).'<br>
                        Tytuł: '.$rowBookClean['book_title'].'<br>
                        Wydawca: '.$rowBookClean['publisher_house_name'].'<br>
                </p>';
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
			Ilość dostępnych egzemplarzy: '.$freeBook.'<br>
                        <button id="editBook">Edytuj</button>
                        <button id="deleteBook">Usuń</button>
		<div>';
    }    
        
    public function showAjaxBooksSearch(){
        return '<p>Brak dostępu</p>';
    }
    public function showAjaxBoorowsSearch(){
        return '<p>Brak dostępu</p>';
    }
    public function showAjaxReadersSearch(){
        return '<p>Brak dostępu</p>';
    }
    public function showAjaxAdminSearch(){
        return '<p>Brak dostępu</p>';
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
        $return =  '<div id="search" align="center">
		<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
			<table>
				<tr> <td colspan = 3 align="center">Szukaj książki:</td><tr>
				<tr>
                                <td>ISBN:</td>
                                <td><input type="text" value="'.@$_POST['isbn'].'" name="isbn" placeholder="ISBN"/></td></tr>
				<tr>
                                <td>Tytuł:</td>
                                <td><input type="text" value="'.@$_POST['title'].'" name="title" placeholder="Tytuł"/></td></tr>
				<tr>
                                <td>Wydawca:</td>
                                <td><input type="text" value="'.@$_POST['publisher_house'].'" name="publisher_house" placeholder="Wydawca"/></td></tr>
				<tr>
                                <td>Wydanie:</td>
                                <td><input type="text" value="'.@$_POST['edition'].'" name="edition" placeholder="Wydanie"/></td></tr>
				<tr>
                                <td>Rok wydania:</td>
                                <td><input type="text" value="'.@$_POST['premiere'].'" name="premiere" placeholder="Rok Wydania"/></td></tr>
				<tr>
                                <td>Autor:</td>
                                <td><input type="text" value="'.@$_POST['authorName'].'" name="authorName" placeholder="Imie"/></td>
                                <td><input type="text" value="'.@$_POST['authorSurname'].'" name="authorSurname" placeholder="Nazwisko"/></td></tr>
			</table>
			<input type="submit" value="Szukaj ksiażki">
                        
		</form>
                <button id="advancedSearch">Szukanie zaawansowane</button>
	</div>';
        return $return;
	}
    public function showAdvancedSearch() {
        $this->controller->connect();
        $form =  '<div id="advancedSearch" align="center">
		<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
			<table>
				<tr>
                                    <td colspan="3" align="center">Szukaj:</td>
                                </tr>
				<tr>
                                    <td>ISBN:</td>
                                    <td><input type="text" value="" name="isbn" placeholder="ISBN"/></td>
                                </tr>
				<tr>
                                    <td>Oryginalny tytuł:</td>
                                    <td><input type="text" value="" name="original_title" placeholder="Oryginalny tytuł"/></td>
                                </tr>
				<tr>
                                    <td>Tytuł:</td>
                                    <td><input type="text" value="" name="title" placeholder="Tytuł"/></td>
                                </tr>
                                <tr>
                                    <td>Oryginalny wydawca:</td>
                                    <td><input type="text" value="" name="original_publisher_house" placeholder="Oryginalny wydawca"/></td>
                                    <td><input type="text" value="" name="country_original_publisher_house" placeholder="Kraj"/></td>
                                </tr>        
				<tr>
                                    <td>Wydawca:</td>
                                    <td><input type="text" value="" name="publisher_house" placeholder="Wydawca"/></td>
                                    <td><input type="text" value="" name="country_publisher_house" placeholder="Kraj"/></td>
                                </tr>
				<tr>
                                    <td>Ilość stron:</td>
                                    <td><input type="text" value="" name="nr_page" placeholder="Ilość stron"/></td>
                                </tr>
				<tr>
                                    <td>Wydanie:</td>
                                    <td><input type="text" value="" name="edition" placeholder="Wydanie"/></td>
                                </tr>
				<tr>
                                    <td>Rok wydania:</td>
                                    <td><input type="text" value="" name="premiere" placeholder="Rok Wydania"/></td>
                                </tr>
                                <tr>
                                    <td>Okładka:</td>
                                    <td><input type="text" value="" name="cover" placeholder="Okładka"/></td>
                                </tr>
                                <tr>
                                    <td>Autor:</td>
                                    <td><input type="text" value="" name="authorName[0]" placeholder="Imie"/></td>
                                    <td><input type="text" value="" name="authorSurname[0]" placeholder="Nazwisko"/></td>
                                </tr>
                                <tr>
                                    <td>Tłumacz:</td>
                                    <td><input type="text" value="" name="translatorName[0]" placeholder="Imie"/></td>
                                    <td><input type="text" value="" name="translatorSurname[0]" placeholder="Nazwisko"/></td>
                                </tr>
                                </table>                        
                                
                                
			<input type="submit" value="Szukaj">
		</form>
	</div>';
        $this->controller->close();
        return $form;
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
                        $rowClean = $this->controller->clearArray($row, array_keys($row));
                        $news .= '<div align="center"><table>'
                                . '<tr>'
                                . '<td align="center">'.$rowClean['new_title'].'</td>'
                                . '<td align="right">'.$rowClean['new_date'].'</td>'
                                . '</tr>'
                                . '<tr>'
                                . '<td colspan="2">'.$rowClean['new_text'].'</td>'
                                . '</tr></table></div>';
                    }
                }
                $this->controller->close(); 
		return $news;
	}
    public function search($search){
        $this->controller->connect();
        $searchClean = $this->controller->clearArray($search, array_keys($search));
        $books = "";
        if(empty($searchClean["isbn"])){
            $searchClean['isbn'] = "%";
        }
        else{
            $searchClean['isbn'] = '%'.$searchClean['isbn'].'%';
        }
        if(empty($searchClean['title'])){ 
            $searchClean['title'] = "%";
        }
        else{
            $searchClean['title'] = '%'.$searchClean['title'].'%';
        }
        if(empty($searchClean['publisher_house'])){
            $searchClean['publisher_house'] = "%";
        }
        else{
            $searchClean['publisher_house'] = '%'.$searchClean['publisher_house'].'%';
        }
        if(empty($searchClean['edition'])){
            $searchClean['edition'] = "%";
        }    
        if(empty($searchClean['premiere'])){
            $searchClean['premiere'] = "%";
        }
        if(empty($searchClean['authorName'])){
            $searchClean['authorName'] = "%";
        }
        else{
            $searchClean['authorName'] = '%'.$searchClean['authorName'].'%';
        }
        if(empty($searchClean['authorSurname'])){
            $searchClean['authorSurname'] = "%";
        }
        else{
            $searchClean['authorSurname'] = '%'.$searchClean['authorSurname'].'%';
        }    
        $resultBook = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false,
                    "view_books", 
                    null,
                    null,
                    array(
                        array("book_isbn","LIKE",$searchClean["isbn"],"AND"),
                        array("book_title","LIKE",$searchClean['title'],"AND"),
                        array("publisher_house_name","LIKE",$searchClean['publisher_house'],"AND"),
                        array("book_premiere","LIKE",$searchClean['premiere'],"AND"),
                        array("book_edition","LIKE",$searchClean['edition'],"")
                    ),
                    null,null,null);
        $bool = false;
        while($rowBook = mysqli_fetch_assoc($resultBook)){
            $rowBookClean = $this->controller->clearArray($rowBook, array_keys($rowBook));
            $resultAuthor = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, 
                        "authors",
                        null,
                        null,
                        array(
                            array("authors.author_name","LIKE",$searchClean['authorName'],"AND"),
                            array("authors.author_surname","LIKE",$searchClean['authorSurname'],"")
                            ));
            while($rowAuthor = mysqli_fetch_assoc($resultAuthor)){
                $rowAuthorClean = $this->controller->clearArray($rowAuthor, array_keys($rowAuthor));
                $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false,
                            "authors_books",
                            null,
                            null,
                            array(array("author_id","=",$rowAuthorClean['author_id'],"AND"),
                                array("book_id","=",$rowBookClean['book_id'],"")
                                )); 
                if(mysqli_num_rows($result)>0){
                    $bool = true;
                }
            }
            if($bool){
                $bool = false;
                $resultA = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false,
                            "authors", 
                            null,
                            array(
                                array("authors_books", "authors_books.author_id", "authors.author_id"),
                                array("books", "books.book_id", "authors_books.book_id")
                                ),
                            array(
                                array("books.book_id","=", $rowBookClean['book_id'], " ")
                                ));
                if(mysqli_num_rows($resultA) == 0){
                    $this->controller->close();
                    return 'Błąd przy wykonywaniu zapytania';
                }
                else{	
                    $books .= '<p>
                        ISBN: '.$rowBookClean['book_isbn'].'<br>
                        Autor: '.$this->controller->authorsToString($resultA).'<br>
                        Tytuł: '.$rowBookClean['book_title'].'<br>
                        Wydawca: '.$rowBookClean['publisher_house_name'].'<br>
                        Ilość stron: '.$rowBookClean['book_nr_page'].'<br>
                        Wydanie: '.$rowBookClean['book_edition'].'<br>
                        Rok wydania: '.$rowBookClean['book_premiere'].'<br>
                        <a href="'.backToFuture().'Library/UserAction/book.php?book='.$rowBookClean['book_id'].'">Przejdź do książki</a>
                        </p>';
                }
            }
        }
        $this->controller->close();
        if($books == ""){
            return '<p>Brak książke dla zapytania</p>';
        }
        return $books;
    }
    public function advancedSearch($isbn, $original_title, $title, $original_punblisher_house, $original_country, $publisher_house, $country,
            $nr_page, $edition, $premiere, $cover, $authorName, $authorSurname, $translatorName, $translatorSurname) {
        $books = ""; 
            
            if(empty($isbn)) $isbn = "%";
            
            if(empty($original_title)) $original_title = "%";
            else $original_title = '%'.$original_title.'%';
            if(empty($title)) $title = "%";
            else $title = '%'.$title.'%';
            
            if(empty($original_punblisher_house)) $original_punblisher_house = "%";
            else $original_punblisher_house = '%'.$original_punblisher_house.'%';
            if(empty($original_country)) $original_country = "%";
            else $original_country = '%'.$original_country.'%';
            
            if(empty($publisher_house)) $publisher_house = "%";
            else $publisher_house = '%'.$publisher_house.'%';
            if(empty($country)) $country = "%";
            else $country = '%'.$country.'%';
            
            if(empty($nr_page)) $nr_page = "%";
            if(empty($edition)) $edition = "%";
            if(empty($premiere)) $premiere = "%";
            if(empty($cover)) $cover = "%";
            
            if(empty($authorName[0])) $authorName[0] = "%";
            else $authorName[0] = '%'.$authorName[0].'%';
            if(empty($authorSurname[0])) $authorSurname[0] = "%";
            else $authorSurname[0] = '%'.$authorSurname[0].'%';
            
            if(empty($translatorName[0])) $translatorName[0] = "%";
            else $translatorName[0] = '%'.$translatorName[0].'%';
            if(empty($translatorSurname[0])) $translatorSurname[0] = "%";
            else $translatorSurname[0] = '%'.$translatorSurname[0].'%';
            
            $this->controller->connect();
		$isbn = $this->controller->clear($isbn);
		$title = $this->controller->clear($title);
		$publisher_house = $this->controller->clear($publisher_house);
		$nr_page = $this->controller->clear($nr_page);
		$edition = $this->controller->clear($edition);
		$premiere = $this->controller->clear($premiere);
		$original_punblisher_house = $this->controller->clear($original_punblisher_house);
		$cover = $this->controller->clear($cover);
		$original_title = $this->controller->clear($original_title);
                $country = $this->controller->clear($country);
                $original_country = $this->controller->clear($original_country);
                $authorName[0] = $this->controller->clear($authorName[0]);
                $authorSurname[0] = $this->controller->clear($authorSurname[0]);
                $translatorName[0] = $this->controller->clear($translatorName[0]);
                $translatorSurname[0]= $this->controller->clear($translatorSurname[0]);
            $resultBook = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "view_books", 
                    null,
                    null,
                    array(
                        array("book_isbn","LIKE",$isbn,"AND"),
                        array("book_title","LIKE",$title,"AND"),
                        array("publisher_house_name","LIKE",$publisher_house,"AND"),
                        array("book_nr_page","LIKE",$nr_page,"AND"),
                        array("book_edition","LIKE",$edition,"AND"),
                        array("book_premiere","LIKE",$premiere,"AND"),
                        array("original_publisher_house_name","LIKE",$original_punblisher_house,"AND"),
                        array("book_premiere","LIKE",$cover,"AND"),
                        array("book_original_title","LIKE",$original_title,"AND"),
                        array("publisher_house_country","LIKE",$country,"AND"),
                        array("original_publisher_house_country","LIKE",$original_country,"AND"),
                        array("book_edition","LIKE",$edition,"")
                    ),
                    null,null,null);
            
            $boolA = false;
            $boolT = false;
            while($rowB = mysqli_fetch_assoc($resultBook)){
                $resultAuthor = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "authors",
                        null,null,
                        array(
                            array("authors.author_name","LIKE",$authorName[0],"AND"),
                            array("authors.author_surname","LIKE",$authorSurname[0],"")
                            ),
                    null,null,null);
                while($rowA = mysqli_fetch_assoc($resultAuthor)){
                    $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "authors_books",null,null,
                            array(array("author_id","=",$rowA['author_id'],"AND"),
                                array("book_id","=",$rowB['book_id'],"")
                                ),null,null,null); 
                    if(mysqli_num_rows($result)>0){
                        $boolA = true;
                    }
                }
                $resultTranslators = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "translators",
                        null,null,
                        array(
                            array("translators.translator_name","LIKE",$translatorName[0],"AND"),
                            array("translators.translator_surname","LIKE",$translatorSurname[0],"")
                            ),
                    null,null,null);
                while($rowA = mysqli_fetch_assoc($resultTranslators)){
                    $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "translators_books",null,null,
                            array(array("translator_id","=",$rowA['translator_id'],"AND"),
                                array("book_id","=",$rowB['book_id'],"")
                                ),null,null,null); 
                    if(mysqli_num_rows($result)>0){
                        $boolT = true;
                    }
                }
                
                if($boolA && $boolT){
                    $boolA = false;
                    $boolT = false;
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
                    $resultT = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "translators", 
                            null,
                            array(
                                array("translators_books", "translators_books.translator_id", "translators.translator_id"),
                                array("books", "books.book_id", "translators_books.book_id")
                                ),
                            array(
                                array("books.book_id","=", $rowB['book_id'], " ")
                                ),null,null,null);
                    if(mysqli_num_rows($resultA) == 0) {
                        die('Brak autorów bład');
                    }
                    else{	
                       $books .= '<p>ISBN: '.$this->controller->clear($rowB['book_isbn']).'<br>
                                        Oryginalny tytuł: '.$this->controller->clear($rowB['book_original_title']).'<br>
					Tytuł: '.$this->controller->clear($rowB['book_title']).'<br>
					Autorzy: '.$this->controller->clear($this->controller->authorsToString($resultA)).'<br>
                                        Tłumacze: '.$this->controller->translatorsToString($resultT).'<br>
                                        Oryginalne wydawnictwo: '.$this->controller->clear($rowB['original_publisher_house_name']).'<br>
                                        Wydawnictwo: '.$this->controller->clear($rowB['publisher_house_name']).'<br>
					Premiera: '.$this->controller->clear($rowB['book_premiere']).'<br>
					Wydanie: '.$this->controller->clear($rowB['book_edition']).'<br>
					Ilość stron: '.$this->controller->clear($rowB['book_nr_page']).'<br>
                                        Okładka: '.$this->controller->clear($rowB['book_cover']).'<br>'
                               . '<a href="'.backToFuture().'Library/UserAction/book.php?book='.$this->controller->clear($rowB['book_id']).'">Przejdź do książki</a></p>';
                    }
                }
            }
            if($books == "")
                return '<p>Brak książke dla zapytania</p>';
            $this->controller->close();
            return $books;
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
            $loginClean = $this->controller->clear($login);
            $passwordClean = $this->controller->clear($password);
            $result = $this->controller->validationLoginAdmin($loginClean, $passwordClean);
            if(mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
                $rowClean = $this->controller->clearArray($row, array_keys($row));
                $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false,"sessions",null,null,
                        array(array("session_user","=", $rowClean['admin_id'],"AND"),
                            array("session_acces_right","=", "admin" ,"")
                            ));
                if(mysqli_num_rows($result) > 0){
                    $this->controller->deleteTableWhere(false,"sessions", array(array("session_user","=", $rowClean['admin_id'],"AND"),
                            array("session_acces_right","=", "admin" ,"")
                            ));
                }
                $_SESSION['logged'] = true;
		$_SESSION['user_id'] = $rowClean['admin_id'];
		$_SESSION['acces_right'] = "admin";
                $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['user'] = serialize(new Admin(new Controller(), $u = $rowClean['admin_id']));
                
                do{
                    session_regenerate_id();
                }while(!$this->controller->insertTableRecordValue(false,"sessions", 
                        array("session_id", "session_ip", "session_user", "session_user_agent", "session_acces_right"),
                        array(session_id(), $_SESSION['ip'], $rowClean['admin_id'],$_SESSION['user_agent'], "admin" )));
                
                $_SESSION['id'] = session_id();
		$this->controller->close();
                return '<p>Witaj jesteś adminem, zostałeś poprawnie zalogowany! Możesz teraz przejść na <a href="'.backToFuture().'Library/index.php">stronę główną</a>.</p>';
            }
            else{
		$result = $this->controller->validationLoginReader($loginClean, $passwordClean);
		if(mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $rowClean = $this->controller->clearArray($row, array_keys($row));
                    $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false,"sessions",null,null,
                        array(array("session_user","=", $rowClean['reader_id'],"AND"),
                            array("session_acces_right","=", "reader" ,"")
                            ));
                    if(mysqli_num_rows($result) > 0){
                        $this->controller->deleteTableWhere(false, "sessions", array(array("session_user","=", $rowClean['reader_id'],"AND"),
                                array("session_acces_right","=", "admin" ,"")
                                ));
                    }
                    $_SESSION['logged'] = true;
                    $_SESSION['user_id'] = $rowClean['reader_id'];
                    $_SESSION['acces_right'] = "reader";
                    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
                    $_SESSION['user'] = serialize(new Reader(new Controller(), $u = $rowClean['reader_id']));
                    
                    
                    do{
                        session_regenerate_id();
                    }while(!$this->controller->insertTableRecordValue(false,"sessions", 
                            array("session_id", "session_ip","session_user_agent", "session_user", "session_acces_right"),
                            array(session_id(), $_SESSION['ip'], $_SESSION['user_agent'], $rowClean['reader_id'], "reader" )));
                    
                    $_SESSION['id'] = session_id();
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
        return '<p>Nie masz jeszcze konta</p>'; 
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
    
    public function showAllReaders($array) {
            return '<p>Brak dostępu</p>';
        }
    public function showAllBooks($array) {
            return '<p>Brak dostępu</p>';
        }
    public function showAllAdmins($array) {
            return '<p>Brak dostępu</p>';
        }
    public function showAllBorrows($array){
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
    
    public function showBook($bookID) {
        $this->controller->connect();
        $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "view_books", 
                    null,
                    null,
                    array(
                        array("book_id","=", $bookID, "")));
        $row = mysqli_fetch_assoc($result);
        $rowClean= $this->controller->clearArray($row, array_keys($row));
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
        $return = $this->book($rowClean, $resultAuthors, $resultTranslators);
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
            $rowClean= $this->controller->clearArray($row, array_keys($row));
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
            return $this->bookLight($rowClean, $resultAuthors);
        }
        
    public function showBorrow($borrowID){
            return '<p>Brak dostępu</p>';
        }
    public function showMyBorrows(){
            return '<p>Brak dostępu</p>';
        }
        
    public function addReader($array){
            return '<p>Brak dostępu</p>';
	}
    public function editReader($array) {
            return '<p>Brak dostępu</p>';
        }
    public function deleteReader($id) {
        return '<p>Brak dostępu</p>';
    }
        
    public function addBook($isbn, $original_title, $title, $original_punblisher_house, $original_country, $publisher_house, $country, $nr_page, $edition, $premiere, $number, $cover, $authorName, $authorSurname, $translatorName, $translatorSurname, $path) {
            return '<p>Brak dostępu</p>';
        }
    public function editBook($id, $isbn, $original_title, $title, $original_punblisher_house, $original_country, $publisher_house, $country, $nr_page, $edition, $premiere, $number, $cover, $authorName, $authorSurname, $translatorName, $translatorSurname, $path) {
        return '<p>Brak dostępu</p>';
    }
    public function deleteBook($id) {
        return '<p>Brak dostępu</p>';
    }
    
    public function addAdmin($array) {
            return '<p>Brak dostępu</p>';
        }
    public function editAdmin($array) {
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
        return false;
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