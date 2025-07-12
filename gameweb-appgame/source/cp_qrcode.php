<?php

if(!defined('IN_YYJIA')) {

	exit('Access Denied');

}

include_once(S_ROOT.'./source/phpqrcode.php');
$url=$_GET['url'];
$url=str_replace("*","&",$url);
$erweima="http://".$_SCONFIG['siteurl']."/".$url;

QRcode::png($erweima,false,'L','4');

?>