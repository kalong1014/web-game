<?php
//注册+登陆接口
require_once './common.inc.php'; 
$type= $_REQUEST['type'];
$passWord = $_REQUEST['passWord'];
$userName=$_REQUEST['userName'];
$time=time()."888";
if($type==2){
	$sqlcmdg="select * from account where username='$userName'";
$result = $db ->query($sqlcmdg);
$sl=$db->num_rows($result);
if($sl>0){
	echo '{"qdCode2":0,"serverId":0,"qdCode1":0,"sign":null,"tstamp":0,"identityName":null,"identityId":null,"uuid":null,"userName":null,"msg":"用户名已存在","code":2}';
	exit;
}else{
	$sql="INSERT INTO `account` (`username`, `password`) VALUES ('$userName', '$passWord')";
	$result = $db ->query($sql);
	if($result){
	echo '{"qdCode2":0,"serverId":0,"qdCode1":0,"sign":null,"tstamp":0,"identityName":null,"identityId":null,"uuid":null,"userName":null,"msg":"注册成功,请登录吧","code":0}';
	exit;
	}else{
	echo '{"qdCode2":0,"serverId":0,"qdCode1":0,"sign":null,"tstamp":0,"identityName":null,"identityId":null,"uuid":null,"userName":null,"msg":"服务器异常","code":2}';
	exit;	
	}	
}
}else{
	$sqlcmdg="select * from account where username='$userName' and password='$passWord'";
$result = $db ->query($sqlcmdg);
$sl=$db->num_rows($result);
$row=$db->fetch_array($result);
if($sl>0){
$serverId=$_REQUEST['serverId'];
$qdCode1=$_REQUEST['qcode1'];
$qdCode2=$_REQUEST['qcode2'];
$gameKey=$_REQUEST['gameKey'];
$id=$row['id'];
	$sign=strtoupper(md5($id.$time."ABC123"));
echo '{"serverId":'.$serverId.',"qdCode1":'.$qdCode1.',"qdCode2":'.$qdCode2.',"sign":"'.$sign.'","tstamp":'.$time.',"identityName":"'.$userName.'","identityId":"'.$id.'","uuid":"'.$id.'","userName":"'.$userName.'","msg":"","code":0}';
	exit;	
}else{
	exit('{"qdCode2":0,"serverId":0,"qdCode1":0,"sign":null,"tstamp":0,"identityName":null,"identityId":null,"uuid":null,"userName":null,"msg":"用户名或密码错误","code":3}');
}
	
}

/* file_put_contents("loginAuth.txt",json_encode($x)."\n",FILE_APPEND);

echo '{"serverId":1,"qdCode1":1,"qdCode2":2,"sign":"42036F084541328126AFE2C3E2E8655C","tstamp":1464354637660,"identityName":"identityName","identityId":"1111111","uuid":"xw","userName":"fengfeng","msg":"","code":0}'; */
