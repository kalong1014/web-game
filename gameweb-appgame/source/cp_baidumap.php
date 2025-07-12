<?php
if(!defined('IN_YYJIA')) {
	exit('Access Denied');
}
header("Content-type: text/html; charset=utf-8");
$newscategorys=get_categorys(2,-1,-1,20);
$newscategorylist=$newscategorys['id'];
$_SGLOBAL['newscate']=$newscategorys['id'];
$appinfos=getapplists(0,0,-1,-1,0,"dateline",10000,0,$allcategorylist,0);
$xml="<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$xml.="<urlset>\n";
if($_SCONFIG[allowrewrite]){
	$siteurl=$_SC['siteurl'];
}else{
	$siteurl=$_SC['siteurl'];
}
foreach ($appinfos[app]['list'] as $data) {
$time=date('c',$data[dateline]);
$data['url']=str_replace('&','&amp;',$data['url']);
$data['contents']=str_replace('&','&amp',str_replace('”','\”',str_replace('“','\“',str_replace('"','\"',$data['briefsummary']))));
$xml.= create_item($data['url'],$time,$siteurl);
}
$xml .= "</urlset>\n";
$tempdir=S_ROOT.'./data/baidumap.xml';
$k=fopen("$tempdir","w+");
fwrite($k,$xml);
fclose($k);
echo "已经生成百度地图，地图路径".$siteurl."/data/baidumap.xml";
function create_item($url,$time,$siteurl){
    $item.= "<item>\n";
	$item.="<op>add</op>\n";
	$item.= "<title>".$name."</title>\n";
	$item.= "<playLink>".$url."</playLink>\n";
	$item.="<pubDate>".$time."</pubDate>\n";
    $item.= "</item>\n";
    return $item;
}
?>