<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `searchkey`;");
E_C("CREATE TABLE `searchkey` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isshouyou` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是不是手游-',
  `name` varchar(50) NOT NULL,
  `engname` varchar(100) NOT NULL,
  `isrecommend` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL,
  `sysearchnum` mediumint(8) NOT NULL DEFAULT '0' COMMENT '搜索次数',
  PRIMARY KEY (`id`),
  KEY `lasttime` (`dateline`,`isrecommend`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>