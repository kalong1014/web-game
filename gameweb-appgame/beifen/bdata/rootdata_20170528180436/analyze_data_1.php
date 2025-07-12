<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `analyze_data`;");
E_C("CREATE TABLE `analyze_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `webdownnum` int(11) NOT NULL DEFAULT '0' COMMENT 'web下载记录',
  `wapdownnum` int(11) NOT NULL DEFAULT '0' COMMENT 'wap下载记录',
  `khddownnum` int(11) NOT NULL DEFAULT '0' COMMENT '客户端下载记录',
  `ip` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `appid` (`appid`),
  KEY `ip` (`ip`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>