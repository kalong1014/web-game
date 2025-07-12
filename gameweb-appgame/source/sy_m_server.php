<?php

if(!defined('IN_YYJIA')) {
	exit('Access Denied');
}
$dayBegin = strtotime(date('Y-m-d',time()));//当天开始时间戳

$dayEnd = $dayBegin+86399;//当天结束时间戳

$_SCONFIG['title']=str_replace("%sitename%",$_SCONFIG['sitename'],$_SCONFIG['symopentitle']);

$_SCONFIG['keyword']=str_replace("%sitename%",$_SCONFIG['sitename'],$_SCONFIG['symopenkeyword']);

$_SCONFIG['description']=str_replace("%sitename%",$_SCONFIG['sitename'],$_SCONFIG['symopendescription']);

$_SCONFIG['title']=str_replace("%channeltype%",$_GET['type'],$_SCONFIG['title']);

$_SCONFIG['keyword']=str_replace("%channeltype%",$_GET['type'],$_SCONFIG['keyword']);

$_SCONFIG['description']=str_replace("%channeltype%",$_GET['type'],$_SCONFIG['description']);

$_GET['sy']="server";

$headcss=array($_GET['sy']=>' class="dangqian"');
if($_GET['ajax']){
	$page=intval($_GET['page']);
	if($page<2){
		$page=2;	
	}
	$pagesize=10;
	$start=($page-1)*$pagesize;
	$lists=getopengames(0,0,10,1);
	echo json_encode($lists['list']);
	exit;	
}
if($_GET['reqPageNum']){
	$page=intval($_GET['reqPageNum']);
	if($page<2){
		$page=2;	
	}
	$_GET['page']=$page;
	if($_SCONFIG['ismemcache'] && $_SGLOBAL['mc']){
		$cachename = $_SC['siteid']."_server_reqPageNum_".$reqPageNum;
		$list=$_SGLOBAL['mc']->get($cachename);
	}
	if(!$list){
		$pagesize=10;
		$start=($page-1)*$pagesize;	
		$list=getopengames(0,0,10,1);
		if($_SCONFIG['ismemcache'] && $_SGLOBAL['mc']){
			$_SGLOBAL['mc']->add($cachename,$list,$exptime);
		}	
	}
	$moreFineList['list']=$list;
	$typeList['moreFineList']=$moreFineList;
	$typeList['status']=200;
	$typeList['totalPages']=2;
	echo json_encode($typeList);	
	exit;
}

$headcss=array("server"=>' class="cur"');
include_once template($ac);

?>