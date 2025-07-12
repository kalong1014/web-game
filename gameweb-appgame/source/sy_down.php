<?php
if(!defined('IN_YYJIA')) {
	exit('Access Denied');
}
	$id=intval($_GET['id']);
	$devid=intval($_GET['k']);
	$type=$_GET['type'];
	echo $id."||";
	echo $devid."||";
	echo $type."||";die();
	if($id){
		$sql="select downloadcount from appinfo where id=".$id;
		$downnums=$_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query($sql));
		$downnum=$downnums['downloadcount']+1;
		$sql="update appinfo set downloadcount='".$downnum."' where id=".$id;
		$_SGLOBAL['db']->query($sql);
		
		if($_SGLOBAL['supe_uid']){
			$sql1="select * from user_data where zxid=".$id;
			$dwappinfo=$_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query($sql1));
			if(!$dwappinfo){
					$dwsql="insert into user_data (uid,zxid,type,dateline) values('".$_SGLOBAL['supe_uid']."','".$id."','1','".time()."')";
					$_SGLOBAL['db']->query($dwsql);
			}
		}
		
		$sql="select * from handgameinfo where appid=".$id;
		$appinfo=$_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query($sql));
		if($devid){
			if($type=="android"){
				$t="1";
			}else{
				$t="2";
			}
			$dwsql="select downurl from platform_downurl where appid='".$id."' and devid='".$devid."' and type='".$t."'";
			$sdownurl = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($dwsql), 0);
			echo $sdownurl;die();
			header("Location:".$sdownurl);		
		}else{
			if($type=="android"){
				$sydsql="select downurl as dw from handgameinfo where appid='".$id."'";
			}else{
				$sydsql="select iosdownurl as dw from handgameinfo where appid='".$id."'";
			}
			$appinfo=$_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query($sydsql));
			if($appinfo['dw']){
				$downurls=explode("@@@",$appinfo['dw']);
				$kk=0;
				foreach($downurls as $k1=>$v){
					if($k1%2==1){
						$durl[$kk]['name']=$v;
						$kk++;
					}else{
						if(strstr($v,"http")){
						}else{
							$v=$_SC['siteurl']."/".$v;	
						}	
						$durl[$kk]['url']=$v;
					}
				}
				
				if($k==0){
					if($downurls[0]){
						if(strstr($downurls[0],"http")){
						}else{
							$downurls[0]=$_SC['siteurl']."/".$downurls[0];		
						}
						
						header("Location:".$downurls[0]);	
					}elseif($downurls[2]){
						if(strstr($downurls[2],"http")){
						}else{
							$downurls[2]=$_SC['siteurl']."/".$downurls[2];		
						}
						
						
						header("Location:".$downurls[2]);	
					}
				}else{
						
	
						header("Location:".$durl[$k]['url']);		
				}
		    }
			
		}
	}
	exit;
?>