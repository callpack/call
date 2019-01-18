#!/usr/bin/php
<?php
require __DIR__.'/vendor/autoload.php';
$PWD=getcwd().'/';//get current working director
$fn=@$argv[1];
switch($fn){
    case 'install':
    install();
    break;
    case 'remove' OR 'uninstall':
    uninstall();
    break;
    case 'update':
    update();
    break;
    default:
    help();
    break;
}
function download($url,$method='GET',$ua=false) {
    //http://docs.guzzlephp.org/en/stable/
    $client=new GuzzleHttp\Client ();
    if(!$ua){
        $ua ="USER_AGENT','Mozilla/5.0 ";
        $ua.='(X11; Ubuntu; Linux x86_64; rv:64.0) ';
        $ua.='Gecko/20100101 Firefox/64.0';
    }
    $headers=[
        'headers'=>[
            'User-Agent'=>$ua
        ]
    ];
    try {
        $res=$client->request($method,$url,$headers);
        $body=false;
        if($res->getStatusCode()==200){
            return $res->getBody();
        }else{
            return false;
        }
    } catch (RuntimeException $e) {
        return false;
    }
}
function dirIsEmpty($dir)
{
    if ($files = glob($dir . "/*")) {
        return false;
    } else {
        return true;
    }
}
function help(){
    echo "Usage: basic command [optional package name]".PHP_EOL;
    echo "Commands:".PHP_EOL;
    echo chr(9).'install - Install package'.PHP_EOL;
    echo chr(9).'uninstall - Remove package'.PHP_EOL;
    echo chr(9).'update - Update package'.PHP_EOL;
}
function install($repo=false){
    if(is_string($repo)){
        $skipCache=true;
    }else{
        global $argv;
        $repo=@$argv[2];
        $skipCache=false;
    }
    $filename=__DIR__."/cache";
    if(!file_exists($filename)){
        mkdir($filename);
    }
    $filename=__DIR__."/cache/$repo.zip";
    if(file_exists($filename) && $skipCache==true){
        unlink($filename);
    }
    if(file_exists($filename) && $skipCache==false){
        echo 'instalando partir do cache...'.PHP_EOL;
        $content=file_get_contents($filename);
    }else{
        echo 'baixando do github...'.PHP_EOL;
        $url="https://github.com/getbasic/";
        $url=$url."$repo/archive/master.zip";
        $content=@download($url);
        if(!$content){
            die('pacote não encontrado'.PHP_EOL);
        }
        file_put_contents($filename,$content);
    }
    global $PWD;
    $destination=$PWD.'basic';
    if(!file_exists($destination)){
        mkdir($destination);
        install('inc');
    }
    $destination=$destination.'/getbasic';
    //cria a pasta do usuário
    if(!file_exists($destination)){
        mkdir($destination);
    }
    $destinationTempName=$destination."/$repo-master";
    $destinationNewName=$destination."/$repo";
    //verifica se repositório já tá instalando
    if(file_exists($destinationNewName)){
        rmDirNotEmpty($destinationNewName);
    }
    //verifica se sobrou uma pasta temporária
    if(file_exists($destinationTempName)){
        rmDirNotEmpty($destinationTempName);
    }
    if(unzip($filename,$destination)){
        if(file_exists($destinationTempName)){
            if(!file_exists($destinationNewName)){
                rename($destinationTempName,$destinationNewName);
            }
        }
        //atualiza o basic/basic.json
        $filename=$PWD.'basic/basic.json';
        if(file_exists($filename)){
            $jsonString=file_get_contents($filename);
            $jsonArray=json_decode($jsonString,true);
        }
        $jsonArray[]=$repo;
        $jsonArray=array_values(array_unique($jsonArray));
        $data=json_encode($jsonArray,JSON_PRETTY_PRINT);
        file_put_contents($filename,$data);
        if($skipCache){
            echo $repo.' atualizado com sucesso'.PHP_EOL;
        }else{
            echo $repo.' instalado com sucesso'.PHP_EOL;
        }
    }else{
        die('ocorreu um erro ao extrair os arquivos'.PHP_EOL);
    }
}
function remove(){
    return uninstall();
}
function rmDirNotEmpty($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir."/".$object) == "dir") rmDirNotEmpty($dir."/".$object); else unlink($dir."/".$object);
            }
        }
        reset($objects);
        rmdir($dir);
    }
}
function uninstall(){
    echo 'removendo...'.PHP_EOL;
    global $argv;
    global $PWD;
    $repo=@$argv[2];
    // verifica se o pacote existe no "{$PWD}basic/basic.json
    $filename="{$PWD}basic/basic.json";
    $array=[];
    if(file_exists($filename)){
        $content=file_get_contents($filename);
        $array=json_decode($content);
    }
    // apaga o registro do pacote no $PWD/basic/basic.json
    foreach ($array as $key => $value) {
        if($value==$repo){
            unset($array[$key]);
        }
    }
    $data=json_encode($array,JSON_PRETTY_PRINT);
    file_put_contents($filename,$data);
    // apaga a pasta do pacote em "{$PWD}basic/$repo"
    $filename="{$PWD}basic/getbasic/{$repo}";
    if(file_exists($filename)){
        rmDirNotEmpty($filename);
    }
    $filename="{$PWD}basic/getbasic/";
    if(dirIsEmpty($filename)){
        rmDirNotEmpty($filename);
    }
    echo $repo." removido com sucesso".PHP_EOL;
}
function unzip($filename,$folderDestination){
    $zip = new ZipArchive;
    $res = $zip->open($filename);
    if ($res === TRUE) {
        $zip->extractTo($folderDestination);
        $zip->close();
        return true;
    } else {
        return false;
    }
}
function update(){
    echo 'atualizando...'.PHP_EOL;
    global $argv;
    $repo=@$argv[2];
    install($repo);
}
?>
