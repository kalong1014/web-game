<?php
header('Content-Type:text/html; charset=utf-8');
$type = "login";
if(isset($_GET["type"])) {
	$type = $_GET["type"];
}
$serverId = 0;
if(isset($_GET["serverId"])) {
	$serverId = $_GET["serverId"];
}
$userName = '';
if(isset($_GET["userName"])) {
	$userName = $_GET["userName"];
}
$passWord = '';
if(isset($_GET["passWord"])) {
	$passWord = $_GET["passWord"];
}
$tstamp = '' . time();
$userId = 0;
$code = 0;
$devid = '';
$error = '';
$str_len1 = strlen($userName);
$str_len2 = strlen($passWord);

//---------------------------------------
// 要先检查帐号和密码等字符串的合法性
//---------------------------------------
if ($str_len1 < 4 || $str_len1 > 16){
	$arr = array('code'=>1,'errmsg'=>'帐号长度必须4~16');
	echo json_encode($arr);
	exit();
}

if ($str_len2 < 1 || $str_len2 > 16){
	$arr = array('code'=>1,'errmsg'=>'密码长度必须4~16');
	echo json_encode($arr);
	exit();
}

if (!preg_match("#^[a-z0-9]+$#i", $userName)){
	$arr = array('code'=>1,'errmsg'=>'帐号只能包含数字和小写字母');
	echo json_encode($arr);
	exit();
}

if (!preg_match("#^[a-z0-9]+$#i", $passWord)){
	$arr = array('code'=>1,'errmsg'=>'密码只能包含数字和小写字母');
	echo json_encode($arr);
	exit();
}

if ($type != "register"){
	$type = "login";
}
//---------------------------------------
// 要先检查帐号和密码等字符串的合法性
//---------------------------------------

$mysqli = new mysqli('127.0.0.1', 'root', '123321', 'lieyanzhetian_passport');
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

//---------------------------------------
// 查找是否有这个帐号
//---------------------------------------
$sql = "SELECT COUNT(*) AS COUNT from user WHERE userName='".$userName."'";
$result = $mysqli->query($sql);
$field = $result->fetch_object();

//---------------------------------------
// 处理注册
//---------------------------------------
if ($type == "register") {
	if ($field->COUNT == 0) {
		// 没注册就注册一下
		$sql ='insert into user(`userName`,`passWord`, `c_time`, `devid`) values("'.$userName.'", "'.$passWord.'", '.time().', "Y'.$devid.'X")';
		$result = $mysqli->query($sql);
		if ($result == false) {
			$error = '注册失败: ' . $sql . "\r\n";
			$arr = array('code'=>1,'errmsg'=>'数据库错误，注册失败');
			echo json_encode($arr);
			exit();
		}
		else {
			$arr = array('code'=>0,'errmsg'=>'注册成功');
			echo json_encode($arr);
			exit();
		}
	}
else if ($field->COUNT == 0) {
		$arr = array('code'=>1,'errmsg'=>'此帐号已被注册');
		echo json_encode($arr);
		exit();
	}
}
else if ($field->COUNT == 0) {
	$arr = array('code'=>1,'errmsg'=>'登录失败,没有找到该帐号');
	echo json_encode($arr);
	exit();
}

//---------------------------------------
// 处理验证
//---------------------------------------
// 验证并获取帐号信息
$sql = "SELECT COUNT(*) AS COUNT, userId from user WHERE userName='".$userName."' and passWord='".$passWord."'";
$result = $mysqli->query($sql);
$field = $result->fetch_object();
if ($field->COUNT != 1) {
	$code = 1;
	$error = '验证失败: ' . $sql . "\r\n";
	$arr = array('code'=>1,'errmsg'=>'登录失败,密码错误');
	echo json_encode($arr);
	exit();
}
else {
	$code = 0;
	$userId = $field->userId;
}

//---------------------------------------
// 输出信息给客户端
$identityId = $userId;
$sign = strtoupper(md5('' . $identityId . $tstamp . 'ABC123'));
$arr = array(
	'code'=>$code,
	'serverId'=>$serverId,
	'identityId'=>'' . $userId,
	'identityName'=>$userName,
	'userId'=>'' . $userId,
	'userName'=>$userName,
	'tstamp'=>$tstamp,
	'sign'=>$sign
);
echo json_encode($arr);
$mysqli->close();
//---------------------------------------

// 写点日志
//exit();
$data = "";
foreach ($_GET as $k=>$v) { 
	$data = $data . $k . '=' . $v . "\r\n";
} 
$data = $data . "---------------------\r\n";
foreach ($arr as $k=>$v) { 
	$data = $data . $k . '=' . $v . "\r\n";
} 
//file_put_contents("auth_log.txt",$data.$error);

function getIP(){
    global $ip;
    if (getenv("HTTP_CLIENT_IP"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if(getenv("HTTP_X_FORWARDED_FOR"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if(getenv("REMOTE_ADDR"))
        $ip = getenv("REMOTE_ADDR");
    else $ip = "Unknow";
    return $ip;
}
?>