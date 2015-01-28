<?php

interface IUser{
    
    public function showAjaxBooksSearch();
    public function showAjaxBoorowsSearch();
    public function showAjaxAdminSearch();
    
    public function showMainPage();
    public function showHours();
    public function showSearch();
    public function showAdvancedSearch();
    public function showContact();
    public function showRegulation();
    public function showOptionPanel();
    public function showNews();
    
    public function search($search);
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
    
    public function showAllReaders($array);
    public function showAllAdmins($array);
    public function showAllBorrows($array);
    public function showAllBooks($array);
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
    
    public function addReader($array);
    public function editReader($array);
    public function deleteReader($id);
    
    public function addBook($isbn, $original_title, $title, $original_punblisher_house, $original_country, $publisher_house, $country, $nr_page, $edition, $premiere, $number, $cover, $authorName, $authorSurname, $translatorName, $translatorSurname, $path);
    public function editBook($id, $isbn, $original_title, $title, $original_punblisher_house, $original_country, $publisher_house, $country, $nr_page, $edition, $premiere, $number, $cover, $authorName, $authorSurname, $translatorName, $translatorSurname, $path);
    public function deleteBook($id);
    
    public function addAdmin($array);
    public function editAdmin($array);
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