<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `pack_card`;");
E_C("CREATE TABLE `pack_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL COMMENT '礼包id',
  `dateline` int(11) NOT NULL,
  `statue` tinyint(1) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL,
  `card` varchar(20) NOT NULL COMMENT '卡号',
  `isverify` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>