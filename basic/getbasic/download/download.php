<?php
//Criado por Anderson Ismael
//30 de Julho de 2019
function download($url) {
    $useragent='Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:68.0) Gecko/20100101 Firefox/68.0';
    $ch = curl_init();
    //you might need to set some cookie details up (depending on the site)
    //curl_setopt($ch, CURLOPT_TIMEOUT, 1);
    curl_setopt($ch, CURLOPT_URL,$url); //set the url we want to use
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, $useragent); //set our user agent
    $result= curl_exec ($ch); //execute and get the results
    if($result){
        return $result;
    }else{
        return false;
    }
    curl_close ($ch);
}
