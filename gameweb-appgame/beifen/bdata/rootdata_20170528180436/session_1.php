<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `session`;");
E_C("CREATE TABLE `session` (
  `uid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `dateline` int(11) NOT NULL,
  `ip` varchar(50) NOT NULL
) ENGINE=MEMORY DEFAULT CHARSET=utf8");
E_D("replace into `session` values('1','admin','16e85c41d8ffba49488b29dc521310b8','1495934489','');");

require("../../inc/footer.php");
?>