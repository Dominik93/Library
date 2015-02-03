<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function monozmacierz($m1, $m2){
    $wynik = array();
    for($i = 0;$i < count($m1); $i++){
        for($j = 0;$j < count($m2); $j++){
            $s = 0;
            for($k = 0; $k < count($m1[0]); $k++){
                $s += $m1[$i][$k] * $m2[$k][$j];
            }
            array_push($wynik, $s);
        }
    }
    var_dump($wynik);
}

if(isset($_POST['licz'])){
    $mac2 = $_POST['m2'];
    $mac1 = $_POST['m1'];
    var_dump($mac1);
    var_dump($mac2);
    monozmacierz($mac1, $mac2);
    
}
else if(isset($_POST['n1'])){
    $n1 = $_POST['n1'];
    $m1 = $_POST['m1'];
    $n2 = $_POST['n2'];
    $m2 = $_POST['m2'];
    echo '<form action="test.php" method="post">';
    for($i = 0; $i< $m1; $i++){
        for($j = 0; $j< $n1; $j++){
            echo '<input name="m1['.$i.']['.$j.']">';
        }
        echo '<br>';
    }
    echo '<br>';
    for($i = 0; $i< $n2; $i++){
        for($j = 0; $j< $m2; $j++){
            echo '<input name="m2['.$i.']['.$j.']">';
        }
        echo '<br>';
    }
    echo '<input type="hidden" value=1 name="licz"><input type="submit" value="Licz"/></form>';
}else{
echo '<form action="test.php" method="post">'
    . 'Podaj n<input name="n1"/><br>'
.    'Podaj m<input name="m1"><br>'
        .'Podaj n<input name="n2"/><br>'
.    'Podaj m<input name="m2"><br>'
. '<input type="submit" value="Podaj">';

}