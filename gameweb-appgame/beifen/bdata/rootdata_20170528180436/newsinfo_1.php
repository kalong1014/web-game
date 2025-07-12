<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `newsinfo`;");
E_C("CREATE TABLE `newsinfo` (
  `newid` int(11) NOT NULL AUTO_INCREMENT,
  `categoryid` int(11) NOT NULL,
  `categorypid` int(11) NOT NULL,
  `logo` varchar(150) NOT NULL COMMENT '缩略图',
  `title` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `isrecommend` int(11) NOT NULL,
  `viewnum` int(11) NOT NULL,
  `weeknum` int(11) NOT NULL,
  `daynum` int(11) NOT NULL,
  `isverify` tinyint(1) NOT NULL,
  `displayorder` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `dateline` int(11) NOT NULL,
  `sourceurl` varchar(200) NOT NULL,
  `isad` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是不是广告  android首页的滚动',
  `adpic` varchar(150) NOT NULL COMMENT '广告图片',
  `serverid` int(11) NOT NULL COMMENT '服务器端对应ID',
  `isphone` tinyint(1) NOT NULL DEFAULT '0',
  `ispad` tinyint(1) NOT NULL DEFAULT '0',
  `isdownloadimg` tinyint(1) NOT NULL DEFAULT '0',
  `isdownloadpic` tinyint(1) NOT NULL DEFAULT '0',
  `appid` int(11) NOT NULL DEFAULT '0' COMMENT '关联的应用id',
  `message` varchar(300) NOT NULL COMMENT '拒绝留言',
  PRIMARY KEY (`newid`),
  KEY `categoryid` (`categoryid`),
  KEY `categorypid` (`categorypid`),
  KEY `isrecommend` (`isrecommend`),
  KEY `viewnum` (`viewnum`),
  KEY `dateline` (`dateline`),
  KEY `isverify` (`isverify`,`type`,`isad`) USING BTREE,
  KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>