<?php
header("Content-type:text/html;charset=utf-8");
include_once(S_ROOT.'./source/simple_html_dom.php');
$url="http://gh.u.360.cn/service?type=1";
$tcinfo=get_servrlist($url);
if($tcinfo){
	echo "采集完毕";
	exit();
}else{
	echo "采集出错";
	exit();
}
function get_servrlist($url){
	global $_SGLOBAL, $_SCONFIG,$_SC;
	$User_Agent = "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.0";
	$Referer_Url = 'http://gh.u.360.cn';
	$str=GetSources($url,$User_Agent,$Referer_Url);	
	//$str=iconv("gbk","utf-8",$str);
	$html = str_get_html($str);
	$resli=$html->find('div[class=svr-soon] li');
	$gservernum=1;
	foreach ($resli as $key => $item){
		$today=strtotime(date('Y-m-d'));
		$n=date('Y-m-d');
		$dayfg=$item->find('span[class=time-tag]',0)->plaintext;
		
		if($dayfg){
			$dayfg=strtotime(date('Y')."-".str_replace("日","",str_replace("月","-",$dayfg)));
			$datetime=$dayfg;
		}else{
			$kt=$kv;
			$dayfg=$datetime;
		}
		
		if($dayfg>$today){
			$kfsj=trim($item->find('p[class=td-time]',0)->plaintext);
			$name=trim($item->find('p[class=td-name]',0)->plaintext);
			$kfaddress=trim($item->find('p[class=td-stat]',0)->plaintext);
			if($name){
				$appnamearr=explode("(",$name);
				$appname=$appnamearr[0];
				$sql="select id from opengame where gamename='".$appname."' and addressnum='".$kfaddress."'";
				$isinfo=$_SGLOBAL['db']->result($_SGLOBAL['db']->query($sql),0);
				if($isinfo==""){
					$sql="select id from appinfo where type='4' and name='".$appname."'";
					$appid=$_SGLOBAL['db']->result($_SGLOBAL['db']->query($sql),0);
					$cjserver['appid']=$appid;
					$cjserver['gamename']=$appname;
					$cjserver['addressnum']=$kfaddress;
					$cjserver['starttime']=$dayfg+$kfsj*3600;
					$cjserver['dateline']=time();
					$cjserver['isverify']="0";
					$cjserver['isandroid']="1";
					$cjserver['useplatform']="360平台";
					$openid=inserttable("opengame",$cjserver,1);
					if($openid){
						$gservernum++;
					}
				}
			}
			
		}
		//$newlilist[$dayfg][]=$item;
	}
	
	$html->clear();
	return $gservernum;
}
function GetSources($Url,$User_Agent='',$Referer_Url='') //抓取某个指定的页面
{
	//$Url 需要抓取的页面地址
	//$User_Agent 需要返回的user_agent信息 如"baiduspider"或"googlebot"
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $Url);
	curl_setopt ($ch, CURLOPT_USERAGENT, $User_Agent);
	curl_setopt ($ch, CURLOPT_REFERER, $Referer_Url);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, false); 
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION,1);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	$MySources = curl_exec ($ch);
	curl_close($ch);
	return $MySources;
	//print_r($MySources);die();
}
?>