<?php
header("Content-type:text/html;charset=utf-8");
$page=$_GET['page']?intval($_GET['page']):'1';
//即将开服
$urled="http://fahao.4399.cn/ajax/kaifu-p-".$page."-type-2.html";
$js_infoed=file_get_contents($urled);
$infoed=json_decode($js_infoed,true);
if($page-1<$infoed['result']['pagecount']){
	if($infoed['result']['data']){
		foreach($infoed['result']['data'] as $key => $value){
			$sql="select id from opengame where gamename='".$value['game_name']."' and addressnum='".$value['name']."' and useplatform='".$value['dev_name']."'";
			$isinfo=$_SGLOBAL['db']->result($_SGLOBAL['db']->query($sql),0);
			if($isinfo){
				//**********
			}else{
				$sql="select id from appinfo where name='".$value['game_name']."' and isverify='1'";
				$appid=$_SGLOBAL['db']->result($_SGLOBAL['db']->query($sql),0);
				if($appid){
					$cjserver['gamename']=$value['game_name'];
					$cjserver['starttime']=$value['start'];
					$cjserver['appid']=$appid;
					$cjserver['isverify']='0';
					$cjserver['gameurl']="";
					if($value['platform'][0]=="android"){
						$cjserver['isandroid']='1';
					}
					if($value['platform'][0]=="ios"){
						$cjserver['isios']='1';
					}
					$cjserver['dateline']=time();
					$cjserver['addressnum']=$value['name'];
					$cjserver['useplatform']=$value['dev_name'];
					$nid=inserttable("opengame",$cjserver,true);
				}
			}
		}
	}
}else{
	echo "4399开服信息采集完毕";
	exit();
}
$page=$page+1;
echo "正在采集中...,当前页数".$page;
echo "<script>window.location.href='/index.php?ac=cj_4399server&page=".$page."';</script>";
exit;
?>