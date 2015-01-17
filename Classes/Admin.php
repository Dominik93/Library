<?php
include_once "User.php";

class Admin extends User{

    public function __construct($c, $u = -1) {
        parent::__construct($c, $u);
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
    private function addAuthors($author, $bookId){
        $authors = explode(",", $author);
	foreach($authors as $author){
            $date = explode(' ', $author);
            $name = $date[0];
            $surname = $date[1];
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "authors", 
                                array("*"), null,
                                array(
                                    array("author_name","=", $name, "AND"),
                                    array("author_surname","=", $surname, "")
                                    ));
            if(mysqli_num_rows($result) > 0){
		$rowA = mysqli_fetch_array($result);
            }
            else{
                    $this->controller->insertTableRecordValue(false,"authors",
                            array("author_name", "author_surname"),
                            array($name, $surname));
                    $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "authors", 
                                        array("*"), null,
                                        array(
                                        array("author_name","=", $name, "AND"),
                                        array("author_surname","=", $surname, "")
                                        ));
                    $rowA = mysqli_fetch_array($result);
		}
            $this->controller->insertTableRecordValue(false,"authors_books",
                    array("author_id", "book_id"), 
                    array($rowA[0], $bookId));
        }	
    }
    private function addTranslators($translator, $bookId){
        $translators = explode(",", $translator);
	foreach($translators as $translator){
            $date = explode(' ', $translator);
            $name = $date[0];
            $surname = $date[1];
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "translators", 
                                array("*"), null,
                                array(
                                    array("translator_name","=", $name, "AND"),
                                    array("translator_surname","=", $surname, "")
                                    ));
            if(mysqli_num_rows($result) > 0){
		$rowA = mysqli_fetch_array($result);
            }
            else{
                    $this->controller->insertTableRecordValue(false,"translators",
                            array("translator_name", "translator_surname"),
                            array($name, $surname));
                    $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "translators", 
                                        array("*"), null,
                                        array(
                                        array("translator_name","=", $name, "AND"),
                                        array("translator_surname","=", $surname, "")
                                        ));
                    $rowA = mysqli_fetch_array($result);
		}
            $this->controller->insertTableRecordValue(false,"translators_books",
                    array("translator_id", "book_id"), 
                    array($rowA[0], $bookId));
        }
    }
    private function addAddress($country, $city,$postCode ,$street, $houseNumber){
        $this->controller->insertTableRecordValue(true,"addresses",
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
        $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(true, "view_addresses", null,null,
                array(
                    array("address_street_id","=",$street,"AND"),
                    array("address_post_code_id","=",$postCode,"AND"),
                    array("address_nr_house_id","=",$houseNumber,"AND"),
                    array("address_country_id","=",$country,"AND"),
                    array("address_city_id","=",$city,"")
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
        
    public function session(){
        $this->controller->connect();
        $this->controller->updateTableRecordValuesWhere(false,"sessions", 
                array(array("session_last_action", date('Y-m-d H:i:s'))),
                array(
                    array("session_user","=", $this->userID, "AND"),
                    array("session_acces_right","=", "admin", "")
                    ));
        $this->controller->close();
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
		$news = $news.'<p>';
		if(mysqli_num_rows($result) == 0) {
				$news = $news.'Brak newsów';
		}else{
			while($row = mysqli_fetch_assoc($result)) {
				$news = $news.$row['new_title'].' '.$row['new_date'].' '.$row['new_text'];
				$news = $news.' <a href="'.backToFuture().'Library/Menu/news.php?id='.$row['new_id'].'">Usuń</a><br>';
			}	
                }
		$news = $news.'</p>';
                $this->controller->close();
		return $news;
	}
    public function showLogged(){
        return '<p>'.templateTable($this->controller, array("Session ID", "IP","User Agent", "User", "Logged", "Rights", "Last action"),
                                        array("session_id", "session_ip","session_user_agent", "session_user", "session_logged", "session_acces_right", "session_last_action"),
                                        "sessions", "loggedTable", "" ).'</p>';
	}
    public function showAccount(){
        $userData =  $this->getData($this->userID);
	return '<p>
                            ID: '.$userData['admin_id'].'<br>
                            Imie: '.$userData['admin_name'].'<br>
                            Nazwisko: '.$userData['admin_surname'].'<br>
                            Login: '.$userData['admin_login'].'<br>
                            Email: '.$userData['admin_email'].'<br>
                            Prawa: '.$userData['acces_right_name'].'<br>
                        </p>';
	}
    public function showRegistrationReader(){
        return '<div id="registration" align="center">
			<form action="'.backToFuture().'Library/AdminAction/Add/registration_reader.php" method="post">
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
                                            <td><input id="login" type="text" value="'.@$_POST['login'].'" name="login" placeholder="Login" required/><span id="status_login"></span></td>
                                            <td>Kraj:</td>
                                            <td><input id="country" type="text" value="'.@$_POST['country'].'" name="country" placeholder="Kraj" required/></td>
                                        
                                        </tr>
					<tr>
                                            <td>E-mail:</td>
                                            <td><input id="email" type="email" value="'.@$_POST['email'].'" name="email" placeholder="E-mail" required/><span id="status_email"></span>
                                            <td>Miasto:</td>
                                            <td><input id="city" type="text" value="'.@$_POST['city'].'" name="city" placeholder="Misto" required/></td>
                                        </td></tr>
					<tr>
                                            <td>Hasło:</td>
                                            <td><input id="password1" type="password" value="'.@$_POST['password1'].'" name="password1" placeholder="Hasło" required/></td>
                                            <td>Kod pocztowy:</td>
                                            <td><input id="post_code" type="text" value="'.@$_POST['post_code'].'" name="post_code" placeholder="Kod pocztowy" required/></td>
                                        </tr>
					<tr>
                                            <td>Powtórz hasło:</td>
                                            <td><input id="password2" type="password" value="'.@$_POST['password2'].'" name="password2" placeholder="Powtórz hasło" required/><span id="status_password"></span></td>
                                            <td>Ulica:</td>
                                            <td><input id="street" type="text" value="'.@$_POST['street'].'" name="street" placeholder="Ulica" required/></td>
                                        </tr>
					<tr>
                                            <td>Imie:</td>
                                            <td><input id="name" type="text" value="'.@$_POST['name'].'" name="name" placeholder="Imie" required/></td>
                                            <td>Nr mieszkania/domu:</td>
                                            <td><input id="nr_house" type="text" value="'.@$_POST['nr_house'].'" name="nr_house" placeholder="Nr mieszkania/domu" required/></td>
                                        </tr>
					<tr>
                                            <td>Nazwisko:</td>
                                            <td><input id="surname" type="text" value="'.@$_POST['surname'].'" name="surname" placeholder="Nazwisko" required/></td>
                                        </tr>
				</table>
				<input type="submit" id="submit" value="Zarejestruj czytelnika">
			</form>
		</div>';
	}  
    public function showRegistrationAdmin() {
             return '<div id="registration" align="center">
			<form action="'.backToFuture().'Library/AdminAction/Add/registration_admin.php" method="post">
				<table>
					<tr>Dodaj admina</tr>
					<tr><td>Login:</td><td><input id="login" type="text" value="'.@$_POST['login'].'" name="login" placeholder="Login" required/><span id="status_login"></span></td></tr>
					<tr><td>E-mail:</td><td><input id="email" type="email" value="'.@$_POST['email'].'" name="email" placeholder="E-mail" required/><span id="status_email"></span></td></tr>
					<tr><td>Hasło:</td><td><input id="password1" type="password" value="'.@$_POST['password1'].'" name="password1" placeholder="Hasło" required/></td></tr>
					<tr><td>Powtórz hasło:</td><td><input id="password2" type="password" value="'.@$_POST['password2'].'" name="password2" placeholder="Powtórz hasło" required/><span id="status_password"></span></td></tr>
					<tr><td>Imie:</td><td><input id="name" type="text" value="'.@$_POST['name'].'" name="name" placeholder="Imie" required/></td></tr>
					<tr><td>Nazwisko:</td><td><input id="surname" type="text" value="'.@$_POST['surname'].'" name="surname" placeholder="Nazwisko" required/></td></tr>
				</table>
				<input type="submit" id="submit" value="Zarejestruj admina">
			</form>
		</div>';
        }
    public function showAddBookForm() {
        return '<div id="add_book" align="center">
		<form action="'.backToFuture().'Library/AdminAction/Add/add_book.php" method="post">
			<table>
				<tr>
                                    <td colspan="3" align="center">Dodaj książke:</td>
                                </tr>
				<tr>
                                    <td>ISBN:</td>
                                    <td><input type="text" value="'.@$_POST['isbn'].'" name="isbn" placeholder="ISBN" required/></td>
                                </tr>
				<tr>
                                    <td>Oryginalny tytuł:</td>
                                    <td><input type="text" value="'.@$_POST['original_title'].'" name="original_title" placeholder="Oryginalny tytuł" required/></td>
                                </tr>
				<tr>
                                    <td>Tytuł:</td>
                                    <td><input type="text" value="'.@$_POST['title'].'" name="title" placeholder="Tytuł" required/></td>
                                </tr>
                                <tr>
                                    <td>Oryginalny wydawca:</td>
                                    <td><input type="text" value="'.@$_POST['original_publisher_house'].'" name="original_publisher_house" placeholder="Oryginalny wydawca" required/></td>
                                    <td><input type="text" value="'.@$_POST['country_original_publisher_house'].'" name="country_original_publisher_house" placeholder="Kraj" required/></td>
                                </tr>        
				<tr>
                                    <td>Wydawca:</td>
                                    <td><input type="text" value="'.@$_POST['publisher_house'].'" name="publisher_house" placeholder="Wydawca" required/></td>
                                    <td><input type="text" value="'.@$_POST['country_publisher_house'].'" name="country_publisher_house" placeholder="Kraj" required/></td>
                                </tr>
				<tr>
                                    <td>Ilość stron:</td>
                                    <td><input type="text" value="'.@$_POST['nr_page'].'" name="nr_page" placeholder="Ilość stron" required/></td>
                                </tr>
				<tr>
                                    <td>Wydanie:</td>
                                    <td><input type="text" value="'.@$_POST['edition'].'" name="edition" placeholder="Wydanie" required/></td>
                                </tr>
				<tr>
                                    <td>Rok wydania:</td>
                                    <td><input type="text" value="'.@$_POST['premiere'].'" name="premiere" placeholder="Rok Wydania" required/></td>
                                </tr>
                                <tr>
                                    <td>Okładka:</td>
                                    <td><input type="text" value="'.@$_POST['cover'].'" name="cover" placeholder="Okładka" required/></td>
                                </tr>
				<tr>
                                    <td>Ilość egzemplarzy:</td>
                                    <td><input type="text" value="'.@$_POST['number'].'" name="number" placeholder="Ilość egzemplarzy" required/></td>
                                </tr>
				<tr>
                                    <td>Autor:</td>
                                    <td><input type="text" value="'.@$_POST['author'].'" name="author" placeholder="Imie Nazwisko," required/></td>
                                </tr>
                                <tr>
                                    <td>Tłumacz:</td>
                                    <td><input type="text" value="'.@$_POST['translator'].'" name="translator" placeholder="Imie Nazwisko,"/></td>
                                </tr>
			</table>
			<input type="submit" value="Dodaj ksiażke">
		</form>
	</div>';
            return '<div id="add_book" align="center">
		<form action="'.backToFuture().'Library/AdminAction/Add/add_book.php" method="post">
			<table>
				<tr> <td colspan = 2 align="center">Dodaj książke:</tf><tr>
				<tr>
                                    <td>ISBN:</td>
                                    <td><input type="text" value="'.@$_POST['isbn'].'" name="isbn" placeholder="ISBN" required/></td></tr>
				<tr>
                                    <td>Otyginalny tytuł:</td>
                                    <td><input type="text" value="'.@$_POST['original_title'].'" name="original_title" placeholder="Oryginalny tytuł" required/></td></tr>
				<tr>
                                    <td>Tytuł:</td>
                                    <td><input type="text" value="'.@$_POST['title'].'" name="title" placeholder="Tytuł" required/></td></tr>
                                <tr>
                                    <td>Oryginalny wydawca:</td>
                                    <td><input type="text" value="'.@$_POST['original_publisher_house'].'" name="original_publisher_house" placeholder="Oryginalny wydawca" required/></td></tr>        
				<tr>
                                    <td>Wydawca:</td>
                                    <td><input type="text" value="'.@$_POST['publisher_house'].'" name="publisher_house" placeholder="Wydawca" required/></td></tr>
				<tr>
                                    <td>Ilość stron:</td>
                                    <td><input type="text" value="'.@$_POST['nr_page'].'" name="nr_page" placeholder="Ilość stron" required/></td></tr>
				<tr>
                                    <td>Wydanie:</td>
                                    <td><input type="text" value="'.@$_POST['edition'].'" name="edition" placeholder="Wydanie" required/></td></tr>
				<tr>
                                    <td>Rok wydania:</td>
                                    <td><input type="text" value="'.@$_POST['premiere'].'" name="premiere" placeholder="Rok Wydania" required/></td></tr>
				<tr>
                                    <td>Ilość egzemplarzy:</td>
                                    <td><input type="text" value="'.@$_POST['number'].'" name="number" placeholder="Ilość egzemplarzy" required/></td></tr>
				<tr>
                                    <td>Autor:</td>
                                    <td><input type="text" value="'.@$_POST['author'].'" name="author" placeholder="Imie Nazwisko," required/></td></tr>
			</table>
			<input type="submit" value="Dodaj ksiażke">
		</form>
	</div>';
        }
    public function showAddNewsForm(){
       return '
            <div id="news" align="center">
                <form action="'.backToFuture().'Library/AdminAction/Add/add_news.php" method="post">
                    <table>
			<tr>
                            <td colspan = 2 align="center">Dodaj news:</td>
                        <tr>
			<tr>
                            <td>Tytył:</td>
                            <td><input type="text" value="'.@$_POST['title'].'" name="title" placeholder="Tytuł" required/></td>
                        </tr>
			<tr>
                            <td>Tekst:</td>
                            <td><textarea id="news_input" value="'.@$_POST['text'].'" name="text" placeholder="Tekst" required></textarea></td>
                        </tr>
                    </table>
                    <input type="submit" value="Dodaj news">
		</form>
            </div>';
    }
    public function showAdmin($adminID){
        $userData =  $this->getData($adminID);
	return '<p>
                            ID: '.$userData['admin_id'].'<br>
                            Imie: '.$userData['admin_name'].'<br>
                            Nazwisko: '.$userData['admin_surname'].'<br>
                            Login: '.$userData['admin_login'].'<br>
                            Email: '.$userData['admin_email'].'<br>
                            Prawa: '.$userData['acces_right_name'].'<br>
                                <button id="editAdmin">Edytuj</button>
                                <button id="deleteAdmin">Usuń</button>
                        </p>';
        }
    public function showEditAdmin($adminID){
        $this->controller->connect();
        $userData =  $this->controller->getAdminData($adminID);
        $this->controller->close();
        return '<div align="center"> Edytowanie admina o '.$userData['admin_id'].'
            <form action="'.backToFuture().'Library/AdminAction/Edit/edit_admin.php?id='.$userData['admin_id'].'" method="post">
                <table>
                    <tr>
                        <td>Imie:</td>
                        <td><input type="text" id="name" name="name" value="'.$userData['admin_name'].'"/></td>
                    </tr>
                    <tr>
                        <td>Nazwisko:</td>
                        <td><input type="text" id="surname" name="surname" value="'.$userData['admin_surname'].'"/></td>
                    </tr>
                    <tr>
                        <td>Login:</td>
                        <td><input type="text" id="login" name="login" value="'.$userData['admin_login'].'"/></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input type="email" id="email" name="email" value="'.$userData['admin_email'].'"/></td>
                    </tr>
                </table>
                <input type="hidden" id="edit" value="'.$userData['admin_id'].'"/>
                <input type="submit" id="submit" value="Zapisz zmiany">
            </form>'
                .'</div>';
        }    
    public function showReader($readerID){
        $this->controller->connect();
        $userData =  $this->controller->getReaderData($readerID);
        $this->controller->close();
        return '<p>
            ID: '.$userData['reader_id'].'<br>
            Imie: '.$userData['reader_name'].'<br>
            Nazwisko: '.$userData['reader_surname'].'<br>
            Login: '.$userData['reader_login'].'<br>
            Email: '.$userData['reader_email'].'<br>
            Konto aktywne do: '.$userData['reader_active_account'].'<br>
            Adres: '.$userData['country_name'].', '.$userData['city_name'].' '.$userData['post_code_name'].', '.$userData['street_name'].' '.$userData['house_number_name'].'<br>	
            Prawa: '.$userData['acces_right_name'].'<br>
            <button id="extendAccount">Przedłuż konto</button>
            <button id="deleteReader">Usuń czytelnika</button> 
            <button id="editReader">Edytuj</button> 
            <button id="newPassword">Wygeneruj nowe hasło</button> 
	</p>';
    }
    public function showReaderLight($readerID){
        $this->controller->connect();
        $userData =  $this->controller->getReaderData($readerID);
        $this->controller->close();
        return '<p>
            ID: '.$userData['reader_id'].'<br>
            Imie: '.$userData['reader_name'].'<br>
            Nazwisko: '.$userData['reader_surname'].'<br>
            Login: '.$userData['reader_login'].'<br>
            Email: '.$userData['reader_email'].'<br>
            Konto aktywne do: '.$userData['reader_active_account'].'<br>
            Adres: '.$userData['reader_address'].'<br>	
            Prawa: '.$userData['acces_right_name'].'<br>
	</p>';
    }
    public function showEditReader($readerID){
        $this->controller->connect();
        $userData = $this->controller->getReaderData($readerID);
        $this->controller->close();
        return '<div id="registration" align="center">
			<form action="'.backToFuture().'Library/AdminAction/Edit/edit_reader.php?id='.$userData['reader_id'].'" method="post">
				<table>
                                        <tr align="center">
                                            <td colspan="4">Edytowanie czytelnika o id '.$userData['reader_id'].'</td>
                                        </tr>
                                        <tr align="center">
                                            <td colspan="2">Dane</td>
                                            <td colspan="2">Adres</td>
                                        </tr>
					<tr>
                                            <td>Login:</td>
                                            <td><input id="login" type="text" value="'.$userData['reader_login'].'" name="login" placeholder="Login" required/><span id="status_login"></span></td>
                                            <td>Kraj:</td>
                                            <td><input id="country" type="text" value="'.$userData['country_name'].'" name="country" placeholder="Kraj" required/></td>
                                        
                                        </tr>
					<tr>
                                            <td>E-mail:</td>
                                            <td><input id="email" type="email" value="'.$userData['reader_email'].'" name="email" placeholder="E-mail" required/><span id="status_email"></span>
                                            <td>Miasto:</td>
                                            <td><input id="city" type="text" value="'.$userData['reader_login'].'" name="city" placeholder="Misto" required/></td>
                                        </td></tr>
					<tr>
                                            <td>Imie:</td>
                                            <td><input id="name" type="text" value="'.$userData['reader_name'].'" name="name" placeholder="Imie" required/></td>
                                            <td>Kod pocztowy:</td>
                                            <td><input id="post_code" type="text" value="'.$userData['post_code_name'].'" name="post_code" placeholder="Kod pocztowy" required/></td>
                                        </tr>
					<tr>
                                            <td>Nazwisko:</td>
                                            <td><input id="surname" type="text" value="'.$userData['reader_surname'].'" name="surname" placeholder="Nazwisko" required/></td>
                                            <td>Ulica:</td>
                                            <td><input id="street" type="text" value="'.$userData['street_name'].'" name="street" placeholder="Ulica" required/></td>
                                        </tr>
					<tr>
                                            <td></td>
                                            <td></td>
                                            <td>Nr mieszkania/domu:</td>
                                            <td><input id="nr_house" type="text" value="'.$userData['house_number_name'].'" name="nr_house" placeholder="Nr mieszkania/domu" required/></td>
                                        </tr>
				</table>
				<input type="submit" id="submit" value="Zarejestruj czytelnika">
			</form>
		</div>';
        
        return '<div align="center">Edytowanie czytelnika o '.$userData['reader_id'].'
            <form action="'.backToFuture().'Library/AdminAction/Edit/edit_reader.php?id='.$userData['reader_id'].'" method="post">
                Imie: <input type="text" id="name" name="name" value="'.$userData['reader_name'].'"/><br>
                Nazwisko: <input type="text" id="surname" name="surname" value="'.$userData['reader_surname'].'"/><br>
                Login: <input type="text" id="login" name="login" value="'.$userData['reader_login'].'"/><br>
                Email: <input type="email" id="email" name="email" value="'.$userData['reader_email'].'"/><br>
                Adres: <input type="text" id="address" name="address" value="'.$userData['reader_address'].'"/><br>	
                <input type="hidden" id="edit" value="'.$userData['reader_id'].'"/>
                <input type="submit" id="submit" value="Zapisz zmiany">
            </form></div>';
    }
    public function showBorrow($borrowID){
        $this->controller->connect();
        $borrow = "";
        $borrowResult = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "borrows", null, null,
                array(array("borrow_id","=", $borrowID, "")));
        $rowBorrow = mysqli_fetch_array($borrowResult);
        $feesResult = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "fees",
                null, null,
                array(array("borrow_id","=", $borrowID, "")));
        $rowF = mysqli_fetch_array($feesResult);
        $delay = 0;
        if($rowF['borrow_delay'] > 0){
            $delay = $rowF['borrow_delay'];
        }
        $this->controller->close();
        $borrow = $borrow.'<p>Data wypożyczenia: '.$rowBorrow['borrow_date_borrow'].'<br>Data zwrotu: '.$rowBorrow['borrow_return'].'<br>Odebrano: '.$rowBorrow['borrow_received'].'<br>Opóźnienie: '.$delay.'<br>Do zapłaty: '.$delay*0.25.'</p>';
        $borrow = $borrow.'<p><button id="receive">Odebrano</button> <button id="delete">Zwrócono</button></p>';
        $borrow = $borrow.'<div id="reader" align="center">Czytelnik:<br>'.$this->showReaderLight($rowBorrow['borrow_reader_id']).'</div>';
        $borrow = $borrow.'<div id="book" align="center">Książka:<br>'.$this->showBookLight($rowBorrow['borrow_book_id']).'</div>';
        return $borrow;
    }    
    public function showAllUsers() {
        return '<p><div id="search" align="center"><table><tr>'
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
    public function showAllBorrows(){
        return '<p><div id="search" align="center"><table><tr>'
                . '<td><input placeholder="ID" style="width: 60%;" type="text" id="id"></td>'
                . '<td><input placeholder="ID książki" style="width: 60%;" type="text" id="id_book"></td>'
                . '<td><input placeholder="ID czytelnika" style="width: 60%;" type="text" id="id_reader"></td>'
                . '<td><input placeholder="Data wypożyczenia" style="width: 60%;" type="text" id="date_borrow"></td>'
                . '<td><input placeholder="Data zwrotu" style="width: 60%;" type="text" id="date_return"></td>'
                . '</tr></table></div>'.templateTable($this->controller, array('ID','ID książki','ID czytelnika', 'Data wypożyczenia', 'Odebrano?', 'Data zwrotu'),
                                    array('borrow_id','borrow_book_id','borrow_reader_id', 'borrow_date_borrow', 'borrow_received', 'borrow_return'),
                                    "borrows", "borrowsTable", backToFuture().'Library/AdminAction/borrow.php?id');
    }
    public function showAllBooks() {
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
                . '<td><input placeholder="Ilość egzemlarzy" style="width: 60%;" type="text" id="number"></td>' 
                . '</tr></table></div>';
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "books",
                    array("*"),
                    array(array("publisher_houses","publisher_houses.publisher_house_id","books.book_publisher_house_id")));
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
				$books = $books.'<tr onClick="location.href=\'https://torus.uck.pk.edu.pl/~dslusarz/Library/UserAction/book.php?book='.$row['book_id'].'\'" /> '
                                                    . '<td>'.$row['book_id'].'</td> '
                                                    . '<td>'.$row['book_isbn'].'</td> '
                                                    . '<td>'.$row['book_title'].'</td> '
                                                    . '<td>'.$this->controller->authorsToString($resultAuthors).'</td> '
                                                    . '<td>'.$row['publisher_house_name'].'</td>'
                                                    . ' <td>'.$row['book_nr_page'].'</td>'
                                                    . ' <td>'.$row['book_edition'].'</td> '
                                                    . '<td>'.$row['book_premiere'].'</td>'
                                                    . ' <td>'.$row['book_number'].'</td>'
                                                . ' </tr>';
			}
			$books = $books.'</table><p><a href="'.backToFuture().'Library/AdminAction/Add/add_book.php">Dodaj</a></p></div>';
		}     
                $this->controller->close();
            return $books; 
        }
    public function showAllAdmins(){
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
                            array($name, $surname, $login, Codepass($password1), $email, $rowAR['acces_right_id']));
                $this->controller->close();
                return "<p>Dodano admina</p>";
            }
        }
    public function editAdmin($id, $name, $surname, $email, $login){
        $this->controller->connect();
        $this->controller->updateTableRecordValuesWhere(false,"admins",
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
    public function addBook($isbn, $original_title, $title, $original_punblisher_house, $original_country,  $publisher_house, $country, $nr_page, $edition, $premiere, $number, $cover, $author, $translator) {
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
                empty($cover) ||  
		empty($author)){
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
		$author = $this->controller->clear($author);
		$original_punblisher_house = $this->controller->clear($original_punblisher_house);
		$cover = $this->controller->clear($cover);
		$original_title = $this->controller->clear($original_title);
                $country = $this->controller->clear($country);
                $original_country = $this->controller->clear($original_country);
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
                
                $this->addAuthors($author, $rowB[0]);
                if(!empty($translator)){
                    $this->addTranslators($translator, $rowB[0]);
                }
                $this->controller->close();
		return '<p>Dodano ksiażke.</p>';
            }
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
                    $this->controller->insertTableRecordValue(true,"readers", 
                            array("reader_name", "reader_surname", "reader_login", "reader_password", "reader_email", "reader_address_id", "reader_active_account", "reader_acces_right_id"),
                            array($name, $surname, $login, Codepass($password1), $email, $this->addAddress($country, $city,$post_code ,$street, $nr_house),  date_format($date,"y-m-d"), $rowAR['acces_right_id']));
                    $this->controller->close();
                    return '<p>Czytelnik Został poprawnie zarejestrowany! Możesz się teraz wrócić na <a href="'.backToFuture().'Library/index.php">stronę główną</a>.</p>';
		}
	}
    public function editReader($id, $login, $email, $name, $surname, $address) {
        $this->controller->connect();
        $this->controller->updateTableRecordValuesWhere(false,"readers",
                        array(
                            array("reader_login",$this->controller->clear($login)),
                            array("reader_email",$this->controller->clear($email)),
                            array("reader_name",$this->controller->clear($name)),
                            array("reader_surname",$this->controller->clear($surname)),
                            array("reader_address",$this->controller->clear($address))
                            ),
                        array(array("reader_id","=",$this->controller->clear($id),"")));
        $this->controller->close();
        return "<p>Edytowano czytelnika</p>";
    }
    public function deleteNews($id){
        $this->controller->connect();
        $id = $this->controller->clear($id);
        $this->controller->deleteTableWhere(false,"news", array(array("new_id","=",$id,"")));
        $this->controller->close();
    }    
    public function getData($ID){
        $this->controller->connect();
        $ID = $this->controller->clear($ID);
        $data = $this->controller->getAdminData($ID);
        $this->controller->close();
	return $data;
    }
    public function search($isbn, $title, $publisher_house, $edition, $premiere, $author){
            $books = "";
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
            $this->controller->connect();
            $isbn = $this->controller->clear($isbn);
            $title = $this->controller->clear($title);
            $publisher_house = $this->controller->clear($publisher_house);
            $edition = $this->controller->clear($edition);
            $premiere = $this->controller->clear($premiere);
            $author =  $this->controller->clear($author);
            
            $resultBook = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "full_books", 
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
                        ID: '.$rowB['book_id'].'<br>
                        ISBN: '.$rowB['book_isbn'].'<br>
                        Autor: '.$this->controller->authorsToString($resultA).'<br>
                        Tytuł: '.$rowB['book_title'].'<br>
                        Wydawca: '.$rowB['publisher_house_name'].'<br>
                        Ilość stron: '.$rowB['book_nr_page'].'<br>
                        Wydanie: '.$rowB['book_edition'].'<br>
                        Rok wydania: '.$rowB['book_premiere'].'<br>
                        Ilość sztuk: '.$rowB['book_number'].'<br>
                        <a href="'.backToFuture().'Library/UserAction/book.php?book='.$rowB['book_id'].'">Przejdź do książki</a>
                        </p>';
                    }
                }
            }
            $this->controller->close();
            return $books;
    }
    public function showBook($bookID, $active = "disabled") {
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
            $resultFreeBook = $this->controller->selectTableWhatJoinWhereGroupOrderLimit(false, "free_books", 
                        array("*"),
                        null,
                        array(
                              array("book_id","=", $bookID, " ")
                              ));
            $rowFreeBook = mysqli_fetch_assoc($resultFreeBook);
            if($rowFreeBook['free_books'] == null){
                $freeBook = $row['book_number'];
            }
            else{
                $freeBook = $rowFreeBook['free_books'];
            }
            $this->controller->close();
            return '<p>
					ID: '.$row['book_id'].'<br>
					ISBN: '.$row['book_isbn'].'<br>
                                        Oryginalny tytuł: '.$row['book_original_title'].'<br>
					Tytuł: '.$row['book_title'].'<br>
					Autorzy: '.$this->controller->authorsToString($resultAuthors).'<br>
                                        Tłumacze: '.$this->controller->translatorsToString($resultTranslators).'<br>
                                        Oryginalne wydawnictwo: '.$row['original_publisher_house_name'].'<br>
                                        Wydawnictwo: '.$row['publisher_house_name'].'<br>
					Premiera: '.$row['book_premiere'].'<br>
					Wydanie: '.$row['book_edition'].'<br>
					Ilość stron: '.$row['book_nr_page'].'<br>
                                        Okładka: '.$row['book_cover'].'<br>
                                        Ilość wszsytkich egzemplarzy: '.$row['book_number'].'<br>
					Ilość dostępnych egzemplarzy: '.$freeBook.'<br>
                                        <button id="editBook">Edytuj</button>
                                        <button id="deleteBook">Usuń</button>
				</p>';
        }
    public function editBook($id,$isbn, $title, $publisher_house, $nr_page, $edition, $premiere, $number, $author){
        $this->controller->connect();
        $row = $this->addPublisherHouseAndReturnOrReturnExisted($this->controller->clear($publisher_house));
        $this->controller->deleteTableWhere(false,"authors_books", array(array("book_id","=",$id,"")));
        $this->addAuthorsIfDontExist($author, $id);
        $this->controller->updateTableRecordValuesWhere(false,"books",
                        array(
                            array("book_isbn",$this->controller->clear($isbn)),
                            array("book_title",$this->controller->clear($title)),
                            array("book_nr_page",$this->controller->clear($nr_page)),
                            array("book_edition",$this->controller->clear($edition)),
                            array("book_premiere",$this->controller->clear($premiere)),
                            array("book_publisher_house_id",$row[0]),
                            array("book_number",$this->controller->clear($number))
                            ),
                        array(array("book_id","=",$this->controller->clear($id),"")));
        $this->controller->close();
        return "<p>Edytowano książke</p>";
    }
    public function showEditBook($bookID){
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
        $this->controller->close();
        return '<div align="center">Edytowanie książki '.$row['book_id'].'
                                <form action="'.backToFuture().'Library/AdminAction/Edit/edit_book.php?id='.$row['book_id'].'" method="post">
					ISBN: <input type="text" id="isbn" name="isbn" value="'.$row['book_isbn'].'"/><br>
					Tytuł: <input type="text" id="title" name="title" value="'.$row['book_title'].'"/><br>
					Autorzy: <input type="text" id="authors" name="authors" value="'.$this->controller->authorsToString($resultAuthors).'"/><br>
					Wydawnictwo: <input type="text" id="publisher_house" name="publisher_house" value="'.$row['publisher_house_name'].'"/><br>
					Premiera: <input type="text" id="premiere" name="premiere"" value="'.$row['book_premiere'].'"/><br>
					Wydanie: <input type="text" id="edition" name="edition" value="'.$row['book_edition'].'"/><br>
					Ilość stron: <input type="text" id="nr_page" name="nr_page" value="'.$row['book_nr_page'].'"/><br>
                                        Ilość wszsytkich egzemplarzy: <input type="text" id="number" name="number" value="'.$row['book_number'].'"/><br>
                                        <input type="hidden" id="edit" name="edit" value="'.$row['book_id'].'"/>
                                        <input type="submit" id="submit" value="Zapisz zmiany"/>
                                </form>
                            </div>';
    }

}
?>