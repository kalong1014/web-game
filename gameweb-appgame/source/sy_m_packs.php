<?php

if(!defined('IN_YYJIA')) {

	exit('Access Denied');

}
$title="礼包列表";
$pt=$_GET['pt']?intval($_GET['pt']):'0';

$op=trim($_GET['op']);

$dayBegin = strtotime(date('Y-m-d',time()));//当天开始时间戳

$dayEnd = $dayBegin+86399;//当天结束时间戳

if($pt){
	$dqpacktypename=$ptypeinfo[$pt];
}else{
	$dqpacktypename="全部";
}

$_GET['sy']="packs";

$headcss=array($_GET['sy']=>' class="dangqian"');
if($_GET['ajax']){
	$page=intval($_GET['page']);
	if($page<2){
		$page=2;	
	}
	$pagesize=10;
	$start=($page-1)*$pagesize;
	$lists=getpackinfo(0,$pt,0,$pagesize,1);
	echo json_encode($lists);
	exit;	
}
if($_GET['page']){
	if($_SCONFIG['ismemcache'] && $_SGLOBAL['mc']){
		$cachename = $_SC['siteid']."_packs_cateid_".$cateid."_"."reqPageNum_".$page."_".$type;
		$list=$_SGLOBAL['mc']->get($cachename);
	}
	if(!$list){
		$page=intval($_GET['page']);
		if($page<2){
			$page=2;	
		}
		$pagesize=10;
		$start=($page-1)*$pagesize;
		$lists=getpackinfo(0,$pt,0,$pagesize,1);
		if($_SCONFIG['ismemcache'] && $_SGLOBAL['mc']){
			$_SGLOBAL['mc']->add($cachename,$list,$exptime);	
		}
		$moreFineList['list']=$lists;
		$typeList['moreFineList']=$moreFineList;
		$typeList['status']=200;
		$typeList['totalPages']=2;
		echo json_encode($typeList);	
		exit;
		
	}
}
if($op=="list"){
	$id=intval($_GET['id']);
	if($id){
		$syappinfo=get_appinfo($id,"handgameinfo");
	}
}
$_SCONFIG['title']=str_replace("%sitename%",$_SCONFIG['sitename'],$_SCONFIG['sympacktitle']);

$_SCONFIG['keyword']=str_replace("%sitename%",$_SCONFIG['sitename'],$_SCONFIG['sympackkeyword']);

$_SCONFIG['description']=str_replace("%sitename%",$_SCONFIG['sitename'],$_SCONFIG['sympackdescription']);
$headcss=array("packs"=>' class="cur"');
if($op){
	include_once template($ac."_".$op);
}else{
	include_once template($ac);
}

?>