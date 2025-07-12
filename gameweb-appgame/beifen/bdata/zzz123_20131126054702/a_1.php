<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('latin1');
E_D("DROP TABLE IF EXISTS `a`;");
E_C("CREATE TABLE `a` (
  `n` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1");

require("../../inc/footer.php");
?>