<?php
/*
根据角色名充值到player表dj字段
*/
header('Content-Type: text/html; Charset=utf-8');
error_reporting(0);
$reIP=$_SERVER["REMOTE_ADDR"]; 
if($reIP != '127.0.0.1'){
	exit('请在服务器上运行');
}
//常量
$bili=1;
$HttpCommunicationKey = "ABC123";
$url='http://127.0.0.1:81/game/services?action=playerChangeProperty';
$refreshsec=5;
//数据库处理
$failer=0;
$success=0;
$connect = mysqli_connect('127.0.0.1','root','123321','morningglory_data') or die('无法连接到mysql');
mysqli_query($connect,'set names utf8');
$sql="SELECT name,dj,id FROM player WHERE dj >0";
$result = mysqli_query($connect,$sql);
while($row = mysqli_fetch_row($result)){
	$playerName=$row[0];
	$cmdstr='chongzhi '.($row[1]*$bili);
	$sign = strtoupper(md5($playerName .$cmdstr . $HttpCommunicationKey));
	$post_data = array(
		'playerName'=>$playerName ,
		'cmdstr'=>$cmdstr,
		'sign'=>$sign
	);
	$result=post2($url, $post_data);
	$result=json_decode($result);
	if($result['code']==0){
		$success++;
		mysqli_query($connect,'update player set dj=0 where id="'.$row[2].'"');
	}else{
		$failer++;
	}
}
echo '时间：'.date('Y-m-d H:i:s')."<br>\r\n";
echo '充值成功：'.$success.',充值失败：'.$failer;
header('Refresh:'.$refreshsec.',Url='.$_SERVER["REQUEST_URI"]); 
	
function post2($url, $data){
         $postdata = http_build_query(
            $data
         );
         $opts = array('http' =>
                       array(
                           'method'  => 'POST',
                           'header'  => 'Content-type: application/x-www-form-urlencoded; charset=utf-8',
                           'content' => $postdata
                       )
         );
        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
        return $result;
     }
     
?>