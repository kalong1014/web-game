<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `otherlogin_user`;");
E_C("CREATE TABLE `otherlogin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(100) NOT NULL,
  `openid` varchar(100) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `uid` int(8) NOT NULL,
  `logo` varchar(200) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 qq用户 2 微博用户',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>