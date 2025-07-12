<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `news_data`;");
E_C("CREATE TABLE `news_data` (
  `newid` int(11) NOT NULL,
  `content` text NOT NULL,
  `seotitle` varchar(80) NOT NULL,
  `seokeyword` varchar(150) NOT NULL,
  `seodescription` varchar(200) NOT NULL,
  PRIMARY KEY (`newid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>