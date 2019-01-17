<?php
require 'vendor/autoload.php';
require 'config.php';
$PWD=getcwd().'/';//get current working director
$fn=@$argv[1];
switch($fn){
    case 'install':
    install();
    break;
    case 'uninstall':
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
    if(unzip($filename,$PWD)){
        if($skipCache){
            echo $repo.' atualizado com sucesso'.PHP_EOL;
        }else{
            echo $repo.' instalado com sucesso'.PHP_EOL;
        }
    }else{
        echo 'ocorreu um erro ao extrair os arquivos'.PHP_EOL;
    }
}
function uninstall(){
    echo 'removendo...'.PHP_EOL;
    global $argv;
    $repo=@$argv[2];
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
