<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `uploads`;");
E_C("CREATE TABLE `uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `aid` int(11) NOT NULL DEFAULT '0',
  `uptime` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `url` varchar(150) NOT NULL,
  `mediatype` varchar(20) NOT NULL,
  `width` smallint(3) NOT NULL,
  `height` smallint(3) NOT NULL,
  `playtime` int(11) NOT NULL,
  `filesize` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8");
E_D("replace into `uploads` values('1','0','0','1376617037','130816093717.jpg','/attachment/apple/images/1308/130816093717.jpg','image/jpeg','0','0','0','29634');");
E_D("replace into `uploads` values('2','0','0','1376979840','130820142400.png','/attachment/apple/images/1308/130820142400.png','image/png','0','0','0','2369');");
E_D("replace into `uploads` values('3','0','0','1376979848','130820142408.jpg','/attachment/apple/images/1308/130820142408.jpg','image/jpeg','0','0','0','227700');");
E_D("replace into `uploads` values('4','0','0','1376979855','130820142415.jpg','/attachment/apple/images/1308/130820142415.jpg','image/jpeg','0','0','0','99815');");

require("../../inc/footer.php");
?>