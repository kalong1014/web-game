<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `send_message`;");
E_C("CREATE TABLE `send_message` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `message` varchar(300) NOT NULL,
  `packid` int(11) NOT NULL,
  `murl` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>