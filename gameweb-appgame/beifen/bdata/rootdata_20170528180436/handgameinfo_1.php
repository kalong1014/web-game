<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `handgameinfo`;");
E_C("CREATE TABLE `handgameinfo` (
  `appid` int(11) NOT NULL,
  `summary` text NOT NULL COMMENT '内容',
  `imgurl` varchar(600) NOT NULL COMMENT '图片地址 以@@@连接',
  `sourceurl` varchar(150) NOT NULL COMMENT '官方地址',
  `downurl` text NOT NULL COMMENT '下载地址 以@@@连接',
  `seotitle` varchar(80) NOT NULL,
  `seokeyword` varchar(150) NOT NULL,
  `seodescription` varchar(200) NOT NULL,
  `smallimgurl` varchar(600) NOT NULL,
  `permission` varchar(300) NOT NULL COMMENT '应用权限',
  `updateinfo` varchar(300) NOT NULL COMMENT '版本更新信息',
  `priceinfo` varchar(200) NOT NULL COMMENT '付费信息',
  `yystate` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1 运营;2 公测;3 内测 4 封测; 5 预告',
  `dlogo` varchar(200) NOT NULL COMMENT '详细页大图',
  `iosdownurl` text NOT NULL COMMENT '苹果下载地址',
  `developers` varchar(20) NOT NULL,
  PRIMARY KEY (`appid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>