<?php
if(!defined('IN_YYJIA')) {
	exit('Access Denied');
}
$regcz=intval($_GET['regcz']);
if($regcz) {
	//已经注册用户
	if($_SGLOBAL['supe_uid']) {
		header('localtion:/'.$_SERVER['PHP_SELF'].'?ac=member');
	}
	if($_GET['password'] != $_GET['repassword']) {
		$result['msg']="两次输入的密码不一致";
		$result['state']=0;
		echo json_encode($result);
		exit();
	}
	if(!$_GET['password'] || $_GET['password'] != addslashes($_GET['password'])) {
		$result['msg']="密码空或包含非法字符，请返回重新填写。";
		$result['state']=0;
		echo json_encode($result);
		exit();
	}
	$username = trim($_GET['username']);
	$password = $_GET['password'];
	$email = isemail($_GET['email'])?$_GET['email']:'';
	if(empty($email)) {
		$result['msg']="填写的 Email 格式有误。";
		$result['state']=0;
		echo json_encode($result);
		exit();
	}
	/*
	$seccode=strtolower($_POST[seccode]);
	if($seccode!=strtolower($_SESSION['seccode'])){
			showmessage("您输入的验证码有误，请重新输入",$_SERVER['HTTP_REFERER'],1);
		}
	*/	
	if($_SCONFIG['qiyongyzm']) {
		/*if(!ckseccode($_POST['seccode'])) {
			$_SGLOBAL['input_seccode'] = 1;
			showmessage("您输入的验证码有误，请重新输入",$_SERVER['HTTP_REFERER'],1);
			exit;
		}*/
	}
	//检查邮件

	if($count = getcount('user', array('email'=>$email))) {
		$result['msg']="填写的 Email 已经被注册";
		$result['state']=0;
		echo json_encode($result);
		exit();
	}
	
	if($_SCONFIG['qiyonguc']){
	if(!@include_once S_ROOT.'./uc_client/client.php') {
		showmessage('system_error',"$_SERVER[PHP_SELF]?ac=register",1);
	}
	$newuid = uc_user_register($username, $password, $email);
	if($newuid <= 0) {
		if($newuid == -1) {
			//showmessage('user_name_is_not_legitimate');
			$result['msg']="用户名不合法";
			$result['state']=0;
			
		} elseif($newuid == -2) {
			//showmessage('include_not_registered_words');
			$result['msg']="用户名包含不允许注册的词语";
			$result['state']=0;
			
		} elseif($newuid == -3) {
			//showmessage('user_name_already_exists');
			$result['msg']="用户名已经存在";
			$result['state']=0;
			
		} elseif($newuid == -4) {
			//showmessage('email_format_is_wrong');
			$result['msg']="填写的 Email 格式有误";
			$result['state']=0;
			
		} elseif($newuid == -5) {
			//showmessage('email_not_registered');
			$result['msg']="填写的 Email 不允许注册";
			$result['state']=0;
			
		} elseif($newuid == -6) {
			//showmessage('email_has_been_registered');
			$result['msg']="填写的 Email 已经被注册";
			$result['state']=0;
			
		} else {
			//showmessage('register_error');
			$result['msg']="系统错误";
			$result['state']=0;
		}
		echo json_encode($result);
		exit();
	}else{
		$passport = getpassportuc($username,$password);
		$isotherlogin=uc_user_synlogin($passport[uid]);
		ssetcookie('auth', authcode("$passport[password]\t$passport[uid]", 'ENCODE'), 3600*24);
		ssetcookie('loginuser', $passport['username'], 3600*24);
		$result['msg']="注册成功";
		$result['state']=1;
		echo json_encode($result);
		exit();
	}
}else{
	if($count = getcount('user', array('username'=>$username))) {
		//showmessage('user_name_already_exists',"$_SERVER[PHP_SELF]?ac=register",1);
		$result['msg']="用户名已经存在";
		$result['state']=0;
		echo json_encode($result);
		exit();
	}
	$salt = substr(uniqid(rand()), -6);
	$ip=getonlineip();
	$uid=$newuid;
	$setarr = array(
			'username' => $username,
			'email' => $email,
			'regip' => $ip,
			'salt' => $salt,
			'addtime' => $_SGLOBAL['timestamp'],
			'lastlogin' => $_SGLOBAL['timestamp'],
			'password' =>md5(md5($password).$salt), //密码生成
			'group_id' =>3
			);
		//更新本地用户库
		$uid=inserttable('user', $setarr, 1);
		//设置cookie
		$time=time();
		$session_arr['uid']=$uid;
		$session_arr['username']=$setarr['username'];
		$session_arr['password']=md5($setarr['password'].$time);
		$session_arr['dateline']=$time;
		inserttable("session",$session_arr);
		ssetcookie('auth', authcode("$session_arr[password]\t$uid", 'ENCODE'), 86400);
		ssetcookie('loginuser', $username, 86400);
		}
		
		//注册积分
	  $sql="select * from credit where type='1'";	
	  $creinfo=$_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query($sql));
	if($_SCONFIG['qiyonguc']){
		 $cre_data['uid']=$passport[uid];
	}else{
		$cre_data['uid']=$uid;
	}	
	$cre_data['type']='1';
	$cre_data['credit']=$creinfo['credit'];
	$cre_data['experience']=$creinfo['experience'];
	$cre_data['czreward']=$creinfo['reward'];
	$cre_data['dateline']=time(); 
	$cre_data['isverify']='1'; 
	$cre_data['uploadtype']='0'; 
	inserttable("credit_data",$cre_data);	
	$tjsql="update user set count_credit=".$cre_data[credit].",count_experience=".$cre_data[experience]." where uid='".$cre_data['uid']."'";
	$_SGLOBAL['db']->query($tjsql);
	$result['msg']="注册成功";
	$result['state']=1;
	echo json_encode($result);
	exit();
}
$title="注册";
$_SCONFIG['title']=str_replace("%sitename%",$_SCONFIG['sitename'],$_SCONFIG['shouyou_title']);
$_SCONFIG['keyword']=str_replace("%sitename%",$_SCONFIG['sitename'],$_SCONFIG['shouyou_keyword']);
$_SCONFIG['description']=str_replace("%sitename%",$_SCONFIG['sitename'],$_SCONFIG['shouyou_description']);		
include_once template($ac);
?>