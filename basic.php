#!/usr/bin/php
<?php
//Criado por Anderson Ismael
//06 de agosto de 2019
require 'basic/basic.php';
inc([
    'colortext',
    'download',
    'env',
    'error',
    'iscli'
]);
if(!iscli()){
    erroFatal('O Basic só funciona no modo CLI');
}
error(1);
$PWD=getcwd().'/';//get current working director
$fn=@$_SERVER['argv'][1];
$update=false;
switch($fn){
    case 'install':
    install();
    break;
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
function criarOPacotesArr($arr){
    unset($arr[0]);
    unset($arr[1]);
    return array_values($arr);
}
function erroFatal($msg){
    //ok imprime uma mensagem de erro colorida
    system("clear");
    $title=colortext('Erro fatal:','red',true);
    print $title.PHP_EOL;
    $msg=colortext($msg,'white');
    die($msg.PHP_EOL);
}
function install(){
    //ok extrair o nome dos pacotes criando o array $pacotesArr
    $pacotesArr=criarOPacotesArr($_SERVER['argv']);
    //ok verifica se o inc está instalado, se não tiver adiciona ao $pacotesArr
    if(!oPacoteEstáInstaladoNoPWD('inc')){
        $pacotesArr[]='inc';
    }
    //ok instala cada pacote do $pacotesArr
    foreach ($pacotesArr as $pacoteStr) {
        instalarPacote($pacoteStr);
    }
}
funciton instalarNoPWD(){
    // //dependencias:
    //     pasta PWD/basic/basicpack
    //     inc
    //     ^call
}
function instalarPacote($pacotesArr){
    // possíveis retornos do install
    // //instalação
    instalarNoPWD();
    // if o pacote existe no PWD
    if(oPacoteEstáInstaladoNoPWD($pacoteStr)){
        //     diz que o pacote já está instalado
    }elseif(oPacoteExisteNoCache($pacoteStr)){
        // elseif o pacote existe no cache
        //     instala ele no PWD
        //     diz que o pacote foi instalado com sucesso
    }elseif(oPacoteExisteNoGithub($pacoteStr)){
        // elseif o pacote existe no Github
        //     baixar ele para o cache
        //     instala ele no PWD
        //     diz que o pacote foi instalado com sucesso
    }else{
        // else (se o pacote não existe no pwd, no cache ou no github)
        //     diz que o pacote não existe no github
    }
}
function oPacoteExisteNoCache($pacoteStr){
    //verifica se o pacote existe no cache
}
function oPacoteExisteNoGithub($pacoteStr){
    //verifica se o pacote existe no Github
}
function oPacoteEstáInstaladoNoPWD($pacoteStr){
    //verifica se o pacote está instalado no pwd
}
function uninstall($pacotesArr){
    // possíveis retornos do uninstall
    //     if o pacote existe no PWD
    //         apaga ele
    //         diz que o pacote foi apagado
    //     else
    //         diz que o pacote não está instalado
}
function update($pacotesArr){
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
