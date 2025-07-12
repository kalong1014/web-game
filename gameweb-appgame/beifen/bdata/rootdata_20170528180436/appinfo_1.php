<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `appinfo`;");
E_C("CREATE TABLE `appinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `categoryid` int(11) NOT NULL COMMENT '栏目ID',
  `categorypid` int(11) NOT NULL,
  `logo` varchar(150) NOT NULL COMMENT '图标（缩略图）',
  `size` varchar(20) NOT NULL COMMENT '应用大小',
  `score` varchar(20) NOT NULL,
  `briefsummary` varchar(200) NOT NULL COMMENT '简介',
  `downloadcount` mediumint(8) NOT NULL,
  `dateline` int(11) NOT NULL,
  `updatetime` int(11) NOT NULL COMMENT '上传时间',
  `price` varchar(10) NOT NULL COMMENT '价格',
  `dropprice` varchar(10) NOT NULL,
  `adpictureurl` varchar(150) NOT NULL COMMENT '广告图片',
  `haveadvertising` tinyint(1) NOT NULL,
  `havecharge` tinyint(1) NOT NULL,
  `language` varchar(80) NOT NULL,
  `version` varchar(20) NOT NULL,
  `limitfree` tinyint(1) NOT NULL COMMENT '是否限免',
  `isphone` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是手机应用',
  `ispad` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是ipad应用',
  `type` tinyint(1) NOT NULL COMMENT '1 apple 2android 3 wp 4 shouyou',
  `viewnum` int(11) NOT NULL COMMENT '总点击',
  `weeknum` mediumint(8) NOT NULL COMMENT '周点击',
  `daynum` mediumint(8) NOT NULL COMMENT '日点击',
  `isverify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核 0未审核 1审核',
  `isrecommend` int(11) NOT NULL COMMENT '推荐',
  `displayorder` int(11) NOT NULL,
  `apptype` tinyint(1) NOT NULL DEFAULT '1',
  `commentnum` mediumint(8) NOT NULL DEFAULT '0',
  `sourceid` int(11) NOT NULL,
  `star` smallint(2) NOT NULL DEFAULT '0' COMMENT '星星',
  `serverid` int(11) NOT NULL DEFAULT '0',
  `recomsubject` int(11) NOT NULL DEFAULT '0',
  `isdownloadlogo` tinyint(1) NOT NULL DEFAULT '0' COMMENT '缩略图是否下载',
  `isdownloadimg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '图集是否下载',
  `lastview` int(11) NOT NULL DEFAULT '0' COMMENT '最后浏览时间',
  `lastweekview` int(11) NOT NULL DEFAULT '0' COMMENT '周点击更新时间',
  `isupdate` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否更新',
  `wapadpic` varchar(150) NOT NULL COMMENT 'wap端广告图',
  `isAd` tinyint(1) NOT NULL DEFAULT '0',
  `minVersion` varchar(50) NOT NULL,
  `minVersionCode` varchar(50) NOT NULL,
  `developer` varchar(100) NOT NULL,
  `versionCode` varchar(50) NOT NULL,
  `boxLabel` tinyint(4) NOT NULL DEFAULT '0',
  `incomeShare` tinyint(4) NOT NULL DEFAULT '0',
  `message` varchar(300) NOT NULL COMMENT '拒绝留言',
  `orderadpic` int(1) NOT NULL DEFAULT '0' COMMENT '广告图位置',
  PRIMARY KEY (`id`),
  KEY `categoryid` (`categoryid`),
  KEY `categorypid` (`categorypid`),
  KEY `viewnum` (`viewnum`),
  KEY `updatetime` (`updatetime`),
  KEY `weeknum` (`weeknum`),
  KEY `isrecommend` (`isrecommend`),
  KEY `commentnum` (`commentnum`),
  KEY `downloadcount` (`downloadcount`),
  KEY `name` (`name`,`type`),
  KEY `score` (`score`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>