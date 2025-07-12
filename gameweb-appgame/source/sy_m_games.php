<?php
if(!defined('IN_YYJIA')) {

	exit('Access Denied');

}
$dayBegin = strtotime(date('Y-m-d',time()));//当天开始时间戳
$dayEnd = $dayBegin+86399;//当天结束时间戳
$taginfos=get_tags("dateline");
if($taginfos){
	foreach($taginfos['id'] as $key => $value){
		$csql="select count(*) from tag_app,appinfo where tag_app.appid=appinfo.id and tagid='".$value['id']."' and appinfo.isverify='1'";
		$taginfos['id'][$value['id']]['nums']=$_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql),0);
		$logosql="select logo from tag_app,appinfo where tag_app.appid=appinfo.id and tagid='".$value['id']."' and appinfo.isverify='1' order by appinfo.dateline desc limit 1";
		$taginfos['id'][$value['id']]['logo']=$_SGLOBAL['db']->result($_SGLOBAL['db']->query($logosql),0);
	}
}
$qutags['id']="0";
$qutags['tagname']="全部";
$qutags['logo']="http://src.yyjia.com/logo/sylogo/160600.jpg";
$acsql="select count(*) from appinfo where isverify='1'";
$qutags['nums']=$_SGLOBAL['db']->result($_SGLOBAL['db']->query($acsql),0);
$taginfos['id']['0']=$qutags;
//array_unshift($taginfos['id'],$qutags);
$op=$_GET['op']?$_GET['op']:"isrecommend";
$orderby=$_GET['order']?$_GET['order']:'dateline';
$tagid=$_GET['tagid']?intval($_GET['tagid']):'0';
$cname=$_GET['cname']?$_GET['cname']:"all";
if($tagid){
	$dqtagname=$taginfos['id'][$tagid][tagname];
}else{
	$dqtagname="全部";
}
ksort($taginfos['id']);
$_SCONFIG['title']=str_replace("%catename%",$dqtagname,str_replace("%sitename%",$_SCONFIG['sitename'],$_SCONFIG['symgametitle']));
$_SCONFIG['keyword']=str_replace("%catename%",$dqtagname,str_replace("%sitename%",$_SCONFIG['sitename'],$_SCONFIG['symgamekeyword']));
$_SCONFIG['description']=str_replace("%catename%",$dqtagname,str_replace("%sitename%",$_SCONFIG['sitename'],$_SCONFIG['symgamedescription']));

if($cname=="all"){
	$taginfo[id]=$tagid;
	$_SCONFIG['title']=str_replace("%tagname%",'',$_SCONFIG['title']);
	$_SCONFIG['keyword']=str_replace("%tagname%",'',$_SCONFIG['keyword']);
	$_SCONFIG['description']=str_replace("%tagname%",'',$_SCONFIG['description']);

}else{
	$taginfo=$taginfos['engname'][$cname];
	$_SCONFIG['title']=str_replace("%tagname%",$taginfo['tagname'],$_SCONFIG['title']);
	$_SCONFIG['keyword']=str_replace("%tagname%",$taginfo['tagname'],$_SCONFIG['keyword']);
	$_SCONFIG['description']=str_replace("%tagname%",$taginfo['tagname'],$_SCONFIG['description']);
}
$yystates=array("1"=>"运营","2"=>"公测","3"=>"内测","4"=>"封测","5"=>"预告",);
if(!$_GET['yystate']){
	$_GET['yystate']="0";
	$_SCONFIG['title']=str_replace("%yystate%",'',$_SCONFIG['title']);
	$_SCONFIG['keyword']=str_replace("%yystate%",'',$_SCONFIG['keyword']);
	$_SCONFIG['description']=str_replace("%yystate%",'',$_SCONFIG['description']);

}else{
	$_SCONFIG['title']=str_replace("%yystate%",$yystates[$_GET['yystate']],$_SCONFIG['title']);
	$_SCONFIG['keyword']=str_replace("%yystate%",$yystates[$_GET['yystate']],$_SCONFIG['keyword']);
	$_SCONFIG['description']=str_replace("%yystate%",$yystates[$_GET['yystate']],$_SCONFIG['description']);
}
$orders['dateline']='最新';
$orders['isrecommend']='推荐';
$orders['downloadcount']='最热';

$_SCONFIG['title']=str_replace("%order%",$orders[$orderby],$_SCONFIG['title']);
$_SCONFIG['keyword']=str_replace("%order%",$orders[$orderby],$_SCONFIG['keyword']);
$_SCONFIG['description']=str_replace("%order%",$orders[$orderby],$_SCONFIG['description']);


$tagcss=array($cname=>' class="cur"');
$statecss=array($_GET['yystate']=>' class="cur"');
$ordercss=array($orderby=>' class="cur"');

$_GET['sy']="games";
$headcss=array("games"=>' class="cur"');

