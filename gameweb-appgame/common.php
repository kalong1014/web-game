<?php
@error_reporting(E_ERROR);
define('IN_YYJIA', TRUE);
define('D_BUG', '0');
$_SGLOBAL = $_SCONFIG = $_SBLOCK = $_TPL = $_SCOOKIE = $_SN = $space = array();
//程序目录
define('S_ROOT', dirname(__FILE__).DIRECTORY_SEPARATOR);
//基本文件
include_once(S_ROOT.'./config.php');
include_once(S_ROOT.'./source/function_common.php');
if(!file_exists(S_ROOT."/data/install.lock")){
	showmessage("您还没有安装，现在跳转到安装页面。","/install",2);
}
$SCRIPT_NAME=str_replace("/","",$_SERVER['SCRIPT_NAME']);
$_SC['SCRIPT_NAME']=$SCRIPT_NAME;
//时间
$mtime = explode(' ', microtime());
$_SGLOBAL['timestamp'] = $mtime[1];
$_SGLOBAL['supe_starttime'] = $_SGLOBAL['timestamp'] + $mtime[0];
//GPC过滤
$magic_quote = get_magic_quotes_gpc();
if(empty($magic_quote)) {
	$_GET = saddslashes($_GET);
	$_POST = saddslashes($_POST);
	$_REQUEST=saddslashes($_REQUEST);
}

//本站URL
if(empty($_SC['siteurl'])) $_SC['siteurl'] = getsiteurl();
//链接数据库
dbconnect();
//缓存文件
include_once(S_ROOT.'./source/lib.php');
if($_SC['isSAE']){
	$_SGLOBAL['mc']=memcache_init();
	$_SCONFIG=memcache_get($_SGLOBAL['mc'],"data_config");
	if(empty($_SCONFIG)){
		$sql="select * from ".tname('config');
		$query=$_SGLOBAL['db']->query($sql);
		while($value=$_SGLOBAL['db']->fetch_array($query)){
			$dataconfig[$value['var']]=$value['datavalue'];
		}
		memcache_set($_SGLOBAL['mc'],'data_config',$dataconfig);
		$_SCONFIG=$dataconfig;
	}
}else{
	if(!@include_once(S_ROOT.'./data/data_config.php')) {
		include_once(S_ROOT.'./source/function_cache.php');
		config_cache();
		include_once(S_ROOT.'./data/data_config.php');
	}
		if($_SCONFIG['ismemcache']){
			$_SGLOBAL['mc']  = new Memcache;
			$_SGLOBAL['mc']->connect($_SC['memcache']);
			if(!$_SGLOBAL['mc']->connect($_SC['memcache'])){
			 $_SCONFIG['ismemcache']=0;
			}
			$_SGLOBAL['mc_exptime']=60*60*24;//memcache过期时间
		}
}
if($_SC['isSAE']){
	$_SCONFIG['ismemcache']=$_SC['ismemcache'];
}
//COOKIE
$_SC['siteid']=$_SCONFIG['siteid'];
$prelength = strlen($_SC['cookiepre']);
foreach($_COOKIE as $key => $val) {
	if(substr($key, 0, $prelength) == $_SC['cookiepre']) {
		$_SCOOKIE[(substr($key, $prelength))] = empty($magic_quote) ? saddslashes($val) : $val;
	}
}
//初始化
$_SGLOBAL['supe_uid'] = 0;
$_SGLOBAL['supe_username'] = '';
$_SGLOBAL['inajax'] = empty($_GET['inajax'])?0:intval($_GET['inajax']);
$_SGLOBAL['mobile'] = empty($_GET['mobile'])?'':trim($_GET['mobile']);
$_SGLOBAL['ajaxmenuid'] = empty($_GET['ajaxmenuid'])?'':$_GET['ajaxmenuid'];
$_SGLOBAL['refer'] = empty($_SERVER['HTTP_REFERER'])?'':$_SERVER['HTTP_REFERER'];
$_SGLOBAL['nickname']="";
if(empty($_GET['m_timestamp']) || $_SGLOBAL['mobile'] != md5($_GET['m_timestamp']."\t".$_SCONFIG['sitekey'])) $_SGLOBAL['mobile'] = '';
//登录注册防灌水机
if(empty($_SCONFIG['login_action'])) $_SCONFIG['login_action'] = md5('login'.md5($_SCONFIG['sitekey']));
if(empty($_SCONFIG['register_action'])) $_SCONFIG['register_action'] = md5('register'.md5($_SCONFIG['sitekey']));
//整站风格
if(empty($_SCONFIG['template'])) {
	$_SCONFIG['template'] = 'default';
}
if($_SCONFIG[iswblogin]){
	$wbinfo=json_decode($_SCONFIG[wbloginconfig],true);
	define( "WB_AKEY", $wbinfo[WBAKEY] );
	define( "WB_SKEY", $wbinfo[WBSKEY] );
	define( "WB_CALLBACK_URL",$wbinfo[WBCALLBACKURL]);
}
if($_SCONFIG['qiyonguc']){
	include_once(S_ROOT.'./data/data_ucconfig.php');
}
$_SC['template']=$_SCONFIG['template'];
if($_SCOOKIE['mytemplate']) {
	$_SCOOKIE['mytemplate'] = str_replace('.','',trim($_SCOOKIE['mytemplate']));
	if(file_exists(S_ROOT.'./template/'.$_SCOOKIE['mytemplate'].'/style.css')) {
		$_SCONFIG['template'] = $_SCOOKIE['mytemplate'];
	} else {
		ssetcookie('mytemplate', '', 365000);
	}
}
//处理REQUEST_URI
if(!isset($_SERVER['REQUEST_URI'])) {  
	$_SERVER['REQUEST_URI'] = $_SERVER['PHP_SELF'];
	if(isset($_SERVER['QUERY_STRING'])) $_SERVER['REQUEST_URI'] .= '?'.$_SERVER['QUERY_STRING'];
}
if($_SERVER['REQUEST_URI']) {
	$temp = urldecode($_SERVER['REQUEST_URI']);
	if(strexists($temp, '<') || strexists($temp, '"')) {
		$_GET = shtmlspecialchars($_GET);//XSS
	}
}
if(strip_tags($_GET['code'])){
	if(strip_tags($_GET['way'])=="weibo"){
		weibologin();
	}else{
		 session_start();
		$_SESSION['state']=htmlspecialchars($_GET['state']);
		qqlogin();
	}
}
$_SCONFIG['sysiteurl']="http://".$_SCONFIG['siteurl'];
$_SCONFIG['operate']=array("1"=>"注册","2"=>"每天登录","3"=>"成功举报","4"=>"应用评论","5"=>"下载应用","6"=>"分享","7"=>"上传应用","8"=>"发布资讯","9"=>"添加开服表","10"=>"添加开测表","11"=>"添加礼包","12"=>"签到","13"=>"领取礼包");
//判断用户登录状态
checkauth();
//判断是否签到,积分经验值
if($_SGLOBAL['supe_uid']){
	$daybegin=strtotime(date("Y-m-d H:i:s",mktime(0,0,0,date("m"),date("d"),date("Y"))));
	$dayend=strtotime(date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d"),date("Y"))));
	$sql="select id from credit_data where uid='".$_SGLOBAL['supe_uid']."' and type='12' and dateline between ".$daybegin." and ".$dayend;
	$isqiandao=$_SGLOBAL['db']->result($_SGLOBAL['db']->query($sql),0);
	$usql="select * from user where uid='".$_SGLOBAL['supe_uid']."'";
	$ucxinfo=$_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query($usql));
	$_SGLOBAL['nickname']=$ucxinfo['nickname'];
}
//QQ,微博登入
$_SGLOBAL['uhash'] = md5($_SGLOBAL['supe_uid']."\t".substr($_SGLOBAL['timestamp'], 0, 6));
$qzhost = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
$qzhost=strtolower($qzhost);
$_SCONFIG['maxpage'] = 0;
if(!$_SC['sitename']){
	$_SC['sitename']=$_SCONFIG['sitename'];
}
if ($_SC['gzipcompress'] && function_exists('ob_gzhandler')) {
	ob_start('ob_gzhandler');
} else {
	ob_start();
}
//开测状态
if($_SCONFIG['testtype']){
	$_SCONFIG['testtype']=explode(',',$_SCONFIG['testtype']);
	$_SCONFIG['testtype']=str_replace('&','\\',$_SCONFIG['testtype']);
	$_SCONFIG['testtype']=implode(',',$_SCONFIG['testtype']);
	$ttypeinfo=json_decode($_SCONFIG['testtype'],true);
}else{
	$ttypeinfo="";
}
//礼包类型
if($_SCONFIG['packtype']){
	$_SCONFIG['packtype']=explode(',',$_SCONFIG['packtype']);
	$_SCONFIG['packtype']=str_replace('&','\\',$_SCONFIG['packtype']);
	$_SCONFIG['packtype']=implode(',',$_SCONFIG['packtype']);
	$ptypeinfo=json_decode($_SCONFIG['packtype'],true);
}else{
	$ptypeinfo="";
}

