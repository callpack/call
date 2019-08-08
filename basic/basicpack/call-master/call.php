<?php
//Criado por Anderson Ismael
//21 de junho de 2019
function call($name){
    $filename=ROOT.'call/getcall/'.$name.'/index.php';
    if(file_exists($filename)){
        require $filename;
    }
}
?>
