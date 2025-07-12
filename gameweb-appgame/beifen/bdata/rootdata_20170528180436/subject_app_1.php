<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `subject_app`;");
E_C("CREATE TABLE `subject_app` (
  `subjectid` int(11) NOT NULL,
  `appid` int(11) NOT NULL,
  PRIMARY KEY (`subjectid`,`appid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>