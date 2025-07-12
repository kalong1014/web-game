<?php
include_once('common.php');

if($_SCONFIG['mtemplate']) {
	$_SCONFIG['template'] = $_SCONFIG['mtemplate'];
}else{
	$_SCONFIG['template'] = "mdefault";	
}
$_SC['template']=$_SCONFIG['template'];

$acs = array('index','games','test','server','packs','news','recommend','newdetail','appdetail','packdetail','testmore','servermore','down','search','member','searchpacks','comment','tags','login','register','downurl');

$ac = (empty($_GET['ac']) || !in_array($_GET['ac'], $acs))?'index':$_GET['ac'];

//$sectype=$_GET['sectype'];

if(strstr($_SERVER['HTTP_USER_AGENT'],"MicroMessenger")){
	$isweixin="weixin";
}

if(strstr($_SERVER['HTTP_USER_AGENT'],"Adr")||strstr(strtolower($_SERVER['HTTP_USER_AGENT']),"android")&&$ac!="login"&&$ac!="register"&&$ac!="lostpasswd"&&$ac!="seccode"){

	$_GET['type']="android";
	$viewtype="android";
	
}elseif((strstr($_SERVER['HTTP_USER_AGENT'],"iPh")||strstr(strtolower($_SERVER['HTTP_USER_AGENT']),"iphone")||strstr(strtolower($_SERVER['HTTP_USER_AGENT']),"ipad"))&&$ac!="login"&&$ac!="register"&&$ac!="lostpasswd"&&$ac!="seccode"){

	$_GET['type']="apple";
	$viewtype="apple";
	
}else{
	$_GET['type']="android";
	$viewtype="android";
}
if($_SCONFIG['rewriteend']){
	if($_SCONFIG['rewriteend']==1){
		$rewriteend=".htm";
	}elseif($_SCONFIG['rewriteend']==2){
		$rewriteend=".html";	
	}elseif($_SCONFIG['rewriteend']==3){
		$rewriteend=".shtml";
	}	
}else{
	$rewriteend=".htm";	
}

include_once(S_ROOT.'./source/sy_m_'.$ac.'.php');

?>