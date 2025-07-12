<?php
if(!defined('IN_YYJIA')) {
	exit('Access Denied');
}
if($_POST['template']){
	$_SCONFIG['template']=$_POST['template'];
}
session_start();
if($_GET['type']){
	$type=$_GET['type'];
}
$op = $_GET['op'] ? trim($_GET['op']) : '';
$year = date("Y");
$month = date("m");
$day = date("d");
$dayBegin = mktime(0,0,0,$month,$day,$year);//当天开始时间戳
$dayEnd = mktime(23,59,59,$month,$day,$year);//当天结束时间戳
$between= $dayBegin." and ".$dayEnd;
$ref=$_REQUEST['refer'];
if($ref){
	$ref=urldecode($ref);
}else{
	$ref="/index.php";
}
$_SCONFIG['shouyou_title']=str_replace("%sitename%","$_SCONFIG[sitename]",$_SCONFIG['shouyou_title']);
$_SCONFIG['shouyou_keyword']=str_replace("%sitename%","$_SCONFIG[sitename]",$_SCONFIG['shouyou_keyword']);
$_SCONFIG['shouyou_description']=str_replace("%sitename%","$_SCONFIG[sitename]",$_SCONFIG['shouyou_description']);
//没有登录表单
$_SGLOBAL['nologinform'] = 1;
$invitearr = array();
if(empty($op)) {
	if($_SCONFIG['closeregister']) {
		if($_SCONFIG['closeinvite']) {
			showmessage('not_open_registration');
		} elseif(empty($invitearr)) {
			showmessage('not_open_registration_invite');
		}
	}
	//是否关闭站点
	checkclose();
	if($_POST['registersubmit']) {
		//已经注册用户
		if($_SGLOBAL['supe_uid']) {
			showmessage('registered', 'index.php?ac=login');
		}
		if($_POST['password'] != $_POST['password2']) {
			showmessage('password_inconsistency');
		}
		if(!$_POST['password'] || $_POST['password'] != addslashes($_POST['password'])) {
			showmessage('profile_passwd_illegal');
		}
		$mobile=trim($_POST['chkmobile']);
		$username = trim($_POST['username']);
		$password = $_POST['password'];
		$realname=addslashes($_POST['realname']);
		$idnumber=addslashes($_POST['idnumber']);
		if($_SCONFIG['kqyouxiang']){
			$email = isemail($_POST['email'])?$_POST['email']:'';
			if(empty($email)) {
				showmessage('email_format_is_wrong');
			}else{
				$sql="select uid from user where email='".$email."'";
				$isregemail=$_SGLOBAL['db']->result($_SGLOBAL['db']->query($sql),0);
				if($isregemail){
					showmessage('该邮箱已经被注册',$_SERVER['HTTP_REFERER'],2);
				}
			
			}
		}
		/*
		$seccode=strtolower($_POST[seccode]);
		if($seccode!=strtolower($_SESSION['seccode'])){
				showmessage("您输入的验证码有误，请重新输入",$_SERVER['HTTP_REFERER'],1);
			}
		*/
		//手机验证码	
		if($_SCONFIG['kqdxyz']){
			$mobilecode = $_POST['mobilecode'];
			$sql="select id from send_msg_log where mobile='".$mobile."' and code='".$mobilecode."' and stype='1'";
			$chkcodeid=$_SGLOBAL['db']->result($_SGLOBAL['db']->query($sql),0);
			if($chkcodeid==""){
				showmessage("您输入的手机验证码有误，请重新输入",$_SERVER['HTTP_REFERER'],1);
			}
		}
		if($_SCONFIG['qiyongyzm']) {
			if(!ckseccode($_POST['seccode'])) {
				$_SGLOBAL['input_seccode'] = 1;
				showmessage("您输入的验证码有误，请重新输入",$_SERVER['HTTP_REFERER'],1);
				exit;
			}
		}
		//检查邮件
		if($_SCONFIG['checkemail']) {
			if($count = getcount('user', array('email'=>$email))) {
				showmessage('email_has_been_registered');
			}
		}
		if($_SCONFIG['shimingrenzheng']){
			if($realname==""){
				showmessage('真实姓名不能为空');
			}
			if($idnumber==""){
				showmessage('身份证号不能为空');
			}
		}
    if($_SCONFIG['qiyonguc']){
		if(!@include_once S_ROOT.'./uc_client/client.php') {
			showmessage('system_error');
		}
		$newuid = uc_user_register($username, $password, $email);
		if($newuid <= 0) {
			if($newuid == -1) {
				showmessage('user_name_is_not_legitimate');
			} elseif($newuid == -2) {
				showmessage('include_not_registered_words');
			} elseif($newuid == -3) {
				showmessage('user_name_already_exists');
			} elseif($newuid == -4) {
				showmessage('email_format_is_wrong');
			} elseif($newuid == -5) {
				showmessage('email_not_registered');
			} elseif($newuid == -6) {
				showmessage('email_has_been_registered');
			} else {
				showmessage('register_error');
			}
		}else{
			$passport = getpassportuc($username,$password);
			$isotherlogin=uc_user_synlogin($passport['uid']);
			ssetcookie('auth', authcode("$passport[password]\t$passport[uid]", 'ENCODE'), 3600*24);
			ssetcookie('loginuser', $passport['username'], 3600*24);
		}
	}else{
		if($count = getcount('user', array('username'=>$username))) {
			showmessage('user_name_already_exists');
		}
		$salt = substr(uniqid(rand()), -6);
		$ip=getonlineip();
		$uid=$newuid;
		
		$sql="select * from credit where type='1'";	
		  $creinfo=$_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query($sql));
		$setarr = array(
				'username' => $username,
				'email' => $email,
				'regip' => $ip,
				'salt' => $salt,
				'addtime' => $_SGLOBAL['timestamp'],
				'lastlogin' => $_SGLOBAL['timestamp'],
				'password' =>md5(md5($password).$salt), //密码生成
				'group_id' =>3,
				'count_credit'=>$creinfo['credit'],
				'count_experience'=>$creinfo['experience']
				);
			if($_SCONFIG['shimingrenzheng']){
				$setarr['realname']=$realname;
				$setarr['idnumber']=$idnumber;
			}
			if($_SCONFIG['kqdxyz']){
				$setarr['mobile']=$mobile;
				$setarr['nickname']=$username;
			}
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
			ssetcookie('_refer', '');	
			}
			//注册积分
		  $sql="select * from credit where type='1'";	
		  $creinfo=$_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query($sql));
		  if($_SOCNFIG['kqdxyz']){
		  		//删除短信记录
		  	   $sql="delete from send_msg_log where mobile='".$mobile."' and stype='1' and code='".$mobilecode."'";
		 	   $_SGLOBAL['db']->query($sql);
			}
		if($_SCONFIG['qiyonguc']){
			  $cre_data['uid']=$passport[uid];
		  	  $cre_data['type']='1';
			  $cre_data['credit']=$creinfo['credit'];
			  $cre_data['experience']=$creinfo['experience'];
			  $cre_data['czreward']=$creinfo['reward'];
			  $cre_data['dateline']=time(); 
			  $cre_data['isverify']='1'; 
			  $cre_data['uploadtype']='0'; 
		   	  inserttable("credit_data",$cre_data);
			  showmessage("registered",$ref,1,array($isotherlogin));

		}else{
			 $cre_data['uid']=$uid;
			 $cre_data['type']='1';
			 $cre_data['credit']=$creinfo['credit'];
			 $cre_data['experience']=$creinfo['experience'];
			 $cre_data['czreward']=$creinfo['reward'];
			 $cre_data['dateline']=time(); 
			 $cre_data['isverify']='1'; 
			 $cre_data['uploadtype']='0'; 
		   	 inserttable("credit_data",$cre_data);	
			showmessage("registered2",$ref);	

		}
	}	
	if(strstr($_SERVER['HTTP_USER_AGENT'],"Adr")||strstr(strtolower($_SERVER['HTTP_USER_AGENT']),"android")||strstr($_SERVER['HTTP_USER_AGENT'],"iPh")||strstr(strtolower($_SERVER['HTTP_USER_AGENT']),"iphone")||$_GET['typetest']){
		include_once template('register');
	}else{
		include template('do_register');
	}
}elseif($op=="qq"){
	if($_POST['loginsubmit']){
		$uinfo=$_POST[qqdata];
		if($uinfo[username]==""){
			showmessage("用户名不能为空，请重新输入",$_SERVER['HTTP_REFERER']);
		}
		if($uinfo[password]==""){
			showmessage("密码不能为空，请重新输入",$_SERVER['HTTP_REFERER']);
		}
		if($uinfo[password]!=$uinfo[password2]){
			showmessage("输入的2次密码不一致，请重新输入",$_SERVER['HTTP_REFERER']);
		}
		$email="123456@qq.com";
		if($_SCONFIG['qiyonguc']){
			if(!@include_once S_ROOT.'./uc_client/client.php') {
				showmessage('system_error');
			}
			$newuid = uc_user_register($uinfo['username'], $uinfo['password'], $email);
			if($newuid <= 0) {
				if($newuid == -1) {
					showmessage('user_name_is_not_legitimate');
				} elseif($newuid == -2) {
					showmessage('include_not_registered_words');
				} elseif($newuid == -3) {
					showmessage('user_name_already_exists');
				} elseif($newuid == -4) {
					showmessage('email_format_is_wrong');
				} elseif($newuid == -5) {
					showmessage('email_not_registered');
				} elseif($newuid == -6) {
					showmessage('email_has_been_registered');
				} else {
					showmessage('register_error');
				}
			}else{
				$passport = getpassportuc($uinfo['username'],$uinfo['password']);
				$isotherlogin=uc_user_synlogin($passport['uid']);
				$updateuid['uid']=$passport['uid'];
				$where=" openid='".$uinfo['openid']."'";
				updatetable("otherlogin_user",$updateuid,$where);
				ssetcookie('auth', authcode("$passport[password]\t$passport[uid]", 'ENCODE'), 3600*24);
				ssetcookie('loginuser', $passport['username'], 3600*24);
			}
	}else{
		if($count = getcount('user', array('username'=>$uinfo['username']))) {
			showmessage('user_name_already_exists',$_SERVER['HTTP_REFERER']);
		}
		$salt = substr(uniqid(rand()), -6);
		$ip=getonlineip();
		
		$sql="select * from credit where type='1'";	
		  $creinfo=$_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query($sql));
		$setarr = array(
				'username' => $uinfo['username'],
				'email' => $email,
				'regip' => $ip,
				'salt' => $salt,
				'addtime' => $_SGLOBAL['timestamp'],
				'lastlogin' => $_SGLOBAL['timestamp'],
				'password' =>md5(md5($uinfo['password']).$salt), //密码生成
				'group_id' =>3,
				'count_credit'=>$creinfo['credit'],
				'count_experience'=>$creinfo['experience']
				);
			//更新本地用户库
			$uid=inserttable('user', $setarr,1);
			if($uid){
				$updateuid['uid']=$uid;
				$where=" openid='".$uinfo['openid']."'";
				updatetable("otherlogin_user",$updateuid,$where);
			}
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
			if($_SCONFIG['qiyonguc']){
				showmessage("qq_login","index.php",2,array($isotherlogin));
			}else{			
				showmessage("qq_login2","index.php");
			}
	}
	if($_POST['bangdingsubmit']){
		$uinfo=$_POST[bangding];
		if($uinfo[username]==""){
			showmessage("用户名不能为空，请重新输入",$_SERVER['HTTP_REFERER']);
		}
		if($uinfo[password]==""){
			showmessage("密码不能为空，请重新输入",$_SERVER['HTTP_REFERER']);
		}
		if($_SCONFIG['qiyonguc']){
			if(!$passport = getpassportuc($uinfo['username'], $uinfo['password'])) {
				showmessage('login_failure_please_re_login',$_SERVER['HTTP_REFERER']);
			}	
				$isotherlogin=uc_user_synlogin($passport['uid']);
				$sql="select * from user where username='".$passport['username']."'";
				$que=$_SGLOBAL['db']->query($sql);
				$userinfo=$_SGLOBAL['db']->fetch_array($que);
				$_SGLOBAL['is_admin']=$uinfo['is_admin'];
				$where="openid='".$uinfo['openid']."'";
				$updateuid['uid']=$userinfo['uid'];
				updatetable("otherlogin_user",$updateuid,$where);
				ssetcookie('auth', authcode("$passport[password]\t$passport[uid]", 'ENCODE'), 3600*24);
				ssetcookie('loginuser', $passport['username'], 3600*24);		
				showmessage("qq_login","index.php",2,array($isotherlogin));
    	}else{
			if(!$passport = getpassport($uinfo['username'], $uinfo['password'])) {
				showmessage('login_failure_please_re_login',$_SERVER['HTTP_REFERER']);
			}
			$where="openid='".$uinfo['openid']."'";
			$updateuid['uid']=$passport['uid'];
			updatetable("otherlogin_user",$updateuid,$where);
			$time=time();
			$session_arr['uid']=$passport['uid'];
			$session_arr['username']=$passport['username'];
			$session_arr['password']=md5($passport['password'].$time);
			$session_arr['dateline']=$time;
			inserttable("session",$session_arr);
			ssetcookie('auth',authcode("$session_arr[password]\t$session_arr[uid]",'ENCODE'), 86400);
			ssetcookie('loginuser', $session_arr['username'],86400);
			ssetcookie('_refer','');
			showmessage("QQ授权绑定完成，即将跳转首页", "index.php");	
		}		
	}
}elseif($op=="weibo"){
	if($_POST['loginsubmit']){
		$uinfo=$_POST[wbdata];
		if($uinfo[username]==""){
			showmessage("用户名不能为空，请重新输入",$_SERVER['HTTP_REFERER']);
		}
		if($uinfo[password]==""){
			showmessage("密码不能为空，请重新输入",$_SERVER['HTTP_REFERER']);
		}
		if($uinfo[password]!=$uinfo[password2]){
			showmessage("输入的2次密码不一致，请重新输入",$_SERVER['HTTP_REFERER']);
		}
		$email="123456@qq.com";
		if($_SCONFIG['qiyonguc']){
			if(!@include_once S_ROOT.'./uc_client/client.php') {
				showmessage('system_error');
			}
			$newuid = uc_user_register($uinfo[username], $uinfo[password], $email);
			if($newuid <= 0) {
				if($newuid == -1) {
					showmessage('user_name_is_not_legitimate');
				} elseif($newuid == -2) {
					showmessage('include_not_registered_words');
				} elseif($newuid == -3) {
					showmessage('user_name_already_exists');
				} elseif($newuid == -4) {
					showmessage('email_format_is_wrong');
				} elseif($newuid == -5) {
					showmessage('email_not_registered');
				} elseif($newuid == -6) {
					showmessage('email_has_been_registered');
				} else {
					showmessage('register_error');
				}
			}else{
				$passport = getpassportuc($uinfo['username'],$uinfo['password']);
				$isotherlogin=uc_user_synlogin($passport['uid']);
				$updateuid['uid']=$passport['uid'];
				$where=" openid='".$uinfo['openid']."'";
				updatetable("otherlogin_user",$updateuid,$where);
				ssetcookie('auth', authcode("$passport[password]\t$passport[uid]", 'ENCODE'), 3600*24);
				ssetcookie('loginuser', $passport['username'], 3600*24);
			}
	}else{
		if($count = getcount('user', array('username'=>$uinfo['username']))) {
			showmessage('user_name_already_exists',$_SERVER['HTTP_REFERER']);
		}
		$salt = substr(uniqid(rand()), -6);
		$ip=getonlineip();
		$setarr = array(
				'username' => $uinfo[username],
				'email' => $email,
				'regip' => $ip,
				'salt' => $salt,
				'addtime' => $_SGLOBAL['timestamp'],
				'lastlogin' => $_SGLOBAL['timestamp'],
				'password' =>md5(md5($uinfo[password]).$salt), //密码生成
				'group_id' =>3
				);
			//更新本地用户库
			$uid=inserttable('user', $setarr,1);
			if($uid){
				$updateuid['uid']=$uid;
				$where=" openid='".$uinfo['openid']."'";
				updatetable("otherlogin_user",$updateuid,$where);
			}
			//设置cookie
			$time=time();
			$session_arr['uid']=$uid;
			$session_arr['username']=$setarr['username'];
			$session_arr['password']=md5($setarr['password'].$time);
			$session_arr['dateline']=$time;
			inserttable("session",$session_arr);
			ssetcookie('auth', authcode("$session_arr[password]\t$uid", 'ENCODE'), 86400);
			ssetcookie('loginuser', $username, 86400);
			ssetcookie('_refer', '');	
			}
			//注册积分
		  $sql="select * from credit where type='1'";	
		  $creinfo=$_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query($sql));
			if($_SCONFIG['qiyonguc']){
				 $cre_data['uid']=$passport[uid];
				  $cre_data['type']='1';
				  $cre_data['credit']=$creinfo['credit'];
				  $cre_data['experience']=$creinfo['experience'];
				  $cre_data['czreward']=$creinfo['reward'];
				  $cre_data['dateline']=time(); 
				  $cre_data['isverify']='1'; 
				  $cre_data['uploadtype']='0'; 
				  inserttable("credit_data",$cre_data);
				showmessage("weibo_login","index.php",2,array($isotherlogin));
			}else{
				$cre_data['uid']=$uid;
				 $cre_data['type']='1';
				 $cre_data['credit']=$creinfo['credit'];
				 $cre_data['experience']=$creinfo['experience'];
				 $cre_data['czreward']=$creinfo['reward'];
				 $cre_data['dateline']=time(); 
				 $cre_data['isverify']='1'; 
				 $cre_data['uploadtype']='0'; 
				 inserttable("credit_data",$cre_data);			
				showmessage("weibo_login2","index.php");
			}
	}
	if($_POST['bangdingsubmit']){
		$uinfo=$_POST[bangding];
		if($uinfo['username']==""){
			showmessage("用户名不能为空，请重新输入",$_SERVER['HTTP_REFERER']);
		}
		if($uinfo['password']==""){
			showmessage("密码不能为空，请重新输入",$_SERVER['HTTP_REFERER']);
		}
		if($_SCONFIG['qiyonguc']){
			if(!$passport = getpassportuc($uinfo['username'], $uinfo['password'])) {
				showmessage('login_failure_please_re_login',$_SERVER['HTTP_REFERER']);
			}	
				$sql="select * from user where username='".$passport['username']."'";
				$que=$_SGLOBAL['db']->query($sql);
				$userinfo=$_SGLOBAL['db']->fetch_array($que);
				$_SGLOBAL['is_admin']=$uinfo['is_admin'];
				$where="openid='".$uinfo['openid']."'";
				$updateuid['uid']=$userinfo['uid'];
				updatetable("otherlogin_user",$updateuid,$where);
				ssetcookie('auth', authcode("$passport[password]\t$passport[uid]", 'ENCODE'), 3600*24);
				ssetcookie('loginuser', $passport['username'], 3600*24);
				$isotherlogin=uc_user_synlogin($passport['uid']);
				showmessage("weibo_login","index.php",2,array($isotherlogin));
    	}else{
			if(!$passport = getpassport($uinfo['username'], $uinfo['password'])) {
				showmessage('login_failure_please_re_login',$_SERVER['HTTP_REFERER']);
			}
			$where="openid='".$uinfo['openid']."' and type='2'";
			$updateuid[uid]=$passport['uid'];
			updatetable("otherlogin_user",$updateuid,$where);
			$time=time();
			$session_arr['uid']=$passport['uid'];
			$session_arr['username']=$passport['username'];
			$session_arr['password']=md5($passport['password'].$time);
			$session_arr['dateline']=$time;
			inserttable("session",$session_arr);
			ssetcookie('auth',authcode("$session_arr[password]\t$session_arr[uid]",'ENCODE'), 86400);
			ssetcookie('loginuser', $session_arr['username'],86400);
			ssetcookie('_refer','');
			showmessage("weibo_login2","index.php");
		}		
	}
}elseif($op == "checkusername") {
	$username = trim($_GET['username']);
	if(empty($username)) {
		showmessage('user_name_is_not_legitimate');
	}
	$username=getstr($username,50,0,0,1);
	if($count = getcount('user', array('username'=>$username))) {
		showmessage('user_name_already_exists');
	}else
	{
		showmessage('succeed');
	}	
} elseif($op == "checkseccode") {
if ($_SCONFIG['qiyongyzm']){
	if($_GET["dandan"]!="1")
	{
		if(ckseccode(trim($_GET['seccode']))) {
			showmessage('succeed');
		} else {
			showmessage('incorrect_code');
		}
	}
	}
	else{
	showmessage('succeed');
	}
}
?>