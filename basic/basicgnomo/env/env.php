<?php
//Criado por Anderson Ismael
//08 de abril de 2019

require __DIR__.'/vendor/autoload.php';

use Dotenv\Dotenv;

$filename=ROOT.'.env';
if(file_exists($filename)){
    $dotenv = Dotenv::create(ROOT);
    $dotenv->load();
}else{
    die('nano .env'.PHP_EOL);
}
