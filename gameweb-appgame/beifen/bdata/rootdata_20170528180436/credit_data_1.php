<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `credit_data`;");
E_C("CREATE TABLE `credit_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `type` int(3) NOT NULL COMMENT '操作',
  `credit` int(5) NOT NULL COMMENT '获取积分',
  `experience` int(5) NOT NULL COMMENT '经验值',
  `loginnum` int(5) NOT NULL DEFAULT '1' COMMENT '连续签到天数',
  `czreward` int(1) NOT NULL DEFAULT '1' COMMENT '1 获取，2 减少',
  `dateline` int(11) NOT NULL COMMENT '操作时间',
  `isverify` int(1) NOT NULL DEFAULT '0',
  `uploadtype` int(1) NOT NULL DEFAULT '0' COMMENT '0 不是上传 1 应用 2 资讯 3 礼包 4 开服 5开测 ',
  `uploadid` int(11) NOT NULL DEFAULT '0' COMMENT '上传id',
  PRIMARY KEY (`id`),
  KEY `dateline` (`dateline`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8");
E_D("replace into `credit_data` values('1','1','2','1','1','1','1','1495904106','1','0','0');");

require("../../inc/footer.php");
?>