<?php
if(!defined('IN_YYJIA')) {
	exit('Access Denied');
}
$dayBegin = strtotime(date('Y-m-d',time()));//当天开始时间戳
$dayEnd = $dayBegin+86399;//当天结束时间戳
$taginfos=get_tags("dateline");
if($taginfos){
	foreach($taginfos['id'] as $key => $value){
		$logosql="select logo from tag_app,appinfo where tag_app.appid=appinfo.id and tagid='".$value['id']."' and appinfo.isverify='1' order by appinfo.dateline desc limit 1";
		$taginfos['id'][$key]['logo']=$_SGLOBAL['db']->result($_SGLOBAL['db']->query($logosql),0);
	    $csql="select count(*) from tag_app,appinfo where tag_app.appid=appinfo.id and tagid='".$value['id']."' and appinfo.isverify='1'";
		$taginfos['id'][$key]['num']=$_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql),0);
	}
}
$taginfos['id']['0']['id']="0";
$taginfos['id']['0']['tagname']="全部";
$taginfos['id']['0']['logo']="http://src.yyjia.com/logo/sylogo/160600.jpg";
$csql="select count(*) from appinfo where isverify='1'";
$taginfos['id']['0']['num']=$_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql),0);
ksort($taginfos['id']);
$_SCONFIG['title']=str_replace("%sitename%",$_SCONFIG['sitename'],$_SCONFIG['symgametitle']);
$_SCONFIG['keyword']=str_replace("%sitename%",$_SCONFIG['sitename'],$_SCONFIG['symgamekeyword']);
$_SCONFIG['description']=str_replace("%sitename%",$_SCONFIG['sitename'],$_SCONFIG['symgamedescription']);
include_once template($ac);
?>