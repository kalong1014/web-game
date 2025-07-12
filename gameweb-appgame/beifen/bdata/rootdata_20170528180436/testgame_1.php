<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `testgame`;");
E_C("CREATE TABLE `testgame` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `devid` int(8) NOT NULL,
  `gamename` varchar(20) NOT NULL,
  `starttime` int(11) NOT NULL,
  `dateline` int(11) NOT NULL,
  `testtype` tinyint(1) NOT NULL DEFAULT '1',
  `isrecommend` tinyint(1) NOT NULL DEFAULT '0',
  `isverify` tinyint(1) NOT NULL DEFAULT '0',
  `gameurl` varchar(150) NOT NULL,
  `logo` varchar(150) NOT NULL,
  `isandroid` tinyint(1) NOT NULL DEFAULT '0',
  `isios` tinyint(1) NOT NULL DEFAULT '0',
  `appid` int(11) NOT NULL,
  `addressnum` varchar(20) NOT NULL,
  `message` varchar(300) NOT NULL,
  `useplatform` varchar(30) NOT NULL COMMENT '运营平台',
  `uid` int(11) NOT NULL COMMENT '用户id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>