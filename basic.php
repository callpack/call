#!/usr/bin/php
<?php
//Criado por Anderson Ismael
//06 de agosto de 2019
require 'basic/basic.php';
$incs=['download','env','error'];
inc($incs);
//system('clear');
error(1);
$PWD=getcwd().'/';//get current working director
$fn=@$argv[1];
$update=false;
switch($fn){
    // case 'install':
    // install();
    // break;
    // case 'remove':
    // uninstall();
    // break;
    // case 'uninstall':
    // uninstall();
    // break;
    // case 'update':
    // update();
    // break;
    default:
    help();
    break;
}
function help(){
    print "Usage: basic command [optional package name]".PHP_EOL;
    echo "Commands:".PHP_EOL;
    echo chr(9).'help- Show this screen'.PHP_EOL;
    echo chr(9).'install - Install package'.PHP_EOL;
    echo chr(9).'uninstall - Remove package'.PHP_EOL;
    echo chr(9).'update - Update package'.PHP_EOL;
}
function install($name){
    // possíveis retornos do install
    // //dependencias
    // pasta PWD/basic/getbasic
    // inc
    // ^call
    // //instalação
    // if o pacote existe no PWD
    //     diz que o pacote já está instalado
    // elseif o pacote existe no cache
    //     instala ele no PWD
    //     diz que o pacote foi instalado com sucesso
    // elseif o pacote existe na internet
    //     baixar ele para o cache
    //     instala ele no PWD
    //     diz que o pacote foi instalado com sucesso
    // else
    //     diz que o pacote não existe no github
}
function uninstall($name){
    // possíveis retornos do uninstall
    //     if o pacote existe no PWD
    //         apaga ele
    //         diz que o pacote foi apagado
    //     else
    //         diz que o pacote não está instalado
}
function update($name){
    // possíveis retornos do update
    //     if o pacote existe no PWD
    //         apaga ele
    //         baixar ele para o cache
    //         instala ele no pwd
    //         diz que o pacote foi atualizado com sucesso
    //     elseif o pacote existe no cache
    //         apaga ele
    //         baixar ele para o cache
    //         instala ele no pwd
    //         diz que o pacote foi atualizado com sucesso
    //     elseif o pacote existe na internet
    //         baixar ele para o cache
    //         instala ele no pwd
    //         diz que o pacote foi atualizado com sucesso
    //     else
    //         diz que o pacote não existe no github
}
?>
