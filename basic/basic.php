<?php
$str=__DIR__;
$arr=explode('/',$str);
end($arr);
$key=key($arr);
unset($arr[$key]);
$str=implode('/',$arr).'/';
define("ROOT",$str);
require ROOT.'basic/basicpack/inc/inc.php';
