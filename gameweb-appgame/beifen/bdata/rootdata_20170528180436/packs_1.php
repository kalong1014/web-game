<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `packs`;");
E_C("CREATE TABLE `packs` (
  `packid` int(5) NOT NULL AUTO_INCREMENT,
  `serverid` int(5) NOT NULL DEFAULT '0',
  `addressnum` varchar(10) NOT NULL,
  `starttime` int(11) NOT NULL,
  `endtime` int(11) NOT NULL,
  `packtype` tinyint(1) NOT NULL DEFAULT '1',
  `packname` varchar(30) NOT NULL,
  `packurl` varchar(100) NOT NULL,
  `packcontent` varchar(500) NOT NULL,
  `packuse` varchar(500) NOT NULL,
  `gameurl` varchar(150) NOT NULL COMMENT '游戏地址',
  `activate` varchar(150) CHARACTER SET utf8 COLLATE utf8_icelandic_ci NOT NULL COMMENT '激活地址',
  `dateline` int(11) NOT NULL,
  `isrecommend` tinyint(1) NOT NULL DEFAULT '0',
  `isverify` tinyint(1) NOT NULL DEFAULT '0',
  `devid` int(8) NOT NULL DEFAULT '0',
  `packlogo` varchar(150) NOT NULL,
  `isandroid` tinyint(1) NOT NULL DEFAULT '0',
  `isios` tinyint(1) NOT NULL DEFAULT '0',
  `packfl` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 开服礼包 2 开测礼包',
  `appid` int(11) NOT NULL,
  `message` varchar(300) NOT NULL,
  `usecredit` int(8) NOT NULL DEFAULT '0' COMMENT '消耗积分',
  `useplatform` varchar(20) NOT NULL COMMENT '运营平台',
  `uid` int(11) NOT NULL COMMENT '用户id',
  PRIMARY KEY (`packid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>