$_SCONFIG['footinfo']=str_replace("%siteurl%",$_SCONFIG['siteurl'],$_SCONFIG['footinfo']);
$_SCONFIG['footinfo']=str_replace("%sitename%",$_SCONFIG['sitename'],$_SCONFIG['footinfo']);
$nn=1;
$newscategorys=get_categorys(2,-1,-1,40,-1,"displayorder",-1,-1,1);
$_SGLOBAL['newscate']=$newscategorys['id'];
$newscategorylist=$newscategorys['id'];
if($_SCONFIG['allowrewrite'] && isset($_GET['rewrite']) && ($_SCONFIG['rewritetype']==2 || strstr($_SERVER['SCRIPT_NAME'],"mobile.php"))) {
	$rws = explode('-', $_GET['rewrite']);
	if(isset($rws[0])) {
		$_GET['ac']=$rws[0];
		$_REQUEST=$_GET;
	}
	if(isset($rws[1])) {		
		$rw_count = count($rws);		
		for ($rw_i=1; $rw_i<$rw_count; $rw_i=$rw_i+2) {			
			$_GET[$rws[$rw_i]] = empty($rws[$rw_i+1])?'':$rws[$rw_i+1];
			$_REQUEST=$_GET;				
		}		
	}	
	unset($_GET['rewrite']);	
}
$_SCONFIG['sysiteurl']="http://".$_SCONFIG['siteurl'];
?>