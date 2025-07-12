<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `comment`;");
E_C("CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父ID',
  `appid` int(11) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0',
  `username` varchar(50) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `dateline` int(11) NOT NULL,
  `message` varchar(3000) NOT NULL,
  `isverify` smallint(1) NOT NULL DEFAULT '0' COMMENT '审核',
  `ipaddress` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `userlogo` varchar(150) NOT NULL,
  `subtype` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1:android 2:apple',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) USING BTREE,
  KEY `appid` (`appid`),
  KEY `dateline` (`dateline`),
  KEY `pid` (`subtype`) USING BTREE,
  KEY `isaudit` (`isverify`,`pid`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>