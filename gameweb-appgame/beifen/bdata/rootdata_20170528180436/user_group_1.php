<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `user_group`;");
E_C("CREATE TABLE `user_group` (
  `group_id` mediumint(3) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `isapps` int(1) NOT NULL DEFAULT '0',
  `isnews` int(1) NOT NULL DEFAULT '0',
  `isopen` tinyint(1) NOT NULL DEFAULT '0',
  `istest` tinyint(1) NOT NULL DEFAULT '0',
  `ispack` tinyint(1) NOT NULL DEFAULT '0',
  `type` int(1) NOT NULL DEFAULT '1' COMMENT '1 特殊 2普通',
  `lowerexperience` int(11) NOT NULL DEFAULT '0' COMMENT '下线',
  `upexperience` int(11) NOT NULL DEFAULT '0' COMMENT '上线',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8");
E_D("replace into `user_group` values('1','管理员','1','1','0','0','0','1','0','0');");
E_D("replace into `user_group` values('2','开发者会员','1','1','0','0','0','1','0','0');");
E_D("replace into `user_group` values('3','普通会员','0','0','0','0','0','1','0','0');");

require("../../inc/footer.php");
?>