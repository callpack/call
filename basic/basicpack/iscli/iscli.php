<?php
//Anderson Ismael
//15 de outubro de 2018

function isCli(){
    if (php_sapi_name() == "cli") {
        return true;
    } else{
        return false;
    }
}
