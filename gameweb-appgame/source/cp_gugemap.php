<?php
if(!defined('IN_YYJIA')) {
	exit('Access Denied');
}
header("Content-type: text/html; charset=utf-8");
$newscategorys=get_categorys(2,-1,-1,20);
$newscategorylist=$newscategorys['id'];
$_SGLOBAL['newscate']=$newscategorys['id'];
$appinfos=getapplists(0,0,-1,-1,0,"dateline",200,0,$allcategorylist,0);
$xml="<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$xml.="<document>\n";
if($_SCONFIG[allowrewrite]){
	$siteurl=$_SC['siteurl'];
}else{
	$siteurl=$_SC['siteurl'];
}
foreach ($appinfos[app]['list'] as $data) {
$time=date('c',$data[dateline]);
$data['contents']=str_replace('>','&gt;',str_replace('<','&lt;',str_replace('&','&amp;',str_replace('”','\”',str_replace('“','\“',str_replace('"','\"',$data['briefsummary']))))));
$data['url']=str_replace('&','&amp;',$data['url']);
$data['name']=str_replace('>','&gt;',str_replace('<','&lt;',str_replace('&','&amp;',str_replace('”','\”',str_replace('“','\“',str_replace('"','\"',$data['name']))))));
$xml.= create_item($data['url'],$siteurl);
}
$xml .= "</document>\n";
$tempdir=S_ROOT.'./data/gugemap.xml';
$k=fopen("$tempdir","w+");
fwrite($k,$xml);
fclose($k);
echo "已经生成谷歌地图，地图路径 ".$siteurl."/data/gugemap.xml";
function create_item($url,$siteurl){
	$item.= "<url>\n";
	$item.= "<loc>".$url."</loc>\n";
    $item.= "</url>\n";
    return $item;
}

?>