if($_GET['ajax']){
		
	
	$page=intval($_GET['page']);
	if($page<2){
		$page=2;	
	}
	$pagesize=20;
	$start=($page-1)*$pagesize;
	$lists=getapplists(4,0,-1,-1,0,$orderby,20,1,"",0,$tagid);
	echo json_encode($lists['app']['list']);
	exit;	
}
if($_GET['reqPageNum']){
	$page=intval($_GET['reqPageNum']);
	if($page<2)
	$page=2;
	$pagesize=20;
	if($_SCONFIG['ismemcache'] && $_SGLOBAL['mc']){
		$cachename = $_SC['siteid']."_".$viewtype."_index_type_4_orderby_".$orderby."_page_".$page;
		$list=$_SGLOBAL['mc']->get($cachename);
	}
if(!$list){
	$start=($page-1)*$pagesize;	
	$where=" where isverify=1 and a.type='4' ";
	if($tagid){
		$index="";
		if($orederby=="isrecommend"){
			$sql="select a.*,h.downurl,h.iosdownurl from appinfo as a,tag_app as t,handgameinfo as h ".$index.$where." and a.isrecommend='1' and a.id=t.appid and t.tagid='".$tagid."' and a.id=h.appid order by  dateline desc limit ".$start.",".$pagesize;
		}else{
			$sql="select a.*,h.downurl,h.iosdownurl from appinfo as a,tag_app as t,handgameinfo as h ".$index.$where." and a.id=t.appid and t.tagid='".$tagid."' and a.id=h.appid order by ".$orderby." desc limit ".$start.",".$pagesize;
		}	
	}elseif($orederby=="isrecommend"){
		$sql="select a.*,h.downurl,h.iosdownurl from appinfo as a,handgameinfo as h ".$where."  and a.isrecommend='1' and a.id=h.appid order by dateline desc limit ".$start.",".$pagesize;
	}else{
		$sql="select a.*,h.downurl,h.iosdownurl from appinfo as a,handgameinfo as h ".$where." and a.id=h.appid order by ".$orderby." desc limit ".$start.",".$pagesize;
	}
	$query=$_SGLOBAL['db']->query($sql);
	while($value=$_SGLOBAL['db']->fetch_array($query)){
		if($value['logo']){
			if(strstr($value['logo'],"http://")){
				//
			}else{
				$value['logo']="http://".$_SC['sitehost'].$value['logo'];	
			}
		}
		
		if($viewtype=="android"){
			if($value['downurl']){
				$value['downhtml']='<a href="javascript:void(0);" onClick="down_box(\''.$value[id].'\')" class="button button-small border-yellow">下载</a>';
			}else{
				$value['downhtml']='<a href="javascript:void(0);" class="button button-small border-yellow">预告</a>';
			}
		}elseif($viewtype=="apple"){
			if($value['iosdownurl']){
				$value['downhtml']='<a href="javascript:void(0);" onClick="down_box(\''.$value[id].'\')" class="button button-small border-yellow">下载</a>';
			}else{
				$value['downhtml']='<a href="javascript:void(0);" class="button button-small border-yellow">预告</a>';
			}
		}
		$value['downurl']="http://$_SCONFIG[siteurl]/".$SCRIPT_NAME."?ac=down&id=".$value['id'];
		$value['star']=chkstar($value['star']);
		if($value['downloadcount']>9999){
			$value['downloadcount']=number_format($value['downloadcount']/10000,1)."万";
		}
		$value['url']=$SCRIPT_NAME."?ac=appdetail&id=".$value['id'];
		if($_SCONFIG['allowrewrite']  && strstr($SCRIPT_NAME,"mobile")) {
			$value['downurl']=preg_replace('/mobile\.php\?(ac|do)+\=([a-z0-9\=\&]+?)/ie', "'mobile/\\2'", $value['downurl']).$rewriteend;
			$value['downurl']=str_replace(array('&','='), array('-', '-'), $value['downurl']);
			$value['url']=preg_replace('/mobile\.php\?(ac|do)+\=([a-z0-9\=\&]+?)/ie', "'/mobile/\\2'", $value['url']).$rewriteend;
			$value['url']=str_replace(array('&','='), array('-', '-'), $value['url']);
		}
		$value['downCount']=$value['downloadcount'];
		$value['href']="m_index.php?ac=detail&id=".$value[id];
		$value['score']=intval($value['score']);
		$value['appKinds'][]['kindId']=$value['categoryid'];
		$value['appKinds'][]['typeName']=$idcategorylist[$value['categoryid']]['categoryname'];
		if($isweixin){
			$value['downurl']="javascript:weixindown();";
		}
		$list[]=$value;
	}
	if($_SCONFIG['ismemcache'] && $_SGLOBAL['mc'])
			$_SGLOBAL['mc']->add($cachename,$list,$exptime);
}
	$sql="select count(*) as counts from appinfo where type='4' and isverify=1";
	$countinfo=$_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query($sql));
	$applists['count']=$countinfo['counts'];
	$applists['list']=$list;
	$applists['pageNum']=$page+1;
	$applist['moreFineList']=$applists;
	$applist['status']=200;
	$applist['totalPages']=ceil($applists['count']/$pagesize);
	echo json_encode($applist);
	exit;	
}
include_once template($ac);
?>