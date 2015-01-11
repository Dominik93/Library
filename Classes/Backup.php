<?php
include "../config.php";
include_once backToFuture().'Library/Classes/Controller.php';
class Backup{
    
    private $controller;
    
    private $path;
    private $tables;
    private $views;
    /*
     * Konstruktor podanie scieżki w której będą zapisywane backupy, nazwy bazy, oraz użytkownika i hasła do bazy
     * autopatycznie przypisuje do obiektu wszytkie tabele w bazie
     */
    public function __construct($path, $dataBase, $userName, $password){
        $this->controller = new Controller();
        $this->path = $path;
        $this->tables = array("acces_rights", "admins", "authors",
            "authors_books", "books", "borrows",
            "news", "publisher_houses", "readers", "sessions");
        $this->views = array("fees", "free_books");
    }
    
    /*
     * jeżeli to cholerstwo myslqdump nie będzie działac to tu jest coś zamiast tego
     * zapisuje to do pliku cała strukture tabeli wraz z wartościami w nich
     */
    public function dump(){
        $return = "";
        foreach ( $this->tables as $table ) {
            $result = $this->controller->doQuery('SELECT * FROM '.$table.';');
            $num_fields = mysqli_num_fields($result);
            $num_rows = mysqli_num_rows($result);
            $return .= "--\n-- Structure for the table $table\n--\n\n";
            $return .= "DROP TABLE IF EXISTS `$table`;";
            $row2 = mysqli_fetch_array ($this->controller->doQuery('SHOW CREATE TABLE '.$table.';' ) );
            $return .= "\n\n" . $row2 [1] . ";\n\n";
            if ($num_rows > 0) {
                $return .= "--\n-- Data dump for the table $table\n--\n\n";
            }
            
            $i = 0;
            while ( $row = mysqli_fetch_array ($result ) ) {
                if ($i == 0) {
                    $return .= "INSERT INTO `$table` VALUES\n";
                }
                $i++;
                for($j = 0; $j < $num_fields; $j ++) {
                    if ($j == 0) {
                        $return .= '(';
                    }
                    $row [$j] = addslashes ( $row [$j] );
                    if (isset ( $row [$j] )) {
                        $return .= '"' . $row [$j] . '"';
                    } 
                    else {
                        $return .= '""';
                    }
                    if ($j < ($num_fields - 1)) {
                        $return .= ',';
                    }
                }
                if ($i < $num_rows) { 
                    $return .= "),\n"; 
                } 
                else { 
                    $return .= ");\n\n"; 
                }
            }
        }
        foreach ( $this->views as $view ) {
            $result =  $this->controller->doQuery('SELECT * FROM '.$view.'');
            $num_fields = mysqli_num_fields ($result );
            $num_rows = mysqli_num_rows($result );
            $return .= "--\n-- Structure for the table $view\n--\n\n";
            $return .= "DROP TABLE IF EXISTS `$view`;";
            $row2 = mysqli_fetch_array ($this->controller->doQuery('SHOW CREATE TABLE '.$view.'') );
            $return .= "\n\n" . $row2 [1] . ";\n\n";
        }
        $file = $this->path.'backup_'.date("Y_m_d").'.sql';
        echo "SAVE to ".$file;
        $fp = fopen($file, "a");
        flock($fp, 2);
        fwrite($fp, $return);
        flock($fp, 3);
        fclose($fp); 
        return $return; 
    }
    /*
     * metoda wczytująca backup stworzony metodą dump
     */
    public function recoverDataBase($date){
        $query = fread(fopen($this->path.'backup_'.$date.'.sql', "r"), filesize($this->path.'backup_'.$date.'.sql'));
        $this->controller->doQuery($query);
    }
}


$backup = new Backup('./', "dslusarz_baza", "dslusarz", "kasztan");
echo $backup->dump();