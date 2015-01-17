<?php
include_once "Mysql.php";

class Controller{
    private $mysql;

    public function __construct(){
        if($_SERVER['REMOTE_ADDR'] == "::1" || $_SERVER['REMOTE_ADDR'] == "127.0.0.1")
            $this->mysql = new Mysql('localhost', 'root', '', 'dslusarz_baza');
        else
            $this->mysql = new Mysql('localhost', 'dslusarz', 'kasztan', 'dslusarz_baza');
    }
    
    public function connect(){
        $this->mysql->Connect();
    }
    
    public function close(){
        $this->mysql->Close();
    }
    
    public function doQuery($query){
        //echo $query;
        $result = mysqli_query($this->mysql->baseLink, $query) or die(mysqli_error($this->mysql->baseLink));
        return $result;
    }
    
    public function insertTableRecordValue($test, $table, $arrayRecord, $arrayValues){
        $query = 'INSERT INTO '.$table.' (';
        for($i = 0; $i < count($arrayRecord); $i++){
            $query = $query.$arrayRecord[$i].',';
        }
        $query = substr($query, 0 , strlen($query)-1).') VALUES (';
        for($i = 0; $i < count($arrayValues); $i++){
            $query = $query.'"'.$arrayValues[$i].'",';
        }
        $query = substr($query, 0 , strlen($query)-1).');';
        if($test)
        echo $query.'<br>';
        mysqli_query($this->mysql->baseLink, $query) or die(mysqli_error($this->mysql->baseLink));
    }    
    public function deleteTableWhere($test, $table, $arrayWhere){
        $query = 'DELETE FROM '.$table.' WHERE ';
        for($i = 0; $i< count($arrayWhere); $i++){
            $query = $query.' ('.$arrayWhere[$i][0].' '.$arrayWhere[$i][1].'"'.$arrayWhere[$i][2].'") '.$arrayWhere[$i][3];
        }
        $query = $query.';';
        if($test)
        echo $query.'<br>';
        mysqli_query($this->mysql->baseLink, $query) or die(mysqli_error($this->mysql->baseLink));
    }
    public function selectTableWhatJoinWhereGroupOrderLimit($test, $t, $arrayW = null, $arrayJ = null, $arrayWh = null, $groupBy = null, $orderBy = null, $limit = null){
        $query = 'SELECT ';
        if($arrayW != null){
            for($i = 0; $i< count($arrayW); $i++){
                $query = $query.' '.$arrayW[$i].',';
            }
            $query = substr($query,0, strlen($query)-1);
        }
        else{
            $query = $query.'*';
        }
        $query = $query.' FROM '.$t.' ';
        if($arrayJ != null){
            for($i = 0; $i< count($arrayJ); $i++){
                $query = $query.'JOIN '.$arrayJ[$i][0].' ON '.$arrayJ[$i][1].' = '.$arrayJ[$i][2].' ';
            }
        }
        if($arrayWh != null){
            $query = $query.' WHERE ';
            for($i = 0; $i< count($arrayWh); $i++){
                $query = $query.' ('.$arrayWh[$i][0].' '.$arrayWh[$i][1].' "'.$arrayWh[$i][2].'") '.$arrayWh[$i][3];
            }
        }
        if($groupBy != null){
            $query = $query.' GROUP BY '.$groupBy;
        }
        if($orderBy != null){
            $query = $query.' ORDER BY '.$orderBy;
        }
        if($limit != null){
            $query = $query.' LIMIT '.$limit;
        }
        $query = $query.';';
        if($test)
        echo $query.'<br>';
	$result = mysqli_query($this->mysql->baseLink, $query)
                or die(mysqli_error($this->mysql->baseLink));
	return $result;
        
    }
    public function updateTableRecordValuesWhere($test, $table, $arrayRecordValues, $arrayWh = null){
        $query = 'UPDATE '.$table.' SET ';
        for($i = 0; $i < count($arrayRecordValues); $i++){
            $query = $query.' '.$arrayRecordValues[$i][0].' = "'.$arrayRecordValues[$i][1].'",';
        }
        $query = substr($query, 0 , strlen($query)-1);
        if($arrayWh != null){
            $query = $query.' WHERE ';
            for($i = 0; $i< count($arrayWh); $i++){
                $query = $query.' ('.$arrayWh[$i][0].' '.$arrayWh[$i][1].' "'.$arrayWh[$i][2].'") '.$arrayWh[$i][3];
            }
        }
        $query = $query.';';
        if($test)
        echo $query.'<br>';
	mysqli_query($this->mysql->baseLink, $query) or die(mysqli_error($this->mysql->baseLink));
    }
    
