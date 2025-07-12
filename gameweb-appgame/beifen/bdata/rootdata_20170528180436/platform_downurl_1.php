<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `platform_downurl`;");
E_C("CREATE TABLE `platform_downurl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `devid` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 安卓 2苹果 3 微软',
  `downurl` varchar(200) NOT NULL,
  `isrecommend` tinyint(1) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL,
  `appid` int(11) NOT NULL,
  `isverify` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>