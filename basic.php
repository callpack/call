#!/usr/bin/php
<?php
//Criado por Anderson Ismael
//06 de agosto de 2019
require 'basic/basic.php';
inc([
    'colortext',
    'download',
    'isdownloadable',
    'env',
    'error',
    'iscli',
    'unzip'
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
function baixarOPacoteDoGithub($pacoteStr){
    //baixar o pacote do github
    $nomeDoGithub=$_ENV['NOME_DO_GITHUB'];
    $urlStr='https://github.com/'.$nomeDoGithub.'/'.$pacoteStr.'/archive/master.zip';
    return download($urlStr);
}
function criarAPastaCache(){
    $filename=__DIR__.'/cache';
    if(file_exists($filename)){
        return true;
    }else{
        return mkdir($filename);
    }
}
function criarAPastaDeDestinoNoPWD(){
    //criar a pasta de destino no pwd
    $PWD=getPWD();
    $nomeDoGerenciador=$_ENV['NOME_DO_GERENCIADOR'];
    $nomeDoGithub=$_ENV['NOME_DO_GERENCIADOR'];
    $filename=$PWD.$nomeDoGerenciador.'/'.$nomeDoGithub;
    if(file_exists($filename)){
        return true;
    }else{
        return mkdir($filename);
    }
}
function criarAPastaDoPacoteNoPWD($pacoteStr){
    $PWD=getPWD();
    $nomeDoGerenciador=$_ENV['NOME_DO_GERENCIADOR'];
    $nomeDoGithub=$_ENV['NOME_DO_GERENCIADOR'];
    $filename=$PWD.$nomeDoGerenciador.'/'.$nomeDoGithub.'/'.$pacoteStr;
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
    // TODO possíveis retornos do uninstall
    //     if o pacote existe no PWD
    //         apaga ele
    //         diz que o pacote foi apagado
    //     else
    //         diz que o pacote não está instalado
}
function extrairOPacoteDoCacheParaOPWD($pacoteStr){
    $filename=__DIR__.$_ENV['NOME_DO_GERENCIADOR'].'/cache/'.$pacoteStr.'.zip';
    $PWD=getPWD();
    $nomeDoGerenciador=$_ENV['NOME_DO_GERENCIADOR'];
    $nomeDoGithub=$_ENV['NOME_DO_GITHUB'];
    $destination=$PWD.$nomeDoGerenciador.'/'.$nomeDoGithub.'/'.$pacoteStr;
    if(unzip($filename,$destination)){
        return true;
    }else{
        return false;
    }
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
        instalarOPacote($pacoteStr,$pularDependencias);
    }
}
function instalarOPacote($pacoteStr,$pularDependencias=false,$pularCache=false){
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
    //baixar o pacote do github
    $conteudoDoPacoteStr=baixarOPacoteDoGithub($pacoteStr);
    //salvar o pacote no cache
    criarAPastaCache();
    $filename=__DIR__.'/cache/'.$pacoteStr.'.zip';
    if(file_exists($filename)){
        removerPacoteDoCache($pacoteStr);
    }
    file_put_contents($filename,$conteudoDoPacoteStr);
    //instalar o pacote no pwd a partir do cache
    instalarOPacoteNoPWDAPartirDoCache($pacoteStr);
}
function instalarOPacoteNoPWDAPartirDoCache($pacoteStr){
    //instala o pacote no pwd
    extrairOPacoteDoCacheParaOPWD($pacoteStr);
    $PWD=getPWD();
    $nomeDoGerenciador=$_ENV['NOME_DO_GERENCIADOR'];
    $filename=$PWD.$nomeDoGerenciador.'/'.$nomeDoGerenciador.'.json';
    if(file_exists($filename)){
        $str=file_get_contents($filename);
        $arr=json_decode($str);
    }
    $arr[]=$pacoteStr;
    $arr=array_filter($arr);
    $str=json_encode($arr,JSON_PRETTY_PRINT);
    file_put_contents($filename,$str);
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
    //verifica se o pacote existe no cache
    $nomeDoGerenciador=$_ENV['NOME_DO_GERENCIADOR'];
    $filename=__DIR__.$nomeDoGerenciador.'/cache/'.$pacoteStr.'.zip';
    if(file_exists($filename)){
        return true;
    }else{
        return false;
    }
}
function oPacoteExisteNoGithub($pacoteStr){
    //verifica se o pacote existe no Github
    $nomeDoGithub=$_ENV['NOME_DO_GITHUB'];
    $urlStr='https://github.com/'.$nomeDoGithub.'/'.$pacoteStr.'/archive/master.zip';
    return isdownloadable($urlStr);
}
function oPacoteEstáInstaladoNoPWD($pacoteStr){
    //verifica se o pacote está instalado no pwd
    $PWD=getPWD();
    $nomeDoGerenciador=$_ENV['NOME_DO_GERENCIADOR'];
    $nomeDoGithub=$_ENV['NOME_DO_GERENCIADOR'];
    $filename=$PWD.$nomeDoGerenciador.'/'.$nomeDoGithub.'/'.$pacoteStr.'/';
    $filename.=$pacoteStr.'.php';
    return file_exists($filename);
}
function oPacoteFoiInstaladoComSucesso($pacoteStr){
    $pacoteStr=colortext($pacoteStr,'white',true);
    mensagemDeSucesso('O pacote '.$pacoteStr.' foi instalado');
}
function removerPacoteDoCache($pacoteStr){
    //removerPacoteDoCache
    $nomeDoGerenciador=$_ENV['NOME_DO_GERENCIADOR'];
    $filename=__DIR__.$nomeDoGerenciador.'/cache/'.$pacoteStr.'.zip';
    unlink($filename);
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
