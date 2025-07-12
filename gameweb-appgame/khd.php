<?php
include_once('common.php');
$_SCONFIG['template'] = "khd";	
$_SC['template']=$_SCONFIG['template'];
$acs = array('index','games','test','server','packs','news','recommend','newdetail','appdetail','packdetail','testmore','servermore','down','search','member','searchpacks','comment','tags','login','register','downurl');

$ac = (empty($_GET['ac']) || !in_array($_GET['ac'], $acs))?'index':$_GET['ac'];


$viewtype="android";

if($ac=="down"){
	$downtype="khd";
}
include_once(S_ROOT.'./source/sy_m_'.$ac.'.php');

?>