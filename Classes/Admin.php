<?php
include_once "User.php";

class Admin extends User{

    public function __construct($c, $u = -1) {
        return parent::__construct($c, $u);
    }
    private function addPublisherHouse($publisher_house, $country){
        $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "view_publisher_houses",
                        array("*"),
                        null, 
                        array(array("publisher_house_name", "=", $publisher_house,"AND"),
                            array("country_name", "=", $country, "")));
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
        }
        else{
            $this->controller->insertTableRecordValue(false,"publisher_houses",
                             array("publisher_house_name", "publisher_house_country_id"),
                    array($publisher_house, $this->addCountry($country)));
            
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "view_publisher_houses",
                        array("*"),
                        null, 
                        array(array("publisher_house_name", "=", $publisher_house,"AND"),
                            array("country_name", "=", $country, "")));
            $row = mysqli_fetch_array($result);
	}
        return $row[0];
    }
    private function addAuthors($authorName, $authorSurname, $bookId){
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "authors", 
                                null, null,
                                array(
                                    array("author_name","=", $authorName, "AND"),
                                    array("author_surname","=", $authorSurname, "")
                                    ));
            if(mysqli_num_rows($result) > 0){
		$rowA = mysqli_fetch_array($result);
            }
            else{
                    $this->controller->insertTableRecordValue(false,"authors",
                            array("author_name", "author_surname",),
                            array($authorName, $authorSurname));
                    $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "authors", 
                                        null, null,
                                        array(
                                            array("author_name","=", $authorName, "AND"),
                                            array("author_surname","=", $authorSurname, "")
                                        ));
                    $rowA = mysqli_fetch_array($result);
		}
            $this->controller->insertTableRecordValue(false,"authors_books",
                    array("author_id", "book_id"), 
                    array($rowA[0], $bookId));
        }
    private function addTranslators($translatorName, $translatorSurname, $bookId){
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "translators", 
                                array("*"), null,
                                array(
                                    array("translator_name","=", $translatorName, "AND"),
                                    array("translator_surname","=", $translatorSurname, "")
                                    ));
            if(mysqli_num_rows($result) > 0){
		$rowA = mysqli_fetch_array($result);
            }
            else{
                    $this->controller->insertTableRecordValue(false,"translators",
                            array("translator_name", "translator_surname"),
                            array($translatorName, $translatorSurname));
                    $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "translators", 
                                        array("*"), null,
                                        array(
                                            array("translator_name","=", $translatorName, "AND"),
                                            array("translator_surname","=", $translatorSurname, "")
                                        ));
                    $rowA = mysqli_fetch_array($result);
		}
            $this->controller->insertTableRecordValue(false,"translators_books",
                    array("translator_id", "book_id"), 
                    array($rowA[0], $bookId));
        }
    private function addAddress($country, $city, $postCode ,$street, $houseNumber){
        $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "view_addresses", null,null,
                array(
                    array("street_name","=",$street,"AND"),
                    array("post_code_name","=",$postCode,"AND"),
                    array("house_number_name","=",$houseNumber,"AND"),
                    array("country_name","=",$country,"AND"),
                    array("city_name","=",$city,"")
                    ));
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
            return $row[0];
        }
        $this->controller->insertTableRecordValue(false,"addresses",
                             array("address_street_id",
                                    "address_post_code_id",
                                    "address_nr_house_id",
                                    "address_country_id",
                                    "address_city_id"),
                    array($this->addStreet($street),
                        $this->addPostCode($postCode),
                        $this->addHouseNumber($houseNumber),
                        $this->addCountry($country),
                        $this->addCity($city)));
        $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "view_addresses", null,null,
                array(
                    array("street_name","=",$street,"AND"),
                    array("post_code_name","=",$postCode,"AND"),
                    array("house_number_name","=",$houseNumber,"AND"),
                    array("country_name","=",$country,"AND"),
                    array("city_name","=",$city,"")
                    ));
        $row = mysqli_fetch_array($result);
        return $row[0];
    }
    private function addCountry($country){
        $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "countries",
                        array("*"),
                        null, 
                        array(array("country_name", "=", $country,"")));
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
        }
        else{
            $this->controller->insertTableRecordValue(false,"countries",
                             array("country_name"),
                    array($country));
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "countries", array("*"), null,
                            array(array("countries.country_name","=", $country,"")));
            $row = mysqli_fetch_array($result);
	}
        return $row[0];
    }
    private function addPostCode($postCode){
        $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "post_codes",
                        array("*"),
                        null, 
                        array(array("post_code_name", "=", $postCode,"")));
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
        }
        else{
            $this->controller->insertTableRecordValue(false,"post_codes",
                             array("post_code_name"),
                    array($postCode));
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "post_codes", array("*"), null,
                            array(array("post_codes.post_code_name","=", $postCode,"")));
            $row = mysqli_fetch_array($result);
	}
        return $row[0];
    }
    private function addCity($city){
        $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "cities",
                        array("*"),
                        null, 
                        array(array("city_name", "=", $city,"")));
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
        }
        else{
            $this->controller->insertTableRecordValue(false,"cities",
                             array("city_name"),
                    array($city));
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "cities", array("*"), null,
                            array(array("cities.city_name","=", $city,"")));
            $row = mysqli_fetch_array($result);
	}
        return $row[0];
    }
    private function addStreet($street){
        $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "streets",
                        array("*"),
                        null, 
                        array(array("street_name", "=", $street,"")));
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
        }
        else{
            $this->controller->insertTableRecordValue(false,"streets",
                             array("street_name"),
                    array($street));
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "streets", array("*"), null,
                            array(array("streets.street_name","=", $street,"")));
            $row = mysqli_fetch_array($result);
	}
        return $row[0];
    }
    private function addHouseNumber($houseNumber){
        $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "house_numbers",
                        array("*"),
                        null, 
                        array(array("house_number_name", "=", $houseNumber,"")));
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
        }
        else{
            $this->controller->insertTableRecordValue(false,"house_numbers",
                             array("house_number_name"),
                    array($houseNumber));
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "house_numbers", array("*"), null,
                            array(array("house_numbers.house_number_name","=", $houseNumber,"")));
            $row = mysqli_fetch_array($result);
	}
        return $row[0];
    }
    
    private function bookLight($rowBookClean, $resultAuthors){
        return '<p>
                        ID: '.$rowBookClean['book_id'].'<br>
                        ISBN: '.$rowBookClean['book_isbn'].'<br>
                        Autor: '.$this->controller->authorsToString($resultAuthors).'<br>
                        Tytuł: '.$rowBookClean['book_title'].'<br>
                        Wydawca: '.$rowBookClean['publisher_house_name'].'<br>
                        Wydanie: '.$rowBookClean['book_edition'].'<br>
                        Rok wydania: '.$rowBookClean['book_premiere'].'<br>
                        <a href="'.backToFuture().'Library/UserAction/book.php?book='.$rowBookClean['book_id'].'">Przejdź do książki</a>
                </p>';
    }
    private function book($rowBookClean, $resultAuthors, $resultTranslators){
        if($rowBookClean['free_books'] == null){
            $freeBook = $rowBookClean['book_number'];
        }
        else{
            $freeBook = $rowBookClean['free_books'];
        }
        return '<p>
			ID: '.$rowBookClean['book_id'].'<br>
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
			Ilość dostępnych egzemplarzy: '.$freeBook.'<br>
                        <button id="editBook">Edytuj</button>
                        <button id="deleteBook">Usuń</button>
		</p>';
    }
    private function acountAdmin($userDataClean){
        return '<p>
                            ID: '.$userDataClean['admin_id'].'<br>
                            Imie: '.$userDataClean['admin_name'].'<br>
                            Nazwisko: '.$userDataClean['admin_surname'].'<br>
                            Login: '.$userDataClean['admin_login'].'<br>
                            Email: '.$userDataClean['admin_email'].'<br>
                            Prawa: '.$userDataClean['acces_right_name'].'<br>
                </p>';
    }
    private function acountReader($userDataClean){
        return '<p>
                    ID: '.$userDataClean['reader_id'].'<br>
                    Imie: '.$userDataClean['reader_name'].'<br>
                    Nazwisko: '.$userDataClean['reader_surname'].'<br>
                    Login: '.$userDataClean['reader_login'].'<br>
                    Email: '.$userDataClean['reader_email'].'<br>
                    Konto aktywne do: '.$userDataClean['reader_active_account'].'<br>
                    Adres: '.$userDataClean['country_name'].', '.$userDataClean['city_name'].' '.$userDataClean['post_code_name'].', ul. '.$userDataClean['street_name'].' '.$userDataClean['house_number_name'].'<br>	
                    Prawa: '.$userDataClean['acces_right_name'].'<br>
                    <button id="extendAccount">Przedłuż konto</button>
                    <button id="deleteReader">Usuń czytelnika</button> 
                    <button id="editReader">Edytuj</button> 
                    <button id="newPassword">Wygeneruj nowe hasło</button> 
                </p>';
       
    }
    
    public function showAjaxBooksSearch(){
        return '<div id="search" align="center"><table><tr>'
                . '<td><input placeholder="ID" style="width: 60%;" type="text" id="id"></td>'
                . '<td><input placeholder="ISBN" style="width: 60%;" type="text" id="isbn"></td>'
                . '<td><input placeholder="Tytuł" style="width: 60%;" type="text" id="title"></td>'
                . '<td><input placeholder="Imie autora" style="width: 60%;" type="text" id="authorName"></td>'
                . '<td><input placeholder="Nazwisko autora" style="width: 60%;" type="text" id="authorSurname"></td>'
                . '<td><input placeholder="Wydawca" style="width: 60%;" type="text" id="publisher_house"></td>'
                . '<td><input placeholder="Wydanie" style="width: 60%;" type="text" id="edition"></td>'
                . '<td><input placeholder="Premiera" style="width: 60%;" type="text" id="premiere"></td>' 
                . '</tr></table></div>';
    }
    public function showAjaxBoorowsSearch(){
        return '<div id="search" align="center"><table><tr>'
                . '<td><input placeholder="ID" style="width: 60%;" type="text" id="id"></td>'
                . '<td><input placeholder="ID książki" style="width: 60%;" type="text" id="id_book"></td>'
                . '<td><input placeholder="ID czytelnika" style="width: 60%;" type="text" id="id_reader"></td>'
                . '<td><input placeholder="Data wypożyczenia" style="width: 60%;" type="text" id="date_borrow"></td>'
                . '<td><input placeholder="Data zwrotu" style="width: 60%;" type="text" id="date_return"></td>'
                . '</tr></table></div>';
    }
    public function showAjaxReadersSearch(){
        return '<div id="search" align="center"><table><tr>'
                . '<td><input placeholder="ID" style="width: 60%;" type="text" id="id"></td>'
                . '<td><input placeholder="Login" style="width: 60%;" type="text" id="login"></td>'
                . '<td><input placeholder="Email" style="width: 60%;" type="text" id="email"></td>'
                . '<td><input placeholder="Imie" style="width: 60%;" type="text" id="name"></td>'
                . '<td><input placeholder="Nazwisko" style="width: 60%;" type="text" id="surname"></td>'
                . '</tr></table></div>';
    }
    public function showAjaxAdminSearch(){
        return '<div id="search" align="center"><table><tr>'
                . '<td><input placeholder="ID" style="width: 60%;" type="text" id="id"></td>'
                . '<td><input placeholder="Login" style="width: 60%;" type="text" id="login"></td>'
                . '<td><input placeholder="Email" style="width: 60%;" type="text" id="email"></td>'
                . '<td><input placeholder="Imie" style="width: 60%;" type="text" id="name"></td>'
                . '<td><input placeholder="Nazwisko" style="width: 60%;" type="text" id="surname"></td>'
                . '</tr></table></div><div id="table">';
    }
    
    public function showMainPage(){
        return parent::showMainPage();
    }
    public function showHours(){
         return parent::showHours();
    }
    public function showSearch(){
         return parent::showSearch();
    }
    public function showAdvancedSearch(){
         return parent::showAdvancedSearch();
    }
    public function showContact(){
         return parent::showContact();
    }
    public function showRegulation(){
         return parent::showRegulation();
    }
    public function showOptionPanel(){
        if(!$this->checkSession()){
            $this->timeOut();
            return parent::showOptionPanel();
        }
        $this->session();
	$userData = $this->getData($this->userID);
	return '<div id="panelName">Panel admina</div><p align="center">Witamy '.$userData['admin_name'].'!</p>
			<ul>
				<li><a href="'.backToFuture().'Library/UserAction/profile.php">Twój profil</a></li>
				<li><a href="'.backToFuture().'Library/AdminAction/Add/add_news.php">Dodaj news</a></li>
				<li><a href="'.backToFuture().'Library/AdminAction/Add/registration_reader.php">Zarejestruj czytelnika</a></li>
				<li><a href="'.backToFuture().'Library/AdminAction/Add/registration_admin.php">Utwórz administratora</a></li>
				<li><a href="'.backToFuture().'Library/Manage/manage_admins.php">Zarządzaj adminami</a></li>
				<li><a href="'.backToFuture().'Library/Manage/manage_readers.php">Zarządzaj czytelnikami</a></li>
				<li><a href="'.backToFuture().'Library/Manage/manage_books.php">Zarządzaj ksiażkami</a></li>
				<li><a href="'.backToFuture().'Library/Manage/manage_borrows.php">Zarządaj wypożyczeniami</a></li>
				<li><a href="'.backToFuture().'Library/Manage/manage_sessions.php">Lista zalogowanych</a></li>
                                <li><a href="'.backToFuture().'Library/UserAction/logout.php">Wyloguj</a></li>
			</ul>';	
	}
    public function showNews(){
        $this->controller->connect();
	$result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "news");
	$news = "";
	if(mysqli_num_rows($result) == 0) {
            $news = $news.'Brak newsów';
	}
        else{
            while($row = mysqli_fetch_assoc($result)){
                $rowClean = $this->controller->clearArray($row, array_keys($row));
                $news .= '<div align="center"><table>'
                                . '<tr>'
                                . '<td align="center">'.$rowClean['new_title'].'</td>'
                                . '<td align="right">'.$rowClean['new_date'].'</td>'
                                . '<td><a href="'.backToFuture().'Library/Menu/news.php?id='.$rowClean['new_id'].'">Usuń</a></td>'
                                . '</tr>'
                                . '<tr>'
                                . '<td colspan="3">'.$rowClean['new_text'].'</td>'
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
                    $books .= $this->bookLight($rowBookClean, $resultA);
                }
            }
        }
        $this->controller->close();
        if($books == ""){
            return '<p>Brak książke dla zapytania</p>';
        }
        return $books;
    }    
    public function advancedSearch($isbn, $original_title, $title, $original_punblisher_house, $original_country, $publisher_house, $country, $nr_page, $edition, $premiere, $cover, $authorName, $authorSurname, $translatorName, $translatorSurname) {
        return parent::advancedSearch($isbn, $original_title, $title, $original_punblisher_house, $original_country, $publisher_house, $country, $nr_page, $edition, $premiere, $cover, $authorName, $authorSurname, $translatorName, $translatorSurname);
    }
    
    public function logout(){
        return parent::logout();
    }
    public function login($login, $password){
        return parent::login($login, $password);
    }
    
    public function session(){
        $this->controller->connect();
        /*
        do{
            $r = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false,
                            "sessions",null,null,
                            array(
                                array("session_id","=",  session_regenerate_id(),"")));
        }while(mysqli_num_rows($r) > 0);
        $_SESSION['id'] = session_id();
        */
        $this->controller->updateTableRecordValuesWhere(true,"sessions", 
                array(
                    array("session_last_action", date('Y-m-d H:i:s'))
                    ),
                array(
                    array("session_user","=", $this->userID, "AND"),
                    array("session_acces_right","=", "admin", "")
                    ));
        $this->controller->close();
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
            $rowClean = $this->controller->clearArray($row, array_keys($row));
            if($rowClean['session_ip'] != $_SERVER['REMOTE_ADDR']){
                $this->controller->close();
                return false;
            }
            if($rowClean['session_user_agent'] != $_SERVER['HTTP_USER_AGENT']){
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
        $userData = $this->getData($this->userID);
        $this->controller->connect();
        $userDataClean = $this->controller->clearArray($userData, array_keys($userData));
	$return = $this->acountAdmin($userDataClean).'<p><button id="changePassword">Zmien hasło</button></p>';
        $this->controller->close();
        return $return;
	}
    public function extendAccount($id) {
        $this->controller->connect();
        $idClean = $this->controller->clear($id);
        $date = date_create(date('Y-m-d'));
        date_add($date, date_interval_create_from_date_string('365 days')); 
        $resultAccessRgihts = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "acces_rights", 
                                array("*"),
                                null,
                                array(array("acces_right_name","=", "activeReader", "")));
        if(mysqli_num_rows($resultAccessRgihts) == 0) {
            return '<p>Błąd</p>';
        }
        $rowAR = mysqli_fetch_assoc($resultAccessRgihts);
        $rowARClean = $this->controller->clearArray($rowAR, array_keys($rowAR));
        $this->controller->updateTableRecordValuesWhere(false,"readers",
                array(
                    array("reader_active_account", date_format($date,"y-m-d")),
                    array("reader_acces_right_id", $rowARClean['acces_right_id'])),
                array(array("reader_id", "=", $idClean, ""))
                );
        $return = "<p>Przedłużono konto</p>";
        $this->controller->close();
        return $return;
    }
    
    public function showAddReaderForm(){
        $this->controller->connect();
        $form = '<div id="registration" align="center">
			<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
				<table>
                                        <tr align="center">
                                            <td colspan="4">Dodaj czytelnika</td>
                                        </tr>
                                        <tr align="center">
                                            <td colspan="2">Dane</td>
                                            <td colspan="2">Adres</td>
                                        </tr>
					<tr>
                                            <td>Login:</td>
                                            <td><input id="login" type="text" value="'.@$this->controller->clear($_POST['login']).'" name="login" placeholder="Login" required/><span id="status_login"></span></td>
                                            <td>Kraj:</td>
                                            <td><input id="country" type="text" value="'.@$this->controller->clear($_POST['country']).'" name="country" placeholder="Kraj" required/></td>
                                        
                                        </tr>
					<tr>
                                            <td>E-mail:</td>
                                            <td><input id="email" type="email" value="'.@$this->controller->clear($_POST['email']).'" name="email" placeholder="E-mail" required/><span id="status_email"></span>
                                            <td>Miasto:</td>
                                            <td><input id="city" type="text" value="'.@$this->controller->clear($_POST['city']).'" name="city" placeholder="Misto" required/></td>
                                        </td></tr>
					<tr>
                                            <td>Hasło:</td>
                                            <td><input id="password1" type="password" value="'.@$this->controller->clear($_POST['password1']).'" name="password1" placeholder="Hasło" required/></td>
                                            <td>Kod pocztowy:</td>
                                            <td><input id="post_code" type="text" value="'.@$this->controller->clear($_POST['post_code']).'" name="post_code" placeholder="Kod pocztowy" required/></td>
                                        </tr>
					<tr>
                                            <td>Powtórz hasło:</td>
                                            <td><input id="password2" type="password" value="'.@$this->controller->clear($_POST['password2']).'" name="password2" placeholder="Powtórz hasło" required/><span id="status_password"></span></td>
                                            <td>Ulica:</td>
                                            <td><input id="street" type="text" value="'.@$this->controller->clear($_POST['street']).'" name="street" placeholder="Ulica" required/></td>
                                        </tr>
					<tr>
                                            <td>Imie:</td>
                                            <td><input id="name" type="text" value="'.@$this->controller->clear($_POST['name']).'" name="name" placeholder="Imie" required/></td>
                                            <td>Nr mieszkania/domu:</td>
                                            <td><input id="nr_house" type="text" value="'.@$this->controller->clear($_POST['nr_house']).'" name="nr_house" placeholder="Nr mieszkania/domu" required/></td>
                                        </tr>
					<tr>
                                            <td>Nazwisko:</td>
                                            <td><input id="surname" type="text" value="'.@$this->controller->clear($_POST['surname']).'" name="surname" placeholder="Nazwisko" required/></td>
                                        </tr>
                                        </table>
				<input type="submit" id="submit" value="Zarejestruj czytelnika">
			</form>
		</div>';
            $this->controller->close();
            return $form;
	}  
    public function showAddAdminForm() {
        $this->controller->connect();
            $form = '<div id="registration" align="center">
			<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
				<table>
					<tr>Dodaj admina</tr>
					<tr><td>Login:</td><td><input id="login" type="text" value="'.@$this->controller->clear($_POST['login']).'" name="login" placeholder="Login" required/><span id="status_login"></span></td></tr>
					<tr><td>E-mail:</td><td><input id="email" type="email" value="'.@$this->controller->clear($_POST['email']).'" name="email" placeholder="E-mail" required/><span id="status_email"></span></td></tr>
					<tr><td>Hasło:</td><td><input id="password1" type="password" value="'.@$this->controller->clear($_POST['password1']).'" name="password1" placeholder="Hasło" required/></td></tr>
					<tr><td>Powtórz hasło:</td><td><input id="password2" type="password" value="'.@$this->controller->clear($_POST['password2']).'" name="password2" placeholder="Powtórz hasło" required/><span id="status_password"></span></td></tr>
					<tr><td>Imie:</td><td><input id="name" type="text" value="'.@$this->controller->clear($_POST['name']).'" name="name" placeholder="Imie" required/></td></tr>
					<tr><td>Nazwisko:</td><td><input id="surname" type="text" value="'.@$this->controller->clear($_POST['surname']).'" name="surname" placeholder="Nazwisko" required/></td></tr>
				</table>
				<input type="submit" id="submit" value="Zarejestruj admina">
			</form>
		</div>';
             $this->controller->close();
        return $form;
        }
    public function showAddBookForm() {
        $this->controller->connect();
        $form =  '<div id="add_book" align="center">
		<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
			<table>
				<tr>
                                    <td colspan="3" align="center">Dodaj książke:</td>
                                </tr>
				<tr>
                                    <td>ISBN:</td>
                                    <td><input type="text" value="" name="isbn" placeholder="ISBN" required/></td>
                                </tr>
				<tr>
                                    <td>Oryginalny tytuł:</td>
                                    <td><input type="text" value="" name="original_title" placeholder="Oryginalny tytuł" required/></td>
                                </tr>
				<tr>
                                    <td>Tytuł:</td>
                                    <td><input type="text" value="" name="title" placeholder="Tytuł" required/></td>
                                </tr>
                                <tr>
                                    <td>Oryginalny wydawca:</td>
                                    <td><input type="text" value="" name="original_publisher_house" placeholder="Oryginalny wydawca" required/></td>
                                    <td><input type="text" value="" name="country_original_publisher_house" placeholder="Kraj" required/></td>
                                </tr>        
				<tr>
                                    <td>Wydawca:</td>
                                    <td><input type="text" value="" name="publisher_house" placeholder="Wydawca" required/></td>
                                    <td><input type="text" value="" name="country_publisher_house" placeholder="Kraj" required/></td>
                                </tr>
				<tr>
                                    <td>Ilość stron:</td>
                                    <td><input type="text" value="" name="nr_page" placeholder="Ilość stron" required/></td>
                                </tr>
				<tr>
                                    <td>Wydanie:</td>
                                    <td><input type="text" value="" name="edition" placeholder="Wydanie" required/></td>
                                </tr>
				<tr>
                                    <td>Rok wydania:</td>
                                    <td><input type="text" value="" name="premiere" placeholder="Rok Wydania" required/></td>
                                </tr>
                                <tr>
                                    <td>Okładka:</td>
                                    <td>
                                        <select name="cover">
                                            <option value="Miękka">Miękka</option>
                                            <option value="Twarda">Twarda</option>
                                        </select>
                                    </td>
                                </tr>
				<tr>
                                    <td>Ilość egzemplarzy:</td>
                                    <td><input type="text" value="" name="number" placeholder="Ilość egzemplarzy" required/></td>
                                </tr>
				
			</table>   
                        <button type="button" id="addAuthor">Dodaj autora</button>                             
                                <table><tbody id="authotsTable">
                                <tr>
                                    <td align="center" colspan="5">Autorzy</td>
                                </tr>
                                <tr>
                                    <td><input type="text" value="" name="authorName[0]" placeholder="Imie" required/></td>
                                    <td><input type="text" value="" name="authorSurname[0]" placeholder="Nazwisko" required/></td>
                                </tr>
                                </tbody></table>
                                <button type="button" id="addTranslator">Dodaj translatora</button>
                                <table>
                                <tbody id="translatorsTable">
                                <tr>
                                    <td align="center" colspan="5">Translatorzy</td>
                                </tr>
                                <tr>
                                    <td><input type="text" value="" name="translatorName[0]" placeholder="Imie"/></td>
                                    <td><input type="text" value="" name="translatorSurname[0]" placeholder="Nazwisko"/></td>
                                </tr>
                                </tbody>
                                </table>                        
                                
                                
			<input type="submit" value="Dodaj ksiażke">
		</form>
	</div>';
        $this->controller->close();
        return $form;
        }
    public function showAddNewsForm(){
        $this->controller->connect();
        $form =  '<div id="news" align="center">
                <form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
                    <table>
			<tr>
                            <td colspan = 2 align="center">Dodaj news:</td>
                        <tr>
			<tr>
                            <td>Tytył:</td>
                            <td><input type="text" value="" name="title" placeholder="Tytuł" required/></td>
                        </tr>
			<tr>
                            <td>Tekst:</td>
                            <td><textarea id="news_input" value="" name="text" placeholder="Tekst" required></textarea></td>
                        </tr>
                    </table>
                    <input type="submit" value="Dodaj news">
		</form>
            </div>';
        $this->controller->close();
        return $form;
    }
    public function showLoginForm(){
        return "<p>Jesteś już zalogowany!</p>";
    }
    public function showChangePassForm(){
        $this->controller->connect();
        $return = '<div id="changePass" align="center">
			<form action="'.backToFuture().'Library/UserAction/Edit/edit_pass.php" method="post">
				<table>
					<tr><td>Aktualne hasło:</td><td><input id="oldPassword" type="password" value="" name="oldPassword"  required/></td></tr>
					<tr><td>Nowe hasło:</td><td><input id="newPassword1" type="password" value="" name="newPassword1" required/></td></tr>
					<tr><td>Powtórz nowe hasło:</td><td><input id="newPassword2" type="password" value="" name="newPassword2" required/><span id="status_password"></span></td></tr>
				</table>
				<input type="submit" id="submit" value="Zmien">
			</form>
		</div>';
        $this->controller->close();
        return $return;
    }
    
    public function showAllReaders($array) {
        $this->controller->connect();
        $arrayClean = $this->controller->clearArray($array, array_keys($array));
        if(empty($arrayClean['login'])){
            $arrayClean['login'] = "%";
        }
        else{
            $arrayClean['login'] = '%'.$arrayClean['login'].'%';
        }
        if(empty($arrayClean['id'])){
            $arrayClean['id'] = "%";
        }
        if(empty($arrayClean['email'])){
            $arrayClean['email'] = "%";
        }
        else{
            $arrayClean['email'] = '%'.$arrayClean['email'].'%';
        }
        if(empty($arrayClean['name'])){
            $arrayClean['name'] = "%";
        }
        else{
            $arrayClean['name'] = '%'.$arrayClean['name'].'%';
        }
        if(empty($arrayClean['surname'])){
            $arrayClean['surname'] = "%";
        }
        else{
            $arrayClean['surname'] = '%'.$arrayClean['surname'].'%';
        }
        $this->controller->close();
        return '<p>'.templateTable($this->controller, array("ID", "Login", "Email", "Imie", "Nazwisko"),
                                        array("reader_id", "reader_login", "reader_email", "reader_name", "reader_surname"),
                                        "readers", "usersTable",'AdminAction/profile_readers.php?id', null, null,
            array(
                array("reader_id","like",$arrayClean['id'],"and"),
                array("reader_login","like",$arrayClean['login'],"and"),
                array("reader_email","like",$arrayClean['email'],"and"),
                array("reader_name","like",$arrayClean['name'],"and"),
                array("reader_surname","like",$arrayClean['surname'],"")
            )).'<p><a href="'.backToFuture().'<p>Library/AdminAction/register_reader.php">Dodaj</a></p></p>';
        }
    public function showAllBorrows($array){
        $this->controller->connect();
        $arrayClean = $this->controller->clearArray($array, array_keys($array));
        if(empty($arrayClean['id'])){
            $arrayClean['id'] = "%";
        }
        if(empty($arrayClean['$readerId'])){
            $arrayClean['$readerId'] = "%";
        }
        if(empty($arrayClean['$bookId'])){
            $arrayClean['$bookId'] = "%";
        }
        if(empty($arrayClean['$dateBorrow'])){
            $arrayClean['$dateBorrow'] = "%";
        }
        if(empty($arrayClean['$dateReturn'])){
            $arrayClean['$dateReturn'] = "%";
        }
        $this->controller->close();
        
        return '<p>'.templateTable($this->controller, array('ID','ID książki','ID czytelnika', 'Data wypożyczenia', 'Data zwrotu'),
                              array('borrow_id','borrow_book_id','borrow_reader_id', 'borrow_date_borrow', 'borrow_return'),
                                    "borrows", "borrowsTable",'AdminAction/borrow.php?id', null, null,
            array(
                array("borrow_id", "like", $arrayClean['id'], "and"),
                array("borrow_book_id", "like", $arrayClean['$bookId'], "and"),
                array("borrow_reader_id", "like", $arrayClean['$readerId'], "and"),
                array("borrow_date_borrow", "like", $arrayClean['$dateBorrow'], "and"),
                array("borrow_return", "like", $arrayClean['$dateReturn'], "")
                )).'</p>';
        }
    public function showAllBooks($array) {
        $books = "";
        $this->controller->connect();
        $arrayClean = $this->controller->clearArray($array, array_keys($array));
        if(empty($arrayClean['id'])) 
            $arrayClean['id'] = "%";
        if(empty($arrayClean['isbn'])) 
            $arrayClean['isbn'] = "%";
        else 
            $arrayClean['isbn'] = '%'.$arrayClean['isbn'].'%';
        if(empty($arrayClean['title'])) 
            $arrayClean['title'] = "%";
        else 
            $arrayClean['title'] = '%'.$arrayClean['title'].'%';
        if(empty($arrayClean['publisher_house'])) 
            $arrayClean['publisher_house'] = "%";
        else 
            $arrayClean['publisher_house'] = '%'.$arrayClean['publisher_house'].'%';
        if(empty($arrayClean['edition'])) 
            $arrayClean['edition'] = "%";
        if(empty($arrayClean['premiere'])) 
            $arrayClean['premiere'] = "%";
        if(empty($arrayClean['authorName']))
            $arrayClean['authorName'] = "%";
        else{
            $arrayClean['authorName'] = '%'.$arrayClean['authorName'].'%';
        }
        if(empty($arrayClean['authorSurname']))
            $arrayClean['authorSurname'] = "%";
        else{
            $arrayClean['authorSurname'] = '%'.$arrayClean['authorSurname'].'%';
        }
        $resultBook = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "view_books", 
                    null,
                    null,
                    array(
                        array("book_id","LIKE",$arrayClean['id'],"AND"),
                        array("book_isbn","LIKE",$arrayClean['isbn'],"AND"),
                        array("book_title","LIKE",$arrayClean['title'],"AND"),
                        array("publisher_house_name","LIKE",$arrayClean['publisher_house'],"AND"),
                        array("book_premiere","LIKE",$arrayClean['premiere'],"AND"),
                        array("book_edition","LIKE",$arrayClean['edition'],"")
                    ),
                    null,null,null);
            
        $bool = false;
        $books = $books.'
				<div id="booksTable" align="center">
				<p><table>
					<tr> <td>ID</td> <td>ISBN</td> <td>Tytył</td> <td>Autorzy</td> <td>Wydawca</td><td>Wydanie</td> <td>Premiera</td></tr>
				';
        while($rowB = mysqli_fetch_assoc($resultBook)){
            $rowBClean = $this->controller->clearArray($rowB, array_keys($rowB));
                $resultAuthor = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "authors",
                        null,null,
                        array(
                            array("authors.author_name","LIKE",$arrayClean['authorName'],"AND"),
                            array("authors.author_surname","LIKE",$arrayClean['authorSurname'],"")
                            ),
                    null,null,null,true);
                while($rowA = mysqli_fetch_assoc($resultAuthor)){
                    $rowAClean = $this->controller->clearArray($rowA, array_keys($rowA));
                    $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "authors_books",null,null,
                            array(array("author_id","=",$rowAClean['author_id'],"AND"),
                                array("book_id","=",$rowBClean['book_id'],"")
                                ),null,null,null,true); 
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
                                ),null,null,null,true);
                    if(mysqli_num_rows($resultA) == 0) {
                        return 'Błąd w wykonaniu zapytania';
                    }
                    else{	
                        $books = $books.'<tr onClick="location.href=\'https://torus.uck.pk.edu.pl/~dslusarz/Library/UserAction/book.php?book='.$rowB['book_id'].'\'" > '
                                                    . '<td>'.$rowBClean['book_id'].'</td> '
                                                    . '<td>'.$rowBClean['book_isbn'].'</td> '
                                                    . '<td>'.$rowBClean['book_title'].'</td> '
                                                    . '<td>'.$this->controller->authorsToString($resultA).'</td> '
                                                    . '<td>'.$rowBClean['publisher_house_name'].'</td>'
                                                    . '<td>'.$rowBClean['book_edition'].'</td> '
                                                    . '<td>'.$rowBClean['book_premiere'].'</td>'
                                                . ' </tr>';
                    }
                }
            }
        $books = $books.'</table><a href="'.backToFuture().'Library/AdminAction/add_book.php">Dodaj</a></p></div>';
	$this->controller->close();
        return $books;
    }
    public function showAllAdmins($array){
        $this->controller->connect();
        $arrayClean = $this->controller->clearArray($array, array_keys($array));
        if(empty($arrayClean['login'])){
            $arrayClean['login'] = "%";
        }
        else{
            $arrayClean['login'] = '%'.$arrayClean['login'].'%';
        }
        if(empty($arrayClean['id'])){
            $arrayClean['id'] = "%";
        }
        if(empty($arrayClean['email'])){
            $arrayClean['email'] = "%";
        }
        else{
            $arrayClean['email'] = '%'.$arrayClean['email'].'%';
        }
        if(empty($arrayClean['name'])){
            $arrayClean['name'] = "%";
        }
        else{
            $arrayClean['name'] = '%'.$arrayClean['name'].'%';
        }
        if(empty($arrayClean['surname'])){
            $arrayClean['surname'] = "%";
        }
        else{
            $arrayClean['surname'] = '%'.$arrayClean['surname'].'%';
        }
        $this->controller->close();
        return '<p>'.templateTable($this->controller, array("ID", "Login", "Email", "Imie", "Nazwisko"),
                                        array("admin_id", "admin_login", "admin_email", "admin_name", "admin_surname"),
                                        "admins", "usersTable", 'AdminAction/profile_admins.php?id', null, null,
            array(
                array("admin_id","like",$arrayClean['id'],"and"),
                array("admin_login","like",$arrayClean['login'],"and"),
                array("admin_email","like",$arrayClean['email'],"and"),
                array("admin_name","like",$arrayClean['name'],"and"),
                array("admin_surname","like",$arrayClean['surname'],"")
            )).'<p><a href="'.backToFuture().'Library/AdminAction/register_admin.php">Dodaj</a></p></p>';
        }
    public function showAllLogged(){
        return '<p>'.templateTable($this->controller, array("Session ID", "IP","User Agent", "User", "Rights", "Last action"),
                                        array("session_id", "session_ip","session_user_agent", "session_user", "session_acces_right", "session_last_action"),
                                        "sessions", "loggedTable", "" ).'</p>';
	} 
    
    public function showAdmin($adminID){
        $userData = $this->getData($adminID);
        $this->controller->connect();
        $userDataClean = $this->controller->clearArray($userData, array_keys($userData));
        $return = $this->acountAdmin($userDataClean).'<p><button id="editAdmin">Edytuj</button><button id="deleteAdmin">Usuń</button></p>';
        $this->controller->close();
        return $return;
        }
    public function showEditAdmin($adminID){
        $this->controller->connect();
        $userData = $this->controller->getAdminData($adminID);
        $userDataClean = $this->controller->clearArray($userData, array_keys($userData));
        $return = '<div align="center">
            <form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?id='.$userDataClean['admin_id'].'" method="post">
                <table>
                    <tr align="center">
                        <td colspan="2">Edytowanie admina o '.$userDataClean['admin_id'].'</td>
                    </tr>
                    <tr>
                        <td>Imie:</td>
                        <td><input type="text" id="name" name="name" value="'.$userDataClean['admin_name'].'"/></td>
                    </tr>
                    <tr>
                        <td>Nazwisko:</td>
                        <td><input type="text" id="surname" name="surname" value="'.$userDataClean['admin_surname'].'"/></td>
                    </tr>
                    <tr>
                        <td>Login:</td>
                        <td><input type="text" id="login" name="login" value="'.$userDataClean['admin_login'].'"/></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input type="email" id="email" name="email" value="'.$userDataClean['admin_email'].'"/></td>
                    </tr>
                </table>
                <input type="hidden" id="edit" name="edit" value="'.$userDataClean['admin_id'].'"/>
                <input type="submit" id="submit" value="Zapisz zmiany"/>
            </form></div>';
        $this->controller->close();
        return $return;
    } 
        
    public function showReader($readerID){
        $this->controller->connect();
        $userData = $this->controller->getReaderData($readerID);
        $userDataClean = $this->controller->clearArray($userData, array_keys($userData));
        $return = $this->acountReader($userDataClean);
        $this->controller->close();
        return $return;
    }
    public function showReaderLight($readerID){
        $userData =  $this->controller->getReaderData($readerID);
        $return = '<p>
            ID: '.$this->controller->clear($userData['reader_id']).'<br>
            Imie: '.$this->controller->clear($userData['reader_name']).'<br>
            Nazwisko: '.$this->controller->clear($userData['reader_surname']).'<br>
            Login: '.$this->controller->clear($userData['reader_login']).'<br>
            Email: '.$this->controller->clear($userData['reader_email']).'<br>
	</p>';
        return $return;
    }
    public function showEditReader($readerID){
        $this->controller->connect();
        $userData = $this->controller->getReaderData($readerID);
        $userDataClean = $this->controller->clearArray($userData, array_keys($userData));
        $return = '<div id="registration" align="center">
			<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?id='.$userDataClean['reader_id'].'" method="post">
				<table>
                                        <tr align="center">
                                            <td colspan="4">Edytowanie czytelnika o id '.$userDataClean['reader_id'].'</td>
                                        </tr>
                                        <tr align="center">
                                            <td colspan="2">Dane</td>
                                            <td colspan="2">Adres</td>
                                        </tr>
					<tr>
                                            <td>Login:</td>
                                            <td><input id="login" type="text" value="'.$userDataClean['reader_login'].'" name="login" placeholder="Login" required/><span id="status_login"></span></td>
                                            <td>Kraj:</td>
                                            <td><input id="country" type="text" value="'.$userDataClean['country_name'].'" name="country" placeholder="Kraj" required/></td>
                                        
                                        </tr>
					<tr>
                                            <td>E-mail:</td>
                                            <td><input id="email" type="email" value="'.$userDataClean['reader_email'].'" name="email" placeholder="E-mail" required/><span id="status_email"></span>
                                            <td>Miasto:</td>
                                            <td><input id="city" type="text" value="'.$userDataClean['reader_login'].'" name="city" placeholder="Misto" required/></td>
                                        </td></tr>
					<tr>
                                            <td>Imie:</td>
                                            <td><input id="name" type="text" value="'.$userDataClean['reader_name'].'" name="name" placeholder="Imie" required/></td>
                                            <td>Kod pocztowy:</td>
                                            <td><input id="post_code" type="text" value="'.$userDataClean['post_code_name'].'" name="post_code" placeholder="Kod pocztowy" required/></td>
                                        </tr>
					<tr>
                                            <td>Nazwisko:</td>
                                            <td><input id="surname" type="text" value="'.$userDataClean['reader_surname'].'" name="surname" placeholder="Nazwisko" required/></td>
                                            <td>Ulica:</td>
                                            <td><input id="street" type="text" value="'.$userDataClean['street_name'].'" name="street" placeholder="Ulica" required/></td>
                                        </tr>
					<tr>
                                            <td></td>
                                            <td></td>
                                            <td>Nr mieszkania/domu:</td>
                                            <td><input id="nr_house" type="text" value="'.$userDataClean['house_number_name'].'" name="nr_house" placeholder="Nr mieszkania/domu" required/></td>
                                        </tr>
				</table>
                                <input type="hidden" id="edit" name="edit" value="'.$userDataClean['reader_id'].'"/>
				<input type="submit" id="submit" value="Zapisz zmiany">
			</form>
		</div>';
        $this->controller->close();
        return $return;
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
    public function showEditBook($bookID){
        $this->controller->connect();
        $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "view_books", 
                    null,null,
                    array(array("book_id","=", $bookID, "")));
        $row = mysqli_fetch_assoc($result);
        $rowClean= $this->controller->clearArray($row, array_keys($row));
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
        $resultTranslators = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "translators", 
                            array("translators.*"),
                            array(
                                        array("translators_books", "translators_books.translator_id", "translators.translator_id"),
                                        array("books", "books.book_id", "translators_books.book_id")
                                        ),
                            array(
                                        array("books.book_id","=", $row['book_id'], "")
                                        )
                            );
        $return = '<div align="center">
		<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?id='.$this->controller->clear($rowClean['book_id']).'" method="post">
			<table>
				<tr>
                                    <td colspan="3" align="center">Edytuj książke:</td>
                                </tr>
				<tr>
                                    <td>ISBN:</td>
                                    <td><input type="text" value="'.$rowClean['book_isbn'].'" name="isbn" placeholder="ISBN" required/></td>
                                </tr>
				<tr>
                                    <td>Oryginalny tytuł:</td>
                                    <td><input type="text" value="'.$rowClean['book_original_title'].'" name="original_title" placeholder="Oryginalny tytuł" required/></td>
                                </tr>
				<tr>
                                    <td>Tytuł:</td>
                                    <td><input type="text" value="'.$rowClean['book_title'].'" name="title" placeholder="Tytuł" required/></td>
                                </tr>
                                <tr>
                                    <td>Oryginalny wydawca:</td>
                                    <td><input type="text" value="'.$rowClean['original_publisher_house_name'].'" name="original_publisher_house" placeholder="Oryginalny wydawca" required/></td>
                                    <td><input type="text" value="'.$rowClean['original_publisher_house_country'].'" name="country_original_publisher_house" placeholder="Kraj" required/></td>
                                </tr>        
				<tr>
                                    <td>Wydawca:</td>
                                    <td><input type="text" value="'.$rowClean['publisher_house_name'].'" name="publisher_house" placeholder="Wydawca" required/></td>
                                    <td><input type="text" value="'.$rowClean['publisher_house_country'].'" name="country_publisher_house" placeholder="Kraj" required/></td>
                                </tr>
				<tr>
                                    <td>Ilość stron:</td>
                                    <td><input type="text" value="'.$rowClean['book_nr_page'].'" name="nr_page" placeholder="Ilość stron" required/></td>
                                </tr>
				<tr>
                                    <td>Wydanie:</td>
                                    <td><input type="text" value="'.$rowClean['book_edition'].'" name="edition" placeholder="Wydanie" required/></td>
                                </tr>
				<tr>
                                    <td>Rok wydania:</td>
                                    <td><input type="text" value="'.$rowClean['book_premiere'].'" name="premiere" placeholder="Rok Wydania" required/></td>
                                </tr>
                                <tr>
                                    <td>Okładka:</td>
                                    <td><input type="text" value="'.$rowClean['book_cover'].'" name="cover" placeholder="Okładka" required/></td>
                                </tr>
				<tr>
                                    <td>Ilość egzemplarzy:</td>
                                    <td><input type="text" value="'.$rowClean['book_number'].'" name="number" placeholder="Ilość egzemplarzy" required/></td>
                                </tr>
			</table>            
                                <table><tbody id="authotsTable">
                                <tr>
                                    <td align="center" colspan="5">Autorzy</td>
                                </tr>';
                                $i = 0;
                                while($rowA = mysqli_fetch_array($resultAuthors)){
                                    $rowAClean= $this->controller->clearArray($rowA, array_keys($rowA));
                                    if($i == 0){
                                        $return .= '<tr><td><input type="text" value="'.$rowAClean['author_name'].'" name="authorName['.$i.']" placeholder="Imie" required/></td>';
                                        $return .= '<td><input type="text" value="'.$rowAClean['author_surname'].'" name="authorSurname['.$i.']" placeholder="Nazwisko" required/></td></tr>';
                                    }
                                    else{
                                        $return .= '<tr><td><input type="text" value="'.$rowAClean['author_name'].'" name="authorName['.$i.']" placeholder="Imie" /></td>';
                                        $return .= '<td><input type="text" value="'.$rowAClean['author_surname'].'" name="authorSurname['.$i.']" placeholder="Nazwisko" /></td></tr>';
                                    }
                                    $i++;
                                }
                                $return .= '
                                </tbody></table>
                                <table>
                                <tbody id="translatorsTable">
                                <tr>
                                    <td align="center" colspan="5">Translatorzy</td>
                                </tr>';
                                $j = 0;
                                while($rowT = mysqli_fetch_array($resultTranslators)){
                                    $rowTClean= $this->controller->clearArray($rowT, array_keys($rowT));
                                    $return .= '<tr><td><input type="text" value="'.$rowTClean['translator_name'].'" name="translatorName['.$j.']" placeholder="Imie"/></td>';
                                    $return .= '<td><input type="text" value="'.$rowTClean['translator_surname'].'" name="translatorSurname['.$j.']" placeholder="Nazwisko"/></td></tr>';
                                    $j++;
                                }
                                $return .= '
                                </tbody>
                                </table> 
                                <input type="hidden" name="edit" value="'.$bookID.'">
			<input type="submit" value="Zapisz zmiany">
		</form>
	</div>';
        $this->controller->close();
        return $return;
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
        $this->controller->connect();
        $borrow = "";
        $borrowResult = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "view_borrows", null, null,
                array(array("borrow_id","=", $borrowID, "")));
        $row = mysqli_fetch_array($borrowResult);
        $delay = 0;
        if($row['borrow_delay'] > 0){
            $delay = $row['borrow_delay'];
        }
        $borrow = $borrow.'<p>Data wypożyczenia: '.$this->controller->clear($row['borrow_date_borrow']).''
                . '<br>Data zwrotu: '.$this->controller->clear($row['borrow_return']).''
                . '<br>Odebrano: '.$this->controller->clear($row['borrow_received']).''
                . '<br>Opóźnienie: '.$delay.'<br>Do zapłaty: '.$delay*0.25.'</p>';
        $borrow = $borrow.'<p><button id="receive">Odebrano</button> <button id="delete">Zwrócono</button></p>';
        $borrow = $borrow.'<div id="reader" align="center">Czytelnik:<br>'.$this->showReaderLight($this->controller->clear($row['borrow_reader_id'])).'</div>';
        $borrow = $borrow.'<div id="book" align="center">Książka:<br>'.$this->showBookLight($this->controller->clear($row['borrow_book_id'])).'</div>';
        $this->controller->close();
        return $borrow;
    }
    public function showMyBorrows(){
        return "<p>Jesteś adminem nie masz wypożyczeń</p>";
    }
    
    public function addReader($array){
        $this->controller->connect();
	$arrayClean = $this->controller->clearArray($array, array_keys($array));
		if(empty($arrayClean['login']) 
			|| empty($arrayClean['suranme']) 
			|| empty($arrayClean['email']) 
			|| empty($arrayClean['name'])
			|| empty($arrayClean['password1'])
			|| empty($arrayClean['password2'])
			|| empty($arrayClean['country'])
                        || empty($arrayClean['city'])
                        || empty($arrayClean['post_code'])
                        || empty($arrayClean['street'])
                        || empty($arrayClean['nr_house'])
                        
		){
                    $this->controller->close();
			return '<p>Musisz wypełnić wszystkie pola.</p>';
		}
                elseif($arrayClean['password1'] != $arrayClean['password2']) {
                    $this->controller->close();
			return '<p>Podane hasła różnią się od siebie.</p>';
		}
                elseif(filter_var($arrayClean['email'], FILTER_VALIDATE_EMAIL) === false) {
                    $this->controller->close();
			return '<p>Podany email jest nieprawidłowy.</p>';
		}
                else{
                    if($this->controller->userExist("readers", "reader", $arrayClean['login'], $arrayClean['email'])){
                        $this->controller->close();
                        return '<p>Już istnieje użytkownik z takim loginem lub adresem e-mail.</p>';
                    }
                    elseif($this->controller->userExist("admins", "admin", $arrayClean['login'], $arrayClean['email'])){
                        $this->controller->close();
                        return '<p>Już istnieje użytkownik z takim loginem lub adresem e-mail.</p>';
                    }
                    if(strlen($arrayClean['login']) < 4){
                        $this->controller->close();
                    	return '<p>Za mało znaków.</p>';
                    }
                    $resultAccessRgihts = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "acces_rights", 
                            array("*"),
                            null,
                            array(array("acces_right_name","=", "activeReader", "")));
                    if(mysqli_num_rows($resultAccessRgihts) == 0) {
                        $this->controller->close();
                    	return 'Błąd';
                    }
                    $rowAR = mysqli_fetch_assoc($resultAccessRgihts);
                    $rowARClean = $this->controller->clearArray($rowAR, array_keys($rowAR));
                    $date = date_create(date('Y-m-d'));
                    date_add($date, date_interval_create_from_date_string('365 days')); 
                    $this->controller->insertTableRecordValue(false,"readers", 
                            array("reader_name", "reader_surname", "reader_login", "reader_password", "reader_email", "reader_address_id", "reader_active_account", "reader_acces_right_id"),
                            array($arrayClean['name'], $arrayClean['surname'], $arrayClean['login'], $this->controller->codepass($arrayClean['password1']), $arrayClean['email'], $this->addAddress($arrayClean['country'], $arrayClean['city'],$arrayClean['post_code'] ,$arrayClean['street'], $arrayClean['nr_house']),  date_format($date,"y-m-d"), $rowARClean['acces_right_id']));
                    $this->controller->close();
                    return '<p>Czytelnik Został poprawnie zarejestrowany! Możesz się teraz wrócić na <a href="'.backToFuture().'Library/index.php">stronę główną</a>.</p>';
		}
	}
    public function editReader($array) {
        $this->controller->connect();
        $arrayClean = $this->controller->clearArray($array, array_keys($array));
        $this->controller->updateTableRecordValuesWhere(false,"readers",
                        array(
                            array("reader_login",$arrayClean['login']),
                            array("reader_email",$arrayClean['email']),
                            array("reader_name",$arrayClean['name']),
                            array("reader_surname",$arrayClean['surname'])
                            ),
                        array(array("reader_id","=",$arrayClean['edit'],"")));
        $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "readers",null, null,
                array(array("reader_id","=",$arrayClean['edit'],"")));
        $row = mysqli_fetch_array($result);
        $rowClean = $this->controller->clearArray($row, array_keys($row));
        $this->controller->updateTableRecordValuesWhere(false,"addresses",
                array(
                    array("address_country_id", $this->addCountry($arrayClean['country'])),
                    array("address_city_id", $this->addCity($arrayClean['city'])),
                    array("address_post_code_id", $this->addPostCode($arrayClean['post_code'])),
                    array("address_street_id", $this->addStreet($arrayClean['street'])),
                    array("address_nr_house_id", $this->addHouseNumber($arrayClean['nr_house']))
                    ),
                
                array(array("address_id","=", $rowClean['reader_address_id'],"")));
        $this->controller->close();
        return "<p>Edytowano czytelnika</p>";
    }
    public function deleteReader($id) {
        $this->controller->connect();
        $idClean = $this->controller->clear($id);
        if($this->controller->deleteTableWhere(false,"readers", array(array("reader_id", "=", $idClean, "")))){
            $return = "<p>Usunięto czytelnika</p>";
        }
        else{
            $return = "<p>Nie można usunąć czytelnika</p>";
        }
        $this->controller->close();
        return $return;
    }   
    
    public function addBook($isbn, $original_title, $title, $original_punblisher_house, $original_country, $publisher_house, $country, $nr_page, $edition, $premiere, $number, $cover, $authorName, $authorSurname, $translatorName, $translatorSurname) {
            if(empty($isbn) ||
		empty($title) ||
		empty($publisher_house) ||
		empty($nr_page) ||
                empty($original_country) ||
                empty($country) ||
		empty($edition) ||
		empty($premiere) ||
		empty($number) ||
                empty($original_title) ||
                empty($original_punblisher_house) ||    
                empty($authorName[0]) ||  
                empty($authorSurname[0])){
		return '<p>Nie wypełniono pól</p>';
            }	
            else{
                $this->controller->connect();
		$isbn = $this->controller->clear($isbn);
		$title = $this->controller->clear($title);
		$publisher_house = $this->controller->clear($publisher_house);
		$nr_page = $this->controller->clear($nr_page);
		$edition = $this->controller->clear($edition);
		$premiere = $this->controller->clear($premiere);
		$number = $this->controller->clear($number);
		$original_punblisher_house = $this->controller->clear($original_punblisher_house);
		$cover = $this->controller->clear($cover);
		$original_title = $this->controller->clear($original_title);
                $country = $this->controller->clear($country);
                $original_country = $this->controller->clear($original_country);
                $authorName = $this->controller->clearArray($authorName);
                $authorSurname = $this->controller->clearArray($authorSurname);
                $translatorName = $this->controller->clearArray($translatorName);
                $translatorSurname = $this->controller->clearArray($translatorSurname);
                $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "books", array("*"),
                        null,
                        array(array("books.book_isbn","=", $isbn, "")));
                if(mysqli_num_rows($result) > 0){
                    return 'Książka już istnieje';
		}
                $this->controller->insertTableRecordValue(false,"books",
                        array(
                            "book_isbn", 
                            "book_original_title",
                            "book_title",
                            "book_original_publisher_house_id",
                            "book_publisher_house_id", 
                            "book_nr_page", 
                            "book_edition",
                            "book_premiere", 
                            "book_number", 
                            "book_cover"),
                        array($isbn,
                            $original_title,
                            $title, 
                            $this->addPublisherHouse($original_punblisher_house,$original_country), 
                            $this->addPublisherHouse($publisher_house,$country), 
                            $nr_page,
                            $edition,
                            $premiere,
                            $number,
                            $cover));
                    
		$result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "books", array("*"),
                        null,
                        array(array("books.book_isbn","=", $isbn, "")));
                
		$rowB = mysqli_fetch_array($result);
                for($i = 0; $i < count($authorName); $i++){
                    if(!empty($authorName[$i]) && !empty($authorSurname[$i])){
                        $this->addAuthors($authorName[$i], $authorSurname[$i], $rowB[0]);
                    }
                }
                for($i = 0; $i < count($translatorName); $i++){
                    if(!empty($translatorName[$i]) && !empty($translatorSurname[$i])){
                        $this->addTranslators($translatorName[$i], $translatorSurname[$i], $rowB[0]);
                    }
                }
                
                $this->controller->close();
		return '<p>Dodano ksiażke.</p>';
            }
        }
    public function editBook($id, $isbn, $original_title, $title, $original_punblisher_house, $original_country, $publisher_house, $country, $nr_page, $edition, $premiere, $number, $cover, $authorName, $authorSurname, $translatorName, $translatorSurname){
        $this->controller->connect();
        $this->controller->deleteTableWhere(true,"authors_books", array(array("book_id","=",$id,"")));
        $this->controller->deleteTableWhere(true,"translators_books", array(array("book_id","=",$id,"")));
        var_dump($authorName);
        for($i = 0; $i < count($authorName); $i++){
            echo $i;
            echo $authorName[$i];
            echo $authorSurname[$i];
            if(!empty($authorName[$i]) && !empty($authorSurname[$i])){
                echo $i;
                $this->addAuthors($authorName[$i], $authorSurname[$i], $id);
            }
        }
        for($i = 0; $i < count($translatorName); $i++){
            echo $i;
            echo $translatorName[$i];
            echo $translatorSurname[$i];
            if(!empty($translatorName[$i]) && !empty($translatorSurname[$i])){
                echo $i;
                $this->addTranslators($translatorName[$i], $translatorSurname[$i], $id);
            }
        }        
        $this->controller->updateTableRecordValuesWhere(true,"books",
                        array(
                            array("book_isbn",$this->controller->clear($isbn)),
                            array("book_title",$this->controller->clear($title)),
                            array("book_nr_page",$this->controller->clear($nr_page)),
                            array("book_edition",$this->controller->clear($edition)),
                            array("book_cover",$this->controller->clear($cover)),
                            array("book_premiere",$this->controller->clear($premiere)),
                            array("book_original_title",$this->controller->clear($original_title)),
                            array("book_original_publisher_house_id",$this->addPublisherHouse($this->controller->clear($original_punblisher_house),$this->controller->clear($original_country))),
                            array("book_publisher_house_id",$this->addPublisherHouse($this->controller->clear($publisher_house),$this->controller->clear($country))),
                            array("book_number",$this->controller->clear($number))
                            ),
                        array(array("book_id","=",$this->controller->clear($id),"")));
        $this->controller->close();
        return "<p>Edytowano książke</p>";
    }
    public function deleteBook($id) {
        $this->controller->connect();
        if($this->controller->deleteTableWhere(false,"books", array(array("book_id", "=", $id, "")))){
            $return = "<p>Usunięto książke</p>";
        }
        else{
            $return = "<p>Nie można usunąć książki</p>";
        }
        $this->controller->close();
        return $return;
    }
    
    public function addAdmin($array) {
        $this->controller->connect();
        $arrayClean = $this->controller->clearArray($array, array_keys($array));
            if(empty($arrayClean['name']) 
		|| empty($arrayClean['surname']) 
		|| empty($arrayClean['password1']) 
		|| empty($arrayClean['password2'])
		|| empty($arrayClean['email'])
		|| empty($arrayClean['login'])){
                return '<p>Musisz wypełnić wszystkie pola.</p>';
            }
            elseif($arrayClean['password1'] !=  $arrayClean['password2']) {
                $this->controller->close();
		return '<p>Podane hasła różnią się od siebie.</p>';
            } 
            elseif(filter_var($arrayClean['email'], FILTER_VALIDATE_EMAIL) === false){
                $this->controller->close();
		return '<p>Podany email jest nieprawidłowy.</p>';
            }
            else{
                if($this->controller->userExist("readers", "reader", $arrayClean['login'], $arrayClean['email'])){
                    $this->controller->close();
                    return '<p>Już istnieje użytkownik z takim loginem lub adresem e-mail.</p>';
                }
                elseif($this->controller->userExist("admins", "admin", $arrayClean['login'], $arrayClean['email'])){
                    $this->controller->close();
                    return '<p>Już istnieje użytkownik z takim loginem lub adresem e-mail.</p>';
                }
                if(strlen($arrayClean['login']) < 4){
                    return '<p>Za mało znaków.</p>';
                }
                $resultAccessRgihts = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "acces_rights", 
                            array("*"),
                            null,
                            array(array("acces_right_name","=", "admin", "")));
                if(mysqli_num_rows($resultAccessRgihts) == 0) {
                    $this->controller->close();
                    return 'Błąd';
                }
                $rowAR = mysqli_fetch_assoc($resultAccessRgihts);
                $rowARClean = $this->controller->clearArray($rowAR, array_keys($rowAR));
                $this->controller->insertTableRecordValue(false,"admins", 
                            array("admin_name", "admin_surname", "admin_login", "admin_password", "admin_email", "admin_acces_right_id"),
                            array($arrayClean['name'], $arrayClean['surname'], $arrayClean['login'], $this->controller->codepass($arrayClean['password1']), $arrayClean['email'], $rowARClean['acces_right_id']));
                $this->controller->close();
                return "<p>Dodano admina</p>";
            }
        }
    public function editAdmin($array){
        $this->controller->connect();
        $arrayClean = $this->controller->clearArray($array, array_keys($array));
        $this->controller->updateTableRecordValuesWhere(true,"admins",
                        array(
                            array("admin_login",$arrayClean['login']),
                            array("admin_email",$arrayClean['email']),
                            array("admin_name",$arrayClean['name']),
                            array("admin_surname",$arrayClean['surname'])
                            ),
                        array(array("admin_id","=",$arrayClean['edit'],"")));
        $this->controller->close();
        return "<p>Edytowano admina</p>";
        
    }
    public function deleteAdmin($id) {
        $this->controller->connect();
        $idClean = $this->controller->clear($id);
        if($this->controller->deleteTableWhere(false,"admins", array(array("admin_id", "=", $idClean, "")))){
            $return = "<p>Usunięto admina</p>";
        }
        else{
            $return = "<p>Nie można usunąć admina</p>";
        }
        $this->controller->close();
        return $return;
    }
    
    public function addNews($title, $text){
	if(empty($title) ||
            empty($text)){
                return 'Nie wypełniono pól';
        }	
        else{
            $czas = date('Y-m-d');
            $this->controller->connect();
            $title = $this->controller->clear($title);
            $text =  $this->controller->clear($text);
            $this->controller->insertTableRecordValue(false,"news", array("new_title",
							"new_text",
							"new_date"),array($title, $text, $czas));
            $this->controller->close();
            return '<p>Dodano news</p>';
        }
    }
    public function deleteNews($id){
        $this->controller->connect();
        $idClean = $this->controller->clear($id);
        if($this->controller->deleteTableWhere(false,"news", array(array("new_id","=",$idClean,"")))){
            $return = "<p>Usunięto news</p>";
        }else{
            $return = "<p>Błąd! Nie usinięto newsa</p>";
        }
        $this->controller->close();
    } 
    
    public function addBorrow($bookID){
        return "<p>Jesteś adminem nie możesz wypożyczać</p>";
    }
    public function deleteBorrow($id) {
        $this->controller->connect();
        $idClean = $this->controller->clear($id);
        if($this->controller->deleteTableWhere(false,"borrows", array(array("borrow_id", "=", $idClean, "")))){
            $return = "<p>Książka została zwrócona</p>";
        }
        else{
             $return = "<p>Błąd! Książka nie została zwrócona</p>";
        }
        $this->controller->close();
        return $return;
    }
    public function receiveBorrow($id) {
        $this->controller->connect();
        $this->controller->updateTableRecordValuesWhere(false,"borrows",
            array(array("borrow_received", "1")),
            array(array("borrow_id", "=", $this->controller->clear($id), "")));
    
        $return = "<p>Odebrano książke<p>";
        $this->controller->close();
        return $return;
    }
    
    public function isActive($ID){
        return false;
    }
    
    public function getData($ID){
        $this->controller->connect();
        $data = $this->controller->getAdminData($this->controller->clear($ID));
        $this->controller->close();
	return $data;
    }
    
    public function changePass($oldPass, $newPass){
        $this->controller->connect();
        $oldPassClean = $this->controller->clear($oldPass);
        $newPassClean = $this->controller->clear($newPass);
        $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, 
                "admins",array("admin_password"),null,
                array(array("admin_id","=",$this->userID,"")),null,null,null,True);
        $row = mysqli_fetch_assoc($result);
        if($row["admin_password"] != $this->controller->codepass($oldPassClean)){
            return "<p>Podano błedne hasło<p>";
        }
        $this->controller->updateTableRecordValuesWhere(false,"admins",
                array(array("admin_password", $this->controller->codepass($newPassClean))),
                array(array("admin_id","=",$this->userID,"")),true);
        $this->controller->close();
        return "<p>Zmieniono hasło<p>";
    }
    public function generateNewPas($id) {
        $this->controller->connect();
        $pass = uniqid("reader");
        $this->controller->updateTableRecordValuesWhere(false,"readers",
                array(array("reader_password", $this->controller->codepass($pass))),
                array(array("reader_id", "=", $this->controller->clear($id), "")));

        $return = "<p>Nowe hasło to: ".$pass.'</p>';
        $this->controller->close();
        return $return;
    }

}
?>