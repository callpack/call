<?php
//Criado por Anderson Ismael
//22 de janeiro de 2019
function error($show=true){
    if($show){
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }else{
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        error_reporting(0);
    }
}
