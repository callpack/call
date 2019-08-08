<?php
//Criado por Anderson Ismael
//10 de abril de 2019
//https://tinyurl.com/y6m8vuvp

function isDownloadable($url) {
    $userAgent='Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:68.0) Gecko/20100101 Firefox/68.0';
    $tempoMaximoEmSegundos=10;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER  , true);  // we want headers
    curl_setopt($ch, CURLOPT_NOBODY  , true);  // we don't need body
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, $tempoMaximoEmSegundos);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if($httpCode==200){
        return true;
    }else{
        return false;
    }
}

