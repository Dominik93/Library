<?php
// łączenie się z bazą danych
include 'config.php';
$user = unserialize($_SESSION['user']);
$controller = new Controller();
$controller->connect();

if(isset($_POST['orderBook'])){
    echo $user->addBorrow($_POST['orderBook']);
}

if(isset($_POST['book'])){
    echo $user->showAllBooks($_POST);
}

if(isset($_POST['borrows'])){
    echo $user->showAllBorrows($_POST);
}

if (isset($_POST['reader'])){
    echo  $user->showAllReaders($_POST);
}

if (isset($_POST['admin'])){
    echo  $user->showAlladmins($_POST);
}

if(isset($_POST['deleteBorrow'])){
    echo $user->deleteBorrow($_POST['deleteBorrow']);
}

if(isset($_POST['deleteReader'])){
    echo $user->deleteReader($_POST['deleteReader']);
}

if(isset($_POST['deleteBook'])){
    echo $user->deleteBook($_POST['deleteBook']);
}

if(isset($_POST['deleteAdmin'])){
    echo $user->deleteAdmin($_POST['deleteAdmin']);
}

if(isset($_POST['newPassword'])){
    echo $user->generateNewPas($_POST['newPassword']);
}

if(isset($_POST['extendAccount'])){
    echo $user->extendAccount($_POST['extendAccount']);
}

if(isset($_POST['receiveBorrow'])){
    echo $user->receiveBorrow($_POST['receiveBorrow']);
}

if(isset($_POST['checkLogin'])){
	$login = $_POST['checkLogin'];
	$login = $controller->clear($login);
	$dostepny = true;
	$result = $controller->selectTableWhatJoinWhereGroupOrderLimit(false, "readers", null, null,
                array(array("reader_login","=",$login,"")));
	
	if(mysqli_num_rows($result)){
		$dostepny = false;
	}
	$result = $controller->selectTableWhatJoinWhereGroupOrderLimit(false, "admins", null, null,
                array(array("admin_login","=",$login,"")));
	if(mysqli_num_rows($result)){
		$dostepny = false;
	}
        
	if(!$dostepny){
		echo 'Niedostępny';
	}else{
		echo 'OK';
	}
}

if(isset($_POST['checkEmail'])){
	$email = $_POST['checkEmail'];
	$email = $controller->clear($email);
	$dostepny = true;
	$poprawny = true;
	if (filter_var($email, FILTER_VALIDATE_EMAIL) == false){
		$poprawny = false;
	}
	$result = $controller->selectTableWhatJoinWhereGroupOrderLimit(false, "readers", null, null,
                array(array("reader_email","=",$email,"")));
	if(mysqli_num_rows($result) > 0){
		$dostepny = false;
	}
	$result = $controller->selectTableWhatJoinWhereGroupOrderLimit(false, "admins", null, null,
                array(array("admin_email","=",$email,"")));
	if(mysqli_num_rows($result) > 0){
		$dostepny = false;
	}
        
	if(!$poprawny){
		echo 'Niepoprawny';
	}else if(!$dostepny){
		echo 'Niedostepny';
	}else{
		echo 'OK';
	}
   
$controller->close();        
}
?>