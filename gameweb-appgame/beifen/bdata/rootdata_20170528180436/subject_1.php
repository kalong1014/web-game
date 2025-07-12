<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `subject`;");
E_C("CREATE TABLE `subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subjectname` varchar(50) NOT NULL,
  `summary` text NOT NULL COMMENT '介绍',
  `logo` varchar(150) NOT NULL,
  `subjectpic` varchar(150) NOT NULL,
  `dateline` int(11) NOT NULL,
  `viewnum` int(11) NOT NULL,
  `seotitle` varchar(80) NOT NULL,
  `seokeyword` varchar(150) NOT NULL,
  `seodescription` varchar(200) NOT NULL,
  `appnum` mediumint(8) NOT NULL,
  `slogo` varchar(100) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `isverify` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否审核',
  `isrecommend` int(11) NOT NULL DEFAULT '0' COMMENT '推荐',
  `dbrecommend` int(11) NOT NULL DEFAULT '0',
  `serverid` int(11) NOT NULL DEFAULT '0' COMMENT '服务器对应ID 0为该站自己发布',
  `isdownloadimg` smallint(1) NOT NULL COMMENT '是否下载图片',
  `subtype` tinyint(1) NOT NULL DEFAULT '1',
  `engname` varchar(50) NOT NULL,
  `sublx` tinyint(1) NOT NULL,
  `isdownloadlogo` tinyint(1) NOT NULL DEFAULT '0',
  `isphone` tinyint(1) NOT NULL DEFAULT '0' COMMENT '手机专辑',
  `ispad` tinyint(1) NOT NULL DEFAULT '0' COMMENT '平板专辑',
  PRIMARY KEY (`id`),
  KEY `subtype` (`subtype`),
  KEY `isverify` (`isverify`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>