<?php
if(!defined('IN_YYJIA')) {
	exit('Access Denied');
}
$newaddata=json_decode(str_replace("*", "\\", $_SCONFIG['recordadpic']), true);
$sql="select * from tag";
$query=$_SGLOBAL['db']->query($sql);
while($value=$_SGLOBAL['db']->fetch_array($query)){
	$taglist[]=$value;
}
$op = $_REQUEST['op']?$_REQUEST['op']:"list";

$sql="select d.platform,u.uid,u.zxid from user_data as u,developer as d where u.type=2 and u.uid=d.uid";
$query=$_SGLOBAL['db']->query($sql);
while($value=$_SGLOBAL['db']->fetch_array($query)){
	$platforminfo[$value['zxid']]=$value;
}
if($op=="list"){
	$type=4;
	$page=$_GET['page']?$_GET['page']:1;	
	$mpurl="admincp.php?ac=syapp&op=list";
	$perpage=$_GET['perpage']?$_GET['perpage']:30;
	$mpurl.="&perpage=".$perpage;
	$cateid=$_GET[syinfo]?$_GET[syinfo]:0;
	$categoryid=$cateid[categoryid];
	$mpurl.="&syinfo[categoryid]=".$categoryid;
	$phone=$_GET['phone']?$_GET['phone']:3;
	$mpurl.="&phone=".$phone;
	$tagid=$_GET['tagid']?$_GET['tagid']:'';
	$mpurl.="&tagid=".$tagid;
	$yystate=$_GET['yystate']?$_GET['yystate']:0;
	$mpurl.="&yystate=".$yystate;
	if($phone==4){
		$isphone=-1;
		$ispad=-1;
	}
	//$apptype=$_GET['apptype'];
	$apptype=1;
	$mpurl.="&apptype=".$apptype;
	$orderby=$_GET['orderby'];
	$mpurl.="&orderby=".$orderby;
	$appname=$_GET['appname'];
	$mpurl.="&appname=".$appname;
	$platform=$_GET['platform'];
	if($platform=="后台采集"){
		$platform="";
	}
	$mpurl.="&platform=".$platform;
	$start=($page-1)*$perpage;
	$returncount=1;
	$admin=1;
	$isverify=isset($_GET['isverify'])?$_GET['isverify']:-1;
	$mpurl.="&isverify=".$isverify;
	if($appname){
		$where=" and name like '%".$appname."%' ";
	}
	if(!$orderby){
		$orderby="dateline";
	}
	
	$applist=get_app($type,$categoryid,$isphone,$ispad,$apptype,$orderby,$start,$perpage,$idcategorylist,$returncount,$admin,$where,$isverify,0,"",$tagid,$yystate,$platform);
	if($applist){
		$list=$applist['list'];
		$count=$applist['count'];
		$multi=multi2($count, $perpage, $page, $mpurl);
	}
	
}elseif($op=="edit"){
	session_start();
	$sid=session_id();
	$path=S_ROOT."./data/cache/addon-".$sid.".inc";
	@unlink($path);
	@session_destroy();
	session_start();
	$id=intval($_GET[id]);
	if(!$id){
		showmessage("参数有误","admincp.php?ac=syapp");
	}
	$sql="select * from ".tname('appinfo')." as app,".tname('handgameinfo')." as handgame where handgame.appid=app.id and app.id=".$id;
	$syinfo=$_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query($sql));
	$syinfo['updatetime']=date("Y-m-d",$syinfo['updatetime']);
	if($syinfo['imgurl']){
		$imglist=explode("@@@",$syinfo['imgurl']);
	}else{
		$imglist=explode("@@@",$syinfo['ipadimgurl']);
	}
	
	if($syinfo['downurl']){
		$kk=0;
		$downlist=explode("@@@",$syinfo['downurl']);
		foreach($downlist as $k=>$v){
			if($k%2==1){
				$downurl[$kk]['name']=$v;
				$kk++;
			}else{
				$downurl[$kk]['url']=$v;
			}
		}
	}
	if($syinfo['iosdownurl']){
		$kk=0;
		$iosdownlist=explode("@@@",$syinfo['iosdownurl']);
		foreach($iosdownlist as $k=>$v){
			if($k%2==1){
				$iosdownurl[$kk]['name']=$v;
				$kk++;
			}else{
				$iosdownurl[$kk]['url']=$v;
			}
		}
	}
	$tsql="select * from tag_app where appid='".$id."'";
	$tquery=$_SGLOBAL['db']->query($tsql);
	while($val=$_SGLOBAL['db']->fetch_array($tquery)){
		$syinfo[tags][$val[tagid]]=$val;
	}

}elseif($op=="delete"){
	session_start();
	$sid=session_id();
	$path=S_ROOT."./data/cache/addon-".$sid.".inc";
	@unlink($path);
	@session_destroy();
	session_start();
	$id=intval($_GET[id]);
	if(!$id){
		showmessage("参数有误","admincp.php?ac=syapp");
	}
	$sql="select * from ".tname('appinfo')." where id=$id";
	$syinfo=$_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query($sql));
	if($syinfo['serverid']){
		$serverurl=$_SCONFIG['serverurl'];
		$siteid=$_SCONFIG['siteid'];
		$key=$_SCONFIG['key'];
		$delurl=$serverurl."/serverapi.php?ac=appserver&op=del&siteid=".$siteid."&key=".$key."&gameid=".$syinfo['serverid']."&subtype=".$syinfo['subtype'];	
		$serurl=$serverurl."/serverapi.php";
		$arr=array("ac"=>"appserver","op"=>"del","siteid"=>$siteid,"key"=>$key,"gameid"=>$syinfo['serverid'],"subtype"=>$syinfo['subtype']);
		if(function_exists("curl_init")){
			$insertjsons=$catalogjson=gethtml($serurl,$arr);
		}else{
			$insertjsons=file_get_contents($delurl);
		}	
	}
	$logofile=S_ROOT.$syinfo['logo'];
	if($logofile){
		unlink($logofile);
	}
	$dsql="select imgurl from handgameinfo where appid='".$syinfo['id']."'";
	$dquery=$_SGLOBAL['db']->query($dsql);
	$andrvalue=$_SGLOBAL['db']->fetch_array($dquery);
	$filepics=explode("@@@",$andrvalue[imgurl]);
	foreach($filepics as $dkey=>$dval){
		$filepic=S_ROOT.$dval;
		if($filepic){
			unlink($filepic);
		}
	}
	
	$sql = "delete from ".tname('appinfo')." where id=$id";
	$query = $_SGLOBAL['db']->query($sql);
	$sql = "delete from ".tname('handgameinfo')." where appid=$id";
	$query = $_SGLOBAL['db']->query($sql);
	//删除关联表
	$sql = "delete from ".tname('tag_app')." where appid in ($id)"; 
	$query = $_SGLOBAL['db']->query($sql);
	if($newaddata){
		unset($newaddata[web][shouyou][$id]);
		$nrecordpicinfos=json_encode(str_replace("\\","*",$newaddata));
		$sql="update config set datavalue='".$nrecordpicinfos."' where var ='recordadpic'";
		$_SGLOBAL['db']->query($sql);
	}
	$datafile=S_ROOT."/data/data_config.php";
	if($datafile){
		@unlink($datafile);
	}
	delete_memcached();//删除所有的游戏缓存
	showmessage("删除操作成功",$_SERVER['HTTP_REFERER']);
}elseif($op=="add"){
	session_start();
	$sid=session_id();
	$path=S_ROOT."./data/cache/addon-".$sid.".inc";
	@unlink($path);
	@session_destroy();
	session_start();
	$op="edit";
}elseif($op=="noverify"){
	$id=intval($_GET['id']);
	if($id){
		$sql="update appinfo set isverify=0 where id=$id";
		$_SGLOBAL['db']->query($sql);
		$refer=$_SERVER['HTTP_REFERER'];
		echo "<script>window.location.href='".$refer."';</script>";
	}
	exit;
}elseif($op=="verify"){
	$id=intval($_GET['id']);
	$val=$_GET['val'];
	if($id){
		$sql="update appinfo set isverify=$val where id=$id";
		$_SGLOBAL['db']->query($sql);
		$refer=$_SERVER['HTTP_REFERER'];
		echo "<script>window.location.href='".$refer."';</script>";
	}
	exit;
}elseif($op=="jzverify"){
	$id=intval($_GET['id']);
	if($id){
		$sql="update appinfo set isverify=2 where id=$id";
		$_SGLOBAL['db']->query($sql);
		$refer=$_SERVER['HTTP_REFERER'];
		echo "<script>window.location.href='".$refer."';</script>";
	}
	exit;
}elseif($op=="liuyan"){
	$appid=intval($_GET['appid']);
	$message=$_GET['message'];
	if($appid){
		$sql="update appinfo set message='".$message."' where id='".$appid."'";
		$query=$_SGLOBAL['db']->query($sql);
		if($query){
			$lyresult="1";
		}else{
			$lyresult="0";
		}
	}else{
		$lyresult="0";
	}
	echo json_encode($lyresult);die();
}elseif($op=="isrecommend"){
	$id=intval($_GET['id']);
	if($id){
		$sql="update appinfo set isrecommend=1 where id=$id";
		$_SGLOBAL['db']->query($sql);
		$refer=$_SERVER['HTTP_REFERER'];
		echo "<script>window.location.href='".$refer."';</script>";
	}
	exit;
}elseif($op=="recommend"){
	$id=intval($_GET['id']);
	if($id){
		$sql="update appinfo set isrecommend=0 where id=$id";
		$_SGLOBAL['db']->query($sql);
		$refer=$_SERVER['HTTP_REFERER'];
		echo "<script>window.location.href='".$refer."';</script>";
	}
	exit;
}elseif($op=="subjectajax"){
	$catid=$_GET['catid']?$_GET['catid']:0;
	$type=$_GET['type']?$_GET['type']:2;
	$subtype=$_GET['subtype']?$_GET['subtype']:2;
	if($catid){
		$sql="select s.* from ".tname('subject_category')." as cs,".tname('subject')." as s where s.id=cs.subjectid "."and s.type=$type and s.subtype=$subtype"." and cs.categoryid='".$catid."' order by s.id";
		$query1=$_SGLOBAL['db']->query($sql);
		$n=0;
		while($value1=$_SGLOBAL['db']->fetch_array($query1)){
			$subjectlists[$n]=$value1;
			$n++;
		}
		echo json_encode($subjectlists);
		exit;
	}else{
		$sql="select s.* from ".tname('subject')." as s where s.type=$type and s.subtype=$subtype order by s.id";
		$query1=$_SGLOBAL['db']->query($sql);
		$n=0;
		while($value1=$_SGLOBAL['db']->fetch_array($query1)){
			$subjectlists[$n]=$value1;
			$n++;
		}
		echo json_encode($subjectlists);
		exit;
	}
}elseif($op=="save"){
	//chksiteinfo();
	session_start();
	$sid=session_id();
	$picinfook=$_POST['picinfook'];
	$imgurl="";
	include_once(S_ROOT.'./source/chinesespell.php');
	$pinyin=new ChineseSpell();
	if(count($picinfook)>0){
		$path=S_ROOT."./data/cache/addon-".$sid.".inc";
		include_once($path);
		foreach($picinfook as $k=>$v){
			if(!$imgurl){
				$imgurl=$myaddons[$k-1][1];
			}else{
				$imgurl.="@@@".$myaddons[$k-1][1];
			}	
		}
	}
	if($_POST['appid']){
		$dimgurl=$_POST['dimgurl'];
		foreach($dimgurl as $k=>$v){
			if($_FILES['imgfile']['name'][$k]){
				$dir="syapp/images/".date("m",time());
				$dimgurl[$k]=pic($dir,'imgfile',$k);
			}
		}
		$dimgurls=implode("@@@",$dimgurl);
		if($imgurl){
			if($dimgurls){
				$imgurl=$dimgurls."@@@".$imgurl;
			}
		}else{
			$imgurl=$dimgurls;
		}
	}
	@session_destroy();
	@unlink($path);
	$sydata=$_POST['sydata'];
	$syinfo=$_POST['syinfo'];
	$tags=$_POST[tag];
	if(!$syinfo['score']){
		$syinfo['score']=6;
	}
	$syinfo['star']=score($syinfo['score']);
	$syinfo['dateline']=time();
	if($_POST['starttime']==""){
		$syinfo['updatetime']=time();
	}else{
		$syinfo['updatetime']=strtotime($_POST['starttime']);
	}
	if($_POST['logourl']){
		$syinfo['logo']=$_POST['logourl'];
	}else{
		if($_FILES['logo']['name']){
			$dir="syapp/logo";
			$syinfo['logo']=pic($dir,'logo',-1);
		}
	}
	if($_FILES['adpictureurl']['name']){
		$dir="syapp/lbpic";
		$syinfo['adpictureurl']=pic($dir,'adpictureurl',-1);
	}
	if($_FILES['wapadpic']['name']){
		$dir="syapp/waplb";
		$syinfo['wapadpic']=pic($dir,'wapadpic',-1);
	}
	if($_FILES['dlogo']['name']){
		$dir="syapp/dlogo";
		$sydata['dlogo']=pic($dir,'dlogo',-1);
	}
	if($_FILES['appfile']['name']){
		$dir="syapp/soft/".$syinfo['categoryid'];
		$ddurl=uploadfile($dir,'appfile',-1);
	}
	$downurls=$_POST['downurl']?$_POST['downurl']:"";
	$downnames=$_POST['downname']?$_POST['downname']:"";
	$iosdownurls=$_POST['iosdownurl']?$_POST['iosdownurl']:"";
	$iosdownnames=$_POST['iosdownname']?$_POST['iosdownname']:"";
	$ddownurl="";
	if($ddurl){
		$ddownurl=$ddurl."@@@本地下载";
	}
	if($downurls){
		foreach($downurls as $k=>$v){
			if($ddownurl){
				$ddownurl.="@@@";
			}
			if($downnames[$k]){
				$ddownurl.=$v."@@@".$downnames[$k];	
			}else{
				$ddownurl.=$v."@@@安卓下载";	
			}
		}
	}
	$iosddownurl="";
	if($iosdownurls){
		foreach($iosdownurls as $ik=>$iv){
			if($iosddownurl){
				$iosddownurl.="@@@";
			}
			if($iosdownurls[$ik]){
				$iosddownurl.=$iv."@@@".$iosdownnames[$ik];	
			}else{
				$iosddownurl.=$iv."@@@苹果下载";	
			}
		}
	}
	
	if($_POST['addimgurl']){
		foreach($_POST['addimgurl'] as $key=>$value){
			if($key==1){
				$addjturl=$value;
			}else{
				$addjturl.="@@@".$value;
			}
		}
		if($imgurl!=""){
			$imgurl.="@@@".$addjturl;
		}else{
			$imgurl=$addjturl;
		}
	}
	$sydata['imgurl']=$imgurl;
	$sydata['downurl']=$ddownurl;
	$sydata['iosdownurl']=$iosddownurl;
	if($_POST['appid']){
		if($tags){
			foreach($tags as $k=>$v){
				$sql="select * from tag_app where tagid='".$v."' and appid='".$_POST['appid']."'";
				$query=$_SGLOBAL['db']->query($sql);
				$istag=$_SGLOBAL['db']->fetch_array($query);
				if(!$istag){
					$sql="insert into tag_app (tagid,appid) values ('".$v."','".$_POST['appid']."')";
					$_SGLOBAL['db']->query($sql);
				}
				$ids.=$v.",";
			}
			$id = rtrim($ids,",");
			$sql = "delete from ".tname('tag_app')." where appid='".$_POST['appid']."' and tagid not in($id)";
			$query = $_SGLOBAL['db']->query($sql);
		}
		
		updatetable("appinfo",$syinfo,array("id"=>$_POST['appid']));
		updatetable("handgameinfo",$sydata,array("appid"=>$_POST['appid']));
		$appid=$_POST['appid'];
	}else{
		$syinfo['dateline']=time();
		$appid=inserttable("appinfo",$syinfo,1);
		$sydata['appid']=$appid;
		inserttable("handgameinfo",$sydata);
		if($tags){
			foreach($tags as $k=>$v){
				$sql="insert into tag_app (tagid,appid) values ('".$v."','".$appid."')";
				$_SGLOBAL['db']->query($sql);
			}
		}
	}
	if($syinfo['adpictureurl']){
		$record[$appid]['id']=$appid;
		$record[$appid]['pic']=$syinfo['adpictureurl'];
		if($_SCONFIG['allowrewrite']){
			$record[$appid]['url']=$_SCONFIG['sysiteurl']."/index-appdetail-id-".$appid.$rewriteend;
			$record[$appid]['murl']=$_SCONFIG['sysiteurl']."/mobile/appdetail-id-".$appid.$rewriteend;
		}else{
			$record[$appid]['url']=$_SCONFIG['sysiteurl']."/index.php?ac=appdetail&id=".$appid;
			$record[$appid]['murl']=$_SCONFIG['sysiteurl']."/mobile.php?ac=appdetail&id=".$appid;
		}
		$record[$appid]['dateline']=$syinfo['dateline'];
		recordadpic('shouyou','web',"7",$record);
	}
	if($syinfo['wapadpic']){
		$record[$appid]['id']=$appid;
		$record[$appid]['pic']=$syinfo['wapadpic'];
		if($_SCONFIG['allowrewrite']){
			$record[$appid]['url']=$_SCONFIG['sysiteurl']."/index-appdetail-id-".$appid.$rewriteend;
			$record[$appid]['murl']=$_SCONFIG['sysiteurl']."/mobile/appdetail-id-".$appid.$rewriteend;
		}else{
			$record[$appid]['url']=$_SCONFIG['sysiteurl']."/index.php?ac=appdetail&id=".$appid;
			$record[$appid]['murl']=$_SCONFIG['sysiteurl']."/mobile.php?ac=appdetail&id=".$appid;
		}
		$record[$appid]['dateline']=$syinfo['dateline'];
		recordadpic('shouyou','wap',"3",$record);
	}
	if($recordpicinfos){
		//unset($recordpicinfos[web][shouyou][$appid]);
		$nrecordpicinfos=str_replace("\\","*",json_encode($recordpicinfos));
		$sql="update config set datavalue='".$nrecordpicinfos."' where var ='recordadpic'";
		$_SGLOBAL['db']->query($sql);
	}
	$datafile=S_ROOT."/data/data_config.php";
	if($datafile){
		@unlink($datafile);
	}
	showmessage("更新成功","admincp.php?ac=syapp");
}elseif($op=="deladpic" || $op=="adpictureurl"){
	$id=intval($_GET['id']);
	if($id){
		$sql="select adpictureurl,wapadpic from appinfo where id='".$id."'";
		$dadpicpath=$_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query($sql));
		if(substr($dadpicpath['adpictureurl'],0,11)=="/attachment"){
			$delf=S_ROOT.$dadpicpath['adpictureurl'];
			if($delf){
				@unlink($delf);
			}
		}
		if(substr($dadpicpath['wapadpic'],0,11)=="/attachment"){
			$delwapf=S_ROOT.$dadpicpath['wapadpic'];
			if($delwapf){
				@unlink($delwapf);
			}
		}
		$sql="update appinfo set adpictureurl='',wapadpic='' where id=$id";
		$_SGLOBAL['db']->query($sql);
		if($newaddata){
			unset($newaddata[web][shouyou][$id]);
			unset($newaddata[wap][shouyou][$id]);
			$nrecordpicinfos=str_replace("\\","*",json_encode($newaddata));
			$sql="update config set datavalue='".$nrecordpicinfos."' where var ='recordadpic'";
	  	    $_SGLOBAL['db']->query($sql);
		}
		$datafile=S_ROOT."/data/data_config.php";
		if($datafile){
			@unlink($datafile);
		}
		$refer=$_SERVER['HTTP_REFERER'];
		echo "<script>window.location.href='".$refer."';</script>";
	}
	exit;
}elseif($op=="deldlogo"){
	$id=intval($_GET['id']);
	if($id){
		$sql="select dlogo from handgameinfo where appid='".$id."'";
		$dlogopath=$_SGLOBAL['db']->result($_SGLOBAL['db']->query($sql), 0);
		if(substr($dlogopath,0,11)=="/attachment"){
			$delf=S_ROOT.$dlogopath;
			if($delf){
				@unlink($delf);
			}
		}
		$sql="update handgameinfo set dlogo='' where appid='".$id."'";
		$_SGLOBAL['db']->query($sql);
		$refer=$_SERVER['HTTP_REFERER'];
		echo "<script>window.location.href='".$refer."';</script>";
	}
	exit;
}elseif($op=="delwapad"){
	$id=intval($_GET['id']);
	if($id){
		$sql="select wapadpic from appinfo where id='".$id."'";
		$dwapadpicpath=$_SGLOBAL['db']->result($_SGLOBAL['db']->query($sql), 0);
		if(substr($dwapadpicpath,0,11)=="/attachment"){
			$delf=S_ROOT.$dwapadpicpath;
			if($delf){
				@unlink($delf);
			}
		}
		$sql="update appinfo set wapadpic='' where id='".$id."'";
		$_SGLOBAL['db']->query($sql);
		if($newaddata){
			unset($newaddata[wap][shouyou][$id]);
			$nrecordpicinfos=str_replace("\\","*",json_encode($newaddata));
			$sql="update config set datavalue='".$nrecordpicinfos."' where var ='recordadpic'";
	  	    $_SGLOBAL['db']->query($sql);
		}
		$datafile=S_ROOT."/data/data_config.php";
		if($datafile){
			@unlink($datafile);
		}
		$refer=$_SERVER['HTTP_REFERER'];
		echo "<script>window.location.href='".$refer."';</script>";
	}
	exit;
}elseif($op=="caozuo"){
	if($_POST['verifysubmit']){	
		$idss=$_POST[ids];
		if(!$idss){
			showmessage("您还没选择要审核的应用","admincp.php?ac=syapp");
		}
		$id = implode(",",$idss);
		$sql = "update  ".tname('appinfo')." set isverify=1 where id in($id)";
		$query = $_SGLOBAL['db']->query($sql);
		delete_memcached();
		showmessage("审核成功",$_SERVER['HTTP_REFERER']);
	}
	if($_POST['nolocksubmit']){	
		$idss=$_POST[ids];
		if(!$idss){
			showmessage("您还没选择要解锁的应用","admincp.php?ac=wphone");
		}
		$id = implode(",",$idss);
		$sql = "update  ".tname('appinfo')." set isupdate=0 where id in($id)";
		$query = $_SGLOBAL['db']->query($sql);
		delete_memcached();
		showmessage("取消锁定操作成功",$_SERVER['HTTP_REFERER']);
	}
	if($_POST['qxrecomsubmit']){
		$idss=$_POST[ids];
		if(!$idss){
			showmessage("您还没选择要取消推荐的应用","admincp.php?ac=syapp");
		}
		$id = implode(",",$_POST[ids]);
		$sql = "update  ".tname('appinfo')." set isrecommend=0 where id in($id)";
		$query = $_SGLOBAL['db']->query($sql);
		delete_memcached($_SC['siteid']."_syapp");
		showmessage("批量取消推荐成功",$_SERVER['HTTP_REFERER']);
	}
	if($_POST['alternum']){
		$appnum=$_POST['appnum'];
		foreach($appnum as $key=>$value){
			$sql = "update  ".tname('appinfo')." set viewnum='".$value['viewnum']."',downloadcount='".$value['downloadcount']."' where id='".$key."'";	
			$query = $_SGLOBAL['db']->query($sql);
			delete_memcached($_SC['siteid']."_syinfo");
		}
		showmessage("成功保存当前点击数和下载数；",$_SERVER['HTTP_REFERER']);
		
	}
	if($_POST['insertsub']){	
		$idss=$_REQUEST[ids];
		$appnum=count($idss);
		//$id = implode(",",$idss);
		$subids=$_REQUEST[subid];
		//$subid = implode(",",$subids);
		for($i=0;$i<count($subids);$i++){
			$num=0;
			for($k=0;$k<count($idss);$k++){
				$sql1="select * from subject_app where appid=$idss[$k] and subjectid=$subids[$i]";	
				$result=$_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query($sql1));
				if($result){
					continue;
				}
				$num++;
				$sql = "insert into ".tname('subject_app')." (appid,subjectid) values ('$idss[$k]','$subids[$i]')";
				$query = $_SGLOBAL['db']->query($sql);
			}			
			$sql2="update subject set appnum=appnum+$num where id=$subids[$i]";
			$query=$_SGLOBAL['db']->query($sql2);
		}
		delete_memcached($_SC['siteid']."_subject_app");
		showmessage("添加成功",$_SERVER['HTTP_REFERER']);
	}
	if($_POST['prodsub']){
		$idss=$_REQUEST[ids];
		$subjectinfo= $_REQUEST['subjectinfo'];
		$subjectinfo['appnum']=count($idss);
		if(empty($subjectinfo[subjectname])){
			showmessage('专辑名称不能为空！', $_SERVER['HTTP_REFERER']);
		}
		//if(empty($subjectinfo['summary'])){
		//	showmessage('专辑简介不能为空！', $_SERVER['HTTP_REFERER'],1);
		//}
		
		$sql = "select id from ".tname('subject')." where subjectname='".$subjectinfo[subjectname]."' limit 1";
		$query = $_SGLOBAL['db']->query($sql);
		if($_SGLOBAL['db']->num_rows($query) !== 0){
			showmessage('专辑已经存在！', $_SERVER['HTTP_REFERER']);
		}
		if($_FILES['subjectpic']['name']){
			$addsubjectpic="subject/subjectpic";
			$subjectinfo['subjectpic']=pic($addsubjectpic,"subjectpic",-1);
		}
		if($_FILES['logo']['name']){
			$addlogo="subject/logo";
			$subjectinfo['logo']=pic($addlogo,"logo",-1);
		}if($_FILES['slogo']['name']){
			$addslogo="subject/slogo";
			$subjectinfo['slogo']=pic($addslogo,"slogo",-1);
		}
		$sid=inserttable("subject",$subjectinfo,1);
		if($idss){
			//添加专辑应用
			for($i=0;$i<count($idss);$i++){
				$sql = "insert into ".tname('subject_app')." (subjectid,appid) values('$sid','$idss[$i]')";
				$query = $_SGLOBAL['db']->query($sql);
			}
			
			if($_SCONFIG['ismemcache'] && $_SGLOBAL['mc']){
				delete_memcached($_SC['siteid']."_subject");
				delete_memcached($_SC['siteid']."_gamesubject");
				$_SGLOBAL['mc']->delete($_SC['siteid']."_gamesubject_order_");
			}
			if($_SC['isSAE']){
				delete_memcached();
			}
			subject_list();
			
			
		}
		showmessage('添加专辑成功！',$_SERVER['HTTP_REFERER'],1);
	}
	
	if($_POST['qxrecomsubmit']){
		$idss=$_POST[ids];	
		if(!$idss){
			showmessage("您还没选择要取消推荐的应用","admincp.php?ac=syapp");
		}
		$id = implode(",",$idss);
		$sql = "update  ".tname('appinfo')." set isrecommend=0 where id in($id)";
		$query = $_SGLOBAL['db']->query($sql);
		delete_memcached($_SC['siteid']."_syapp");
		showmessage("取消推荐成功",$_SERVER['HTTP_REFERER']);
	}
	if($_POST['submitaddtime']){
		$idss=$_POST[ids];
		if(!$idss){
			showmessage("您还没选择要更新的应用","admincp.php?ac=syapp");
		}	
		$id = implode(",",$idss);
		$sql = "update  ".tname('appinfo')." set dateline=".$_SGLOBAL['timestamp']." where id in($id)";
		$query = $_SGLOBAL['db']->query($sql);
		delete_memcached($_SC['siteid']."_syinfo");
		showmessage("更新发布时间成功",$_SERVER['HTTP_REFERER']);
	}
	if($_POST['recomsubmit']){	
		$idss=$_POST[ids];
		if(!$idss){
			showmessage("您还没选择要推荐的应用","admincp.php?ac=syapp");
		}
		$id = implode(",",$idss);
		$sql = "update  ".tname('appinfo')." set isrecommend='1' where id in($id)";
		$query = $_SGLOBAL['db']->query($sql);
		delete_memcached($_SC['siteid']."_appinfo");
		showmessage("批量推荐成功",$_SERVER['HTTP_REFERER']);
	}
	if($_POST['addsubj']){	
		showmessage("传送成功",$_SERVER['HTTP_REFERER']);
	}
	if($_POST['batchsubmit']){
		@set_time_limit(0);
		$idss = $_POST[ids];
		$ids="";
		if(!is_array($idss)){
			showmessage("您还没选择要删除的应用","admincp.php?ac=syapp");
		}
		$serverurl=$_SCONFIG['serverurl'];
		$siteid=$_SCONFIG['siteid'];
		$key=$_SCONFIG['key'];
		foreach($idss as $val){
			$sql="select * from ".tname('appinfo')." where id=".$val;
			$query=$_SGLOBAL['db']->query($sql);
			$value=$_SGLOBAL['db']->fetch_array($query);
			if($value['isdownloadlogo']==1){
				$logofile=S_ROOT.$value['logo'];
				if($logofile){
					unlink($logofile);
				}
			}
			$dsql="select imgurl from handgameinfo where appid='".$value[id]."'";
			$dquery=$_SGLOBAL['db']->query($dsql);
			$andrvalue=$_SGLOBAL['db']->fetch_array($dquery);
			$filepics=explode("@@@",$andrvalue[imgurl]);
			foreach($filepics as $dkey=>$dval){
				$filepic=S_ROOT.$dval;
				if($filepic){
					unlink($filepic);
				}
			}
			
			if($value['serverid']){
				$delurl=$serverurl."/serverapi.php?ac=appserver&op=del&siteid=".$siteid."&key=".$key."&gameid=".$value['serverid']."&subtype=".$value['subtype'];	
				$serurl=$serverurl."/serverapi.php";
				$arr=array("ac"=>"appserver","op"=>"del","siteid"=>$siteid,"key"=>$key,"gameid"=>$value['serverid'],"subtype"=>$value['subtype']);
				if(function_exists("curl_init")){
					$insertjsons=$catalogjson=gethtml($serurl,$arr);
				}else{
					$insertjsons=file_get_contents($delurl);
				}	
			}
			
			$sql = "select subjectid from ".tname('subject_app')." where appid='$val'";
			$query = $_SGLOBAL['db']->query($sql);
			while ($values = $_SGLOBAL['db']->fetch_array($query)){
				$subject_ids[] = $values['subjectid'];
			}
			$ids.=$val.",";	
			if($newaddata){
				unset($newaddata[web][shouyou][$val]);
				unset($newaddata[wap][shouyou][$val]);
				$nrecordpicinfos=str_replace("\\","*",json_encode($newaddata));
				$sql="update config set datavalue='".$nrecordpicinfos."' where var ='recordadpic'";
				$_SGLOBAL['db']->query($sql);
			}
											
		}

		if(!empty($subject_ids)){
			foreach ($subject_ids as $gid){
				$sql = "update ".tname('subject')." set appnum=appnum-1 where id ='$gid'";
				$query = $_SGLOBAL['db']->query($sql);
			}
		}
		$id = rtrim($ids,",");
		$sql = "delete from ".tname('appinfo')." where id in($id)";
		$query = $_SGLOBAL['db']->query($sql);
		$sql = "delete from ".tname('handgameinfo')." where appid in($id)";
		$query = $_SGLOBAL['db']->query($sql);
		//删除关联表
		$sql = "delete from ".tname('new_app')." where appid in ($id)"; 
		$query = $_SGLOBAL['db']->query($sql);
		$sql = "delete from " .tname('subject_app')." where appid in($id)";
		$query = $_SGLOBAL['db']->query($sql);
		if($query){
			$datafile=S_ROOT."/data/data_config.php";
			if($datafile){
				@unlink($datafile);
			}	
			delete_memcached($_SC['siteid']);
			showmessage('批量删除成功', $_SERVER['HTTP_REFERER'],1);
		}	
	}
	if($_POST['zhuanyisubmit']){
		$idss = $_POST[ids];
		$apptype2=$_POST[apptype2]?$_POST[apptype2]:0;
		$cateid2=$_POST[appinfo]?$_POST[appinfo]:0;
		$categoryid2=$cateid2[categoryid];
		if(!is_array($idss)){
			showmessage("您还没选择要转移的应用",$_SERVER['HTTP_REFERER']);
		}
		if($apptype2=="0"){
			showmessage("请给选中的应用选择类型（游戏,软件）。",$_SERVER['HTTP_REFERER'],2);
		}
		if($categoryid2==0){
			showmessage("请给选中的应用选择栏目。",$_SERVER['HTTP_REFERER'],2);
		}
		$id = implode(",",$idss);
		$sql = "update  ".tname('appinfo')." set apptype='".$apptype2."',categoryid='".$categoryid2."' where id in($id)";
		$query = $_SGLOBAL['db']->query($sql);
		showmessage("选择的数据转移成功。",$_SERVER['HTTP_REFERER']);
	}
	if($_POST['add_subject']){
		$subject_ids = $_POST['subject_id'] ;
		$app_id= $_POST['ids'] ;
		$subject_ids=array_unique ($subject_ids);
		//检查专辑里是否游戏存在
		foreach($subject_ids as $sid){
			$i=0;
			foreach($app_id as $aid){
				$sql = "select subjectid from ".tname('subject_app')." where appid='$aid' and subjectid='$sid' limit 1";
				$query = $_SGLOBAL['db']->query($sql);
				if($_SGLOBAL['db']->num_rows($query) !== 0 ){
					
				}else{
					$app_ids[$sid][$i]=$aid;
				}
				$i++;
			}
		}
		if(!empty($subject_ids)){
			foreach($subject_ids as $sid){
				$appnum = count($app_ids[$sid]);
				foreach($app_ids[$sid] as $aid){
					$sql = "insert into ".tname('subject_app')." (appid,subjectid) values('$aid','$sid')";
					$query = $_SGLOBAL['db']->query($sql);
					
				}
				$sql = "update ".tname('subject')." set appnum=appnum+$appnum where id='$sid'";
				$query = $_SGLOBAL['db']->query($sql);
			}
		}
		
		if($_SCONFIG['ismemcache'] && $_SGLOBAL['mc']){
			$_SGLOBAL['mc']->delete($_SCONFIG['siteid']."_subject");		
			$_SGLOBAL['mc']->delete($_SCONFIG['siteid']."_gamesubject_order_gamenum");
			$_SGLOBAL['mc']->delete($_SCONFIG['siteid']."_gamesubject_order_clicknum");
		}
		delete_memcached($_SCONFIG['siteid']."_subject");
		delete_memcached($_SCONFIG['siteid']."_gamesubject_order_");
		if($_SC['isSAE']){
			delete_memcached();
		}
		showmessage('专辑批量处理成功', $_SERVER['HTTP_REFERER'],1);
	}
}
$dangqianname=$ac."list";
$dangqian=array($dangqianname=>'class=dangqian');
include_once template($ac."_".$op);
function subject_list(){
	global $_SGLOBAL;
	$sql = "select id,subjectname,type,subtype from ".tname('subject');
	$query = $_SGLOBAL['db']->query($sql);
	while($value = $_SGLOBAL['db']->fetch_array($query)) {
		$subject_list[] = $value;
	} 
	foreach($subject_list as $key=>$val){
		$subject_lists[$val[type]][$val[subtype]][$val[id]] =  $val[subjectname];
	}		
	cache_write('subject','_subject_list', $subject_lists);
}
?>