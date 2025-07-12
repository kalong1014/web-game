<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `new_app`;");
E_C("CREATE TABLE `new_app` (
  `newid` int(11) NOT NULL,
  `appid` int(11) NOT NULL,
  PRIMARY KEY (`newid`,`appid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>