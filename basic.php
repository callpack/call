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
    mensagemDeErro('O '.$_ENV['NOME_DO_GERENCIADOR'].' só funciona no modo CLI');
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
    // case 'remove':
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
    print "Modo de usar:".PHP_EOL;
    print chr(9).$_ENV['NOME_DO_GERENCIADOR']." comando ";
    print "[nome do pacote opcional]".PHP_EOL;
    echo "Comandos:".PHP_EOL;
    echo chr(9).'help- Mostra essa tela de ajuda'.PHP_EOL;
    echo chr(9).'install - Instala o(s) pacote(s)'.PHP_EOL;
    echo chr(9).'remove - Remove o(s) pacote(s)'.PHP_EOL;
    echo chr(9).'uninstall - Remove o(s) pacote(s)'.PHP_EOL;
    echo chr(9).'update - Atualiza o(s) pacote(s)'.PHP_EOL;
}
function criarOPacotesArr($arr){
    unset($arr[0]);
    unset($arr[1]);
    return array_values($arr);
}
function mensagemDeErro($msg){
    //ok imprime uma mensagem de erro colorida
    $title=colortext('❌ ','red',true);
    die($title.$msg.PHP_EOL);
}
function mensagemDeSucesso($msg){
    //ok imprime uma mensagem de sucesso colorida
    $title=colortext('✔️ ','green',true);
    print $title.$msg.PHP_EOL;
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
function instalarDependenciasNoPWD(){
    // //dependencias:
    //     pasta PWD/basic/basicpack
    //     inc
    //     ^call
}
function instalarPacote($pacotesArr){
    // possíveis retornos do install
    // //instalação
    instalarDependenciasNoPWD();
    // ok if o pacote existe no PWD
    if(oPacoteEstáInstaladoNoPWD($pacoteStr)){
        //     diz que o pacote já está instalado
        oPacoteFoiInstaladoComSucesso($pacoteStr);
    }elseif(oPacoteExisteNoCache($pacoteStr)){
        // elseif o pacote existe no cache
        //     instala ele no PWD
        instalarOPacoteNoPWDAPartirDoCache($pacoteStr)
    }elseif(oPacoteExisteNoGithub($pacoteStr)){
        // elseif o pacote existe no Github
        //     baixar ele para o cache
        //     instala ele no PWD
        //     diz que o pacote foi instalado com sucesso
        oPacoteFoiInstaladoComSucesso($pacoteStr);
    }else{
        // else (se o pacote não existe no pwd, no cache ou no github)
        //     diz que o pacote não existe no github
    }
}
function instalarOPacoteNoPWDAPartirDoCache($pacoteStr){
    //instala o pacote no pwd
    //     diz que o pacote foi instalado com sucesso
    oPacoteFoiInstaladoComSucesso($pacoteStr);
}
function instalarOPacoteAPartirDoGithub($pacoteStr){
    //baixa o pacote do github
    //salva o pacote no cache
    //instala o pacote no pwd a partir do cache
    instalarOPacoteNoPWDAPartirDoCache($pacoteStr);
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
function oPacoteFoiInstaladoComSucesso($pacoteStr){
    $pacoteStr=colortext($pacoteStr,'white',true);
    mensagemDeSucesso('O pacote '.$pacoteStr.' foi instalado');
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
