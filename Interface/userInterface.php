<?php

interface IUser{
    
    public function showMainPage();
    public function showHours();
    public function showSearch();
    public function showAdvancedSearch();
    public function showContact();
    public function showRegulation();
    public function showOptionPanel();
    public function showNews();
    
    public function search($isbn, $title, $publisher_house, $edition, $premiere, $authorName, $authorSurname);
    public function advancedSearch($isbn, $original_title, $title, $original_punblisher_house, $original_country, $publisher_house, $country, $nr_page, $edition, $premiere, $cover, $authorName, $authorSurname, $translatorName, $translatorSurname);
    
    public function logout();
    public function login($login, $password);
    
    public function session();
    public function checkSession();
    public function timeOut();
            
    public function showAccount(); 
    public function extendAccount($id);
    
    public function showLoginForm();
    public function showAddBookForm();  
    public function showAddNewsForm();
    public function showAddReaderForm();
    public function showAddAdminForm();
    public function showChangePassForm();
    
    public function showAllReaders($id, $login, $email, $name, $surname);
    public function showAllAdmins($id, $login, $email, $name, $surname);
    public function showAllBorrows($id, $bookId, $readerId, $dateBorrow, $dateReturn);
    public function showAllBooks($id, $isbn, $title, $publisher_house, $premiere, $edition);
    public function showAllLogged(); 
    
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
    public function deleteReader($id);
    
    public function addBook($isbn, $original_title, $title, $original_punblisher_house, $original_country, $publisher_house, $country, $nr_page, $edition, $premiere, $number, $cover, $authorName, $authorSurname, $translatorName, $translatorSurname);
    public function editBook($id, $isbn, $original_title, $title, $original_punblisher_house, $original_country, $publisher_house, $country, $nr_page, $edition, $premiere, $number, $cover, $authorName, $authorSurname, $translatorName, $translatorSurname);
    public function deleteBook($id);
    
    public function addAdmin($name, $surname, $password1, $password2, $email, $login);
    public function editAdmin($id, $name, $surname, $email, $login);
    public function deleteAdmin($id);
    
    public function addNews($title, $text);
    public function deleteNews($id);
   
    public function addBorrow($bookID);
    public function deleteBorrow($id);
    public function receiveBorrow($id);
    
    public function isActive($ID);
    
    public function getData($ID);
    
    public function changePass($oldPass, $newPass);
    public function generateNewPas($id);
    
}
?>