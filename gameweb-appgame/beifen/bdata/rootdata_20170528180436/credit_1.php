<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `credit`;");
E_C("CREATE TABLE `credit` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `type` int(2) NOT NULL DEFAULT '0' COMMENT '操作',
  `cycle` int(1) NOT NULL DEFAULT '1' COMMENT '周期 1 一次性 2 每天 3 无限周期',
  `getnum` int(3) NOT NULL COMMENT '次数',
  `reward` varchar(10) NOT NULL DEFAULT '1' COMMENT ' 奖励方式 1 加 0 减  ',
  `credit` int(5) NOT NULL COMMENT '积分',
  `experience` int(5) NOT NULL COMMENT '经验值',
  `addcredit` int(5) NOT NULL DEFAULT '0' COMMENT '签到叠加',
  `limitdaynum` int(5) NOT NULL DEFAULT '7' COMMENT '上限天数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8");
E_D("replace into `credit` values('1','1','1','1','1','12','5','0','7');");
E_D("replace into `credit` values('2','2','2','1','1','1','1','0','7');");
E_D("replace into `credit` values('3','3','1','2','1','1','1','1','7');");
E_D("replace into `credit` values('4','4','2','5','1','1','1','0','7');");
E_D("replace into `credit` values('5','5','2','2','1','2','2','0','7');");
E_D("replace into `credit` values('6','6','2','5','1','2','2','0','7');");
E_D("replace into `credit` values('7','7','2','1','1','1','1','0','7');");
E_D("replace into `credit` values('8','8','2','1','1','1','1','0','7');");
E_D("replace into `credit` values('9','9','2','1','1','1','1','0','7');");
E_D("replace into `credit` values('10','10','2','1','1','1','1','0','7');");
E_D("replace into `credit` values('11','11','2','10','1','2','2','0','7');");
E_D("replace into `credit` values('12','12','2','1','1','2','2','2','7');");
E_D("replace into `credit` values('13','13','2','200','2','0','0','0','1');");

require("../../inc/footer.php");
?>