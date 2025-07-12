<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `user`;");
E_C("CREATE TABLE `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `regip` varchar(15) NOT NULL COMMENT '注册IP',
  `salt` varchar(6) NOT NULL,
  `addtime` int(11) NOT NULL COMMENT '注册时间',
  `lastlogin` int(11) NOT NULL COMMENT '最后登陆的时间',
  `loginnum` mediumint(8) NOT NULL DEFAULT '1' COMMENT '登录次数',
  `is_admin` int(11) NOT NULL DEFAULT '0',
  `tell` varchar(20) NOT NULL,
  `userqq` varchar(12) NOT NULL,
  `group_id` mediumint(3) NOT NULL DEFAULT '3',
  `userlogo` varchar(150) NOT NULL,
  `realname` varchar(12) NOT NULL,
  `idnumber` varchar(20) NOT NULL,
  `count_credit` int(11) NOT NULL DEFAULT '0' COMMENT '总积分',
  `count_experience` int(11) NOT NULL DEFAULT '0' COMMENT '总经验',
  PRIMARY KEY (`uid`),
  KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8");
E_D("replace into `user` values('1','admin','28dfe69adc2672156e5762862ee819bf','572724219@qq.com','unknown','746821','1495904055','1495904055','1','1','','','1','','','','1','1');");

require("../../inc/footer.php");
?>