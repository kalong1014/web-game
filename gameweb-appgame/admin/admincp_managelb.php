<?php
if(!defined('IN_YYJIA')) {
	exit('Access Denied');
}
$op=$_REQUEST[op]?$_REQUEST[op]:'list';
$perpage=$_POST['perpage']?$_POST['perpage']:30;
$page=$_REQUEST['page']?$_REQUEST['page']:1;
$orderby=$_POST['orderby']?$_POST['orderby']:"dateline";
$packname=$_POST['packname']?$_POST['packname']:"";
$mpurl.="&packname=".$packname;

$isverify=isset($_REQUEST['isverify'])?$_REQUEST['isverify']:'0';
$time = $_REQUEST['time']?$_REQUEST['time']:0;
$mpurl="admincp.php?ac=managelb&op=list&time=$time";
$mpurl.="&isverify=".$isverify;
//认证信息
$devsql="select * from developer where uid='".$_SGLOBAL['supe_uid']."'";
$devquery=$_SGLOBAL['db']->query($devsql);
$devinfo=$_SGLOBAL['db']->fetch_array($devquery);
//添加记录
$sql="select appinfo.name,packs.appid from packs,appinfo where packs.appid=appinfo.id and packs.uid='".$_SGLOBAL['supe_uid']."' group by packs.appid order by packs.dateline desc";
$que=$_SGLOBAL['db']->query($sql);
while($value=$_SGLOBAL['db']->fetch_array($que)){
	$ugames[]=$value;
}

$appids=$_GET['appids']?intval($_GET['appids']):'';

$where="where 1=1 ";
if($isverify){
	if($isverify=="2"){
		$where.=" and isverify=0";
	}else{
		$where.=" and isverify=".$isverify;
	}
}

