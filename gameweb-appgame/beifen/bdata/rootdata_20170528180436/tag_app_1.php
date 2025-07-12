<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `tag_app`;");
E_C("CREATE TABLE `tag_app` (
  `tagid` int(11) NOT NULL,
  `appid` int(11) NOT NULL,
  PRIMARY KEY (`tagid`,`appid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>