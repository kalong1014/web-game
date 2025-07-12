<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `category`;");
E_C("CREATE TABLE `category` (
  `categoryid` int(11) NOT NULL AUTO_INCREMENT,
  `categoryname` varchar(50) NOT NULL,
  `engname` varchar(80) NOT NULL,
  `categorypid` int(11) NOT NULL COMMENT '1 游戏；2软件；3壁纸；4资讯',
  `seotitle` varchar(80) NOT NULL,
  `seokeyword` varchar(150) NOT NULL,
  `seodescription` varchar(200) NOT NULL,
  `isapple` tinyint(1) NOT NULL COMMENT '1 iphone;2 ipad',
  `isandroid` tinyint(1) NOT NULL,
  `isrecommend` int(11) NOT NULL COMMENT '是否推荐',
  `redirecturl` varchar(150) NOT NULL COMMENT '栏目外部链接',
  `displayorder` smallint(2) NOT NULL DEFAULT '20',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `isnav` tinyint(1) NOT NULL DEFAULT '1' COMMENT '导航 1：显示 0：不显示',
  `apptype` tinyint(1) NOT NULL DEFAULT '1',
  `isverify` tinyint(1) NOT NULL DEFAULT '1' COMMENT '审核 1 未审核 0',
  `serverid` int(11) NOT NULL COMMENT '服务器端对应ID',
  `iswphone` tinyint(1) NOT NULL,
  `isshouyou` tinyint(1) NOT NULL DEFAULT '0' COMMENT '手游',
  PRIMARY KEY (`categoryid`),
  KEY `engname` (`engname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>