if($packname){
	$where.=" and packname like '%".$packname."%' ";
}else{
	$where.="";
}
if($page<1) $page=1;
$start = ($page-1)*$perpage;
if($op=="list"){
	//
	$nowtime=time();
	$isverify = $_GET[verify]?$_GET[verify]:0;
	$csql="select count(*) from packs ".$where;
	if($time){
		if($time=="1"){
			$where.=" and endtime<$nowtime ";
		}elseif($time=="2"){
			$where.=" and endtime>$nowtime ";
		}
	}
	$num = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($csql),0);	
	$sql="select * from packs ".$where." order by dateline desc limit ".$start.",".$perpage;
	$query=$_SGLOBAL['db']->query($sql);
	while($value=$_SGLOBAL['db']->fetch_array($query)){
		
			$namesql="select name from appinfo where id=".$value['appid'];		
			$gamename=$_SGLOBAL['db']->result($_SGLOBAL['db']->query($namesql),0);
			if($value['useplatform']==""){
				$value['useplatform']=$devinfo['platform'];
			}
			$value['gamename']=$gamename;
			$allcardsql="select count(*) from pack_card where pid='".$value[packid]."'";
			$allcardcount = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($allcardsql),0);
			$cardsql="select count(*) from pack_card where statue='0' and pid='".$value[packid]."'";
			$cardcount = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($cardsql),0);
			$value['allcard']=$allcardcount;
			$value['leftcard']=$cardcount;
			$packinfo[]=$value;
	}
	$mpurl ="admincp.php?ac=managelb&op=list&isverify=$isverify"; //4.25修改审核
	$multi=multi2($num, $perpage, $page, $mpurl);
}elseif($op=="addpack"){
	$packid=intval($_GET['packid']);
	if($packid){
		$sql="select * from packs where packid='".$packid."'";
		$query=$_SGLOBAL['db']->query($sql);
		$packinfo=$_SGLOBAL['db']->fetch_array($query);
		$sql="select name as gamename from appinfo where id=$packinfo[appid]";
		$query=$_SGLOBAL['db']->query($sql);
		$sinfo=$_SGLOBAL['db']->fetch_array($query);
		$packinfo['sinfo']=$sinfo;
		$sql="select * from opengame where devid='".$devinfo[devid]."' group by gamename";
		$query=$_SGLOBAL['db']->query($sql);
		while($value=$_SGLOBAL['db']->fetch_array($query)){
			$upgames[]=$value;
		}
	}
}elseif($op=="savepack"){
	$getplatname=$_REQUEST['getplatname']?intval($_REQUEST['getplatname']):'';
	$time=time();
	if($getplatname){
		$sql="select useplatform from packs where uid='".$_SGLOBAL['supe_uid']."' group by useplatform order by dateline desc ";
		$query=$_SGLOBAL['db']->query($sql);
		while($value=$_SGLOBAL['db']->fetch_array($query)){
			$info[platname][]=$value;
		}
		echo json_encode($info);die();
	}
	if($_POST['packsubmit']){
		$lbinfo=$_POST[lbinfo];
		$gamename=$_POST['gamename'];
		if($lbinfo['starttime']==""){
			$lbinfo['starttime']=$time;
		}else{
			$lbinfo['starttime']=strtotime($lbinfo['starttime']);
		}
		if($_POST['starthour']){
			$lbinfo['starttime']+=$_POST['starthour']*3600;
		}
		if($lbinfo['endtime']==""){
			$lbinfo['endtime']=$time+3600*24*365;
		}else{
			$lbinfo['endtime']=strtotime($lbinfo['endtime']);
		}
		if($_POST['endhour']){
			$lbinfo['endtime']+=$_POST['endhour']*3600;
		}
		if($gamename==""){
			showmessage("游戏名称不能为空,请填写游戏名称",$_SERVER['HTTP_REFERER']);
		}
		if($lbinfo[useplatform]==""){
			showmessage("运营平台不能为空,请填写运营平台名称",$_SERVER['HTTP_REFERER']);
		}
		if($lbinfo[addressnum]==""){
			showmessage("服务名不能为空,请填写",$_SERVER['HTTP_REFERER']);
		}elseif($lbinfo[addressnum]=="all"){
			$lbinfo[addressnum]==0;
		}
		if($_FILES['packlogo']['name']){
			$dir="packlogo";
			$lbinfo['packlogo']=pic($dir,'packlogo',-1);
			
		}
		$lbinfo['isverify']="0";
		$lbinfo['dateline']=$time;
		$lbinfo['devid']=$devinfo['devid'];
		$lbinfo['uid']=$_SGLOBAL['supe_uid'];
		if(!$lbinfo['isandroid']){
			$lbinfo['isandroid']="0";
		}
		if(!$lbinfo['isios']){
			$lbinfo['isios']="0";
		}
		
		if($_POST['packid']){
			$packid=intval($_POST['packid']);
			$where=" packid=".$packid;
			
			if($_FILES['pack']['name']){
				$dir="pack";
				$ddurl=uploadfile($dir,'pack',-1,$packid);
			}
			updatetable("packs",$lbinfo,$where);
			showmessage("您的礼包信息更新成功","admincp.php?ac=managelb");	
		}
		$sql="select * from packs where packname='".$lbinfo[packname]."' and devid='".$devinfo[devid]."' and isandroid='".$lbinfo[isandroid]."' and isios='".$lbinfo[isios]."' and serverid='".$lbinfo[serverid]."'";
		$query=$_SGLOBAL['db']->query($sql);
		$isinfo=$_SGLOBAL['db']->fetch_array($query);
		if($isinfo){
			showmessage("您已经发布了礼包信息","admincp.php?ac=managelb");
		}else{
			$packid=inserttable("packs",$lbinfo,1);
			if($packid){
				if($_FILES['pack']['name']){
					$dir="pack";
					$ddurl=uploadfile($dir,'pack',-1,$packid);
				}
			}
			showmessage("发布成功","admincp.php?ac=managelb");
		}
	}
}elseif($op=="packtype"){

	if($_POST['addptype']){
		$pinfo=$_POST['packtype'];
		if($pinfo['bianhao']=="" || $pinfo['name']==""){
			showmessage("输入的值不能为空，请重新输入",$_SERVER['HTTP_REFERER']);
		}
		if($ptypeinfo[$pinfo['bianhao']]){
			showmessage("该编号已经存在，请用其他编号",$_SERVER['HTTP_REFERER']);
		}else{
			$ptypeinfo[$pinfo['bianhao']]=$pinfo['name'];

			$ptypeinfos=json_encode($ptypeinfo);
			$ptypeinfos=explode(',',$ptypeinfos);
			$ptypeinfos=str_replace('\\','&',$ptypeinfos);
			$ptypeinfos=implode(',',$ptypeinfos);
			if($_SCONFIG['packtype']){
				$sql="update config set datavalue='".$ptypeinfos."' where var='packtype' ";
			}else{
				$sql="insert into config (var,datavalue) values ('packtype','".$ptypeinfos."')";
			}
			$_SGLOBAL['db']->query($sql);
			$datafile=S_ROOT."/data/data_config.php";
			if($datafile){
				@unlink($datafile);
			}
			$refer=$_SERVER['HTTP_REFERER'];
			echo "<script>window.location.href='".$refer."';</script>";
		}
	}
	if($_GET['d']=="del"){
		$bianhao=intval($_GET['bianhao']);
		if($bianhao){
			$sql="select packid from packs where packtype='".$bianhao."'";
			$isinfo = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($sql),0);
			if($isinfo){
				showmessage("改类型下还有数据,先转移或者删除数据，在删除该类型",$_SERVER['HTTP_REFERER']);	
			}
			unset($ptypeinfo[$bianhao]);
			$ptypeinfos=json_encode($ptypeinfo);
			$ptypeinfos=explode(',',$ptypeinfos);
			$ptypeinfos=str_replace('\\','&',$ptypeinfos);
			$ptypeinfos=implode(',',$ptypeinfos);
			$sql="update config set datavalue='".$ptypeinfos."' where var='packtype' ";
			$_SGLOBAL['db']->query($sql);
			$datafile=S_ROOT."/data/data_config.php";
			if($datafile){
				@unlink($datafile);
			}
			$refer=$_SERVER['HTTP_REFERER'];
			echo "<script>window.location.href='".$refer."';</script>";
		}
	}elseif($_GET['d']=="move"){
		$oldbh=intval($_GET['oldbh']);
		$newbh=intval($_GET['newbh']);
		$sql="update packs set packtype='".$newbh."' where packtype='".$oldbh."'";
		$_SGLOBAL['db']->query($sql);
		showmessage("转移成功","admincp.php?ac=managelb&op=packtype");
	}
	if($_POST['alterpname']){
		$alterptype=$_POST['alterptype'];
		if($alterptype){
			foreach($alterptype as $k=>$v){
				$newpacktype[$k]=$v;
			}
			$newpacktype=json_encode($newpacktype);
			$newpacktype=explode(',',$newpacktype);
			$newpacktype=str_replace('\\','&',$newpacktype);
			$newpacktype=implode(',',$newpacktype);
			$sql="update config set datavalue='".$newpacktype."' where var='packtype' ";
			$_SGLOBAL['db']->query($sql);
			$datafile=S_ROOT."/data/data_config.php";
			if($datafile){
				@unlink($datafile);
			}
			$refer=$_SERVER['HTTP_REFERER'];
			echo "<script>window.location.href='".$refer."';</script>";
		}
	}
}elseif($op=="verify"){
	$id=intval($_GET['packid']);
	if($id){
		$sql="update packs set isverify=1 where packid=$id";
		$_SGLOBAL['db']->query($sql);
		$packurl=S_ROOT."/attachment/pack/$id.txt";
		$time=time();
		if($packurl){
				$pinfo=file_get_contents($packurl);
			//	$pinfo=iconv("GBK", "utf-8",file_get_contents($packurl)); //更新礼包能上传中文
				$pinfos=explode("\n",$pinfo);
				if(count($pinfos)<2){
					$pinfos=explode("	",$pinfo);
				}
				$cardinfo['dateline']=$time;
				$cardinfo['pid']=$id;
				$cardinfo['isverify']=1;
				foreach($pinfos as $key=>$value){
					$cardinfo['card']=trim($value);
					if($cardinfo['card']){
						$pcsql="select id from pack_card where pid='".$id."' and card='".$cardinfo['card']."'";
						$pcinfo=$_SGLOBAL['db']->result($_SGLOBAL['db']->query($pcsql),0);
						if($pcinfo){
							$pcsql2="update pack_card set isverify='1' where pid='".$id."' and card='".$cardinfo['card']."'";
							$_SGLOBAL['db']->query($pcsql2);
						}else{
							inserttable("pack_card",$cardinfo,1);
						}
					}
				}
		}
		$cresql="select * from credit_data where uploadtype='3' and uploadid='".$id."' and isverify='0'";
		$creinfo=$_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query($cresql));
		if($creinfo){
			$ucresql="update credit_data set isverify='1' where id='".$creinfo['id']."'";
			$_SGLOBAL['db']->query($ucresql);
			if($creinfo[czreward]=="1"){
				$uinfosql="update user set count_credit=count_credit+".$creinfo[credit].",count_experience=count_experience+".$creinfo[experience]." where uid='".$creinfo['uid']."'";
			}else{
				$uinfosql="update user set count_credit=count_credit-".$creinfo[credit].",count_experience=count_experience-".$creinfo[experience]." where uid='".$creinfo['uid']."'";
			}
			$_SGLOBAL['db']->query($uinfosql);
		}
		$msql=" select packname,appid from packs where packid='".$id."'";
		$mpacks=$_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query($msql));
		if($mpacks['appid']){
			$nsql="select name from appinfo where id='".$mpacks['appid']."'";
			$gname=$_SGLOBAL['db']->result($_SGLOBAL['db']->query($nsql),0);
		}
		$ismsql="select id from send_message where packid='".$id."'";
		$isminfo=$_SGLOBAL['db']->result($_SGLOBAL['db']->query($ismsql),0);
		if(!$isminfo){
			$msg['message']="您好，【".$gname."】新增的$mpacks[packname]已上架";
			$msg['murl']="http://".$_SCONFIG[siteurl]."/index.php?ac=packdetail&packid=".$id."";
			$msg['packid']=$id;
			$mid=inserttable("send_message",$msg,1);
		}
		if($mid){
			$usql="select * from uid_appid";
			$uquery=$_SGLOBAL['db']->query($usql);
			while($uval=$_SGLOBAL['db']->fetch_array($uquery)){
				if($uval){
					$umsgsql="select uid from uid_msg where mid='".$mid."'";
					$isumsg=$_SGLOBAL['db']->result($_SGLOBAL['db']->query($umsgsql),0);
					if($isumsg){
					}else{
						$uid_msg['dateline']=time();
						$uid_msg['mid']=$mid;
						$uid_msg['uid']=$uval['uid'];
						$uid_msg['status']="0";
						inserttable("uid_msg",$uid_msg);
					}
				}
			}
		}
		$refer=$_SERVER['HTTP_REFERER'];
		echo "<script>window.location.href='".$refer."';</script>";
	}
	exit;
	
}elseif($op=="noverify"){
	$id=intval($_GET['packid']);
	if($id){
		$sql="update packs set isverify=0 where packid=$id";
		$_SGLOBAL['db']->query($sql);
		$sql="update pack_card set isverify=0 where pid='".$id."' and isverify='1'";
		$_SGLOBAL['db']->query($sql);
		$refer=$_SERVER['HTTP_REFERER'];
		echo "<script>window.location.href='".$refer."';</script>";
	}
	exit;
	
}elseif($op=="jzverify"){
	$id=intval($_GET['packid']);
	if($packid){
		$sql="update packs set isverify=2 where packid=$packid";
		$_SGLOBAL['db']->query($sql);
		$sql="update pack_card set isverify=0 where pid='".$id."' and isverify='1'";
		$_SGLOBAL['db']->query($sql);
		$refer=$_SERVER['HTTP_REFERER'];
		echo "<script>window.location.href='".$refer."';</script>";
	}
	exit;
}elseif($op=="liuyan"){
	$packid=intval($_GET['packid']);
	$message=$_GET['message'];
	if($packid){
		$sql="update packs set message='".$message."' where packid='".$packid."'";
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
}elseif($op=="recommend"){
	$id=intval($_GET['packid']);
	if($id){
		$sql="update packs set isrecommend=1 where packid=$id";
		$_SGLOBAL['db']->query($sql);
		$refer=$_SERVER['HTTP_REFERER'];
		echo "<script>window.location.href='".$refer."';</script>";
	}
	exit;
	
}elseif($op=="qxrecommend"){
	$id=intval($_GET['packid']);
	if($id){
		$sql="update packs set isrecommend=0 where packid=$id";
		$_SGLOBAL['db']->query($sql);
		$refer=$_SERVER['HTTP_REFERER'];
		echo "<script>window.location.href='".$refer."';</script>";
	}
	exit;
	
}elseif($op=="lbyl"){
	$id=intval($_GET['packid']);
	if($id){
		$lbfile=S_ROOT."attachment/pack/".$id.".txt";
		if($lbfile){
			$lbinfo=file_get_contents($lbfile);
			echo $lbinfo;die();
		}else{
			echo "没有相关礼包信息";
		}
	}else{
		showmessage("操作失败",$_SERVER['HTTP_REFERER']);
	}
	
}elseif($op=="packdel"){
	$id=intval($_GET['packid']);
	if($id){
		$sql = "delete from ".tname('packs')." where packid=$id";
		$query = $_SGLOBAL['db']->query($sql);
		$refer=$_SERVER['HTTP_REFERER'];
		echo "<script>window.location.href='".$refer."';</script>";
	}
	exit;
}elseif($op=="alertptype"){
	$packid=intval($_GET[pid]);
	$ptype=intval($_GET[tval]);
	if($packid && $ptype){
		$sql="update packs set packtype='".$ptype."' where packid='".$packid."'";
		$query = $_SGLOBAL['db']->query($sql);
		$refer=$_SERVER['HTTP_REFERER'];
		echo "<script>window.location.href='".$refer."';</script>";
	}
	exit;
}elseif($op=="caozuo"){
	if($_POST['batchsubmit']){
		@set_time_limit(0);
		$idss = $_POST[ids];
		$ids="";
		if(!is_array($idss)){
			showmessage("您还没选择要删除的开服信息","admincp.php?ac=managelb");
		}
		$ids=implode(",",$idss);
		$sql = "delete from ".tname('packs')." where packid in($ids)";
		$query = $_SGLOBAL['db']->query($sql);
		if($query){
			showmessage('批量删除成功', $_SERVER['HTTP_REFERER'],1);
		}	
	}
	if($_POST['qxrecomsubmit']){
		$idss=$_POST[ids];
		$ids="";
		if(!$idss){
			showmessage("您还没选择礼包信息","admincp.php?ac=managelb");
		}
		$ids=implode(",",$idss);
		$sql = "update  ".tname('packs')." set isrecommend=0 where packid in($ids)";
		$query = $_SGLOBAL['db']->query($sql);
		showmessage("批量取消推荐成功",$_SERVER['HTTP_REFERER']);
	}
	if($_POST['recomsubmit']){
		$idss=$_POST[ids];
		$ids="";
		if(!$idss){
			showmessage("您还没选择礼包信息","admincp.php?ac=managelb");
		}
		$ids=implode(",",$idss);
		$sql = "update  ".tname('packs')." set isrecommend=1 where packid in($ids)";
		$query = $_SGLOBAL['db']->query($sql);
		showmessage("批量推荐成功",$_SERVER['HTTP_REFERER']);
	}
	if($_POST['verifysubmit']){	
		$idss=$_POST[ids];
		if(!$idss){
			showmessage("您还没选择礼包信息","admincp.php?ac=managelb");
		}
		$ids=implode(",",$idss);
		$sql = "update  ".tname('packs')." set isverify=1 where packid in($ids)";
		$query = $_SGLOBAL['db']->query($sql);
		delete_memcached();
		showmessage("审核成功",$_SERVER['HTTP_REFERER']);
	}
	if($_POST['saveptype']){
		$pinfo=$_POST['packtypes'];
		if($pinfo){
			foreach($pinfo as $key=>$value){
				$sql="update packs set packtype='".$value."' where packid='".$key."'";
				$query = $_SGLOBAL['db']->query($sql);
			}
			$refer=$_SERVER['HTTP_REFERER'];
			echo "<script>window.location.href='".$refer."';</script>";
		}
	}
}
$multi=multi2($num, $perpage, $page, $mpurl);
include_once template($ac."_".$op);
?>