<?php
include_once('common.php');
include_once(S_ROOT.'./source/function_admincp.php');
define('IN_YYJIA', TRUE);
//是否关闭站点
checkclose(); 
//需要登录
$_SCONFIG["template"]="admin";

$acs = array(array( 'client','newsclient','appclient','subclient','recache','game','comment','subject','category','tag','link','search','config','downloadzy','sitemap','news','newscatalog','apple','android','acategory',"website","jubao","guolv","appdownload","subdownload",'newsdownload','login','seccode','checkupdate','index','swfupload','usermanage','managedata','usergroup','wphone','datainfo','apperror','chkvendor','managekfb','managelb','managekcb','syapp','synews','managetag','sycate','serverclient','union','analyze','setcredit','managecredit','360union','packrecord','manageserver'));

if($_REQUEST['ac']!="login"&&$_REQUEST['ac']!="seccode"&&$_REQUEST['ac']!="swfupload"){

	if(empty($_SGLOBAL['supe_uid'])) {
		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			ssetcookie('_refer', rawurlencode($_SERVER['REQUEST_URI']));
		} else {
			ssetcookie('_refer', rawurlencode('admincp.php?ac='.$_REQUEST['ac']));
		}
		showmessage('to_login', 'admincp.php?ac=login&ref=admincp.php');
	}
	if(!checkadmin()){
		showmessage('you_do_not_have_permission_to_visit');
	}
}

if(empty($_REQUEST['ac']) || (!in_array($_REQUEST['ac'], $acs[0]))) {
	$ac = 'index';
} else {
	$ac = $_REQUEST['ac'];
}

if(!empty($_SC['allowedittpl']) && $isfounder) {
	$acs[2][] = 'template';
}
if($isfounder) {
	$acs[2][] = 'backup';
}

//来源
if(!preg_match("/admincp\.php/", $_SGLOBAL['refer'])) $_SGLOBAL['refer'] = "admincp.php?ac=$ac";
//菜单激活
$menuactive = array($ac => ' class="active"');
//权限
$menus = array();
$needlogin = 0;
$acfile = $ac;
//取消翻页限制
$_SCONFIG['maxpage'] = 0;
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
$hours=array(7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24);
$currentcc=array($sidename=>'class=dangq');

include_once(S_ROOT.'./admin/admincp_'.$acfile.'.php');
?>