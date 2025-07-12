<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `tag`;");
E_C("CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tagname` varchar(50) NOT NULL,
  `engname` varchar(50) NOT NULL,
  `dateline` int(11) NOT NULL,
  `seotitle` varchar(80) NOT NULL,
  `seokeyword` varchar(150) NOT NULL,
  `seodescription` varchar(200) NOT NULL,
  `viewnum` int(11) NOT NULL,
  `isrecommend` tinyint(1) NOT NULL DEFAULT '0',
  `servertid` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>