<?php
if(!defined('IN_YYJIA')) {
	exit('Access Denied');
}
if($_SGLOBAL['supe_uid']){
	//showmessage('do_success',"$_SERVER[PHP_SELF]",0);
	header('localtion:/'.$_SERVER['PHP_SELF'].'?ac=member');
}
$logincz=intval($_GET['logincz']);
if($logincz){
	$username=addslashes($_GET['username']);
	$password=addslashes($_GET['password']);
	if(empty($username)) {
		//showmessage('users_were_not_empty_please_re_login', "$_SERVER[PHP_SELF]?ac=login",0);
		$result['msg']="用户名不能为空";
		$result['state']=0;
		echo json_encode($result);
		exit();
	}
	if($_SCONFIG['qiyonguc']){
		if(!$passport = getpassportuc($username, $password)) {
			//showmessage('login_failure_please_re_login', "$_SERVER[PHP_SELF]?ac=login",0);
			$result['msg']="用户名或密码错误";
			$result['state']=0;
			echo json_encode($result);
			exit();
		}	
			$sql="select * from user where uid='".$passport[uid]."'";
			$que=$_SGLOBAL['db']->query($sql);
			$uinfo=$_SGLOBAL['db']->fetch_array($que);
			//$_SGLOBAL['is_admin']=$uinfo['is_admin'];
			$isotherlogin=uc_user_synlogin($passport[uid]);
		
	}else{
		if(!$passport = getpassport($username, $password)) {
			//showmessage('login_failure_please_re_login', "$_SERVER[PHP_SELF]?ac=login",0);
			$result['msg']="用户名或密码错误";
			$result['state']=0;
			echo json_encode($result);
			exit();
		}
	}
	ssetcookie('auth', authcode("$passport[password]\t$passport[uid]", 'ENCODE'), 3600*24);
	ssetcookie('loginuser', $passport['username'], 3600*24);
	ssetcookie('_refer', '');
	$result['msg']="登入成功";
	$result['state']=1;
	echo json_encode($result);
	exit();
}
$title="登入";
$_SCONFIG['title']=str_replace("%sitename%",$_SCONFIG['sitename'],$_SCONFIG['shouyou_title']);
$_SCONFIG['keyword']=str_replace("%sitename%",$_SCONFIG['sitename'],$_SCONFIG['shouyou_keyword']);
$_SCONFIG['description']=str_replace("%sitename%",$_SCONFIG['sitename'],$_SCONFIG['shouyou_description']);	
include_once template($ac);
?>