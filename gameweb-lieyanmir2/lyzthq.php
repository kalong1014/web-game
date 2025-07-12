<?php
error_reporting(0);
session_start();
set_time_limit(0);
header("content-type:text/html; charset=utf-8");
echo 'http://你的地址/id=E_2(区号)_30（30级饱含30级内不进行合区）<br/>';
function so8($a,$b,$c,$d){
    $so8 = @mysql_pconnect($a,$b,$c);
    mysql_query("set names utf8"); 
    mysql_select_db($d, $so8) ;
    return $so8;
}
$b=split('_',$_GET[id]);
if($b[0]!='E'){exit;}
$db1='127.0.0.1';
$db2='root';
$db3='123321';
$dbacc1='morningglory_data'.$b[1];//被合库
$newdbacc='morningglory_data';//主库
$so8=so8($db1,$db2,$db3,'') or die('服务器连接失败');
if($b[0]=='E' and $b[1]!='' and $b[2]!=''){
mysql_query("ALTER TABLE $newdbacc.player DROP INDEX `idx_name` ,ADD INDEX `idx_name` (`name`) USING BTREE")or die('0');
$row='';
$sql="SELECT id,`name`,propertyData FROM $dbacc1.player WHERE`level` >='$b[2]'";
$result=mysql_query($sql,$so8) or die(mysql_error());
if($result&&mysql_num_rows($result)>0){
while($row[] = mysql_fetch_array($result)){}
            mysql_free_result($result);
            array_pop($row);
}
foreach($row as $value){
$a='S'.$b[1].'-'.$value[1];
$a1=bin2hex($value[1]);
$a2=bin2hex($a);
$a3=strstr(bin2hex($value[2]),$a1,true);
$a4=hexdec(substr($a3,-2));
$a5=strstr(bin2hex($value[2]),$a1);
$a6=substr($a3,0,strlen($a3)-2).bin2hex(pack(c,strlen($a2)/2)).$a2.substr($a5,$a4*2,strlen($a5));
mysql_query("insert into $newdbacc.player select * from $dbacc1.player WHERE (`id`='$value[0]')")or die(mysql_error());
mysql_query("insert into $newdbacc.no_delay_player select * from $dbacc1.no_delay_player WHERE (`id`='$value[0]')")or die('2');
mysql_query("UPDATE $newdbacc.player SET `name`='$a',`propertyData`=0x$a6 WHERE (`id`='$value[0]')")or die('3');
mysql_query("UPDATE $newdbacc.no_delay_player SET `name`='$a' WHERE (`id`='$value[0]')")or die('4');
mysql_query("insert into $newdbacc.game_chatfriend select * from $dbacc1.game_chatfriend WHERE (`id`='$value[0]')")or die('5');
mysql_query("insert into $newdbacc.game_auction select * from $dbacc1.game_auction WHERE (`playerId`='$value[0]')")or die('6');
mysql_query("insert into $newdbacc.game_funstep select * from $dbacc1.game_funstep WHERE (`playerId`='$value[0]')")or die('7');
}
$row='';
$sql="SELECT id,memberData FROM $dbacc1.game_union";
$result=mysql_query($sql,$so8) or die(mysql_error());
if($result&&mysql_num_rows($result)>0){
while($row[] = mysql_fetch_array($result)){}
            mysql_free_result($result);
            array_pop($row);
foreach($row as $value){
$a=hexdec(substr(bin2hex($value[1]),6,2));
$a1=array('8','78','2','56');
$b0='0';
$b4='000000'.bin2hex(pack(c,$a));
$b5='S'.$b[1].'-';
$b5=bin2hex($b5);
for($i=1;$i<=$a;$i++){
$b1=substr(bin2hex($value[1]),$a1[0]+$b0,$a1[1]);
$b0+=strlen($b1);
$a2=hexdec(substr(bin2hex($value[1]),$a1[0]+$b0,$a1[2]));
$b0+=$a1[2];
$b2=substr(bin2hex($value[1]),$a1[0]+$b0,$a2*2);
$b0+=strlen($b2);
$b3=substr(bin2hex($value[1]),$a1[0]+$b0,$a1[3]);
$b0+=strlen($b3);
$b4.=$b1.bin2hex(pack(c,$a2+strlen($b5)/2)).$b5.$b2.$b3;
}
mysql_query("insert into $newdbacc.game_union select * from $dbacc1.game_union WHERE (`id`='$value[0]')")or die('8');
mysql_query("UPDATE $newdbacc.game_union SET `memberData`=0x$b4 WHERE (`id`='$value[0]')")or die('9');
}
}
mysql_query("ALTER TABLE $newdbacc.player DROP INDEX `idx_name` ,ADD UNIQUE INDEX `idx_name` (`name`) USING BTREE")or die('10');
echo $b[1].'合区完成<br/>';
}
?>