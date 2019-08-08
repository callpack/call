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
    instalar();
    break;

    case 'remove':
    uninstall();
    break;

    case 'remove':
    case 'uninstall':
    desinstalar();
    break;

    case 'update':
    atualizar();
    break;

    default:
    telaDeAjuda();
    break;
}
//FUNÇÕES
function atualizar($pacotesArr){
    // TODO possíveis retornos do update
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
function criarAPastaDeDestinoNoPWD(){
    //criar a pasta de destino no pwd
    $PWD=getPWD();
    $filename=$PWD.$_ENV['NOME_DO_GERENCIADOR'];
    if(file_exists($filename)){
        return true;
    }else{
        return mkdir($filename);
    }
}
function criarOPacotesArr($arr){
    unset($arr[0]);
    unset($arr[1]);
    return array_values($arr);
}
function desinstalar($pacotesArr){
    // possíveis retornos do uninstall
    //     TODO if o pacote existe no PWD
    //         apaga ele
    //         diz que o pacote foi apagado
    //     TODO else
    //         diz que o pacote não está instalado
}
function getPWD(){
    return getcwd().'/';
}
function instalar(){
    //extrair o nome dos pacotes criando o array $pacotesArr
    $pacotesArr=criarOPacotesArr($_SERVER['argv']);
    //verifica se o inc está instalado, se não tiver adiciona ao $pacotesArr
    if(!oPacoteEstáInstaladoNoPWD('inc')){
        $pacotesArr[]='inc';
    }
    //instala cada pacote do $pacotesArr
    foreach ($pacotesArr as $pacoteStr) {
        instalarOPacote($pacoteStr);
    }
}
function instalarDependenciasNoPWD(){
    // //dependencias:
    //     pasta PWD/basic/basicpack
    criarAPastaDeDestinoNoPWD();
    //     inc, call
    $pacotesArr=[
        'call',
        'inc'
    ];
    $pularDependencias=true;
    foreach ($pacotesArr as $pacoteStr) {
        instalarOPacote($pacotesStr,$pularDependencias);
    }
}
function instalarOPacote($pacotesStr,$pularDependencias=false,$pularCache=false){
    // possíveis retornos do install
    // //instalação
    if($pularDependencias==false){
        instalarDependenciasNoPWD();
    }
    // if o pacote existe no PWD
    if(oPacoteEstáInstaladoNoPWD($pacoteStr)){
        //     diz que o pacote já está instalado
        oPacoteFoiInstaladoComSucesso($pacoteStr);
    }elseif(oPacoteExisteNoCache($pacoteStr)){
        // elseif o pacote existe no cache
        //     instala ele no PWD
        instalarOPacoteNoPWDAPartirDoCache($pacoteStr);
    }elseif(oPacoteExisteNoGithub($pacoteStr)){
        // elseif o pacote existe no Github
        instalarOPacoteAPartirDoGithub($pacoteStr);
    }else{
        // else (se o pacote não existe no pwd, no cache ou no github)
        //     diz que o pacote não existe no github
        mensagemDeErro('O pacote não existe no Github');
    }
}
function instalarOPacoteAPartirDoGithub($pacoteStr){
    //TODO baixar o pacote do github
    //TODO salvar o pacote no cache
    //instalar o pacote no pwd a partir do cache
    instalarOPacoteNoPWDAPartirDoCache($pacoteStr);
}
function instalarOPacoteNoPWDAPartirDoCache($pacoteStr){
    //TODO instala o pacote no pwd
    //     diz que o pacote foi instalado com sucesso
    oPacoteFoiInstaladoComSucesso($pacoteStr);
}
function mensagemDeErro($msg){
    //imprime uma mensagem de erro colorida
    $title=colortext('❌ ','red',true);
    die($title.$msg.PHP_EOL);
}
function mensagemDeSucesso($msg){
    //imprime uma mensagem de sucesso colorida
    $title=colortext('✔️ ','green',true);
    print $title.$msg.PHP_EOL;
}
function oPacoteExisteNoCache($pacoteStr){
    //TODO verifica se o pacote existe no cache
}
function oPacoteExisteNoGithub($pacoteStr){
    //TODO verifica se o pacote existe no Github
}
function oPacoteEstáInstaladoNoPWD($pacoteStr){
    //TODO verifica se o pacote está instalado no pwd
}
function oPacoteFoiInstaladoComSucesso($pacoteStr){
    $pacoteStr=colortext($pacoteStr,'white',true);
    mensagemDeSucesso('O pacote '.$pacoteStr.' foi instalado');
}
function telaDeAjuda(){
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
?>
