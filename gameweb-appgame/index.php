<?php
if(is_file($_SERVER['DOCUMENT_ROOT'].'/source/yyjiasafe/webscan.php')){
    require_once($_SERVER['DOCUMENT_ROOT'].'/source/yyjiasafe/webscan.php');
}

unset($value);
unset($key);
include_once('common.php');
$taginfos=get_tags("viewnum");
$acs = array('index','games','test','server','packs','news','recommend','newdetail','appdetail','packdetail','testmore','servermore','down','search','register','login','lostpasswd','resetpswd','common','comment','contact','seccode','managedata','newsmanagedata','shortcut','rss','sitemap','user','fastdown','searchnews','baidumap','gugemap','qrcode','chkvendor','updatehtml','sendmsg','pinyin','cj_360server','cj_4399test','cj_4399server');

$ac = (empty($_GET['ac']) || !in_array($_GET['ac'], $acs))?'index':$_GET['ac'];

$sectype=$_GET['sectype'];

if($ac!="down"){
	if($_GET['ac']=="login"||$_GET['ac']=="register"||$_GET['ac']=="seccode"||$_GET['ac']=="lostpasswd"||$_GET['ac']=="common"){
	
	}else{
		if(strstr($_SERVER['HTTP_USER_AGENT'],"Adr")||strstr(strtolower($_SERVER['HTTP_USER_AGENT']),"android") || strstr($_SERVER['HTTP_USER_AGENT'],"iPh")||strstr(strtolower($_SERVER['HTTP_USER_AGENT']),"iphone") || strstr($_SERVER['HTTP_USER_AGENT'],"MicroMessenger")){
			if($ac=="newdetail"){
				$id=intval($_GET['newid']);
				if($id){
					inserttype("newdetail",$id);
				}
			}elseif($ac=="appdetail"){
				$id=intval($_GET['id']);
				if($id){
					inserttype("appdetail",$id);
				}
			}elseif($ac=="packdetail"){
				$id=intval($_GET['packid']);
				if($id){
					inserttype("packdetail",$id);
				}
			}elseif($ac=="games" || $ac=="recommend"  || $ac=="test" || $ac=="server" || $ac=="news" || $ac=="packs"){
				if($ac=="recommend"){
					$ac="games";
				}
				inserttype($ac,'0');
			}else{
				if($_SCONFIG['sydomain']){
					//header("Location:".$_SCONFIG['sydomain']);	
					if("http://".$_SERVER['SERVER_NAME']==$_SCONFIG['sydomain'] && !strstr(strtolower($_SERVER['REQUEST_URI']),"mobile")){
						header("location:".$_SCONFIG['sydomain']."/mobile.php");
					}else{
						header("Location:".$_SCONFIG['sydomain']);
					}
			
				}else{
			
					header("Location:mobile.php");
			
				}
			}
		
			exit;
		
		}
	}
}
if($_SCONFIG['kqjingtai'] && $ac!="down" && $ac!="common" && $ac!="login" && $ac!="register" && $ac!="lostpassword" && $ac!="seccode" && $ac!="qrcode"){
	
	$htmlpath=createhtml("shouyou");
}


include_once(S_ROOT.'./source/cp_'.$ac.'.php');
?>