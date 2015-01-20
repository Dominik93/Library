<?php

function backToFuture(){
    if($_SERVER['REMOTE_ADDR'] == "::1" || $_SERVER['REMOTE_ADDR'] == "127.0.0.1"){
        $future= "";
        $pathExplode = explode("\\", getcwd());
        $i = count($pathExplode) - 1;
        while($pathExplode[$i] != "dominik"){
            array_pop($pathExplode);
            $future.="../";
            $i--;
        }
    }
    else{
        $future= "";
        $pathExplode = explode("/", getcwd());
        $i = count($pathExplode) - 1;
        while($pathExplode[$i] != "public_html"){
            array_pop($pathExplode);
            $future.="../";
            $i--;
        }
    }
    return $future;
}

include backToFuture()."Library/Layout/layout.php";
include backToFuture()."Library/Classes/Controller.php";
include backToFuture()."Library/Classes/Admin.php";
include backToFuture()."Library/Classes/Reader.php";


function CreateOwner(){
	$controller = new Controller();
        $controller->connect();
	$result = $controller->selectTableWhatJoinWhereGroupOrderLimit(false, "admins", array("admin_login"),null,array(array("admin_login","=","dslusarz","")));
	if(mysqli_num_rows($result) == 0){
            $result = $controller->selectTableWhatJoinWhereGroupOrderLimit(false, "acces_rights",null,null,array(array("acces_right_name", "=", "admin","")));

            if(mysqli_num_rows($result) == 0) {
                die('Błąd');
            }
            $row = mysqli_fetch_assoc($result);
            $result = $controller->selectTableWhatJoinWhereGroupOrderLimit(false, "admins",null,null,
                    array(array("login", "=", "dslusarz","")));
            if(mysqli_num_rows($result) < 0){
            $controller->insertTableRecordValue(false,"admins",
                    array("admin_login", "admin_password", "admin_email", "admin_name", "admin_surname", "admin_acces_right_id"),
                    array("dslusarz", $controller->codepass('wiosna'), "slusarz.dominik@gmail.com", "Dominik", "Ślusarz", $row['acces_right_id']));
            }
        }
        $controller->close();
}

function templateTable($controller, $array, $arrayTable, $table, $tableStyle, $link = null, $what = null, $join = null, $where = null){
            $controller->connect();
            $result = $controller->selectTableWhatJoinWhereGroupOrderLimit(false, $table, $what, $join, $where);
            $return = "";
            $return .= '<div id="'.$tableStyle.'" align="center">
                            <table>';
            $return = $return.'<tr>';
            foreach ($array as $s){
                $return = $return.'<td>'.$s.'</td>';
            }
            $return = $return.'</tr>';
            if(mysqli_num_rows($result) == 0) {
		return $return."</table></div>";
            }
            while($row = mysqli_fetch_array($result)) {
                if($link == null){
                   $return = $return.'<tr>';
                }
                else{
                    $return = $return.'<tr onClick="location.href=\'https://torus.uck.pk.edu.pl/~dslusarz/Library/AdminAction/'.$link.'='.$controller->clear($row[0]).'\'">';
                }
		for($i = 0; $i< count($array); $i++){
                    $return = $return.'<td>'.$controller->clear($row[$arrayTable[$i]]).'</td>';
                }
                $return = $return.'<tr>';
            }
            $return = $return.'</table></div>';
            $controller->close();
            return $return;
        }
session_start();
date_default_timezone_set("Europe/Warsaw");
CreateOwner();
if(!isset($_SESSION['logged'])) {
    $controller = new Controller();
    $controller->connect();
    do{
        $result = $controller->selectTableWhatJoinWhereGroupOrderLimit(false, "sessions",null,null,array(array("session_id","=",  session_regenerate_id(),"")));
    }while(mysqli_num_rows($result) > 0);
	$_SESSION['id'] = session_id();
        $_SESSION['logged'] = false;
        $_SESSION['user_id'] = -1;
	$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
	$_SESSION['acces_right'] = "user";
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
	$_SESSION['user'] = serialize(new User(new Controller()));
    $controller->close();
}

?>