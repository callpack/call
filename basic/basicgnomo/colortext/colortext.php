<?php
//Criado por Anderson Ismael
//07 de agosto de 2019
require_once __DIR__ . '/vendor/autoload.php';
use Colors\Color;
function colortext($textStr,$textColorStr,$boldBool=false){
    $c = new Color();
    if($boldBool){
        return $c($textStr)->$textColorStr()->bold();
    }else{
        return $c($textStr)->$textColorStr();
    }
}
