<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `app_errors`;");
E_C("CREATE TABLE `app_errors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appid` int(11) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL COMMENT '1 苹果 2 安卓 3 微软',
  `message` varchar(300) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `errors` varchar(50) NOT NULL COMMENT '1:无法下载 2:无法安装启动 3:版本太旧需要更新 4:恶意扣费 5:携带病毒 6:含有恶意插件 7:侵犯版权',
  `dateline` int(11) NOT NULL,
  `isverify` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>