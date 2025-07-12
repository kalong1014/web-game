-- phpMyAdmin SQL Dump
-- version 3.1.3.2
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015 年 03 月 04 日 16:05
-- 服务器版本: 5.1.48
-- PHP 版本: 5.2.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- 数据库: ``
--

-- --------------------------------------------------------

--
-- 表的结构 `analyze_data`
--

CREATE TABLE IF NOT EXISTS `analyze_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `webdownnum` int(11) NOT NULL DEFAULT '0' COMMENT 'web下载记录',
  `wapdownnum` int(11) NOT NULL DEFAULT '0' COMMENT 'wap下载记录',
  `khddownnum` int(11) NOT NULL DEFAULT '0' COMMENT '客户端下载记录',
  `ip` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `appid` (`appid`),
  KEY `ip` (`ip`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='下载数据分析表';

-- --------------------------------------------------------

--
-- 表的结构 `appinfo`
--

CREATE TABLE IF NOT EXISTS `appinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `categoryid` int(11) NOT NULL COMMENT '栏目ID',
  `categorypid` int(11) NOT NULL,
  `logo` varchar(150) NOT NULL COMMENT '图标（缩略图）',
  `size` varchar(20) NOT NULL COMMENT '应用大小',
  `score` varchar(20) NOT NULL,
  `briefsummary` varchar(200) NOT NULL COMMENT '简介',
  `downloadcount` mediumint(8) NOT NULL,
  `dateline` int(11) NOT NULL,
  `updatetime` int(11) NOT NULL COMMENT '上传时间',
  `price` varchar(10) NOT NULL COMMENT '价格',
  `dropprice` varchar(10) NOT NULL,
  `adpictureurl` varchar(150) NOT NULL COMMENT '广告图片',
  `haveadvertising` tinyint(1) NOT NULL,
  `havecharge` tinyint(1) NOT NULL,
  `language` varchar(80) NOT NULL,
  `version` varchar(20) NOT NULL,
  `limitfree` tinyint(1) NOT NULL COMMENT '是否限免',
  `isphone` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是手机应用',
  `ispad` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是ipad应用',
  `type` tinyint(1) NOT NULL COMMENT '1 apple 2android 3 wp 4 shouyou',
  `viewnum` int(11) NOT NULL COMMENT '总点击',
  `weeknum` mediumint(8) NOT NULL COMMENT '周点击',
  `daynum` mediumint(8) NOT NULL COMMENT '日点击',
  `isverify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核 0未审核 1审核',
  `isrecommend` int(11) NOT NULL COMMENT '推荐',
  `displayorder` int(11) NOT NULL,
  `apptype` tinyint(1) NOT NULL DEFAULT '1',
  `commentnum` mediumint(8) NOT NULL DEFAULT '0',
  `sourceid` int(11) NOT NULL,
  `star` smallint(2) NOT NULL DEFAULT '0' COMMENT '星星',
  `serverid` int(11) NOT NULL DEFAULT '0',
  `recomsubject` int(11) NOT NULL DEFAULT '0',
  `isdownloadlogo` tinyint(1) NOT NULL DEFAULT '0' COMMENT '缩略图是否下载',
  `isdownloadimg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '图集是否下载',
  `lastview` int(11) NOT NULL DEFAULT '0' COMMENT '最后浏览时间',
  `lastweekview` int(11) NOT NULL DEFAULT '0' COMMENT '周点击更新时间',
  `isupdate` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否更新',
  `wapadpic` varchar(150) NOT NULL COMMENT 'wap端广告图',
  `isAd` tinyint(1) NOT NULL DEFAULT '0',
  `minVersion` varchar(50) NOT NULL,
  `minVersionCode` varchar(50) NOT NULL,
  `developer` varchar(100) NOT NULL,
  `versionCode` varchar(50) NOT NULL,
  `boxLabel` tinyint(4) NOT NULL DEFAULT '0',
  `incomeShare` tinyint(4) NOT NULL DEFAULT '0',
  `message` varchar(300) NOT NULL COMMENT '拒绝留言',
  `orderadpic` int(1) NOT NULL DEFAULT '0' COMMENT '广告图位置',
  PRIMARY KEY (`id`),
  KEY `categoryid` (`categoryid`),
  KEY `categorypid` (`categorypid`),
  KEY `viewnum` (`viewnum`),
  KEY `updatetime` (`updatetime`),
  KEY `weeknum` (`weeknum`),
  KEY `isrecommend` (`isrecommend`),
  KEY `commentnum` (`commentnum`),
  KEY `downloadcount` (`downloadcount`),
  KEY `name` (`name`,`type`),
  KEY `score` (`score`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `app_errors`
--

CREATE TABLE IF NOT EXISTS `app_errors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appid` int(11) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL COMMENT '1 苹果 2 安卓 3 微软',
  `message` varchar(300) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `errors` varchar(50) NOT NULL COMMENT '1:无法下载 2:无法安装启动 3:版本太旧需要更新 4:恶意扣费 5:携带病毒 6:含有恶意插件 7:侵犯版权',
  `dateline` int(11) NOT NULL,
  `isverify` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `categoryid` int(11) NOT NULL AUTO_INCREMENT,
  `categoryname` varchar(50) NOT NULL,
  `engname` varchar(80) NOT NULL,
  `categorypid` int(11) NOT NULL COMMENT '1 游戏；2软件；3壁纸；4资讯',
  `seotitle` varchar(80) NOT NULL,
  `seokeyword` varchar(150) NOT NULL,
  `seodescription` varchar(200) NOT NULL,
  `isapple` tinyint(1) NOT NULL COMMENT '1 iphone;2 ipad',
  `isandroid` tinyint(1) NOT NULL,
  `isrecommend` int(11) NOT NULL COMMENT '是否推荐',
  `redirecturl` varchar(150) NOT NULL COMMENT '栏目外部链接',
  `displayorder` smallint(2) NOT NULL DEFAULT '20',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `isnav` tinyint(1) NOT NULL DEFAULT '1' COMMENT '导航 1：显示 0：不显示',
  `apptype` tinyint(1) NOT NULL DEFAULT '1',
  `isverify` tinyint(1) NOT NULL DEFAULT '1' COMMENT '审核 1 未审核 0',
  `serverid` int(11) NOT NULL COMMENT '服务器端对应ID',
  `iswphone` tinyint(1) NOT NULL,
  `isshouyou` tinyint(1) NOT NULL DEFAULT '0' COMMENT '手游',
  PRIMARY KEY (`categoryid`),
  KEY `engname` (`engname`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父ID',
  `appid` int(11) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0',
  `username` varchar(50) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `dateline` int(11) NOT NULL,
  `message` varchar(3000) NOT NULL,
  `isverify` smallint(1) NOT NULL DEFAULT '0' COMMENT '审核',
  `ipaddress` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `userlogo` varchar(150) NOT NULL,
  `subtype` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1:android 2:apple',
  PRIMARY KEY (`id`),
  KEY `uid` USING BTREE (`uid`) ,
  KEY `appid` (`appid`),
  KEY `dateline` (`dateline`),
  KEY `pid` USING BTREE (`subtype`) ,
  KEY `isaudit` (`isverify`,`pid`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `var` varchar(30) NOT NULL DEFAULT '' COMMENT '配置变量名称',
  `datavalue` text NOT NULL COMMENT '配置变量的值',
  PRIMARY KEY (`var`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `credit`
--

CREATE TABLE IF NOT EXISTS `credit` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `credit_data`
--

CREATE TABLE IF NOT EXISTS `credit_data` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `developer`
--

CREATE TABLE IF NOT EXISTS `developer` (
  `devid` int(11) NOT NULL AUTO_INCREMENT,
  `devname` varchar(100) NOT NULL COMMENT '开发者姓名',
  `summary` varchar(300) NOT NULL COMMENT '介绍',
  `pic` varchar(100) NOT NULL,
  `shortname` varchar(20) NOT NULL,
  `appnum` mediumint(8) NOT NULL COMMENT '应用数量',
  `isverify` tinyint(1) NOT NULL DEFAULT '0',
  `devetype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 开发者；2厂商',
  `tell` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `QQ` int(12) NOT NULL,
  `contactname` varchar(20) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `companyurl` varchar(100) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL,
  `platform` varchar(30) NOT NULL,
  `sfzpic` varchar(150) NOT NULL,
  `yyzzpic` varchar(150) NOT NULL,
  `message` varchar(300) NOT NULL,
  PRIMARY KEY (`devid`),
  KEY `name` USING BTREE (`devname`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `dev_app`
--

CREATE TABLE IF NOT EXISTS `dev_app` (
  `devid` int(11) NOT NULL,
  `appid` int(11) NOT NULL,
  PRIMARY KEY (`devid`,`appid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `email`
--

CREATE TABLE IF NOT EXISTS `email` (
  `uid` int(11) NOT NULL,
  `email_num` varchar(50) NOT NULL,
  `dateline` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  PRIMARY KEY (`email_num`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `handgameinfo`
--

CREATE TABLE IF NOT EXISTS `handgameinfo` (
  `appid` int(11) NOT NULL,
  `summary` text NOT NULL COMMENT '内容',
  `imgurl` varchar(600) NOT NULL COMMENT '图片地址 以@@@连接',
  `sourceurl` varchar(150) NOT NULL COMMENT '官方地址',
  `downurl` text NOT NULL COMMENT '下载地址 以@@@连接',
  `seotitle` varchar(80) NOT NULL,
  `seokeyword` varchar(150) NOT NULL,
  `seodescription` varchar(200) NOT NULL,
  `smallimgurl` varchar(600) NOT NULL,
  `permission` varchar(300) NOT NULL COMMENT '应用权限',
  `updateinfo` varchar(300) NOT NULL COMMENT '版本更新信息',
  `priceinfo` varchar(200) NOT NULL COMMENT '付费信息',
  `yystate` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1 运营;2 公测;3 内测 4 封测; 5 预告',
  `dlogo` varchar(200) NOT NULL COMMENT '详细页大图',
  `iosdownurl` text NOT NULL COMMENT '苹果下载地址',
  `developers` varchar(20) NOT NULL,
  PRIMARY KEY (`appid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `newsinfo`
--

CREATE TABLE IF NOT EXISTS `newsinfo` (
  `newid` int(11) NOT NULL AUTO_INCREMENT,
  `categoryid` int(11) NOT NULL,
  `categorypid` int(11) NOT NULL,
  `logo` varchar(150) NOT NULL COMMENT '缩略图',
  `title` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `isrecommend` int(11) NOT NULL,
  `viewnum` int(11) NOT NULL,
  `weeknum` int(11) NOT NULL,
  `daynum` int(11) NOT NULL,
  `isverify` tinyint(1) NOT NULL,
  `displayorder` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `dateline` int(11) NOT NULL,
  `sourceurl` varchar(200) NOT NULL,
  `isad` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是不是广告  android首页的滚动',
  `adpic` varchar(150) NOT NULL COMMENT '广告图片',
  `serverid` int(11) NOT NULL COMMENT '服务器端对应ID',
  `isphone` tinyint(1) NOT NULL DEFAULT '0',
  `ispad` tinyint(1) NOT NULL DEFAULT '0',
  `isdownloadimg` tinyint(1) NOT NULL DEFAULT '0',
  `isdownloadpic` tinyint(1) NOT NULL DEFAULT '0',
  `appid` int(11) NOT NULL DEFAULT '0' COMMENT '关联的应用id',
  `message` varchar(300) NOT NULL COMMENT '拒绝留言',
  PRIMARY KEY (`newid`),
  KEY `categoryid` (`categoryid`),
  KEY `categorypid` (`categorypid`),
  KEY `isrecommend` (`isrecommend`),
  KEY `viewnum` (`viewnum`),
  KEY `dateline` (`dateline`),
  KEY `isverify` USING BTREE (`isverify`,`type`,`isad`) ,
  KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `news_data`
--

CREATE TABLE IF NOT EXISTS `news_data` (
  `newid` int(11) NOT NULL,
  `content` text NOT NULL,
  `seotitle` varchar(80) NOT NULL,
  `seokeyword` varchar(150) NOT NULL,
  `seodescription` varchar(200) NOT NULL,
  PRIMARY KEY (`newid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `new_app`
--

CREATE TABLE IF NOT EXISTS `new_app` (
  `newid` int(11) NOT NULL,
  `appid` int(11) NOT NULL,
  PRIMARY KEY (`newid`,`appid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `opengame`
--

CREATE TABLE IF NOT EXISTS `opengame` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `gamename` varchar(30) NOT NULL,
  `addressnum` varchar(20) NOT NULL,
  `starttime` int(11) NOT NULL,
  `gameurl` varchar(200) NOT NULL,
  `dateline` int(11) NOT NULL,
  `isrecommend` tinyint(1) NOT NULL DEFAULT '0',
  `isverify` tinyint(1) NOT NULL DEFAULT '0',
  `devid` mediumint(8) NOT NULL,
  `isandroid` tinyint(1) NOT NULL DEFAULT '0',
  `isios` tinyint(1) NOT NULL DEFAULT '0',
  `appid` int(11) NOT NULL,
  `message` varchar(300) NOT NULL,
  `useplatform` varchar(30) NOT NULL COMMENT '运营平台',
  `uid` int(11) NOT NULL COMMENT '用户id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `otherlogin_user`
--

CREATE TABLE IF NOT EXISTS `otherlogin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(100) NOT NULL,
  `openid` varchar(100) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `uid` int(8) NOT NULL,
  `logo` varchar(200) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 qq用户 2 微博用户',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `packs`
--

CREATE TABLE IF NOT EXISTS `packs` (
  `packid` int(5) NOT NULL AUTO_INCREMENT,
  `serverid` int(5) NOT NULL DEFAULT '0',
  `addressnum` varchar(10) NOT NULL,
  `starttime` int(11) NOT NULL,
  `endtime` int(11) NOT NULL,
  `packtype` tinyint(1) NOT NULL DEFAULT '1',
  `packname` varchar(30) NOT NULL,
  `packurl` varchar(100) NOT NULL,
  `packcontent` varchar(500) NOT NULL,
  `packuse` varchar(500) NOT NULL,
  `gameurl` varchar(150) NOT NULL COMMENT '游戏地址',
  `activate` varchar(150) CHARACTER SET utf8 COLLATE utf8_icelandic_ci NOT NULL COMMENT '激活地址',
  `dateline` int(11) NOT NULL,
  `isrecommend` tinyint(1) NOT NULL DEFAULT '0',
  `isverify` tinyint(1) NOT NULL DEFAULT '0',
  `devid` int(8) NOT NULL DEFAULT '0',
  `packlogo` varchar(150) NOT NULL,
  `isandroid` tinyint(1) NOT NULL DEFAULT '0',
  `isios` tinyint(1) NOT NULL DEFAULT '0',
  `packfl` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 开服礼包 2 开测礼包',
  `appid` int(11) NOT NULL,
  `message` varchar(300) NOT NULL,
  `usecredit` int(8) NOT NULL DEFAULT '0' COMMENT '消耗积分',
  `useplatform` varchar(20) NOT NULL COMMENT '运营平台',
  `uid` int(11) NOT NULL COMMENT '用户id',
  PRIMARY KEY (`packid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `pack_card`
--

CREATE TABLE IF NOT EXISTS `pack_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL COMMENT '礼包id',
  `dateline` int(11) NOT NULL,
  `statue` tinyint(1) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL,
  `card` varchar(20) NOT NULL COMMENT '卡号',
  `isverify` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `platform_downurl`
--

CREATE TABLE IF NOT EXISTS `platform_downurl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `devid` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 安卓 2苹果 3 微软',
  `downurl` varchar(200) NOT NULL,
  `isrecommend` tinyint(1) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL,
  `appid` int(11) NOT NULL,
  `isverify` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `searchkey`
--

CREATE TABLE IF NOT EXISTS `searchkey` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isshouyou` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是不是手游-',
  `name` varchar(50) NOT NULL,
  `engname` varchar(100) NOT NULL,
  `isrecommend` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL,
  `sysearchnum` mediumint(8) NOT NULL DEFAULT '0' COMMENT '搜索次数',
  PRIMARY KEY (`id`),
  KEY `lasttime` USING BTREE (`dateline`,`isrecommend`) 
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `send_message`
--

CREATE TABLE IF NOT EXISTS `send_message` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `message` varchar(300) NOT NULL,
  `packid` int(11) NOT NULL,
  `murl` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='消息表';

-- --------------------------------------------------------

--
-- 表的结构 `session`
--

CREATE TABLE IF NOT EXISTS `session` (
  `uid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `dateline` int(11) NOT NULL,
  `ip` varchar(50) NOT NULL
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subjectname` varchar(50) NOT NULL,
  `summary` text NOT NULL COMMENT '介绍',
  `logo` varchar(150) NOT NULL,
  `subjectpic` varchar(150) NOT NULL,
  `dateline` int(11) NOT NULL,
  `viewnum` int(11) NOT NULL,
  `seotitle` varchar(80) NOT NULL,
  `seokeyword` varchar(150) NOT NULL,
  `seodescription` varchar(200) NOT NULL,
  `appnum` mediumint(8) NOT NULL,
  `slogo` varchar(100) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `isverify` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否审核',
  `isrecommend` int(11) NOT NULL DEFAULT '0' COMMENT '推荐',
  `dbrecommend` int(11) NOT NULL DEFAULT '0',
  `serverid` int(11) NOT NULL DEFAULT '0' COMMENT '服务器对应ID 0为该站自己发布',
  `isdownloadimg` smallint(1) NOT NULL COMMENT '是否下载图片',
  `subtype` tinyint(1) NOT NULL DEFAULT '1',
  `engname` varchar(50) NOT NULL,
  `sublx` tinyint(1) NOT NULL,
  `isdownloadlogo` tinyint(1) NOT NULL DEFAULT '0',
  `isphone` tinyint(1) NOT NULL DEFAULT '0' COMMENT '手机专辑',
  `ispad` tinyint(1) NOT NULL DEFAULT '0' COMMENT '平板专辑',
  PRIMARY KEY (`id`),
  KEY `subtype` (`subtype`),
  KEY `isverify` (`isverify`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `subject_app`
--

CREATE TABLE IF NOT EXISTS `subject_app` (
  `subjectid` int(11) NOT NULL,
  `appid` int(11) NOT NULL,
  PRIMARY KEY (`subjectid`,`appid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `subject_category`
--

CREATE TABLE IF NOT EXISTS `subject_category` (
  `categoryid` int(11) NOT NULL,
  `subjectid` int(11) NOT NULL,
  PRIMARY KEY (`categoryid`,`subjectid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `tag_app`
--

CREATE TABLE IF NOT EXISTS `tag_app` (
  `tagid` int(11) NOT NULL,
  `appid` int(11) NOT NULL,
  PRIMARY KEY (`tagid`,`appid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `testgame`
--

CREATE TABLE IF NOT EXISTS `testgame` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `devid` int(8) NOT NULL,
  `gamename` varchar(20) NOT NULL,
  `starttime` int(11) NOT NULL,
  `dateline` int(11) NOT NULL,
  `testtype` tinyint(1) NOT NULL DEFAULT '1',
  `isrecommend` tinyint(1) NOT NULL DEFAULT '0',
  `isverify` tinyint(1) NOT NULL DEFAULT '0',
  `gameurl` varchar(150) NOT NULL,
  `logo` varchar(150) NOT NULL,
  `isandroid` tinyint(1) NOT NULL DEFAULT '0',
  `isios` tinyint(1) NOT NULL DEFAULT '0',
  `appid` int(11) NOT NULL,
  `addressnum` varchar(20) NOT NULL,
  `message` varchar(300) NOT NULL,
  `useplatform` varchar(30) NOT NULL COMMENT '运营平台',
  `uid` int(11) NOT NULL COMMENT '用户id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `uid_appid`
--

CREATE TABLE IF NOT EXISTS `uid_appid` (
  `uid` int(11) NOT NULL,
  `appid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL,
  PRIMARY KEY (`uid`,`appid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='关注提醒表';

-- --------------------------------------------------------

--
-- 表的结构 `uid_msg`
--

CREATE TABLE IF NOT EXISTS `uid_msg` (
  `mid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1 已读 0 未读',
  `dateline` int(11) NOT NULL,
  PRIMARY KEY (`mid`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户消息表';

-- --------------------------------------------------------

--
-- 表的结构 `uploads`
--

CREATE TABLE IF NOT EXISTS `uploads` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_data`
--

CREATE TABLE IF NOT EXISTS `user_data` (
  `uid` int(11) NOT NULL,
  `zxid` mediumint(8) NOT NULL,
  `dateline` int(11) NOT NULL,
  `type` mediumint(3) NOT NULL COMMENT '1,下载，2 上传app 3 上传news',
  KEY `uid` (`uid`),
  KEY `dateline` (`dateline`),
  KEY `zxid` (`zxid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_group`
--

CREATE TABLE IF NOT EXISTS `user_group` (
  `group_id` mediumint(3) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `isapps` int(1) NOT NULL DEFAULT '0',
  `isnews` int(1) NOT NULL DEFAULT '0',
  `isopen` tinyint(1) NOT NULL DEFAULT '0',

  `istest` tinyint(1) NOT NULL DEFAULT '0',
  `ispack` tinyint(1) NOT NULL DEFAULT '0',
  `type` int(1) NOT NULL DEFAULT '1' COMMENT '1 特殊 2普通',
  `lowerexperience` int(11) NOT NULL DEFAULT '0' COMMENT '下线',
  `upexperience` int(11) NOT NULL DEFAULT '0' COMMENT '上线',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
