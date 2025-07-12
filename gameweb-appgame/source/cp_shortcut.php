<?php
include_once("./common.php");
global $_SCONFIG;
$n=$_GET["n"];
$title=$_SCONFIG["sitename"];
$title=iconv("UTF-8","GBK",$title);
$Shortcut = "[InternetShortcut]
		URL=".$_SERVER['HTTP_REFERER']."
		IDList=
		[{000214A0-0000-0000-C000-000000000046}]
		Prop3=19,2
		";
Header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$title.".url;");
echo $Shortcut;
?>