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
function adicionarOPacoteAoJson($pacoteStr){
    $PWD=getPWD();
    $nomeDoGerenciador=$_ENV['NOME_DO_GERENCIADOR'];
    $filename=$PWD.$nomeDoGerenciador.'/'.$nomeDoGerenciador.'.json';
    if(file_exists($filename)){
        $str=file_get_contents($filename);
        $arr=json_decode($str,true);
    }
    $arr[]=$pacoteStr;
    $arr=array_filter($arr);
    $str=json_encode($arr,JSON_PRETTY_PRINT);
    file_put_contents($filename,$str);
}
function atualizar($pacotesArr){
    $pularCache=true;
    instalarOPacote($pacoteStr,$pularCache);
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
    $filename=__DIR__.'/cache/'.$pacoteStr.'.zip';
    $PWD=getPWD();
    $nomeDoGerenciador=$_ENV['NOME_DO_GERENCIADOR'];
    $nomeDoGithub=$_ENV['NOME_DO_GITHUB'];
    $destination=$PWD.$nomeDoGerenciador.'/'.$nomeDoGithub;
    if(unzip($filename,$destination)){
        $oldName=$destination.'/'.$pacoteStr.'-master';
        $newName=$destination.'/'.$pacoteStr;
        //TODO move fatal
        if(file_exists($newName)){
            system("rm -rf $newName");
        }
        system("mv $oldName $newName");
        return true;
    }else{
        return false;
    }
}
function getPWD(){
    return getcwd().'/';
}
function instalar(){
    instalarDependenciasNoPWD();
    //extrair o nome dos pacotes criando o array $pacotesArr
    $pacotesArr=criarOPacotesArr($_SERVER['argv']);
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
        if(!oPacoteEstaNoPWD($pacoteStr)){
            instalarOPacote($pacoteStr);
        }
    }
}
function instalarOPacote($pacoteStr,$pularCache=false){
    //verifica se já tá instalado
    $oPacoteEstaNoPWD=oPacoteEstaNoPWD($pacoteStr);
    if($oPacoteEstaNoPWD){
        return oPacoteJaEstavaInstalado($pacoteStr);
    }else{
        if($pularCache){
            $via='github';
            $foiInstalado=instalarOPacoteAPartirDoGithub($pacoteStr);
        }else{
            //verifica se existe no cache
            $oPacoteEstaNoCache=oPacoteEstaNoCache($pacoteStr);
            if($oPacoteEstaNoCache){
                $via='cache';
                $foiInstalado=instalarOPacoteAPartirDoCache($pacoteStr);
            }else{
                $via='github2';
                $foiInstalado=instalarOPacoteAPartirDoGithub($pacoteStr);
            }
        }
        print $via.PHP_EOL;
        //verifica se foi instalado
        if($foiInstalado){
            return oPacoteFoiInstaladoComSucesso($pacoteStr);
        }else{
            return ocorreuUmErroAoInstalarOPacote($pacoteStr);
        }
    }
}
function instalarOPacoteAPartirDoGithub($pacoteStr){
    if(oPacoteEstaNoGithub($pacoteStr)){
        //baixar o pacote do github
        $conteudoDoPacoteStr=baixarOPacoteDoGithub($pacoteStr);
        //salvar o pacote no cache
        criarAPastaCache();
        $filename=__DIR__.'/cache/'.$pacoteStr.'.zip';
        if(file_exists($filename)){
            removerOPacoteDoCache($pacoteStr);
        }
        file_put_contents($filename,$conteudoDoPacoteStr);
        //instalar o pacote no pwd a partir do cache
        return instalarOPacoteAPartirDoCache($pacoteStr);
    }else{
        return false;
    }
}
function instalarOPacoteAPartirDoCache($pacoteStr){
    if(extrairOPacoteDoCacheParaOPWD($pacoteStr)){
        adicionarOPacoteAoJson($pacoteStr);
        return true;
    }else{
        return false;
    }
}
function mensagemDeErro($msg){
    //imprime uma mensagem de erro colorida
    $title=colortext('❌ ','red',true);
    die($title.$msg.PHP_EOL);
}
function mensagemDeSucesso($msg){
    //imprime uma mensagem de sucesso colorida
    $title=colortext('✔️','green',true);
    return print $title.' '.$msg.PHP_EOL;
}
function ocorreuUmErroAoInstalarOPacote($pacoteStr){
    $pacoteStr=colortext($pacoteStr,'white',true);
    return mensagemDeErro('Ocorreu um erro ao tentar instalar o pacote '.$pacoteStr);
}
function oPacoteEstaNoCache($pacoteStr){
    //verifica se o pacote existe no cache
    $nomeDoGerenciador=$_ENV['NOME_DO_GERENCIADOR'];
    $filename=__DIR__.$nomeDoGerenciador.'/cache/'.$pacoteStr.'.zip';
    if(file_exists($filename)){
        return true;
    }else{
        return false;
    }
}
function oPacoteEstaNoGithub($pacoteStr){
    //verifica se o pacote existe no Github
    $nomeDoGithub=$_ENV['NOME_DO_GITHUB'];
    $urlStr='https://github.com/'.$nomeDoGithub.'/'.$pacoteStr.'/archive/master.zip';
    return isdownloadable($urlStr);
}
function oPacoteEstaNoPWD($pacoteStr){
    //TODO bug no bool
    //verifica se o pacote está instalado no pwd
    $PWD=getPWD();
    $nomeDoGerenciador=$_ENV['NOME_DO_GERENCIADOR'];
    $nomeDoGithub=$_ENV['NOME_DO_GERENCIADOR'];
    $filename=$PWD.$nomeDoGerenciador.'/'.$nomeDoGithub.'/'.$pacoteStr.'/';
    $filename=$filename.$pacoteStr.'.php';
    if(file_exists($filename)){
        return true;
    }else {
        return false;
    }
}
function oPacoteFoiInstaladoComSucesso($pacoteStr){
    $pacoteStr=colortext($pacoteStr,'white',true);
    return mensagemDeSucesso('O pacote '.$pacoteStr.' foi instalado');
}
function oPacoteJaEstavaInstalado($pacoteStr){
    $pacoteStr=colortext($pacoteStr,'white',true);
    return mensagemDeSucesso('O pacote '.$pacoteStr.' já estava instalado');
}
function removerOPacoteDoCache($pacoteStr){
    //removerPacoteDoCache
    $nomeDoGerenciador=$_ENV['NOME_DO_GERENCIADOR'];
    $filename=__DIR__.'/cache/'.$pacoteStr.'.zip';
    if(file_exists($filename)){
        unlink($filename);
    }
}
function removerOPacoteDoJson($pacoteStr){
    $PWD=getPWD();
    $nomeDoGerenciador=$_ENV['NOME_DO_GERENCIADOR'];
    $filename=$PWD.$nomeDoGerenciador.'/'.$nomeDoGerenciador.'.json';
    if(file_exists($filename)){
        $str=file_get_contents($filename);
        $arr=json_decode($str,true);
    }
    $arr[]=$pacoteStr;
    $arr=array_filter($arr);
    foreach ($arr as $key => $value) {
        if($value==$pacoteStr){
            unset($arr[$key]);
        }
    }
    $str=json_encode($arr,JSON_PRETTY_PRINT);
    file_put_contents($filename,$str);
}
function removerOPacoteDoPWD($pacoteStr){
    removerOPacoteDoJson($pacoteStr);
    $PWD=getPWD();
    $nomeDoGerenciador=$_ENV['NOME_DO_GERENCIADOR'];
    $nomeDoGithub=$_ENV['NOME_DO_GERENCIADOR'];
    $filename=$PWD.$nomeDoGerenciador.'/'.$nomeDoGithub.'/'.$pacoteStr.'/';
    if(file_exists($filename)){
        system("rm -rf $filename");
    }
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
