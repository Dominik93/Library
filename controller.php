<?php
include "database.php";

class Controller{

	private $mysql;

	public function __construct(){
		$this->mysql = new Mysql('localhost', 'root', '', 'dslusarz_baza');
	}
	
	public function clear($text){
		if(get_magic_quotes_gpc()) {
			$text = stripslashes($text);
		}
		$text = trim($text);
		$text = mysql_real_escape_string($text);
		$text = htmlspecialchars($text);
		return $text;
	}
	/*
         * add function
         */
	public function addReader($name, $surname, $login, $password, $email, $adres, $right){
		$this->mysql->Connect();
		mysqli_query($this->mysql->baseLink, 'INSERT INTO readers 
					(reader_name, reader_surname,
					reader_login, reader_password,
					reader_email, reader_address,
					reader_active_account, reader_acces_right_id)
				VALUES ("'.$name.'", "'.$surname.'",
				"'.$login.'", "'.Codepass($password).'",
				"'.$email.'", "'.$adres.'", 
				"'.date('Y-m-d').'", '.$right.');');
		$this->mysql->Close();		
	}
	
	public function addAdmin($name, $surname, $login, $password, $email, $right){
		$this->mysql->Connect();
		mysqli_query($this->mysql->baseLink, 'INSERT INTO admins 
				(admin_name, admin_surname,
				admin_login, admin_password,
				admin_email, admin_acces_right_id)
				VALUES ("'.$name.'", "'.$surname.'",
				"'.$login.'", "'.Codepass($password).'",
				"'.$email.'", '.$right.');');
	}

	public function addBook($isbn, $title, $publisherHouse, $nrPage, $edtiotion, $premiere, $number){
		$this->mysql->Connect();
		mysqli_query($this->mysql->baseLink, 'INSERT INTO books
									(`book_isbn`,
									`book_title`,
									`book_publisher_house_id`,
									`book_nr_page`,
									`book_edition`,
									`book_premiere`,
									`book_number`)
									VALUES
									("'.$isbn.'",
									"'.$title.'",
									"'.$publisherHouse.'",
									"'.$nrPage.'",
									"'.$edtiotion.'",
									"'.$premiere.'",
									"'.$number.'");
								');
		$this->mysql->Close();						
	}
	
	public function addPublisherHouse($publisherHouse){
		$this->mysql->Connect();
		mysqli_query($this->mysql->baseLink, 'INSERT INTO publisher_houses (publisher_houses.publisher_house_name) VALUES("'.$publisherHouse.'");');
		$this->mysql->Close();
	}
	
	public function addAuthor($name, $surname){
		$this->mysql->Connect();
		mysqli_query($this->mysql->baseLink, 'INSERT INTO authors (authors.author_name, authors.author_surname) VALUES("'.$name.'", "'.$surname.'");');
		$this->mysql->Close();
	}
	
        public function addConnectionBetwenAuthorAndBook($authorId,$bookId){
            $this->mysql->Connect();
            mysqli_query($this->mysql->baseLink, 
                    'INSERT INTO `dslusarz_baza`.`authors_books`
						(`author_id`,
						`book_id`)
						VALUES
						('.$authorId.',
						'.$bookId.');
						') or die(mysqli_error($this->mysql->baseLink));
            $this->mysql->Close();
        }
        
	public function addBorrow($book, $user, $date){
		$this->mysql->Connect();
		$dateReturn = date_create(date('Y-m-d'));
		date_add($dateReturn, date_interval_create_from_date_string('365 days'));
		mysqli_query($this->mysql->baseLink, 'INSERT INTO borrows 
										(
										borrow_book_id, borrow_reader_id,
										borrow_date_borrow, borrow_return
										) 
										VALUES(
										'.$book.',
										'.$user.',
										"'.$date.'",
										"'.date_format($dateReturn, 'Y-m-d').'");');
		$this->mysql->Close();
	}
	
	public function addNew($title, $text, $czas){
		$this->mysql->Connect();
		mysqli_query($this->mysql->baseLink, 'INSERT INTO news
							(new_title,
							new_text,
							new_date)
							VALUES
							("'.$title.'",
							"'.$text.'",
							"'.$czas.'");');
		$this->mysql->Close();
	}
        
        public function addSession($sessionID, $sessionIP, $sesssionUser){
		$this->mysql->Connect();
		mysqli_query($this->mysql->baseLink, 'INSERT INTO sessions
											(`session_id`,
											`session_ip`,
											`session_user`,
											`session_logged`,
											`session_acces_right`)
											VALUES 
											("'.$sessionID.'",
											"'.$sessionIP.'",
											'.$sesssionUser.',
											"0",
											"none")');
		$this->mysql->Close();
	}
	/*
         * delete function
         */
	public function deleteReader($readerId){
		$this->mysql->Connect();
		mysqli_query($this->mysql->baseLink, 'DELETE FROM readers WHERE readers.reader_id = '.$readerId.';') or die(mysqli_error($this->mysql->baseLink));
		$this->mysql->Close();
	}
	
	public function deleteFromTable($table, $record, $id){
		$this->mysql->Connect();
		mysqli_query($this->mysql->baseLink, 'DELETE FROM '.$table.' WHERE '.$record.' = '.$id.';') or die(mysqli_error($this->mysql->baseLink));
		$this->mysql->Close();
	}
	
	public function deleteAdmin($adminId){
		$this->mysql->Connect();
		mysqli_query($this->mysql->baseLink, 'DELETE FROM admins where admins.admin_id = '.$adminId.';') or die(mysqli_error());
		$this->mysql->Close();
	}
	/*
         * update function
         */
	public function updateSession($id, $logged, $acces_right, $session_id){
		$this->mysql->Connect();
		mysqli_query($this->mysql->baseLink,
		'UPDATE sessions SET
		session_user = '.$id.',
		session_logged = '. $logged.',
		session_acces_right = "'.$acces_right.'"
		where session_id = "'.$session_id.'";')
		or die(mysqli_error($this->mysql->baseLink));
		$this->mysql->Close();
	}
	
        public function updateSessionAction(){
            $this->mysql->Connect();
            mysqli_query($this->mysql->baseLink,
		'UPDATE sessions SET
		session_last_action = \''.date('Y-m-d H:i:s').'\';')
            or die(mysqli_error($this->mysql->baseLink));
            $this->mysql->Close();
        }
        
	public function updateReader($readerId, $data){
		$this->mysql->Connect();
		mysqli_query($this->mysql->baseLink, 'UPDATE readers SET 
					reader_active_account = "'.$data.'"
					where reader_id = '.$readerId.';');
		$this->mysql->Close();
	}
	/*
         * get function
         */
	public function getReaderData($reader_id = -1){
		$this->mysql->Connect();
		if($reader_id == -1) {
			$reader_id = $_SESSION['user_id'];
		}
		$result = mysqli_query($this->mysql->baseLink,
			'SELECT readers.*, acces_rights.acces_right_name FROM readers
			join acces_rights on acces_rights.acces_right_id = readers.reader_acces_right_id
			WHERE reader_id = "'.$reader_id.'" LIMIT 1;')
		or die(mysqli_error($this->mysql->baseLink));
		$this->mysql->Close();
		if(!$result){
			return false;
		}
		return mysqli_fetch_assoc($result);
	}
	
	public function getAdminData($admin_id = -1){
		$this->mysql->Connect();
		if($admin_id == -1) {
			$admin_id = $_SESSION['user_id'];
		}
		$result = mysqli_query($this->mysql->baseLink, 'SELECT admins.*, acces_rights.acces_right_name FROM admins
			join acces_rights on acces_rights.acces_right_id = admins.admin_acces_right_id
			WHERE admin_id = "'.$admin_id.'" LIMIT 1;') or die(mysqli_error($this->mysql->baseLink));
		$this->mysql->Close();
		if(!$result){
			return false;
		}
		return mysqli_fetch_assoc($result);
	}
	/*
         * select function
         */
	public function selectBooks(){
		$this->mysql->Connect();
		$result = mysqli_query($this->mysql->baseLink, 'SELECT books.*, publisher_houses.publisher_house_name FROM books join publisher_houses on publisher_houses.publisher_house_id = books.book_publisher_house_id;')or die(mysqli_error($this->mysql->baseLink));
		$this->mysql->Close();
		return $result;
	}
	
        public function selectSearchedBook($isbn, $title, $publisher_house, $edition, $author){
                $this->mysql->Connect();
		$result = mysqli_query($this->mysql->baseLink,
                        'SELECT books.*, publisher_houses.publisher_house_name, authors.* FROM books 
								JOIN publisher_houses ON publisher_houses.publisher_house_id = books.book_publisher_house_id
								JOIN authors_books ON authors_books.book_id = books.book_id
								JOIN authors ON authors_books.author_id = authors.author_id
								WHERE 
								(books.book_isbn LIKE \''.$isbn.'\') AND
								(books.book_title LIKE \''.$title.'\') AND
								(publisher_houses.publisher_house_name LIKE \''.$publisher_house.'\') AND
								(books.book_edition LIKE \''.$edition.'\') AND
								(authors.author_name LIKE \''.$author.'\' OR authors.author_surname LIKE \''.$author.'\' )
								GROUP BY books.book_id;
								')
                        or die(mysqli_error($this->mysql->baseLink));
		$this->mysql->Close();
		return $result;
            
        }
        
	public function selectAuthors($bookId){
		$this->mysql->Connect();
		$result = mysqli_query($this->mysql->baseLink, 'SELECT authors.* from authors join authors_books on authors_books.author_id = authors.author_id join books on books.book_id = authors_books.book_id where books.book_id = '.$bookId.';')or die(mysqli_error($this->mysql->baseLink));
		$this->mysql->Close();
		return $result;
	}
	
	public function selectReaders(){
		$this->mysql->Connect();
		$result = mysqli_query($this->mysql->baseLink, 'SELECT *, acces_rights.acces_right_name FROM readers join acces_rights on acces_rights.acces_right_id = readers.reader_acces_right_id ;')or die(mysqli_error($this->mysql->baseLink));
		$this->mysql->Close();
		return $result;
	}
	
	public function selectAdmins(){
		$this->mysql->Connect();
		$result = mysqli_query($this->mysql->baseLink, 'SELECT *, acces_rights.acces_right_name FROM admins join acces_rights on acces_rights.acces_right_id = admins.admin_acces_right_id ;')or die(mysqli_error($this->mysql->baseLink));
		$this->mysql->Close();
		return $result;
	}
	
	public function selectAccessRights(){
		$this->mysql->Connect();
		$result = mysqli_query($this->mysql->baseLink,
		'SELECT * FROM acces_rights WHERE acces_right_name = "activeReader";')
		or die(mysqli_error($this->mysql->baseLink));
		$this->mysql->Close();
		return $result;
	}
	
	public function selectExistingUser($from, $record, $login, $email){
		$this->mysql->Connect();
		$result = mysqli_query($this->mysql->baseLink,
		'SELECT Count('.$record.'_id) FROM '.$from.'
		WHERE '.$record.'_login = "'.$login.'" OR '.$record.'_email = "'.$email.'";')
		or die(mysqli_error($this->mysql->baseLink));
		$this->mysql->Close();
		return $result;
	}
	
	public function selectNews($limit = 10){
		$this->mysql->Connect();
		$result = mysqli_query($this->mysql->baseLink, 'SELECT * FROM news LIMIT '.$limit.';')or die(mysqli_error($this->mysql->baseLink));
		$this->mysql->Close();
		return $result;
	}
	
	public function selectReaderLogin($login){
		$this->mysql->Connect();
		$result = mysqli_query($this->mysql->baseLink, 'SELECT readers.reader_login FROM readers WHERE reader_login = "'.$login.'";')or die(mysqli_error($this->mysql->baseLink));
		$this->mysql->Close();
		return $result;
	}
	
	public function selectAdminLogin($login){
		$this->mysql->Connect();
		$result = mysqli_query($this->mysql->baseLink, 'SELECT admins.admin_login FROM admins WHERE admin_login = "'.$login.'";')or die(mysqli_error($this->mysql->baseLink));
		$this->mysql->Close();
		return $result;
	}
	
	public function selectReaderEmail($email){
		$this->mysql->Connect();
		$result = mysqli_query($this->mysql->baseLink, 'SELECT readers.reader_email FROM readers WHERE reader_email = "'.$email.'";')or die(mysqli_error($this->mysql->baseLink));
		$this->mysql->Close();
		return $result;
	}
	
	public function selectAdminEmail($email){
		$this->mysql->Connect();
		$result = mysqli_query($this->mysql->baseLink, 'SELECT admins.admin_email FROM admins WHERE admin_email = "'.$email.'";')or die(mysqli_error($this->mysql->baseLink));
		$this->mysql->Close();
		return $result;
	}
	
        public function selectPublisherHouse($publisher_house){
            $this->mysql->Connect();
            $result = mysqli_query($this->mysql->baseLink, 
                    'SELECT * FROM publisher_houses WHERE publisher_houses.publisher_house_name = "'.$publisher_house.'";')
                    or die(mysqli_error($this->mysql->baseLink));
            $this->mysql->Close();
            return $result;
        }
        
        public function selectBook($isbn){
            $this->mysql->Connect();
            $result = mysqli_query($this->mysql->baseLink, 
                    'SELECT * FROM books WHERE books.book_isbn = "'.$isbn.'";')
                    or die(mysqli_error($this->mysql->baseLink));
            $this->mysql->Close();
            return $result;
        }
        
        public function selectAuthor($name, $surname){
            $this->mysql->Connect();
            $result = mysqli_query($this->mysql->baseLink, 
                    'SELECT * FROM authors WHERE authors.author_name = "'.$name.'" and authors.author_surname = "'.$surname.'";')
                    or die(mysqli_error($this->mysql->baseLink));
            $this->mysql->Close();
            return $result;
        }
        
	public function selectSession(){
		$this->mysql->Connect();
		$result = mysqli_query($this->mysql->baseLink, 'SELECT * FROM sessions;')or die(mysqli_error($this->mysql->baseLink));
		$this->mysql->Close();
		return $result;
	}
	
	public function validationLoginAdmin($login, $password){
		$this->mysql->Connect();
		$result = mysqli_query($this->mysql->baseLink,
		'SELECT admin_id FROM admins WHERE admin_login = "'.$login.'" AND admin_password = "'.Codepass($password).'" LIMIT 1;')
		or die(mysqli_error($this->mysql->baseLink));
		$this->mysql->Close();
		return $result;
	}
	
	public function validationLoginReader($login, $password){
		$this->mysql->Connect();
		$result = mysqli_query($this->mysql->baseLink,
		'SELECT reader_id FROM readers WHERE reader_login = "'.$login.'" AND reader_password = "'.Codepass($password).'" LIMIT 1;')
		or die(mysqli_error($this->mysql->baseLink));
		$this->mysql->Close();
		return $result;
	}
	
}

?>