    public function clear($text){
	if(get_magic_quotes_gpc()) {
            $text = stripslashes($text);
	}
	$text = trim($text);
	$text = mysqli_real_escape_string($this->mysql->baseLink,$text) or die(mysqli_error($this->mysql->baseLink));
	$text = htmlspecialchars($text);
	return $text;
    }
    public function validationLoginAdmin($login, $password){
	$query = 'SELECT admin_id FROM admins WHERE admin_login = "'.$login.'" AND admin_password = "'.Codepass($password).'" LIMIT 1;';
        $result = mysqli_query($this->mysql->baseLink, $query) or die(mysqli_error($this->mysql->baseLink));
	return $result;
	}
    public function validationLoginReader($login, $password){
        $query = 'SELECT reader_id FROM readers WHERE reader_login = "'.$login.'" AND reader_password = "'.Codepass($password).'" LIMIT 1;';
	$result = mysqli_query($this->mysql->baseLink, $query) or die(mysqli_error($this->mysql->baseLink));
	return $result;
	}
    public function getReaderData($reader_id = -1){
	if($reader_id == -1) {
            $reader_id = $_SESSION['user_id'];
	}
        $query = 'SELECT * FROM view_readers WHERE reader_id = "'.$reader_id.'" LIMIT 1;';
	$result = mysqli_query($this->mysql->baseLink, $query) or die(mysqli_error($this->mysql->baseLink));
	if(!$result){
            return false;
	}
	return mysqli_fetch_assoc($result);
    }
    public function getAdminData($admin_id = -1){
	if($admin_id == -1) {
            $admin_id = $_SESSION['user_id'];
	}
        $query = 'SELECT admins.*, acces_rights.acces_right_name FROM admins
		join acces_rights on acces_rights.acces_right_id = admins.admin_acces_right_id
		WHERE admin_id = "'.$admin_id.'" LIMIT 1;';
	$result = mysqli_query($this->mysql->baseLink, $query) or die(mysqli_error($this->mysql->baseLink));
	if(!$result){
		return false;
	}
	return mysqli_fetch_assoc($result);
    }
    public function userExist($from, $record, $login, $email){
        $query = 'SELECT Count('.$record.'_id) FROM '.$from.' WHERE '.$record.'_login = "'.$login.'" OR '.$record.'_email = "'.$email.'";';
	$result = mysqli_query($this->mysql->baseLink, $query) or die(mysqli_error($this->mysql->baseLink));
        $row = mysqli_fetch_row($result);
        if($row[0] > 0) {
            return true;
        }
	return false;
    }   
    public function authorsToString($resultAuthors){
        $autorzy = "";
	if(mysqli_num_rows($resultAuthors) == 0) {
            die('Brak autorów bład');
	}
        else{		
            while($rowA = mysqli_fetch_assoc($resultAuthors)) {
		$autorzy = $autorzy.''.$rowA['author_name'].' '.$rowA['author_surname'].', ';
            }
        }
        return substr($autorzy,0, strlen($autorzy)-2);
    }
    public function translatorsToString($resultTranslators){
        $transtalors = "";
	if(mysqli_num_rows($resultTranslators) == 0) {
            return "";
	}
        else{		
            while($rowT = mysqli_fetch_assoc($resultTranslators)) {
		$transtalors .= $rowT['translator_name'].' '.$rowT['translator_surname'].', ';
            }
        }
        return substr($transtalors,0, strlen($transtalors)-2);
    }
}

?>