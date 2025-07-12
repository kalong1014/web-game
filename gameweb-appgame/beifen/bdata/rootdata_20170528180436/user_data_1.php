<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `user_data`;");
E_C("CREATE TABLE `user_data` (
  `uid` int(11) NOT NULL,
  `zxid` mediumint(8) NOT NULL,
  `dateline` int(11) NOT NULL,
  `type` mediumint(3) NOT NULL COMMENT '1,下载，2 上传app 3 上传news',
  KEY `uid` (`uid`),
  KEY `dateline` (`dateline`),
  KEY `zxid` (`zxid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>