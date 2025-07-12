<?php
$op=$_GET[op]?$_GET[op]:'address';

$dangqianname=$op;
$dangqian=array($dangqianname=>'class=dangqian');

$_SCONFIG['shouyou_title']=str_replace("%sitename%","$_SCONFIG[sitename]",$_SCONFIG['shouyou_title']);
$_SCONFIG['shouyou_keyword']=str_replace("%sitename%","$_SCONFIG[sitename]",$_SCONFIG['shouyou_keyword']);
$_SCONFIG['shouyou_description']=str_replace("%sitename%","$_SCONFIG[sitename]",$_SCONFIG['shouyou_description']);

if($op=="copyright"){
	$content=$_SCONFIG['copyright'];
}elseif($op=="comment"){
	$content=$_SCONFIG['comment'];
}elseif($op=="upload"){
	$content=$_SCONFIG['upload'];
}elseif($op=="agreement"){
	$content=$_SCONFIG['agreement'];
}else{
	$content=$_SCONFIG['contact'];
}
include_once template($ac);
if($_SCONFIG['kqjingtai']){
	$content = ob_get_contents();
	$fp = fopen($htmlpath,"w");
	fwrite($fp, $content);
	fclose($fp);
}
?>