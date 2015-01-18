<?php

interface IUser{
    /*
     * user
     */
    public function showMainPage();
    public function showHours();
    public function showSearch();
    public function showContact();
    public function showRegulation();
    public function showLogin();
    public function logout();
    public function login($login, $password);
    public function session();
    public function search($isbn, $title, $publisher_house, $edition, $premiere, $author);
    public function checkSession();
    /*
     * admin and reader
     */
    public function showOptionPanel();
    public function showNews();
    public function showAccount(); 
    public function showLogged();  
    public function showAddBookForm();  
    public function showAddNewsForm();
    public function showRegistrationReader();
    public function showRegistrationAdmin();
    public function showAllUsers();
    public function showAllAdmins();
    public function showAllBorrows();
    public function showAllBooks();
    public function showAdmin($adminID);
    public function showEditAdmin($readerID);
    public function showReader($readerID);
    public function showReaderLight($readerID);
    public function showEditReader($readerID);
    public function showBook($bookID);
    public function showEditBook($bookID);
    public function showBookLight($bookID);
    public function showBorrow($borrowID);
    public function showMyBorrows();
    public function addReader($login, $email, $name, $surname, $password1, $password2, $country, $city, $street, $post_code, $nr_house);
    public function editReader($id, $login, $email, $name, $surname, $country, $city, $street, $post_code, $nr_house);
    public function addBook($isbn, $original_title, $title, $original_punblisher_house, $original_country,  $publisher_house, $country, $nr_page, $edition, $premiere, $number, $cover, $author, $translator);
    public function editBook($id,$isbn, $title, $publisher_house, $nr_page, $edition, $premiere, $number, $author);
    public function addAdmin($name, $surname, $password1, $password2, $email, $login);
    public function editAdmin($id, $name, $surname, $email, $login);
    public function addNews($title, $text);
    public function deleteNews($id);
    public function orderBook($bookID);
    public function isActive($ID);
    public function getData($ID);
    public function changePassForm();
    public function changePass($oldPass, $newPass);
    public function deleteBorrow($id);
    public function deleteReader($id);
    public function deleteBook($id);
    public function deleteAdmin($id);
    public function generateNewPas();
    public function extendAccount($id);
    public function receiveBook($id);
    
    
    }
?>