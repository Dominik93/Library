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
                                array("*"), null,
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
                    //$this->controller->commit();
                    $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "authors", 
                                        array("*"), null,
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
    private function addAddress($country, $city,$postCode ,$street, $houseNumber){
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
            echo "session time out";
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
		}else{
			while($row = mysqli_fetch_assoc($result)) {
                            $news .= '<div align="center"><table>'
                                . '<tr>'
                                . '<td align="center">'.$this->controller->clear($row['new_title']).'</td>'
                                . '<td align="right">'.$this->controller->clear($row['new_date']).'</td>'
                                . '<td><a href="'.backToFuture().'Library/Menu/news.php?id='.$row['new_id'].'">Usuń</a></td>'
                                . '</tr>'
                                . '<tr>'
                                . '<td colspan="3">'.$this->controller->clear($row['new_text']).'</td>'
                                . '</tr></table></div>';
                        }
                }
                $this->controller->close();
		return $news;
	}
    
    public function search($isbn, $title, $publisher_house, $edition, $premiere, $authorName, $authorSurname){
            $books = "";
            if(empty($isbn)) $isbn = "%";
            else $isbn = '%'.$isbn.'%';
            if(empty($title)) $title = "%";
            else $title = '%'.$title.'%';
            if(empty($publisher_house)) $publisher_house = "%";
            else $publisher_house = '%'.$publisher_house.'%';
            if(empty($edition)) $edition = "%";
            if(empty($premiere)) $premiere = "%";
            if(empty($authorName)) $authorName = "%";
            else $authorName = '%'.$authorName.'%';
            if(empty($authorSurname)) $authorSurname = "%";
            else $authorSurname = '%'.$authorSurname.'%';
            $this->controller->connect();
            $isbn = $this->controller->clear($isbn);
            $title = $this->controller->clear($title);
            $publisher_house = $this->controller->clear($publisher_house);
            $edition = $this->controller->clear($edition);
            $premiere = $this->controller->clear($premiere);
            $authorName =  $this->controller->clear($authorName);
            $authorSurname =  $this->controller->clear($authorSurname);
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
                            array("authors.author_name","LIKE",$authorName,"AND"),
                            array("authors.author_surname","LIKE",$authorSurname,"")
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
                        ID: '.$this->controller->clear($rowB['book_id']).'<br>
                        ISBN: '.$this->controller->clear($rowB['book_isbn']).'<br>
                        Autor: '.$this->controller->clear($this->controller->authorsToString($resultA)).'<br>
                        Tytuł: '.$this->controller->clear($rowB['book_title']).'<br>
                        Wydawca: '.$this->controller->clear($rowB['publisher_house_name']).'<br>
                        Ilość stron: '.$this->controller->clear($rowB['book_nr_page']).'<br>
                        Wydanie: '.$this->controller->clear($rowB['book_edition']).'<br>
                        Rok wydania: '.$this->controller->clear($rowB['book_premiere']).'<br>
                        Ilość sztuk: '.$this->controller->clear($rowB['book_number']).'<br>
                        <a href="'.backToFuture().'Library/UserAction/book.php?book='.$this->controller->clear($rowB['book_id']).'">Przejdź do książki</a>
                        </p>';
                    }
                }
            }
            if($books == "")
                return '<p>Brak książke dla zapytania</p>';
            $this->controller->close();
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
        $this->controller->updateTableRecordValuesWhere(false,"sessions", 
                array(
                    //array("session_id", session_id()),
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
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "sessions", null, null, 
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
        $userData = $this->getData($this->userID);
        $this->controller->connect();
	$return = '<p>
                            ID: '.$this->controller->clear($userData['admin_id']).'<br>
                            Imie: '.$this->controller->clear($userData['admin_name']).'<br>
                            Nazwisko: '.$this->controller->clear($userData['admin_surname']).'<br>
                            Login: '.$this->controller->clear($userData['admin_login']).'<br>
                            Email: '.$this->controller->clear($userData['admin_email']).'<br>
                            Prawa: '.$this->controller->clear($userData['acces_right_name']).'<br>
                            <button id="changePassword">Zmien hasło</button>
                            </p>';
        $this->controller->close();
        return $return;
	}
    public function extendAccount($id) {
        $this->controller->connect();
        $date = date_create(date('Y-m-d'));
        date_add($date, date_interval_create_from_date_string('365 days')); 
        $resultAccessRgihts = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "acces_rights", 
                                array("*"),
                                null,
                                array(array("acces_right_name","=", "activeReader", "")));
        if(mysqli_num_rows($resultAccessRgihts) == 0) {
            die('<p>Błąd</p>');
        }
        $rowAR = mysqli_fetch_assoc($resultAccessRgihts);
        $this->controller->updateTableRecordValuesWhere(false,"readers",
                array(
                    array("reader_active_account", date_format($date,"y-m-d")),
                    array("reader_acces_right_id", $rowAR['acces_right_id'])),
                array(array("reader_id", "=", $id, ""))
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
                                    <td><input type="text" value="" name="cover" placeholder="Okładka" required/></td>
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
    public function showchangePassForm(){
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
    
    public function showAllReaders($id = "%", $login = "%", $email = "%", $name = "%", $surname = "%") {
        return '<div id="search" align="center"><table><tr>'
                . '<td><input placeholder="ID" style="width: 60%;" type="text" id="id"></td>'
                . '<td><input placeholder="Login" style="width: 60%;" type="text" id="login"></td>'
                . '<td><input placeholder="Email" style="width: 60%;" type="text" id="email"></td>'
                . '<td><input placeholder="Imie" style="width: 60%;" type="text" id="name"></td>'
                . '<td><input placeholder="Nazwisko" style="width: 60%;" type="text" id="surname"></td>'
                . '</tr></table></div>'.templateTable($this->controller, array("ID", "Login", "Email", "Imie", "Nazwisko"),
                                        array("reader_id", "reader_login", "reader_email", "reader_name", "reader_surname"),
                                        "readers", "usersTable", "profile_readers.php?id" ).
                '<p><a href="'.backToFuture().'Library/AdminAction/Add/registration_reader.php">Dodaj</a></p>';
        }
    public function showAllBorrows($id = "%", $bookId = "%", $readerId = "%", $dateBorrow = "%", $dateReturn = "%"){
        return '<div id="search" align="center"><table><tr>'
                . '<td><input placeholder="ID" style="width: 60%;" type="text" id="id"></td>'
                . '<td><input placeholder="ID książki" style="width: 60%;" type="text" id="id_book"></td>'
                . '<td><input placeholder="ID czytelnika" style="width: 60%;" type="text" id="id_reader"></td>'
                . '<td><input placeholder="Data wypożyczenia" style="width: 60%;" type="text" id="date_borrow"></td>'
                . '<td><input placeholder="Data zwrotu" style="width: 60%;" type="text" id="date_return"></td>'
                . '</tr></table></div>'.templateTable($this->controller, array('ID','ID książki','ID czytelnika', 'Data wypożyczenia', 'Odebrano?', 'Data zwrotu'),
                                    array('borrow_id','borrow_book_id','borrow_reader_id', 'borrow_date_borrow', 'borrow_received', 'borrow_return'),
                                    "borrows", "borrowsTable", backToFuture().'Library/AdminAction/borrow.php?id');
    }
    public function showAllBooks($id = "%", $isbn = "%", $title = "%", $publisher_house = "%", $premiere = "%", $edition = "%") {
            $books = "";
            $this->controller->connect();
            $books .= '<div id="search" align="center"><table><tr>'
                . '<td><input placeholder="ID" style="width: 60%;" type="text" id="id"></td>'
                . '<td><input placeholder="ISBN" style="width: 60%;" type="text" id="isbn"></td>'
                . '<td><input placeholder="Tytuł" style="width: 60%;" type="text" id="title"></td>'
                . '<td><input placeholder="Autor" style="width: 60%;" type="text" id="authors"></td>'
                . '<td><input placeholder="Wydawca" style="width: 60%;" type="text" id="publisher_house"></td>'
                . '<td><input placeholder="Ilość stron" style="width: 60%;" type="text" id="number_page"></td>'
                . '<td><input placeholder="Wydanie" style="width: 60%;" type="text" id="edition"></td>'
                . '<td><input placeholder="Premiera" style="width: 60%;" type="text" id="premiere"></td>' 
                . '</tr></table></div>';
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "view_books",
                    array("*"));
            if(mysqli_num_rows($result) == 0) {
			$books = $books.'Brak książek';
            }
            else{
			$books = $books.'
				<div id="booksTable" align="center">
				<p><table>
					<tr> <td>ID</td> <td>ISBN</td> <td>Tytył</td> <td>Autorzy</td> <td>Wydawca</td> <td>Wydanie</td> <td>Premiera</td></tr>
				';
			while($row = mysqli_fetch_assoc($result)) {
				$resultAuthors = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "authors", 
                                    array("authors.*"),
                                    array(
                                                array("authors_books", "authors_books.author_id", "authors.author_id"),
                                                array("books", "books.book_id", "authors_books.book_id")
                                                ),
                                    array(
                                                array("books.book_id", "=", $row['book_id'], "")
                                                )
                                    );
				$books = $books.'<tr onClick="location.href=\'https://torus.uck.pk.edu.pl/~dslusarz/Library/UserAction/book.php?book='.$this->controller->clear($row['book_id']).'\'" /> '
                                                    . '<td>'.$this->controller->clear($row['book_id']).'</td> '
                                                    . '<td>'.$this->controller->clear($row['book_isbn']).'</td> '
                                                    . '<td>'.$this->controller->clear($row['book_title']).'</td> '
                                                    . '<td>'.$this->controller->clear($this->controller->authorsToString($resultAuthors)).'</td> '
                                                    . '<td>'.$this->controller->clear($row['publisher_house_name']).', '.$this->controller->clear($row['publisher_house_country']).'</td>'
                                                    . '<td>'.$this->controller->clear($row['book_edition']).'</td> '
                                                    . '<td>'.$this->controller->clear($row['book_premiere']).'</td>'
                                                . ' </tr>';
			}
			$books = $books.'</table><p><a href="'.backToFuture().'Library/AdminAction/Add/add_book.php">Dodaj</a></p></div>';
		}     
                $this->controller->close();
            return $books; 
        }
    public function showAllAdmins($id = "%", $login = "%", $email = "%", $name = "%", $surname = "%"){
        return '<div id="search" align="center"><table><tr>'
                . '<td><input placeholder="ID" style="width: 60%;" type="text" id="id"></td>'
                . '<td><input placeholder="Login" style="width: 60%;" type="text" id="login"></td>'
                . '<td><input placeholder="Email" style="width: 60%;" type="text" id="email"></td>'
                . '<td><input placeholder="Imie" style="width: 60%;" type="text" id="name"></td>'
                . '<td><input placeholder="Nazwisko" style="width: 60%;" type="text" id="surname"></td>'
                . '</tr></table></div><div id="table">'.templateTable($this->controller, array("ID", "Login", "Email", "Imie", "Nazwisko"),
                                    array("admin_id", "admin_login", "admin_email", "admin_name", "admin_surname"),
                                    "admins", "usersTable", backToFuture().'Library/AdminAction/profile_admins.php?id').
                '</div><p><a href="'.backToFuture().'Library/AdminAction/Add/registration_admin.php">Dodaj</a></p>';
        }
    public function showAllLogged(){
        return '<p>'.templateTable($this->controller, array("Session ID", "IP","User Agent", "User", "Logged", "Rights", "Last action"),
                                        array("session_id", "session_ip","session_user_agent", "session_user", "session_logged", "session_acces_right", "session_last_action"),
                                        "sessions", "loggedTable", "" ).'</p>';
	} 
    
    public function showAdmin($adminID){
        $userData =  $this->getData($adminID);
        $this->controller->connect();
	$return = '<p>
                            ID: '.$this->controller->clear($userData['admin_id']).'<br>
                            Imie: '.$this->controller->clear($userData['admin_name']).'<br>
                            Nazwisko: '.$this->controller->clear($userData['admin_surname']).'<br>
                            Login: '.$this->controller->clear($userData['admin_login']).'<br>
                            Email: '.$this->controller->clear($userData['admin_email']).'<br>
                            Prawa: '.$this->controller->clear($userData['acces_right_name']).'<br>
                                <button id="editAdmin">Edytuj</button>
                                <button id="deleteAdmin">Usuń</button>
                        </p>';
        $this->controller->close();
        return $return;
        }
    public function showEditAdmin($adminID){
        $this->controller->connect();
        $userData =  $this->controller->getAdminData($adminID);
        $return = '<div align="center">
            <form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?id='.$this->controller->clear($userData['admin_id']).'" method="post">
                <table>
                    <tr align="center">
                        <td colspan="2">Edytowanie admina o '.$this->controller->clear($userData['admin_id']).'</td>
                    </tr>
                    <tr>
                        <td>Imie:</td>
                        <td><input type="text" id="name" name="name" value="'.$this->controller->clear($userData['admin_name']).'"/></td>
                    </tr>
                    <tr>
                        <td>Nazwisko:</td>
                        <td><input type="text" id="surname" name="surname" value="'.$this->controller->clear($userData['admin_surname']).'"/></td>
                    </tr>
                    <tr>
                        <td>Login:</td>
                        <td><input type="text" id="login" name="login" value="'.$this->controller->clear($userData['admin_login']).'"/></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input type="email" id="email" name="email" value="'.$this->controller->clear($userData['admin_email']).'"/></td>
                    </tr>
                </table>
                <input type="hidden" id="edit" name="edit" value="'.$this->controller->clear($userData['admin_id']).'"/>
                <input type="submit" id="submit" value="Zapisz zmiany"/>
            </form></div>';
        $this->controller->close();
        return $return;
        } 
        
    public function showReader($readerID){
        $this->controller->connect();
        $userData = $this->controller->getReaderData($readerID);

        $return = '<p>
            ID: '.$this->controller->clear($userData['reader_id']).'<br>
            Imie: '.$this->controller->clear($userData['reader_name']).'<br>
            Nazwisko: '.$this->controller->clear($userData['reader_surname']).'<br>
            Login: '.$this->controller->clear($userData['reader_login']).'<br>
            Email: '.$this->controller->clear($userData['reader_email']).'<br>
            Konto aktywne do: '.$this->controller->clear($userData['reader_active_account']).'<br>
            Adres: '.$this->controller->clear($userData['country_name']).', '.$this->controller->clear($userData['city_name']).' '.$this->controller->clear($userData['post_code_name']).', ul. '.$this->controller->clear($userData['street_name']).' '.$this->controller->clear($userData['house_number_name']).'<br>	
            Prawa: '.$this->controller->clear($userData['acces_right_name']).'<br>
            <button id="extendAccount">Przedłuż konto</button>
            <button id="deleteReader">Usuń czytelnika</button> 
            <button id="editReader">Edytuj</button> 
            <button id="newPassword">Wygeneruj nowe hasło</button> 
	</p>';
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
        $return = '<div id="registration" align="center">
			<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?id='.$this->controller->clear($userData['reader_id']).'" method="post">
				<table>
                                        <tr align="center">
                                            <td colspan="4">Edytowanie czytelnika o id '.$this->controller->clear($userData['reader_id']).'</td>
                                        </tr>
                                        <tr align="center">
                                            <td colspan="2">Dane</td>
                                            <td colspan="2">Adres</td>
                                        </tr>
					<tr>
                                            <td>Login:</td>
                                            <td><input id="login" type="text" value="'.$this->controller->clear($userData['reader_login']).'" name="login" placeholder="Login" required/><span id="status_login"></span></td>
                                            <td>Kraj:</td>
                                            <td><input id="country" type="text" value="'.$this->controller->clear($userData['country_name']).'" name="country" placeholder="Kraj" required/></td>
                                        
                                        </tr>
					<tr>
                                            <td>E-mail:</td>
                                            <td><input id="email" type="email" value="'.$this->controller->clear($userData['reader_email']).'" name="email" placeholder="E-mail" required/><span id="status_email"></span>
                                            <td>Miasto:</td>
                                            <td><input id="city" type="text" value="'.$this->controller->clear($userData['reader_login']).'" name="city" placeholder="Misto" required/></td>
                                        </td></tr>
					<tr>
                                            <td>Imie:</td>
                                            <td><input id="name" type="text" value="'.$this->controller->clear($userData['reader_name']).'" name="name" placeholder="Imie" required/></td>
                                            <td>Kod pocztowy:</td>
                                            <td><input id="post_code" type="text" value="'.$this->controller->clear($userData['post_code_name']).'" name="post_code" placeholder="Kod pocztowy" required/></td>
                                        </tr>
					<tr>
                                            <td>Nazwisko:</td>
                                            <td><input id="surname" type="text" value="'.$this->controller->clear($userData['reader_surname']).'" name="surname" placeholder="Nazwisko" required/></td>
                                            <td>Ulica:</td>
                                            <td><input id="street" type="text" value="'.$this->controller->clear($userData['street_name']).'" name="street" placeholder="Ulica" required/></td>
                                        </tr>
					<tr>
                                            <td></td>
                                            <td></td>
                                            <td>Nr mieszkania/domu:</td>
                                            <td><input id="nr_house" type="text" value="'.$this->controller->clear($userData['house_number_name']).'" name="nr_house" placeholder="Nr mieszkania/domu" required/></td>
                                        </tr>
				</table>
                                <input type="hidden" id="edit" name="edit" value="'.$this->controller->clear($userData['reader_id']).'"/>
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
            if($row['free_books'] == null){
                $freeBook = $row['book_number'];
            }
            else{
                $freeBook = $row['free_books'];
            }
            
            $return =  '<p>
					ID: '.$this->controller->clear($row['book_id']).'<br>
					ISBN: '.$this->controller->clear($row['book_isbn']).'<br>
                                        Oryginalny tytuł: '.$this->controller->clear($row['book_original_title']).'<br>
					Tytuł: '.$this->controller->clear($row['book_title']).'<br>
					Autorzy: '.$this->controller->clear($this->controller->authorsToString($resultAuthors)).'<br>
                                        Tłumacze: '.$this->controller->translatorsToString($resultTranslators).'<br>
                                        Oryginalne wydawnictwo: '.$this->controller->clear($row['original_publisher_house_name']).'<br>
                                        Wydawnictwo: '.$this->controller->clear($row['publisher_house_name']).'<br>
					Premiera: '.$this->controller->clear($row['book_premiere']).'<br>
					Wydanie: '.$this->controller->clear($row['book_edition']).'<br>
					Ilość stron: '.$this->controller->clear($row['book_nr_page']).'<br>
                                        Okładka: '.$this->controller->clear($row['book_cover']).'<br>
                                        Ilość wszsytkich egzemplarzy: '.$this->controller->clear($row['book_number']).'<br>
					Ilość dostępnych egzemplarzy: '.$freeBook.'<br>
                                        <button id="editBook">Edytuj</button>
                                        <button id="deleteBook">Usuń</button>
				</p>';
            $this->controller->close();
            return $return;
        }
    public function showEditBook($bookID){
        $this->controller->connect();
        $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "view_books", 
                    null,null,
                    array(array("book_id","=", $bookID, "")));
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
		<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?id='.$this->controller->clear($row['book_id']).'" method="post">
			<table>
				<tr>
                                    <td colspan="3" align="center">Edytuj książke:</td>
                                </tr>
				<tr>
                                    <td>ISBN:</td>
                                    <td><input type="text" value="'.@$this->controller->clear($row['book_isbn']).'" name="isbn" placeholder="ISBN" required/></td>
                                </tr>
				<tr>
                                    <td>Oryginalny tytuł:</td>
                                    <td><input type="text" value="'.@$this->controller->clear($row['book_original_title']).'" name="original_title" placeholder="Oryginalny tytuł" required/></td>
                                </tr>
				<tr>
                                    <td>Tytuł:</td>
                                    <td><input type="text" value="'.@$this->controller->clear($row['book_title']).'" name="title" placeholder="Tytuł" required/></td>
                                </tr>
                                <tr>
                                    <td>Oryginalny wydawca:</td>
                                    <td><input type="text" value="'.@$this->controller->clear($row['original_publisher_house_name']).'" name="original_publisher_house" placeholder="Oryginalny wydawca" required/></td>
                                    <td><input type="text" value="'.@$this->controller->clear($row['original_publisher_house_country']).'" name="country_original_publisher_house" placeholder="Kraj" required/></td>
                                </tr>        
				<tr>
                                    <td>Wydawca:</td>
                                    <td><input type="text" value="'.@$this->controller->clear($row['publisher_house_name']).'" name="publisher_house" placeholder="Wydawca" required/></td>
                                    <td><input type="text" value="'.@$this->controller->clear($row['publisher_house_country']).'" name="country_publisher_house" placeholder="Kraj" required/></td>
                                </tr>
				<tr>
                                    <td>Ilość stron:</td>
                                    <td><input type="text" value="'.@$this->controller->clear($row['book_nr_page']).'" name="nr_page" placeholder="Ilość stron" required/></td>
                                </tr>
				<tr>
                                    <td>Wydanie:</td>
                                    <td><input type="text" value="'.@$this->controller->clear($row['book_edition']).'" name="edition" placeholder="Wydanie" required/></td>
                                </tr>
				<tr>
                                    <td>Rok wydania:</td>
                                    <td><input type="text" value="'.@$this->controller->clear($row['book_premiere']).'" name="premiere" placeholder="Rok Wydania" required/></td>
                                </tr>
                                <tr>
                                    <td>Okładka:</td>
                                    <td><input type="text" value="'.@$this->controller->clear($row['book_cover']).'" name="cover" placeholder="Okładka" required/></td>
                                </tr>
				<tr>
                                    <td>Ilość egzemplarzy:</td>
                                    <td><input type="text" value="'.@$this->controller->clear($row['book_number']).'" name="number" placeholder="Ilość egzemplarzy" required/></td>
                                </tr>
			</table>            
                                <table><tbody id="authotsTable">
                                <tr>
                                    <td align="center" colspan="5">Autorzy</td>
                                </tr>';
                                $i = 0;
                                while($rowA = mysqli_fetch_array($resultAuthors)){
                                    if($i == 0){
                                        $return .= '<tr><td><input type="text" value="'.@$this->controller->clear($rowA['author_name']).'" name="authorName['.$i.']" placeholder="Imie" required/></td>';
                                        $return .= '<td><input type="text" value="'.@$this->controller->clear($rowA['author_surname']).'" name="authorSurname['.$i.']" placeholder="Nazwisko" required/></td></tr>';
                                    }
                                    else{
                                        $return .= '<tr><td><input type="text" value="'.@$this->controller->clear($rowA['author_name']).'" name="authorName['.$i.']" placeholder="Imie" /></td>';
                                        $return .= '<td><input type="text" value="'.@$this->controller->clear($rowA['author_surname']).'" name="authorSurname['.$i.']" placeholder="Nazwisko" /></td></tr>';
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
                                $i = 0;
                                while($rowT = mysqli_fetch_array($resultTranslators)){
                                    $return .= '<tr><td><input type="text" value="'.@$this->controller->clear($rowT['translator_name']).'" name="translatorName['.$i.']" placeholder="Imie"/></td>';
                                    $return .= '<td><input type="text" value="'.@$this->controller->clear($rowT['translator_surname']).'" name="translatorSurname['.$i.']" placeholder="Nazwisko"/></td></tr>';
                                    $i++;
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
    public function showBookLight($bookID){
        return parent::showBookLight($bookID);
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
    
    public function addReader($login, $email, $name, $surname, $password1, $password2, $country, $city, $street, $post_code, $nr_house){
        $this->controller->connect();
		$login = $this->controller->clear($login);
		$email = $this->controller->clear($email);
		$name = $this->controller->clear($name);
		$password1 = $this->controller->clear($password1);
		$password2 = $this->controller->clear($password2);
		$surname = $this->controller->clear($surname);
		$country = $this->controller->clear($country);
                $city = $this->controller->clear($city);
                $street = $this->controller->clear($street);
                $post_code = $this->controller->clear($post_code);
                $nr_house = $this->controller->clear($nr_house);
		if(empty($login) 
			|| empty($password1) 
			|| empty($password2) 
			|| empty($name)
			|| empty($surname)
			|| empty($email)
			|| empty($city)
                        || empty($country)
                        || empty($street)
                        || empty($post_code)
                        || empty($nr_house)
                        
		){
                    $this->controller->close();
			return '<p>Musisz wypełnić wszystkie pola.</p>';
		}
                elseif($password1 != $password2) {
                    $this->controller->close();
			return '<p>Podane hasła różnią się od siebie.</p>';
		}
                elseif(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                    $this->controller->close();
			return '<p>Podany email jest nieprawidłowy.</p>';
		}
                else{
                    if($this->controller->userExist("readers", "reader", $login, $email)){
                        $this->controller->close();
                        return '<p>Już istnieje użytkownik z takim loginem lub adresem e-mail.</p>';
                    }
                    elseif($this->controller->userExist("admins", "admin", $login, $email)){
                        $this->controller->close();
                        return '<p>Już istnieje użytkownik z takim loginem lub adresem e-mail.</p>';
                    }
                    if(strlen($login) < 4){
                        $this->controller->close();
                    	return '<p>Za mało znaków.</p>';
                    }
                    $resultAccessRgihts = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "acces_rights", 
                            array("*"),
                            null,
                            array(array("acces_right_name","=", "activeReader", "")));
                    if(mysqli_num_rows($resultAccessRgihts) == 0) {
                        $this->controller->close();
                    	die('Błąd');
                    }
                    $rowAR = mysqli_fetch_assoc($resultAccessRgihts);
                    $date = date_create(date('Y-m-d'));
                    date_add($date, date_interval_create_from_date_string('365 days')); 
                    $this->controller->insertTableRecordValue(false,"readers", 
                            array("reader_name", "reader_surname", "reader_login", "reader_password", "reader_email", "reader_address_id", "reader_active_account", "reader_acces_right_id"),
                            array($name, $surname, $login, $this->controller->codepass($password1), $email, $this->addAddress($country, $city,$post_code ,$street, $nr_house),  date_format($date,"y-m-d"), $rowAR['acces_right_id']));
                    $this->controller->close();
                    return '<p>Czytelnik Został poprawnie zarejestrowany! Możesz się teraz wrócić na <a href="'.backToFuture().'Library/index.php">stronę główną</a>.</p>';
		}
	}
    public function editReader($id, $login, $email, $name, $surname, $country, $city, $street, $post_code, $nr_house) {
        $this->controller->connect();
        $this->controller->updateTableRecordValuesWhere(false,"readers",
                        array(
                            array("reader_login",$this->controller->clear($login)),
                            array("reader_email",$this->controller->clear($email)),
                            array("reader_name",$this->controller->clear($name)),
                            array("reader_surname",$this->controller->clear($surname))
                            ),
                        array(array("reader_id","=",$this->controller->clear($id),"")));
        $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "readers",null, null,
                array(array("reader_id","=",$id,"")));
        $row = mysqli_fetch_array($result);
        $this->controller->updateTableRecordValuesWhere(false,"addresses",
                array(
                    array("address_country_id", $this->addCountry($this->controller->clear($country))),
                    array("address_city_id", $this->addCity($this->controller->clear($city))),
                    array("address_post_code_id", $this->addPostCode($this->controller->clear($post_code))),
                    array("address_street_id", $this->addStreet($this->controller->clear($street))),
                    array("address_nr_house_id", $this->addHouseNumber($this->controller->clear($nr_house)))
                    ),
                
                array(array("address_id","=", $row['reader_address_id'],"")));
        $this->controller->close();
        return "<p>Edytowano czytelnika</p>";
    }
    public function deleteReader($id) {
        $this->controller->connect();
        $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "borrows",
            null, null, array(array("borrow_reader_id","=",$id,"")));
        if(mysqli_num_rows($result) > 0){
            $return = "<p>Nie można usunąć czytelnika</p>";
        }
        else{
            $this->controller->deleteTableWhere(false,"readers", array(array("reader_id", "=", $id, "")));
            $return = "<p>Usunięto czytelnika</p>";
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
        $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "borrows",
            null, null, array(array("borrow_book_id","=",$id,"")));
        if(mysqli_num_rows($result) > 0){
            $return = "<p>Nie można usunąć książki</p>";
        }
        else{
            $this->controller->deleteTableWhere(false,"authors_books", array(array("book_id", "=", $id, "")));
            $this->controller->deleteTableWhere(false,"translators_books", array(array("book_id", "=", $id, "")));
            $this->controller->deleteTableWhere(false,"books", array(array("book_id", "=", $id, "")));
            $return = "<p>Usunięto książke</p>";
        }
        $this->controller->close();
        return $return;
    }
    
    public function addAdmin($name, $surname, $password1, $password2, $email, $login) {
        $this->controller->connect();
            $name = $this->controller->clear($name);
            $surname = $this->controller->clear($surname);
            $password1 = $this->controller->clear($password1);
            $password2 = $this->controller->clear($password2);
            $email = $this->controller->clear($email);
            $login = $this->controller->clear($login);
            if(empty($name) 
		|| empty($password1) 
		|| empty($password2) 
		|| empty($login)
		|| empty($surname)
		|| empty($email)){
                return '<p>Musisz wypełnić wszystkie pola.</p>';
            }
            elseif($password1 !=  $password2) {
                $this->controller->close();
		return '<p>Podane hasła różnią się od siebie.</p>';
            } 
            elseif(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
                $this->controller->close();
		return '<p>Podany email jest nieprawidłowy.</p>';
            }
            else{
                if($this->controller->userExist("readers", "reader", $login, $email)){
                    $this->controller->close();
                    return '<p>Już istnieje użytkownik z takim loginem lub adresem e-mail.</p>';
                }
                elseif($this->controller->userExist("admins", "admin", $login, $email)){
                    $this->controller->close();
                    return '<p>Już istnieje użytkownik z takim loginem lub adresem e-mail.</p>';
                }
                if(strlen($login) < 4){
                    return '<p>Za mało znaków.</p>';
                }
                $resultAccessRgihts = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "acces_rights", 
                            array("*"),
                            null,
                            array(array("acces_right_name","=", "admin", "")));
                if(mysqli_num_rows($resultAccessRgihts) == 0) {
                    $this->controller->close();
                    die('Błąd');
                }
                $rowAR = mysqli_fetch_assoc($resultAccessRgihts);
                $this->controller->insertTableRecordValue(false,"admins", 
                            array("admin_name", "admin_surname", "admin_login", "admin_password", "admin_email", "admin_acces_right_id"),
                            array($name, $surname, $login, $this->controller->codepass($password1), $email, $rowAR['acces_right_id']));
                $this->controller->close();
                return "<p>Dodano admina</p>";
            }
        }
    public function editAdmin($id, $name, $surname, $email, $login){
        $this->controller->connect();
        $this->controller->updateTableRecordValuesWhere(true,"admins",
                        array(
                            array("admin_login",$this->controller->clear($login)),
                            array("admin_email",$this->controller->clear($email)),
                            array("admin_name",$this->controller->clear($name)),
                            array("admin_surname",$this->controller->clear($surname))
                            ),
                        array(array("admin_id","=",$this->controller->clear($id),"")));
        $this->controller->close();
        return "<p>Edytowano admina</p>";
        
    }
    public function deleteAdmin($id) {
        $this->controller->connect();
        $this->controller->deleteTableWhere(false,"admins", array(array("admin_id", "=", $_POST['deleteAdmin'], "")));
        $return = "<p>Usunięto admina</p>";
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
        $id = $this->controller->clear($id);
        $this->controller->deleteTableWhere(false,"news", array(array("new_id","=",$id,"")));
        $this->controller->close();
    } 
    
    public function addBorrow($bookID){
        return "<p>Jesteś adminem nie możesz wypożyczać</p>";
    }
    public function deleteBorrow($id) {
        $this->controller->connect();
        $this->controller->deleteTableWhere(false,"borrows", array(array("borrow_id", "=", $id, "")));
        $return = "<p>Książka została zwrócona</p>";
        $this->controller->close();
        return $return;
    }
    public function receiveBorrow($id) {
        $this->controller->connect();
        $this->controller->updateTableRecordValuesWhere(false,"borrows",
            array(array("borrow_received", "1")),
            array(array("borrow_id", "=", $id, "")));
    
        $return = "<p>Odebrano książke<p>";
        $this->controller->close();
        return $return;
    }
    
    public function isActive($ID){
        return false;
    }
    
    public function getData($ID){
        $this->controller->connect();
        $ID = $this->controller->clear($ID);
        $data = $this->controller->getAdminData($ID);
        $this->controller->close();
	return $data;
    }
    
    public function changePass($oldPass, $newPass){
        $this->controller->connect();
        $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, 
                "admins",array("admin_password"),null,
                array(array("admin_id","=",$this->userID,"")),null,null,null,True);
        $row = mysqli_fetch_assoc($result);
        if($row["admin_password"] != $this->controller->codepass($oldPass)){
            return "<p>Podano błedne hasło<p>";
        }
        $this->controller->updateTableRecordValuesWhere(false,"admins",
                array(array("admin_password", $this->controller->codepass($newPass))),
                array(array("admin_id","=",$this->userID,"")),true);
        $this->controller->close();
        return "<p>Zmieniono hasło<p>";
        
    }
    public function generateNewPas($id) {
        $this->controller->connect();
        $pass = uniqid("reader");
        $this->controller->updateTableRecordValuesWhere(false,"readers",
                array(array("reader_password", $this->controller->codepass($pass))),
                array(array("reader_id", "=", $id, "")));

        $return = "<p>Nowe hasło to: ".$pass.'</p>';
        $this->controller->close();
        return $return;
    }

}
?>