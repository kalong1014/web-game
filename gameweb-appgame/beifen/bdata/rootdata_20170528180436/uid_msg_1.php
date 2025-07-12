<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `uid_msg`;");
E_C("CREATE TABLE `uid_msg` (
  `mid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1 已读 0 未读',
  `dateline` int(11) NOT NULL,
  PRIMARY KEY (`mid`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>