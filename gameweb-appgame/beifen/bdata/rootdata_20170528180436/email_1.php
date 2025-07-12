<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `email`;");
E_C("CREATE TABLE `email` (
  `uid` int(11) NOT NULL,
  `email_num` varchar(50) NOT NULL,
  `dateline` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  PRIMARY KEY (`email_num`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>