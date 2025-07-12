<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `uid_appid`;");
E_C("CREATE TABLE `uid_appid` (
  `uid` int(11) NOT NULL,
  `appid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL,
  PRIMARY KEY (`uid`,`appid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>