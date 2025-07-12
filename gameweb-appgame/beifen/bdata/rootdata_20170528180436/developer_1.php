<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `developer`;");
E_C("CREATE TABLE `developer` (
  `devid` int(11) NOT NULL AUTO_INCREMENT,
  `devname` varchar(100) NOT NULL COMMENT '开发者姓名',
  `summary` varchar(300) NOT NULL COMMENT '介绍',
  `pic` varchar(100) NOT NULL,
  `shortname` varchar(20) NOT NULL,
  `appnum` mediumint(8) NOT NULL COMMENT '应用数量',
  `isverify` tinyint(1) NOT NULL DEFAULT '0',
  `devetype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 开发者；2厂商',
  `tell` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `QQ` int(12) NOT NULL,
  `contactname` varchar(20) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `companyurl` varchar(100) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL,
  `platform` varchar(30) NOT NULL,
  `sfzpic` varchar(150) NOT NULL,
  `yyzzpic` varchar(150) NOT NULL,
  `message` varchar(300) NOT NULL,
  PRIMARY KEY (`devid`),
  KEY `name` (`devname`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>