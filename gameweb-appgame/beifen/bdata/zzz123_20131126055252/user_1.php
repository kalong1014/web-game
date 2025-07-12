<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `user`;");
E_C("CREATE TABLE `user` (
  `uid` mediumint(8) NOT NULL auto_increment,
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `regip` varchar(15) NOT NULL COMMENT '注册IP',
  `salt` varchar(6) NOT NULL,
  `addtime` int(11) NOT NULL COMMENT '注册时间',
  `lastlogin` int(11) NOT NULL COMMENT '最后登陆的时间',
  `loginnum` mediumint(8) NOT NULL default '1' COMMENT '登录次数',
  `is_admin` int(11) NOT NULL default '0',
  PRIMARY KEY  (`uid`),
  KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8");
E_D("replace into `user` values('1','admin','8d1c82631c7d601adf983c9cad94e466','123456@qq.com','127.0.0.1','c8d24e','1384843676','1384843676','1','1');");

require("../../inc/footer.php");
?>