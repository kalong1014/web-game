<?php
header("Content-type:text/html;charset=utf-8");
$page=$_GET['page']?intval($_GET['page']):'1';
foreach($ttypeinfo as $k => $v){
	$ntesttype[$v[name]]=$k;
}
//即将开测
$url="http://fahao.4399.cn/ajax/kaice-p-".$page."-type-2.html";
$js_infoing=file_get_contents($url);
$infoing=json_decode($js_infoing,true);
if($page-1<$infoing['result']['pagecount']){
	if($infoing['result']['data']){
		foreach($infoing['result']['data'] as $key => $value){
			$sql="select id from testgame where gamename='".$value['game_name']."' and testtype='".$ntesttype[$value['name']]."'";
			$isinfo=$_SGLOBAL['db']->result($_SGLOBAL['db']->query($sql),0);
			if($isinfo){
				//**********
			}else{
				$sql="select id from appinfo where name='".$value['game_name']."' and type='4' and isverify='1'";
				$appid=$_SGLOBAL['db']->result($_SGLOBAL['db']->query($sql),0);
				if($appid){
					$cjtest['gamename']=$value['game_name'];
					$cjtest['starttime']=$value['start'];
					$cjtest['appid']=$appid;
					$cjtest['testtype']=$ntesttype[$value['name']];
					$cjtest['isverify']='0';
					$cjtest['gameurl']="";
					if($value['platform'][0]=="android"){
						$cjtest['isandroid']='1';
					}
					if($value['platform'][0]=="ios"){
						$cjtest['isios']='1';
					}
					$cjtest['dateline']=time();
					$cjtest['addressnum']="测试服";
					$cjtest['useplatform']=$value['dev_name'];
					$nid=inserttable("testgame",$cjtest,true);
				}
			}
		}
	}
}else{
	echo "4399开测信息采集完毕";
	exit();
}
//已经开测
/*$urled="http://fahao.4399.cn/ajax/kaice-p-".$page."-type-3.html";
$js_infoed=file_get_contents($urled);
$infoed=json_decode($js_infoed,true);
if($page-1<$infoed['result']['pagecount']){
	if($infoed['result']['data']){
		foreach($infoed['result']['data'] as $key => $value){
			$sql="select id from testgame where gamename='".$value['game_name']."' and testtype='".$ntesttype[$value['name']]."'";
			$isinfo=$_SGLOBAL['db']->result($_SGLOBAL['db']->query($sql),0);
			if($isinfo){
				//**********
			}else{
				$sql="select id from appinfo where name='".$value['game_name']."' and isverify='1'";
				$appid=$_SGLOBAL['db']->result($_SGLOBAL['db']->query($sql),0);
				if($appid){
					$cjtest['gamename']=$value['game_name'];
					$cjtest['starttime']=$value['start'];
					$cjtest['appid']=$appid;
					$cjtest['testtype']=$ntesttype[$value['name']];
					$cjtest['isverify']='0';
					$cjtest['gameurl']="";
					if($value['platform'][0]=="android"){
						$cjtest['isandroid']='1';
					}
					if($value['platform'][0]=="ios"){
						$cjtest['isios']='1';
					}
					$cjtest['dateline']=time();
					$cjtest['addressnum']="测试服";
					$cjtest['useplatform']=$value['dev_name'];				
					$nid=inserttable("testgame",$cjtest,true);
				}
			}
		}
	}
}else{
	echo "4399开测信息采集完毕";
	exit();
}*/
$page=$page+1;
echo "正在采集中...,当前页数".$page;
echo "<script>window.location.href='/index.php?ac=cj_4399test&page=".$page."';</script>";
exit;
?>