-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 03 月 11 日 04:56
-- 服务器版本: 5.5.53
-- PHP 版本: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `jichuban`
--

-- --------------------------------------------------------

--
-- 表的结构 `ask_ad`
--

CREATE TABLE IF NOT EXISTS `ask_ad` (
  `html` text,
  `page` varchar(50) NOT NULL DEFAULT '',
  `position` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`page`,`position`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ask_answer`
--

CREATE TABLE IF NOT EXISTS `ask_answer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` char(50) NOT NULL,
  `author` varchar(15) NOT NULL DEFAULT '',
  `authorid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `adopttime` int(10) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  `comments` int(10) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `ip` varchar(20) DEFAULT NULL,
  `supports` int(10) NOT NULL DEFAULT '0',
  `reward` int(10) DEFAULT '0',
  `serverid` varchar(200) DEFAULT NULL,
  `openid` varchar(200) DEFAULT NULL,
  `voicetime` int(10) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `qid` (`qid`),
  KEY `authorid` (`authorid`),
  KEY `adopttime` (`adopttime`),
  KEY `time` (`time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=857 ;

-- --------------------------------------------------------

--
-- 表的结构 `ask_answer_append`
--

CREATE TABLE IF NOT EXISTS `ask_answer_append` (
  `appendanswerid` int(10) NOT NULL AUTO_INCREMENT,
  `answerid` int(10) NOT NULL,
  `author` varchar(20) NOT NULL,
  `authorid` int(10) NOT NULL,
  `content` text NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`appendanswerid`),
  KEY `answerid` (`answerid`),
  KEY `authorid` (`authorid`),
  KEY `time` (`time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `ask_answer_comment`
--

CREATE TABLE IF NOT EXISTS `ask_answer_comment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aid` int(10) NOT NULL,
  `authorid` int(10) NOT NULL,
  `author` char(18) NOT NULL,
  `content` varchar(100) NOT NULL,
  `time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=286 ;

--
-- 转存表中的数据 `ask_answer_comment`
--

INSERT INTO `ask_answer_comment` (`id`, `aid`, `authorid`, `author`, `content`, `time`) VALUES
(1, 4, 1, 'admin', '非常感谢你', 1448242667),
(2, 6, 2, '小新6868', '你真的帮了我大忙', 1448242668),
(3, 7, 1, 'admin', '真给力', 1448242672),
(4, 10, 2, '小新6868', '真给力', 1448242673),
(5, 12, 1, 'admin', '高手留个联系方式吧', 1448242675),
(6, 13, 6, 'cashcage', '真给力', 1448242676),
(7, 15, 6, 'cashcage', '你真的帮了我大忙', 1448242679),
(8, 20, 3, '傲月怡然', '大神......', 1448242682),
(9, 22, 3, '傲月怡然', '谢谢你', 1448242684),
(10, 24, 6, 'cashcage', '你真是个大好人', 1448242686),
(11, 28, 2, '小新6868', '真给力', 1448242689),
(12, 31, 7, '派派爱哦妈', '你真是个大好人', 1448242691),
(13, 32, 16, '伯爵0616', '非常感谢你', 1448242692),
(14, 33, 13, '胖尧2015', '你真的帮了我大忙', 1448242707),
(15, 36, 4, 'Forpuny', '大神......', 1448242708),
(16, 39, 8, '风吹PP凉晾JJ', '高手留个联系方式吧', 1448242710),
(17, 42, 13, '胖尧2015', '你真的帮了我大忙', 1448242721),
(18, 43, 23, '鱼尾飘香', '真给力', 1448242722),
(19, 47, 26, 'ASS0707', '真给力', 1448242724),
(20, 57, 18, '淘宝话费充值卖家', '真给力', 1448242726),
(21, 67, 41, 'zeng017', '大神......', 1448242728),
(22, 75, 17, '休Se', '真给力', 1448242730),
(23, 91, 47, 'cqupt_zjy9', '你真的帮了我大忙', 1448242733),
(24, 96, 65, '东瞅瞅西望望', '你真是个大好人', 1448242735),
(25, 100, 12, '爱上了你TEL', '你真的帮了我大忙', 1448242786),
(26, 104, 39, '布帅呢', '你真是个大好人', 1448242800),
(27, 106, 75, '爆逗', '谢谢你', 1448242802),
(28, 107, 70, '月落下的郁', '非常感谢你', 1448242803),
(29, 109, 36, '星空_小木公子', '高手留个联系方式吧', 1448242804),
(30, 114, 12, '爱上了你TEL', '真给力', 1448242806),
(31, 123, 83, '风之舞love', '你真的帮了我大忙', 1448242808),
(32, 127, 29, '厉小豆', '非常感谢你', 1448242811),
(33, 129, 90, '楚乌神', '大神......', 1448242812),
(34, 134, 17, '休Se', '真给力', 1448242814),
(35, 141, 96, 'lz904', '大神......', 1448242816),
(36, 149, 97, '轻度浮生', '非常感谢你', 1448242818),
(37, 151, 22, '匿名网友', '你真是个大好人', 1448242820),
(38, 156, 98, '老无所依198_2', '谢谢你', 1448242821),
(39, 158, 103, 'Nick_lau', '非常感谢你', 1448242823),
(40, 159, 100, '无敌婷婷521', '真给力', 1448242824),
(41, 160, 45, 'cklovevivian', '大神......', 1448242826),
(42, 161, 22, '匿名网友', '你真是个大好人', 1448242827),
(43, 162, 61, '石斑鱼1117', '你真是个大好人', 1448242828),
(44, 166, 111, '嘿那小子', '你真的帮了我大忙', 1448242830),
(45, 167, 12, '爱上了你TEL', '非常感谢你', 1448242832),
(46, 176, 39, '布帅呢', '高手留个联系方式吧', 1451997756),
(47, 178, 36, '星空_小木公子', '非常感谢你', 1451997758),
(48, 179, 12, '爱上了你TEL', '真给力', 1451997759),
(49, 180, 1, 'admin', '高手留个联系方式吧', 1451997759),
(50, 181, 114, '什么都得问', '非常感谢你', 1451997759),
(51, 182, 118, 'ywl6021', '你真的帮了我大忙', 1451997759),
(52, 183, 61, '石斑鱼1117', '大神......', 1451997760),
(53, 189, 61, '石斑鱼1117', '高手留个联系方式吧', 1451997819),
(54, 190, 22, '匿名网友', '真给力', 1451997823),
(55, 191, 15, '满满屋good', '大神......', 1451997824),
(56, 196, 17, '休Se', '你真是个大好人', 1451997825),
(57, 205, 16, '伯爵0616', '谢谢你', 1451997827),
(58, 209, 45, 'cklovevivian', '谢谢你', 1451997828),
(59, 212, 29, '厉小豆', '谢谢你', 1451997829),
(60, 216, 133, 'Shining100', '你真是个大好人', 1451997829),
(61, 223, 15, '满满屋good', '你真是个大好人', 1451997830),
(62, 227, 135, '流风渐离', '你真的帮了我大忙', 1451997831),
(63, 232, 127, 'njt42', '大神......', 1451997832),
(64, 239, 6, 'cashcage', '真给力', 1451997833),
(65, 245, 17, '休Se', '你真的帮了我大忙', 1451997834),
(66, 246, 12, '爱上了你TEL', '谢谢你', 1451997834),
(67, 247, 147, '缓缓飘落的雪花', '真给力', 1451997834),
(68, 251, 142, '小天使男', '高手留个联系方式吧', 1451997834),
(69, 258, 116, 'penguinzj', '大神......', 1451997835),
(70, 262, 6, 'cashcage', '高手留个联系方式吧', 1451997837),
(71, 265, 29, '厉小豆', '高手留个联系方式吧', 1451997838),
(72, 271, 16, '伯爵0616', '高手留个联系方式吧', 1451997838),
(73, 272, 129, 'yangyang0308', '高手留个联系方式吧', 1451997838),
(74, 274, 129, 'yangyang0308', '非常感谢你', 1451997839),
(75, 277, 135, '流风渐离', '你真是个大好人', 1451997841),
(76, 278, 140, 'myfavorite0', '你真的帮了我大忙', 1451997841),
(77, 279, 129, 'yangyang0308', '大神......', 1451997841),
(78, 289, 116, 'penguinzj', '非常感谢你', 1451997844),
(79, 291, 133, 'Shining100', '你真是个大好人', 1451997844),
(80, 293, 45, 'cklovevivian', '高手留个联系方式吧', 1451997845),
(81, 294, 39, '布帅呢', '高手留个联系方式吧', 1451997845),
(82, 296, 135, '流风渐离', '大神......', 1451997846),
(83, 297, 22, '匿名网友', '你真是个大好人', 1451997847),
(84, 298, 17, '休Se', '高手留个联系方式吧', 1451997847),
(85, 299, 39, '布帅呢', '谢谢你', 1451997847),
(86, 301, 177, '酷猫猫', '你真是个大好人', 1451997848),
(87, 308, 128, '狼牙VS情感男孩', '真给力', 1451997849),
(88, 313, 134, '0调调同一种0', '非常感谢你', 1451997850),
(89, 314, 177, '酷猫猫', '你真是个大好人', 1451997850),
(90, 316, 129, 'yangyang0308', '真给力', 1451997851),
(91, 318, 164, 'smg0320', '非常感谢你', 1451997851),
(92, 321, 17, '休Se', '非常感谢你', 1451997852),
(93, 322, 135, '流风渐离', '高手留个联系方式吧', 1452143314),
(94, 329, 177, '酷猫猫', '大神......', 1452143314),
(95, 330, 164, 'smg0320', '非常感谢你', 1452143316),
(96, 331, 176, '总院院长', '大神......', 1452143316),
(97, 332, 177, '酷猫猫', '你真的帮了我大忙', 1452143317),
(98, 336, 1, 'admin', '你真的帮了我大忙', 1452143318),
(99, 339, 162, 'CoolCash', '非常感谢你', 1452143361),
(100, 345, 17, '休Se', '谢谢你', 1452143361),
(101, 346, 6, 'cashcage', '谢谢你', 1452143362),
(102, 351, 171, '品乌龙者2013', '非常感谢你', 1452143363),
(103, 353, 17, '休Se', '你真是个大好人', 1452143363),
(104, 355, 208, 'luo_jx2013', '谢谢你', 1452143363),
(105, 356, 171, '品乌龙者2013', '大神......', 1452143364),
(106, 361, 208, 'luo_jx2013', '高手留个联系方式吧', 1452143365),
(107, 364, 129, 'yangyang0308', '真给力', 1452143365),
(108, 367, 22, '匿名网友', '大神......', 1452143365),
(109, 368, 129, 'yangyang0308', '谢谢你', 1452143366),
(110, 372, 176, '总院院长', '你真是个大好人', 1452143366),
(111, 375, 176, '总院院长', '你真的帮了我大忙', 1452143366),
(112, 377, 39, '布帅呢', '大神......', 1452143367),
(113, 385, 129, 'yangyang0308', '大神......', 1452143370),
(114, 386, 176, '总院院长', '你真是个大好人', 1452143372),
(115, 388, 172, '信管15号', '你真的帮了我大忙', 1452143373),
(116, 390, 208, 'luo_jx2013', '你真的帮了我大忙', 1452143373),
(117, 391, 171, '品乌龙者2013', '你真的帮了我大忙', 1452143373),
(118, 392, 39, '布帅呢', '非常感谢你', 1452143374),
(119, 397, 162, 'CoolCash', '你真是个大好人', 1452143374),
(120, 398, 39, '布帅呢', '真给力', 1452143375),
(121, 404, 29, '厉小豆', '谢谢你', 1452143375),
(122, 417, 171, '品乌龙者2013', '高手留个联系方式吧', 1452143376),
(123, 419, 177, '酷猫猫', '高手留个联系方式吧', 1452143376),
(124, 420, 36, '星空_小木公子', '真给力', 1452143377),
(125, 425, 209, 'sjocky', '非常感谢你', 1452143377),
(126, 431, 220, '牛车网问答小助手', '大神......', 1452143378),
(127, 432, 140, 'myfavorite0', '真给力', 1452143379),
(128, 433, 221, '牛车网专家', '高手留个联系方式吧', 1452143379),
(129, 436, 221, '牛车网专家', '你真的帮了我大忙', 1452143379),
(130, 438, 135, '流风渐离', '大神......', 1452143380),
(131, 442, 209, 'sjocky', '谢谢你', 1452143380),
(132, 445, 215, '临时码工', '谢谢你', 1452143381),
(133, 450, 213, 'jiweixia', '谢谢你', 1452143381),
(134, 452, 140, 'myfavorite0', '真给力', 1452143386),
(135, 453, 218, 'involuntary', '谢谢你', 1452143386),
(136, 454, 140, 'myfavorite0', '高手留个联系方式吧', 1452143387),
(137, 458, 248, '牛车网N人', '谢谢你', 1452143387),
(138, 465, 267, 'qinggong', '你真是个大好人', 1452143388),
(139, 466, 244, 'mengqingyang', '你真的帮了我大忙', 1452143389),
(140, 469, 248, '牛车网N人', '你真的帮了我大忙', 1452143389),
(141, 475, 1, 'admin', '大神......', 1452143390),
(142, 479, 135, '流风渐离', '你真是个大好人', 1452143390),
(143, 481, 36, '星空_小木公子', '谢谢你', 1452143391),
(144, 485, 22, '匿名网友', '非常感谢你', 1452143391),
(145, 487, 22, '匿名网友', '你真的帮了我大忙', 1452143391),
(146, 492, 17, '休Se', '你真的帮了我大忙', 1452143392),
(147, 496, 140, 'myfavorite0', '非常感谢你', 1452143392),
(148, 499, 267, 'qinggong', '你真是个大好人', 1452143393),
(149, 500, 16, '伯爵0616', '你真的帮了我大忙', 1452143393),
(150, 501, 267, 'qinggong', '你真的帮了我大忙', 1452143393),
(151, 505, 39, '布帅呢', '谢谢你', 1452143393),
(152, 506, 16, '伯爵0616', '非常感谢你', 1452143394),
(153, 507, 29, '厉小豆', '非常感谢你', 1452143394),
(154, 509, 248, '牛车网N人', '你真的帮了我大忙', 1452143394),
(155, 522, 12, '爱上了你TEL', '非常感谢!', 1457185618),
(156, 510, 12, '爱上了你TEL', '非常感谢!', 1457185648),
(157, 517, 39, '布帅呢', '非常感谢!', 1457185975),
(158, 516, 1, 'admin', '非常感谢!', 1457186191),
(159, 519, 209, 'sjocky', 'bucuo', 1457186223),
(160, 518, 128, '狼牙VS情感男孩', '非常感谢!', 1457186320),
(161, 520, 171, '品乌龙者2013', '非常感谢!', 1457186913),
(162, 510, 135, '流风渐离', '非常感谢!', 1458383276),
(163, 512, 172, '信管15号', '非常感谢!', 1458396805),
(164, 525, 17, '休Se', '你真的帮了我大忙', 1458480543),
(165, 526, 248, '牛车网N人', '谢谢你', 1458480544),
(166, 528, 176, '总院院长', '大神......', 1458480546),
(167, 529, 16, '伯爵0616', '真给力', 1458480547),
(168, 534, 1, 'admin', '非常感谢你', 1458480549),
(169, 537, 1, 'admin', '你真是个大好人', 1458564467),
(170, 543, 171, '品乌龙者2013', '高手留个联系方式吧', 1458564471),
(171, 547, 140, 'myfavorite0', '高手留个联系方式吧', 1458564473),
(172, 548, 17, '休Se', '真给力', 1458564496),
(173, 549, 6, 'cashcage', '真给力', 1458564497),
(174, 550, 135, '流风渐离', '高手留个联系方式吧', 1458564499),
(175, 551, 176, '总院院长', '非常感谢你', 1458564508),
(176, 554, 248, '牛车网N人', '你真是个大好人', 1458564510),
(177, 555, 135, '流风渐离', '高手留个联系方式吧', 1458564512),
(178, 557, 207, '一笑天涯', '真给力', 1458564514),
(179, 558, 6, 'cashcage', '高手留个联系方式吧', 1458564515),
(180, 559, 244, 'mengqingyang', '你真是个大好人', 1458564517),
(181, 560, 171, '品乌龙者2013', '谢谢你', 1458564519),
(182, 562, 29, '厉小豆', '高手留个联系方式吧', 1458564520),
(183, 564, 39, '布帅呢', '真给力', 1458564522),
(184, 565, 1, 'admin', '真给力', 1458652924),
(185, 566, 220, '牛车网问答小助手', '你真的帮了我大忙', 1458652925),
(186, 567, 248, '牛车网N人', '真给力', 1458652927),
(187, 570, 39, '布帅呢', '非常感谢你', 1459171366),
(188, 573, 135, '流风渐离', '大神......', 1459171368),
(189, 575, 29, '厉小豆', '高手留个联系方式吧', 1459171370),
(190, 576, 207, '一笑天涯', '高手留个联系方式吧', 1459171372),
(191, 577, 135, '流风渐离', '真给力', 1459171373),
(192, 578, 248, '牛车网N人', '你真的帮了我大忙', 1459171375),
(193, 581, 29, '厉小豆', '谢谢你', 1459171379),
(194, 582, 208, 'luo_jx2013', '真给力', 1459171381),
(195, 588, 1, 'admin', '给力', 1462626952),
(200, 589, 1, 'admin', '等等', 1462628888),
(202, 589, 1, 'admin', '不错的测试', 1462629041),
(203, 562, 1, 'admin', '回复 厉小豆 :你好厉害', 1462702369),
(204, 592, 1, 'admin', '非常感谢!', 1462705176),
(205, 593, 382, 'oooooo', '大神......', 1466330971),
(206, 595, 1, 'admin', '高手留个联系方式吧', 1466331022),
(207, 596, 382, 'oooooo', '非常感谢你', 1466331024),
(208, 597, 376, '111111', '你真的帮了我大忙', 1466331026),
(209, 601, 382, 'oooooo', '非常感谢你', 1466331049),
(210, 605, 394, 'liulangdeying', '谢谢你', 1466331077),
(211, 609, 395, '孤鹜飞晖', '大神......', 1466331079),
(212, 610, 400, '海里_蛟龙', '大神......', 1466331087),
(213, 611, 398, '气温40度', '你真是个大好人', 1466331089),
(214, 612, 395, '孤鹜飞晖', '你真的帮了我大忙', 1466331096),
(215, 613, 403, '暗夜祥', '你真是个大好人', 1466331098),
(216, 621, 407, 'dycpj', '非常感谢你', 1466331472),
(217, 625, 402, '奇奇娃妈妈', '你真的帮了我大忙', 1466331480),
(218, 628, 396, '东方将白', '真给力', 1466331487),
(219, 632, 412, '叮当的爹', '高手留个联系方式吧', 1466331490),
(220, 636, 413, '胖洋洋的烦恼', '高手留个联系方式吧', 1466331492),
(221, 638, 411, '霸气屌屌屌', '谢谢你', 1466331498),
(222, 639, 407, 'dycpj', '谢谢你', 1466331500),
(223, 640, 408, '中学生自习室', '你真的帮了我大忙', 1466331503),
(224, 641, 415, 'JosePh匿', '谢谢你', 1466331506),
(225, 642, 1, 'admin', '谢谢你', 1466331511),
(226, 643, 400, '海里_蛟龙', '真给力', 1466331513),
(227, 645, 410, '7787166LG', '大神......', 1466331515),
(228, 648, 409, '骑猫去旅行', '非常感谢你', 1466331517),
(229, 649, 417, '晨风80', '谢谢你', 1466331519),
(230, 650, 405, 'Dick_fung', '你真是个大好人', 1466331521),
(231, 652, 405, 'Dick_fung', '你真的帮了我大忙', 1466331523),
(232, 653, 406, '努力长大的鱼', '你真是个大好人', 1466331526),
(233, 660, 422, 'Neo_666', '你真是个大好人', 1466331528),
(234, 661, 424, 'hulfspark', '高手留个联系方式吧', 1466331550),
(235, 670, 415, 'JosePh匿', '你真的帮了我大忙', 1466331552),
(236, 671, 432, 'sa_n_17', '非常感谢你', 1466902170),
(237, 672, 429, '猫猫9命', '谢谢你', 1466902191),
(238, 673, 414, '卐VAV殇', '真给力', 1466902193),
(239, 674, 434, 'lwhheigou', '非常感谢你', 1466902198),
(240, 677, 420, '越A涵', '真给力', 1466902199),
(241, 679, 424, 'hulfspark', '非常感谢你', 1466902228),
(242, 681, 436, '风云府南', '大神......', 1466902230),
(243, 683, 422, 'Neo_666', '高手留个联系方式吧', 1466902233),
(244, 684, 440, '输赢都行', '你真的帮了我大忙', 1466902507),
(245, 688, 435, 'Zxc38628', '高手留个联系方式吧', 1466902510),
(246, 696, 439, 'hb_david', '真给力', 1466902552),
(247, 698, 440, '输赢都行', '真给力', 1466902555),
(248, 700, 446, 'jklhhhssjdi', '真给力', 1466902562),
(249, 701, 453, '松柏常青_2013', '真给力', 1466902564),
(250, 702, 450, 'heartsprite', '真给力', 1466902572),
(251, 704, 441, '品月8号', '高手留个联系方式吧', 1466902576),
(252, 705, 453, '松柏常青_2013', '非常感谢你', 1466902590),
(253, 706, 457, 'bshym002', '你真的帮了我大忙', 1466902608),
(254, 711, 456, 'avataren', '谢谢你', 1466902627),
(255, 723, 464, 'picole', '真给力', 1466902633),
(256, 725, 463, '吾粲', '谢谢你', 1466902636),
(257, 726, 458, 'limingaa1976', '大神......', 1466902639),
(258, 727, 469, '开心花园2015', '你真是个大好人', 1466902641),
(259, 728, 469, '开心花园2015', '你真的帮了我大忙', 1466902648),
(260, 731, 461, '黯然落魄', '大神......', 1466902650),
(261, 738, 473, '佛见佛笑', '真给力', 1466902653),
(262, 742, 473, '佛见佛笑', '大神......', 1466902657),
(263, 750, 473, '佛见佛笑', '你真是个大好人', 1466902660),
(264, 753, 483, '章勇资料馆', '你真是个大好人', 1466902684),
(265, 762, 492, '个忧', '非常感谢你', 1466902687),
(266, 764, 476, '果爸瓜瓜', '谢谢你', 1466902690),
(267, 765, 492, '个忧', '谢谢你', 1466902704),
(268, 770, 489, '士心之王', '真给力', 1466902706),
(269, 771, 489, '士心之王', '高手留个联系方式吧', 1466902709),
(270, 774, 487, '你哥哥在这里', '非常感谢你', 1466902711),
(271, 775, 489, '士心之王', '高手留个联系方式吧', 1466902714),
(272, 777, 502, '龙镇龙', '真给力', 1466902716),
(273, 782, 508, 'huyun1306', '真给力', 1466902719),
(274, 783, 504, 'king369999', '谢谢你', 1466902724),
(278, 790, 1, 'admin', '测试下', 1466946249),
(280, 801, 496, '娇气菟菟', '大神......', 1467414344),
(281, 836, 508, 'huyun1306', '你真是个大好人', 1467815168),
(283, 42, 1, 'admin', '回复 胖尧2015 :不错', 1478429087),
(284, 852, 29, '厉小豆', '非常感谢!', 1487415223),
(285, 853, 29, '厉小豆', '非常感谢!', 1487415460);

-- --------------------------------------------------------

--
-- 表的结构 `ask_answer_support`
--

CREATE TABLE IF NOT EXISTS `ask_answer_support` (
  `sid` char(16) NOT NULL,
  `aid` int(10) NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`sid`,`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ask_articlecomment`
--

CREATE TABLE IF NOT EXISTS `ask_articlecomment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` char(50) NOT NULL,
  `author` varchar(15) NOT NULL DEFAULT '',
  `authorid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `adopttime` int(10) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  `comments` int(10) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `ip` varchar(20) DEFAULT NULL,
  `supports` int(10) NOT NULL DEFAULT '0',
  `reward` int(10) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tid` (`tid`),
  KEY `authorid` (`authorid`),
  KEY `adopttime` (`adopttime`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ask_attach`
--

CREATE TABLE IF NOT EXISTS `ask_attach` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `filename` char(100) NOT NULL DEFAULT '',
  `filetype` char(50) NOT NULL DEFAULT '',
  `filesize` int(10) unsigned NOT NULL DEFAULT '0',
  `location` char(100) NOT NULL DEFAULT '',
  `downloads` mediumint(8) NOT NULL DEFAULT '0',
  `isimage` tinyint(1) NOT NULL DEFAULT '0',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `time` (`time`,`isimage`,`downloads`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `ask_attach`
--

INSERT INTO `ask_attach` (`id`, `time`, `filename`, `filetype`, `filesize`, `location`, `downloads`, `isimage`, `uid`) VALUES
(1, 1453170296, '首页.png', '.png', 101404, 'data/attach/1601/L5ou07vJ.png', 0, 1, 1),
(2, 1460721687, '7.jpg', '.jpg', 13681, 'data/attach/1604/bXLGanHS.jpg', 0, 1, 1),
(3, 1460721688, '12.jpg', '.jpg', 5584, 'data/attach/1604/5JVUupDG.jpg', 0, 1, 1),
(4, 1460721689, '23.jpg', '.jpg', 4524, 'data/attach/1604/0yVDX6x0.jpg', 0, 1, 1),
(5, 1460721690, '28.jpg', '.jpg', 31136, 'data/attach/1604/HPyP0J14.jpg', 0, 1, 1),
(6, 1460721691, '30.jpg', '.jpg', 30837, 'data/attach/1604/IgZatABw.jpg', 0, 1, 1),
(7, 1460721692, '36.jpg', '.jpg', 6967, 'data/attach/1604/gB6fzAZd.jpg', 0, 1, 1),
(8, 1460721693, '58.jpg', '.jpg', 6238, 'data/attach/1604/QAPrfdXV.jpg', 0, 1, 1),
(9, 1460721694, '65.jpg', '.jpg', 17944, 'data/attach/1604/sxE2Relx.jpg', 0, 1, 1),
(10, 1468245752, 'phGUFR7k.png', '.png', 88233, 'data/attach/1607/2BemLX4Q.png', 0, 1, 1),
(11, 1468246057, 'phGUFR7k.png', '.png', 88233, 'data/attach/1607/KOajRoLX.png', 0, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `ask_badword`
--

CREATE TABLE IF NOT EXISTS `ask_badword` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `admin` varchar(15) NOT NULL DEFAULT '',
  `find` varchar(255) NOT NULL DEFAULT '',
  `replacement` varchar(255) NOT NULL DEFAULT '',
  `findpattern` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `find` (`find`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ask_banned`
--

CREATE TABLE IF NOT EXISTS `ask_banned` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `ip1` char(3) NOT NULL,
  `ip2` char(3) NOT NULL,
  `ip3` char(3) NOT NULL,
  `ip4` char(3) NOT NULL,
  `admin` varchar(15) NOT NULL,
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `expiration` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ask_category`
--

CREATE TABLE IF NOT EXISTS `ask_category` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(30) NOT NULL,
  `dir` char(30) NOT NULL,
  `pid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `grade` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `questions` int(10) unsigned NOT NULL DEFAULT '0',
  `alias` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- 转存表中的数据 `ask_category`
--

INSERT INTO `ask_category` (`id`, `name`, `dir`, `pid`, `grade`, `displayorder`, `questions`, `alias`) VALUES
(1, '默认分类', 'default', 0, 1, 0, 17, ''),
(2, '电脑/网络', '', 0, 1, 2, 166, ''),
(3, '手机/数码', '', 0, 1, 3, 42, ''),
(4, '生活', '', 0, 1, 4, 170, ''),
(5, '游戏', '', 0, 1, 5, 21, ''),
(6, '体育/运动', '', 0, 1, 6, 0, ''),
(7, '娱乐明星', '', 0, 1, 7, 0, ''),
(8, '休闲爱好', '', 0, 1, 8, 0, ''),
(9, '文化/艺术', '', 0, 1, 9, 0, ''),
(10, '社会民生', '', 0, 1, 10, 0, ''),
(33, '知乎二', '', 31, 2, 1, 1, ''),
(32, '知乎一', '', 33, 3, 0, 1, ''),
(31, '知乎', '', 0, 1, 0, 2, ''),
(15, '地区问题', '', 0, 1, 15, 0, ''),
(16, '其它', '', 0, 1, 16, 6, ''),
(18, '测试一', '', 17, 2, 0, 0, ''),
(19, 'ask2问答', '', 0, 1, 1, 0, '33333'),
(20, 'ask2问答使用', '', 19, 2, 0, 0, ''),
(21, 'ask2问答安装', '', 19, 2, 1, 0, ''),
(22, 'ask2问答模板', '', 19, 2, 2, 0, ''),
(23, '电脑', '', 2, 2, 0, 23, ''),
(24, '互联网', '', 2, 2, 1, 3, ''),
(25, '操作系统', '', 2, 2, 2, 4, ''),
(26, '软件', '', 2, 2, 3, 7, ''),
(27, '硬件', '', 2, 2, 4, 2, ''),
(28, '编程开发', '', 2, 2, 5, 3, ''),
(29, '资源分享', '', 2, 2, 6, 1, ''),
(30, '电脑知识', '', 2, 2, 7, 2, '');

-- --------------------------------------------------------

--
-- 表的结构 `ask_category_admin`
--

CREATE TABLE IF NOT EXISTS `ask_category_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ask_credit`
--

CREATE TABLE IF NOT EXISTS `ask_credit` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `operation` varchar(100) NOT NULL DEFAULT '',
  `credit1` smallint(6) NOT NULL DEFAULT '0',
  `credit2` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=281 ;

-- --------------------------------------------------------

--
-- 表的结构 `ask_crontab`
--

CREATE TABLE IF NOT EXISTS `ask_crontab` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `available` tinyint(1) NOT NULL DEFAULT '0',
  `type` enum('user','system') NOT NULL DEFAULT 'user',
  `name` char(50) NOT NULL DEFAULT '',
  `method` varchar(50) NOT NULL DEFAULT '',
  `lastrun` int(10) unsigned NOT NULL DEFAULT '0',
  `nextrun` int(10) unsigned NOT NULL DEFAULT '0',
  `weekday` tinyint(1) NOT NULL DEFAULT '0',
  `day` tinyint(2) NOT NULL DEFAULT '0',
  `hour` tinyint(2) NOT NULL DEFAULT '0',
  `minute` char(36) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `nextrun` (`available`,`nextrun`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ask_datacall`
--

CREATE TABLE IF NOT EXISTS `ask_datacall` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '',
  `expression` text NOT NULL,
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ask_doing`
--

CREATE TABLE IF NOT EXISTS `ask_doing` (
  `doingid` bigint(20) NOT NULL AUTO_INCREMENT,
  `authorid` int(10) NOT NULL,
  `author` varchar(20) NOT NULL,
  `action` tinyint(1) NOT NULL,
  `questionid` int(10) NOT NULL,
  `content` text,
  `referid` int(10) NOT NULL DEFAULT '0',
  `refer_authorid` int(10) NOT NULL DEFAULT '0',
  `refer_content` tinytext,
  `createtime` int(10) NOT NULL,
  PRIMARY KEY (`doingid`),
  KEY `authorid` (`authorid`,`author`),
  KEY `sourceid` (`questionid`),
  KEY `createtime` (`createtime`),
  KEY `referid` (`referid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1165 ;

-- --------------------------------------------------------

--
-- 表的结构 `ask_editor`
--

CREATE TABLE IF NOT EXISTS `ask_editor` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `available` tinyint(1) NOT NULL DEFAULT '1',
  `tag` varchar(100) NOT NULL DEFAULT '',
  `icon` varchar(255) NOT NULL DEFAULT '',
  `code` text NOT NULL,
  `displayorder` smallint(3) unsigned NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ask_expert`
--

CREATE TABLE IF NOT EXISTS `ask_expert` (
  `uid` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  PRIMARY KEY (`uid`,`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ask_famous`
--

CREATE TABLE IF NOT EXISTS `ask_famous` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `reason` char(50) DEFAULT NULL,
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ask_favorite`
--

CREATE TABLE IF NOT EXISTS `ask_favorite` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `qid` mediumint(10) unsigned NOT NULL DEFAULT '0',
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `qid` (`qid`),
  KEY `time` (`time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ask_favorite`
--

INSERT INTO `ask_favorite` (`id`, `uid`, `qid`, `time`) VALUES
(1, 1, 376, 1466903255);

-- --------------------------------------------------------

--
-- 表的结构 `ask_gift`
--

CREATE TABLE IF NOT EXISTS `ask_gift` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(250) NOT NULL,
  `credit` int(10) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `ask_gift`
--

INSERT INTO `ask_gift` (`id`, `title`, `description`, `image`, `credit`, `time`, `available`) VALUES
(1, '采集插件', '新版升级过的采集插件，支持无需修改php.ini配置文件。支持过滤问题回答的链接。支持采集自动识别问题标签。', '/data/attach/giftimg/giftZKdHzU.jpg', 30, 1460204888, 1);

-- --------------------------------------------------------

--
-- 表的结构 `ask_giftlog`
--

CREATE TABLE IF NOT EXISTS `ask_giftlog` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `username` char(20) NOT NULL,
  `realname` char(20) NOT NULL,
  `gid` int(10) NOT NULL,
  `giftname` varchar(30) NOT NULL,
  `address` varchar(100) NOT NULL,
  `postcode` char(10) NOT NULL,
  `phone` char(15) NOT NULL,
  `qq` char(15) NOT NULL,
  `email` varchar(30) NOT NULL DEFAULT '',
  `notes` text NOT NULL,
  `credit` int(10) NOT NULL,
  `time` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ask_inform`
--

CREATE TABLE IF NOT EXISTS `ask_inform` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `uid` int(10) NOT NULL,
  `qtitle` varchar(200) NOT NULL,
  `qid` int(100) NOT NULL,
  `aid` int(11) NOT NULL,
  `content` text NOT NULL,
  `title` varchar(100) NOT NULL,
  `keywords` varchar(100) NOT NULL,
  `counts` int(11) NOT NULL DEFAULT '1',
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- 表的结构 `ask_keywords`
--

CREATE TABLE IF NOT EXISTS `ask_keywords` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `find` varchar(200) NOT NULL,
  `replacement` varchar(200) NOT NULL,
  `admin` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- 表的结构 `ask_link`
--

CREATE TABLE IF NOT EXISTS `ask_link` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `description` mediumtext NOT NULL,
  `logo` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `ask_link`
--

INSERT INTO `ask_link` (`id`, `displayorder`, `name`, `url`, `description`, `logo`) VALUES
(1, 0, 'ask2问答系统', 'http://www.ask2.cn', 'ask2问答系统', '');

-- --------------------------------------------------------

--
-- 表的结构 `ask_login_auth`
--

CREATE TABLE IF NOT EXISTS `ask_login_auth` (
  `uid` int(10) NOT NULL,
  `type` enum('qq','sina') NOT NULL,
  `token` varchar(50) NOT NULL,
  `openid` varchar(50) NOT NULL,
  `time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ask_message`
--

CREATE TABLE IF NOT EXISTS `ask_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from` varchar(15) NOT NULL DEFAULT '',
  `fromuid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `touid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `new` tinyint(1) NOT NULL DEFAULT '1',
  `subject` varchar(75) NOT NULL DEFAULT '',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `touid` (`touid`,`time`),
  KEY `fromuid` (`fromuid`,`time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=285 ;

-- --------------------------------------------------------

--
-- 表的结构 `ask_nav`
--

CREATE TABLE IF NOT EXISTS `ask_nav` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL,
  `title` char(255) NOT NULL,
  `url` char(255) NOT NULL,
  `target` tinyint(1) NOT NULL DEFAULT '0',
  `available` tinyint(1) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `displayorder` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `ask_nav`
--

INSERT INTO `ask_nav` (`id`, `name`, `title`, `url`, `target`, `available`, `type`, `displayorder`) VALUES
(1, '问答首页', '问答首页', 'index/default', 0, 1, 1, 0),
(2, '问答动态', '问答动态', 'doing/default', 0, 1, 1, 3),
(3, '问题库', '分类大全', 'category/view/all', 0, 1, 1, 5),
(4, '问答专家', '问答专家', 'expert/default', 0, 1, 1, 4),
(5, '知识专题', '知识专题', 'topic/default', 0, 1, 1, 6),
(8, '站内公告', '站内公告', 'note/list', 0, 1, 1, 9);

-- --------------------------------------------------------

--
-- 表的结构 `ask_note`
--

CREATE TABLE IF NOT EXISTS `ask_note` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `authorid` int(10) NOT NULL DEFAULT '0',
  `author` char(18) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `comments` int(10) NOT NULL DEFAULT '0',
  `views` int(10) NOT NULL DEFAULT '0',
  `url` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `ask_note_comment`
--

CREATE TABLE IF NOT EXISTS `ask_note_comment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `noteid` int(10) NOT NULL,
  `authorid` int(10) NOT NULL,
  `author` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `ask_note_comment`
--

INSERT INTO `ask_note_comment` (`id`, `noteid`, `authorid`, `author`, `content`, `time`) VALUES
(1, 2, 1, 'admin', '<p>不容易，加油</p>', 1478402915);

-- --------------------------------------------------------

--
-- 表的结构 `ask_question`
--

CREATE TABLE IF NOT EXISTS `ask_question` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `cid1` smallint(5) unsigned NOT NULL DEFAULT '0',
  `cid2` smallint(5) unsigned NOT NULL DEFAULT '0',
  `cid3` smallint(5) unsigned NOT NULL DEFAULT '0',
  `price` smallint(6) unsigned NOT NULL DEFAULT '0',
  `author` char(15) NOT NULL DEFAULT '',
  `authorid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` char(50) NOT NULL,
  `description` text NOT NULL,
  `supply` text NOT NULL,
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `hidden` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `answers` smallint(5) unsigned NOT NULL DEFAULT '0',
  `attentions` int(10) NOT NULL DEFAULT '0',
  `goods` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `ip` varchar(20) DEFAULT NULL COMMENT 'ipåœ°å€',
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `shangjin` double DEFAULT '0',
  `hasvoice` int(10) DEFAULT '0',
  `askuid` int(10) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `cid1` (`cid1`),
  KEY `cid2` (`cid2`),
  KEY `cid3` (`cid3`),
  KEY `time` (`time`),
  KEY `price` (`price`),
  KEY `answers` (`answers`),
  KEY `authorid` (`authorid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=418 ;

-- --------------------------------------------------------

--
-- 表的结构 `ask_question_attention`
--

CREATE TABLE IF NOT EXISTS `ask_question_attention` (
  `qid` int(10) NOT NULL,
  `followerid` int(10) NOT NULL,
  `follower` char(18) NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`qid`,`followerid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ask_question_supply`
--

CREATE TABLE IF NOT EXISTS `ask_question_supply` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `qid` int(10) NOT NULL,
  `content` text NOT NULL,
  `time` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `time` (`time`),
  KEY `qid` (`qid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `ask_question_tag`
--

CREATE TABLE IF NOT EXISTS `ask_question_tag` (
  `qid` int(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`qid`,`name`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ask_recommend`
--

CREATE TABLE IF NOT EXISTS `ask_recommend` (
  `qid` int(10) unsigned NOT NULL DEFAULT '0',
  `cid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `title` char(50) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`qid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ask_session`
--

CREATE TABLE IF NOT EXISTS `ask_session` (
  `sid` char(16) NOT NULL DEFAULT '',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `code` char(4) NOT NULL DEFAULT '',
  `islogin` tinyint(1) NOT NULL DEFAULT '0',
  `ip` varchar(20) DEFAULT NULL COMMENT 'ip地址',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `sid` (`sid`),
  KEY `uid` (`uid`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ask_setting`
--

CREATE TABLE IF NOT EXISTS `ask_setting` (
  `k` varchar(32) NOT NULL DEFAULT '',
  `v` text NOT NULL,
  PRIMARY KEY (`k`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ask_setting`
--

INSERT INTO `ask_setting` (`k`, `v`) VALUES
('site_name', 'ask2问答系统'),
('meta_description', 'ask2问答系统'),
('meta_keywords', 'php问答系统,百度知道程序'),
('cookie_domain', ''),
('cookie_pre', 'tp_'),
('seo_prefix', ''),
('seo_suffix', '.html'),
('date_format', 'Y/m/d'),
('time_format', 'H:i'),
('time_offset', '8'),
('time_diff', '0'),
('site_icp', '京ICP备15032243号-1'),
('site_statcode', ''),
('allow_register', '1'),
('access_email', ''),
('censor_email', ''),
('censor_username', ''),
('maildefault', 'vip@domain.com'),
('mailsend', '1'),
('mailserver', 'smtp.domain.com'),
('mailport', '25'),
('mailauth', '0'),
('mailfrom', 'vip <vip@domain.com>'),
('mailauth_username', 'vip@domain.com'),
('mailauth_password', '123456'),
('maildelimiter', '0'),
('mailusername', '1'),
('mailsilent', '0'),
('credit1_register', '20'),
('credit2_register', '20'),
('credit1_login', '2'),
('credit2_login', '0'),
('credit1_ask', '5'),
('credit2_ask', '0'),
('credit1_answer', '2'),
('credit2_answer', '1'),
('credit1_message', '-1'),
('credit2_message', '0'),
('credit1_adopt', '5'),
('credit2_adopt', '2'),
('list_indexnosolve', '10'),
('list_indexcommend', '10'),
('list_indexreward', '8'),
('list_indexnote', '10'),
('list_indexhottag', '20'),
('list_indexexpert', '4'),
('list_indexallscore', '8'),
('list_indexweekscore', '8'),
('list_default', '15'),
('rss_ttl', '60'),
('code_register', '0'),
('code_login', '0'),
('code_ask', '1'),
('code_message', '1'),
('passport_type', '0'),
('passport_open', '0'),
('passport_key', ''),
('passport_client', ''),
('passport_server', ''),
('passport_login', 'login.php'),
('passport_logout', 'login.php?action=quit'),
('passport_register', 'register.php'),
('passport_expire', '3600'),
('passport_credit1', '0'),
('passport_credit2', '0'),
('overdue_days', '600'),
('ucenter_open', '0'),
('seo_on', '0'),
('seo_title', ''),
('seo_keywords', ''),
('seo_description', ''),
('seo_headers', ''),
('notify_mail', '0'),
('notify_message', '1'),
('tpl_dir', 'zui'),
('verify_question', '0'),
('index_life', '10'),
('msgtpl', 'a:4:{i:0;a:2:{s:5:"title";s:36:"您的问题{wtbt}有了新回答！";s:7:"content";s:51:"你在{wzmc}上的提出的问题有了新回答！";}i:1;a:2:{s:5:"title";s:54:"恭喜，您对问题{wtbt}的回答已经被采纳！";s:7:"content";s:42:"你在{wzmc}上的回答内容被采纳！";}i:2;a:2:{s:5:"title";s:78:"抱歉，您的问题{wtbt}由于长时间没有处理，现已过期关闭！";s:7:"content";s:69:"您的问题{wtbt}由于长时间没有处理，现已过期关闭！";}i:3;a:2:{s:5:"title";s:42:"您对{wtbt}的回答有了新的评分！";s:7:"content";s:36:"您的回答{hdnr}有了新评分！";}}'),
('allow_outer', '3'),
('stopcopy_on', '0'),
('stopcopy_allowagent', 'webkit\r\nopera\r\nmsie\r\ncompatible\r\nbaiduspider\r\ngoogle\r\nsoso\r\nsogou\r\ngecko\r\nmozilla'),
('stopcopy_stopagent', ''),
('stopcopy_maxnum', '60'),
('editor_wordcount', 'false'),
('editor_elementpath', 'false'),
('editor_toolbars', '''source'',''Undo'', ''Redo'',''bold'',''simpleupload'', ''scrawl'', ''attachment'' ,''removeformat'',''fullscreen'''),
('gift_range', 'a:3:{i:0;s:2:"50";i:50;s:3:"100";i:100;s:3:"300";}'),
('usernamepre', 'ask_'),
('usercount', '0'),
('sum_onlineuser_time', '30'),
('sum_category_time', '60'),
('del_tmp_crontab', '1440'),
('allow_credit3', '0'),
('apend_question_num', '5'),
('time_friendly', '1'),
('register_clause', ''),
('tpl_wapdir', 'fronzewap'),
('wap_domain', ''),
('auth_key', '8BdS0M5Y5M1L6p8LdleedOcF0rb97Y6NfH9RatcOeV7Dd306c9e71Maq184j2Tew'),
('admin_email', 'webmaster@domain.com'),
('seo_index_title', 'php问答系统-ask2问答官网'),
('seo_index_keywords', 'php问答系统'),
('seo_index_description', 'php问答系统'),
('seo_question_title', ''),
('seo_question_keywords', ''),
('seo_question_description', ''),
('seo_category_title', ''),
('seo_category_keywords', ''),
('seo_category_description', ''),
('question_share', ''),
('open_weixin', '1'),
('list_hot_words', '南昌,345\r\n黄子韬,378\r\n蓝光机,376'),
('site_alias', '站点别名'),
('maxindex_keywords', '4'),
('pagemaxindex_keywords', '4'),
('qqlogin_avatar', '0'),
('unword', '主人，我不知道你要说什么。'),
('zl_domain', 'zl.myrole.com'),
('qqlogin_open', '0'),
('qqlogin_appid', '43243244'),
('qqlogin_key', 'fdsf'),
('ucenter_url', ''),
('openwxpay', '0'),
('hot_words', 'a:3:{i:0;a:2:{s:1:"w";s:6:"南昌";s:3:"qid";i:345;}i:1;a:2:{s:1:"w";s:9:"黄子韬";s:3:"qid";i:378;}i:2;a:2:{s:1:"w";s:9:"蓝光机";s:3:"qid";i:376;}}'),
('max_register_num', '2'),
('site_qrcode', ''),
('hot_on', '0'),
('title_description', '知名专家为您解答'),
('site_logo', 'http://www.baseso.com/data/tmp/sitelogo.png'),
('xunsearch_open', '0'),
('xunsearch_sdk_file', ''),
('search_shownum', '5'),
('allow_expert', '0'),
('gift_note', 'ask2问答系统新增soso模板礼品兑换'),
('openweixin', ''),
('search_placeholder', '请输入关键词检索'),
('tpl_themedir', 'red'),
('register_on', '0'),
('banner_color', '#6a8d89'),
('baidu_api', ' http://data.zz.baidu.com/urls?site=www.ask2.cn&token=YuHZrBhWBcGeXkIL'),
('banner_img', 'http://www.baseso.com/data/attach/banner/sitebanner.jpg'),
('wxtoken', '3546060ff4d14gab024g4200'),
('duoshuoname', '');

-- --------------------------------------------------------

--
-- 表的结构 `ask_site_log`
--

CREATE TABLE IF NOT EXISTS `ask_site_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `guize` varchar(200) NOT NULL,
  `miaoshu` varchar(200) DEFAULT NULL,
  `uid` int(10) DEFAULT NULL,
  `username` varchar(200) NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1247 ;

--
-- 转存表中的数据 `ask_site_log`
--

INSERT INTO `ask_site_log` (`id`, `guize`, `miaoshu`, `uid`, `username`, `time`) VALUES
(1, '', '', 1, 'admin', 1480767970),
(2, '', '', 1, 'admin', 1480767972),
(3, '', '', 1, 'admin', 1480767984),
(4, '', '', 1, 'admin', 1480768044),
(5, '', '', 1, 'admin', 1480768889),
(6, '', '', 1, 'admin', 1480768894),
(7, '', '', 1, 'admin', 1480811318),
(8, '', '', 1, 'admin', 1480811331),
(9, 'admin_main', '', 1, 'admin', 1480811526),
(10, 'admin_main', '', 1, 'admin', 1480811826),
(11, 'admin_main', '', 1, 'admin', 1480811848),
(12, 'admin_main/login', '', 1, 'admin', 1480813036),
(13, 'admin_main', '', 1, 'admin', 1480813153),
(14, 'admin_main', '', 1, 'admin', 1480813174),
(15, 'admin_main', '', 1, 'admin', 1480813187),
(16, 'admin_main', '', 1, 'admin', 1480813248),
(17, 'admin_main', '', 1, 'admin', 1480815522),
(18, 'admin_news/newsadd', '', 1, 'admin', 1480815526),
(19, 'admin_news/newsadd', '', 1, 'admin', 1480815583),
(20, 'admin_news/newsadd', '', 1, 'admin', 1480815614),
(21, '', '', 1, 'admin', 1481367716),
(22, 'admin_main', '', 1, 'admin', 1481367727),
(23, 'admin_main/login', '', 1, 'admin', 1481367732),
(24, 'admin_main/login', '', 1, 'admin', 1481367808),
(25, 'admin_main/login', '', 1, 'admin', 1481367913),
(26, 'admin_main/login', '', 1, 'admin', 1481368199),
(27, 'nopage', '', 1, 'admin', 1481368549),
(28, 'nopage', '', 1, 'admin', 1481368574),
(29, 'nopage', '', 1, 'admin', 1481368981),
(30, 'nopage', '', 1, 'admin', 1481369019),
(31, '', '', 1, 'admin', 1481369034),
(32, 'nopage', '', 1, 'admin', 1481369195),
(33, 'nopage', '', 1, 'admin', 1481369280),
(34, 'nopage', '', 1, 'admin', 1481369313),
(35, 'nopage', '', 1, 'admin', 1481369456),
(36, 'nopage', '', 1, 'admin', 1481369473),
(37, 'nopage', '', 1, 'admin', 1481369491),
(38, 'nopage', '', 1, 'admin', 1481369505),
(39, 'nopage', '', 1, 'admin', 1481369529),
(40, 'nopage', '', 1, 'admin', 1481369543),
(41, 'nopage', '', 1, 'admin', 1481369568),
(42, 'admin_main/login', '', 1, 'admin', 1481379331),
(43, 'nopage', '', 1, 'admin', 1481379473),
(44, 'admin_main/login', '', 1, 'admin', 1481426890),
(45, 'nopage', '', 1, 'admin', 1481426896),
(46, 'admin_category/default', '', 1, 'admin', 1481426909),
(47, 'admin_category/default', '', 1, 'admin', 1481427085),
(48, 'admin_category/default', '', 1, 'admin', 1481427092),
(49, 'admin_category/default', '', 1, 'admin', 1481446860),
(50, 'admin_category/default', '', 1, 'admin', 1481446897),
(51, 'admin_category/default', '', 1, 'admin', 1481448188),
(52, 'admin_category/default', '', 1, 'admin', 1481448231),
(53, 'admin_category/default', '', 1, 'admin', 1481452942),
(54, 'admin_category/default', '', 1, 'admin', 1481452975),
(55, 'admin_category/default', '', 1, 'admin', 1481453453),
(56, 'admin_category/postadd', '', 1, 'admin', 1481453468),
(57, 'admin_category/postadd', '', 1, 'admin', 1481453519),
(58, 'admin_category/default', '', 1, 'admin', 1481453710),
(59, 'admin_category/default', '', 1, 'admin', 1481453786),
(60, 'admin_category/default', '', 1, 'admin', 1481453829),
(61, 'admin_category/default', '', 1, 'admin', 1481453868),
(62, 'admin_category/default', '', 1, 'admin', 1481454158),
(63, 'admin_category/postadd', '', 1, 'admin', 1481454190),
(64, 'admin_category/default', '', 1, 'admin', 1481454326),
(65, 'admin_category/postadd', '', 1, 'admin', 1481454474),
(66, 'admin_category/default', '', 1, 'admin', 1481454478),
(67, 'admin_category/postadd', '', 1, 'admin', 1481454635),
(68, 'admin_category/default', '', 1, 'admin', 1481454638),
(69, 'admin_category/postadd', '', 1, 'admin', 1481454685),
(70, 'admin_category/default', '', 1, 'admin', 1481454688),
(71, 'admin_category/default', '', 1, 'admin', 1481457677),
(72, 'admin_category/default', '', 1, 'admin', 1481457797),
(73, 'admin_category/default', '', 1, 'admin', 1481457873),
(74, 'admin_category/default', '', 1, 'admin', 1481457989),
(75, 'admin_category/default', '', 1, 'admin', 1481458008),
(76, 'admin_category/default', '', 1, 'admin', 1481458025),
(77, 'admin_category/default', '', 1, 'admin', 1481458058),
(78, 'admin_category/default', '', 1, 'admin', 1481458105),
(79, 'admin_category/default', '', 1, 'admin', 1481458163),
(80, 'admin_category/default', '', 1, 'admin', 1481458179),
(81, 'admin_category/default', '', 1, 'admin', 1481458366),
(82, 'admin_category/default', '', 1, 'admin', 1481458430),
(83, 'admin_category/default', '', 1, 'admin', 1481458470),
(84, 'admin_category/default', '', 1, 'admin', 1481458613),
(85, 'admin_category/default', '', 1, 'admin', 1481458639),
(86, 'admin_category/default', '', 1, 'admin', 1481458685),
(87, 'admin_category/default', '', 1, 'admin', 1481458781),
(88, 'admin_category/default', '', 1, 'admin', 1481458809),
(89, 'admin_category/default', '', 1, 'admin', 1481458822),
(90, 'admin_category/default', '', 1, 'admin', 1481458834),
(91, 'admin_category/default', '', 1, 'admin', 1481458866),
(92, 'admin_category/default', '', 1, 'admin', 1481458996),
(93, 'admin_category/default', '', 1, 'admin', 1481459641),
(94, 'admin_category/default', '', 1, 'admin', 1481459710),
(95, 'admin_category/default', '', 1, 'admin', 1481459720),
(96, 'admin_category/default', '', 1, 'admin', 1481459886),
(97, 'admin_category/default', '', 1, 'admin', 1481459951),
(98, 'admin_category/default', '', 1, 'admin', 1481460014),
(99, 'admin_category/default', '', 1, 'admin', 1481460051),
(100, 'admin_category/default', '', 1, 'admin', 1481460134),
(101, 'admin_category/default', '', 1, 'admin', 1481460282),
(102, 'admin_category/default', '', 1, 'admin', 1481460325),
(103, 'admin_category/default', '', 1, 'admin', 1481460372),
(104, 'admin_category/default', '', 1, 'admin', 1481460496),
(105, 'admin_category/default', '', 1, 'admin', 1481460626),
(106, 'admin_category/default', '', 1, 'admin', 1481460638),
(107, 'admin_category/default', '', 1, 'admin', 1481464212),
(108, 'admin_category/default', '', 1, 'admin', 1481464531),
(109, 'admin_category/default', '', 1, 'admin', 1481464644),
(110, 'admin_category/default', '', 1, 'admin', 1481464652),
(111, 'admin_category/default', '', 1, 'admin', 1481464662),
(112, 'admin_category/default', '', 1, 'admin', 1481465012),
(113, 'admin_category/default', '', 1, 'admin', 1481465067),
(114, 'admin_category/default', '', 1, 'admin', 1481465080),
(115, 'admin_category/default', '', 1, 'admin', 1481465294),
(116, 'admin_category/default', '', 1, 'admin', 1481465429),
(117, 'admin_category/default', '', 1, 'admin', 1481465466),
(118, 'admin_category/default', '', 1, 'admin', 1481465481),
(119, 'admin_category/default', '', 1, 'admin', 1481465876),
(120, 'admin_category/default', '', 1, 'admin', 1481466012),
(121, 'admin_category/default', '', 1, 'admin', 1481466240),
(122, 'admin_category/default', '', 1, 'admin', 1481466284),
(123, 'admin_category/default', '', 1, 'admin', 1481466628),
(124, 'admin_category/default', '', 1, 'admin', 1481466706),
(125, 'admin_category/default', '', 1, 'admin', 1481466841),
(126, 'admin_category/default', '', 1, 'admin', 1481467022),
(127, 'admin_category/default', '', 1, 'admin', 1481467041),
(128, 'admin_category/default', '', 1, 'admin', 1481467054),
(129, 'admin_category/default', '', 1, 'admin', 1481467057),
(130, 'admin_category/default', '', 1, 'admin', 1481467088),
(131, 'admin_category/default', '', 1, 'admin', 1481467198),
(132, 'admin_category/default', '', 1, 'admin', 1481467227),
(133, 'admin_category/default', '', 1, 'admin', 1481467235),
(134, 'admin_category/default', '', 1, 'admin', 1481467247),
(135, 'admin_category/default', '', 1, 'admin', 1481467315),
(136, 'admin_category/default', '', 1, 'admin', 1481467434),
(137, 'admin_category/default', '', 1, 'admin', 1481467449),
(138, 'admin_category/default', '', 1, 'admin', 1481467478),
(139, 'admin_category/default', '', 1, 'admin', 1481467506),
(140, 'admin_category/default', '', 1, 'admin', 1481467524),
(141, 'admin_category/default', '', 1, 'admin', 1481467550),
(142, 'admin_category/default', '', 1, 'admin', 1481467559),
(143, 'admin_category/default', '', 1, 'admin', 1481467574),
(144, 'admin_category/default', '', 1, 'admin', 1481467589),
(145, 'admin_category/default', '', 1, 'admin', 1481467603),
(146, 'admin_category/default', '', 1, 'admin', 1481467611),
(147, 'admin_category/default', '', 1, 'admin', 1481467656),
(148, 'admin_category/default', '', 1, 'admin', 1481467672),
(149, 'admin_category/default', '', 1, 'admin', 1481467697),
(150, 'admin_category/default', '', 1, 'admin', 1481467722),
(151, 'admin_category/default', '', 1, 'admin', 1481467801),
(152, 'admin_category/default', '', 1, 'admin', 1481467813),
(153, 'admin_category/default', '', 1, 'admin', 1481467855),
(154, 'admin_category/default', '', 1, 'admin', 1481467889),
(155, 'admin_category/default', '', 1, 'admin', 1481467921),
(156, 'admin_category/default', '', 1, 'admin', 1481467965),
(157, 'admin_category/default', '', 1, 'admin', 1481468024),
(158, 'admin_category/default', '', 1, 'admin', 1481468052),
(159, 'admin_category/default', '', 1, 'admin', 1481468064),
(160, 'admin_category/default', '', 1, 'admin', 1481468091),
(161, 'admin_category/default', '', 1, 'admin', 1481468195),
(162, 'admin_category/default', '', 1, 'admin', 1481468246),
(163, 'admin_category/default', '', 1, 'admin', 1481468322),
(164, 'admin_category/default', '', 1, 'admin', 1481468404),
(165, 'admin_category/default', '', 1, 'admin', 1481468418),
(166, '', '', 1, 'admin', 1481545882),
(167, 'admin_main', '', 1, 'admin', 1481545890),
(168, 'admin_main/login', '', 1, 'admin', 1481545892),
(169, 'nopage', '', 1, 'admin', 1481545896),
(170, 'admin_category/default', '', 1, 'admin', 1481545902),
(171, 'admin_category/default', '', 1, 'admin', 1481546057),
(172, 'admin_category/default', '', 1, 'admin', 1481546068),
(173, 'admin_category/default', '', 1, 'admin', 1481546138),
(174, 'admin_category/default', '', 1, 'admin', 1481546154),
(175, 'admin_category/default', '', 1, 'admin', 1481546213),
(176, 'admin_category/default', '', 1, 'admin', 1481546308),
(177, 'admin_category/default', '', 1, 'admin', 1481546368),
(178, 'admin_category/default', '', 1, 'admin', 1481546388),
(179, 'admin_category/default', '', 1, 'admin', 1481546400),
(180, 'admin_category/default', '', 1, 'admin', 1481546461),
(181, 'admin_category/default', '', 1, 'admin', 1481546591),
(182, 'admin_category/default', '', 1, 'admin', 1481546601),
(183, 'admin_category/default', '', 1, 'admin', 1481546852),
(184, 'admin_category/default', '', 1, 'admin', 1481547000),
(185, 'admin_category/default', '', 1, 'admin', 1481547119),
(186, 'admin_category/default', '', 1, 'admin', 1481547150),
(187, 'admin_category/default', '', 1, 'admin', 1481548138),
(188, 'admin_category/default', '', 1, 'admin', 1481548148),
(189, 'admin_category/default', '', 1, 'admin', 1481548198),
(190, 'admin_category/default', '', 1, 'admin', 1481548213),
(191, 'admin_category/default', '', 1, 'admin', 1481548271),
(192, 'admin_category/default', '', 1, 'admin', 1481548292),
(193, 'admin_category/default', '', 1, 'admin', 1481548468),
(194, 'admin_category/default', '', 1, 'admin', 1481548584),
(195, 'admin_category/default', '', 1, 'admin', 1481548638),
(196, 'admin_category/default', '', 1, 'admin', 1481548691),
(197, 'admin_category/default', '', 1, 'admin', 1481548892),
(198, 'admin_category/default', '', 1, 'admin', 1481548983),
(199, 'admin_category/default', '', 1, 'admin', 1481549068),
(200, 'admin_category/default', '', 1, 'admin', 1481549089),
(201, 'admin_category/default', '', 1, 'admin', 1481549114),
(202, 'admin_category/default', '', 1, 'admin', 1481549299),
(203, '', '', 1, 'admin', 1481938980),
(204, 'user/ajaxuserinfo/341', '', 1, 'admin', 1481938983),
(205, 'user/ajaxuserinfo/522', '', 1, 'admin', 1481938983),
(206, 'user/ajaxuserinfo/318', '', 1, 'admin', 1481938984),
(207, 'user/ajaxuserinfo/380', '', 1, 'admin', 1481938984),
(208, 'user/ajaxuserinfo/318', '', 1, 'admin', 1481938985),
(209, 'user/ajaxuserinfo/1', '', 1, 'admin', 1481938985),
(210, 'user/ajaxuserinfo/310', '', 1, 'admin', 1481938986),
(211, 'user/ajaxuserinfo/318', '', 1, 'admin', 1481938986),
(212, 'user/ajaxuserinfo/1', '', 1, 'admin', 1481938986),
(213, 'user/ajaxuserinfo/380', '', 1, 'admin', 1481938986),
(214, 'user/ajaxuserinfo/318', '', 1, 'admin', 1481938987),
(215, 'user/space/318', '', 1, 'admin', 1481938988),
(216, 'user/space/318', '', 1, 'admin', 1481939033),
(217, 'user/space/318', '', 1, 'admin', 1481939140),
(218, 'user/space/318', '', 1, 'admin', 1481939147),
(219, 'user/space/318', '', 1, 'admin', 1481939155),
(220, 'user/attentto', '', 1, 'admin', 1481939172),
(221, 'user/attentto', '', 1, 'admin', 1481939184),
(222, 'user/ajaxuserinfo/318', '', 1, 'admin', 1481939225),
(223, 'user/ajaxuserinfo/318', '', 1, 'admin', 1481939227),
(224, 'user/ajaxuserinfo/318', '', 1, 'admin', 1481939228),
(225, 'user/ajaxuserinfo/1', '', 1, 'admin', 1481939278),
(226, 'user/space/318', '', 1, 'admin', 1481939280),
(227, 'user/space/318', '', 1, 'admin', 1481939292),
(228, 'message/send/318', '', 1, 'admin', 1481939305),
(229, 'admin_main', '', 1, 'admin', 1481939352),
(230, 'admin_main/login', '', 1, 'admin', 1481939354),
(231, 'admin_editor/setting', '', 1, 'admin', 1481939359),
(232, 'admin_editor/setting', '', 1, 'admin', 1481939378),
(233, '', '', 1, 'admin', 1481939391),
(234, 'user/ajaxuserinfo/310', '', 1, 'admin', 1481939394),
(235, 'user/ajaxuserinfo/522', '', 1, 'admin', 1481939394),
(236, 'user/ajaxuserinfo/380', '', 1, 'admin', 1481939394),
(237, 'user/ajaxuserinfo/341', '', 1, 'admin', 1481939394),
(238, 'user/ajaxuserinfo/318', '', 1, 'admin', 1481939395),
(239, 'user/space/318', '', 1, 'admin', 1481939395),
(240, 'user/ajaxuserinfo/522', '', 1, 'admin', 1481939395),
(241, 'user/ajaxuserinfo/380', '', 1, 'admin', 1481939395),
(242, 'message/send/318', '', 1, 'admin', 1481939399),
(243, 'user/ajaxuserinfo/310', '', 1, 'admin', 1481939410),
(244, 'user/ajaxuserinfo/1', '', 1, 'admin', 1481939410),
(245, 'user/ajaxuserinfo/318', '', 1, 'admin', 1481939410),
(246, 'user/space/318', '', 1, 'admin', 1481939410),
(247, 'user/attentto', '', 1, 'admin', 1481939422),
(248, 'user/attentto', '', 1, 'admin', 1481939425),
(249, 'user/space/318', '', 1, 'admin', 1481939458),
(250, '', '', 1, 'admin', 1481940464),
(251, '', '', 1, 'admin', 1481940465),
(252, 'category/view/all', '', 1, 'admin', 1481940469),
(253, 'user/ajaxuserinfo/296', '', 1, 'admin', 1481940476),
(254, 'user/ajaxuserinfo/1', '', 1, 'admin', 1481940478),
(255, 'user/ajaxuserinfo/1', '', 1, 'admin', 1481940490),
(256, 'user/ajaxuserinfo/207', '', 1, 'admin', 1481940491),
(257, 'category/view/all', '', 1, 'admin', 1481940533),
(258, 'user/ajaxuserinfo/207', '', 1, 'admin', 1481940537),
(259, 'user/ajaxuserinfo/296', '', 1, 'admin', 1481940543),
(260, 'category/view/all', '', 1, 'admin', 1481940574),
(261, 'user/ajaxuserinfo/207', '', 1, 'admin', 1481940581),
(262, 'user/ajaxuserinfo/207', '', 1, 'admin', 1481940615),
(263, 'user/ajaxuserinfo/296', '', 1, 'admin', 1481940618),
(264, 'user/ajaxuserinfo/1', '', 1, 'admin', 1481940620),
(265, 'user/ajaxuserinfo/296', '', 1, 'admin', 1481940623),
(266, 'user/ajaxuserinfo/310', '', 1, 'admin', 1481940623),
(267, 'user/ajaxuserinfo/310', '', 1, 'admin', 1481940624),
(268, 'category/view/all', '', 1, 'admin', 1481940669),
(269, 'user/ajaxuserinfo/207', '', 1, 'admin', 1481940671),
(270, 'user/ajaxuserinfo/207', '', 1, 'admin', 1481940673),
(271, 'user/ajaxuserinfo/302', '', 1, 'admin', 1481940673),
(272, 'user/ajaxuserinfo/302', '', 1, 'admin', 1481940674),
(273, 'category/view/all', '', 1, 'admin', 1481940829),
(274, 'category/view/all', '', 1, 'admin', 1481940854),
(275, 'category/view/all', '', 1, 'admin', 1481940862),
(276, 'category/view/all', '', 1, 'admin', 1481940879),
(277, 'user/ajaxuserinfo/302', '', 1, 'admin', 1481940886),
(278, 'user/ajaxuserinfo/207', '', 1, 'admin', 1481940886),
(279, 'user/ajaxuserinfo/302', '', 1, 'admin', 1481940887),
(280, 'category/view/all', '', 1, 'admin', 1481941006),
(281, 'category/view/all', '', 1, 'admin', 1481941130),
(282, 'user/ajaxuserinfo/296', '', 1, 'admin', 1481941133),
(283, 'user/ajaxuserinfo/296', '', 1, 'admin', 1481941134),
(284, 'user/ajaxuserinfo/310', '', 1, 'admin', 1481941140),
(285, '', '', 1, 'admin', 1481941175),
(286, '', '', 1, 'admin', 1481988774),
(287, '', '', 1, 'admin', 1481988774),
(288, 'admin_main', '', 1, 'admin', 1481988916),
(289, 'admin_setting/base', '', 1, 'admin', 1481988919),
(290, '', '', 1, 'admin', 1482018455),
(291, 'admin_main', '', 1, 'admin', 1482018459),
(292, 'admin_main/login', '', 1, 'admin', 1482018461),
(293, 'admin_usergroup', '', 1, 'admin', 1482018468),
(294, 'admin_usergroup/regular/7', '', 1, 'admin', 1482018471),
(295, 'admin_usergroup/regular/7', '', 1, 'admin', 1482018475),
(296, 'admin_usergroup', '', 1, 'admin', 1482018483),
(297, 'admin_usergroup/regular/7', '', 1, 'admin', 1482018486),
(298, '', '', 1, 'admin', 1482019266),
(299, '', '', 1, 'admin', 1482019266),
(300, 'update', '', 1, 'admin', 1482019272),
(301, '', '', 1, 'admin', 1482150212),
(302, '', '', 1, 'admin', 1482150593),
(303, '', '', 1, 'admin', 1482150594),
(304, '', '', 1, 'admin', 1482150805),
(305, 'admin_main', '', 1, 'admin', 1482151241),
(306, 'admin_main/login', '', 1, 'admin', 1482151246),
(307, '', '', 1, 'admin', 1482155673),
(308, 'topic/getone/449', '', 1, 'admin', 1482155784),
(309, 'topic/getone/449', '', 1, 'admin', 1482157423),
(310, 'topic/getone/449', '', 1, 'admin', 1482157454),
(311, 'topic/getone/448', '', 1, 'admin', 1482157499),
(312, 'topic/getone/448', '', 1, 'admin', 1482157588),
(313, 'nopage', '', 1, 'admin', 1482648708),
(314, 'admin_category/default', '', 1, 'admin', 1482648714),
(315, 'admin_category/default', '', 1, 'admin', 1482648794),
(316, 'admin_category/default', '', 1, 'admin', 1482648832),
(317, 'admin_news/newsadd', '', 1, 'admin', 1482648858),
(318, 'admin_news/newsadd', '', 1, 'admin', 1482650345),
(319, 'admin_news/newsadd', '', 1, 'admin', 1482650369),
(320, 'admin_news/newsadd', '', 1, 'admin', 1482651320),
(321, 'admin_news/newsadd', '', 1, 'admin', 1482651499),
(322, 'admin_news/newsadd', '', 1, 'admin', 1482651547),
(323, 'admin_news/newsadd', '', 1, 'admin', 1482651616),
(324, 'admin_news/newsadd', '', 1, 'admin', 1482651695),
(325, 'admin_news/newsadd', '', 1, 'admin', 1482652644),
(326, 'admin_news/newsadd', '', 1, 'admin', 1482652730),
(327, 'admin_news/newsadd', '', 1, 'admin', 1482652810),
(328, 'admin_news/newsadd', '', 1, 'admin', 1482653017),
(329, 'admin_news/newsadd', '', 1, 'admin', 1482653351),
(330, 'admin_news/newsadd', '', 1, 'admin', 1482653516),
(331, 'admin_news/newsadd', '', 1, 'admin', 1482653571),
(332, 'admin_news/newsadd', '', 1, 'admin', 1482653603),
(333, 'admin_news/newsadd', '', 1, 'admin', 1482653662),
(334, 'admin_news/newsadd', '', 1, 'admin', 1482653713),
(335, 'admin_news/newsadd', '', 1, 'admin', 1482653926),
(336, 'admin_news/newsadd', '', 1, 'admin', 1482654004),
(337, 'admin_news/postnews', '', 1, 'admin', 1482654012),
(338, 'admin_news/newsadd', '', 1, 'admin', 1482654813),
(339, 'admin_news/newsadd', '', 1, 'admin', 1482655218),
(340, 'admin_news/newsadd', '', 1, 'admin', 1482655238),
(341, 'admin_news/newsadd', '', 1, 'admin', 1482655254),
(342, 'admin_news/newsadd', '', 1, 'admin', 1482655310),
(343, 'admin_news/newsadd', '', 1, 'admin', 1482655349),
(344, 'admin_news/newsadd', '', 1, 'admin', 1482655404),
(345, 'admin_news/newsadd', '', 1, 'admin', 1482655483),
(346, 'admin_news/newsadd', '', 1, 'admin', 1482655514),
(347, 'admin_news/newsadd', '', 1, 'admin', 1482655522),
(348, 'admin_news/newsadd', '', 1, 'admin', 1482655553),
(349, 'admin_news/newsadd', '', 1, 'admin', 1482655640),
(350, 'admin_news/newsadd', '', 1, 'admin', 1482655651),
(351, 'admin_news/newsadd', '', 1, 'admin', 1482655688),
(352, 'admin_news/newsadd', '', 1, 'admin', 1482655774),
(353, 'admin_news/newsadd', '', 1, 'admin', 1482655790),
(354, 'admin_news/newsadd', '', 1, 'admin', 1482655806),
(355, 'admin_news/newsadd', '', 1, 'admin', 1482655818),
(356, 'admin_news/newsadd', '', 1, 'admin', 1482656260),
(357, 'admin_news/newsadd', '', 1, 'admin', 1482657212),
(358, 'admin_news/newsadd', '', 1, 'admin', 1482657428),
(359, 'admin_news/newsadd', '', 1, 'admin', 1482657570),
(360, 'admin_news/newsadd', '', 1, 'admin', 1482661526),
(361, 'admin_news/postnews', '', 1, 'admin', 1482661534),
(362, 'admin_news/postnews', '', 1, 'admin', 1482661795),
(363, 'admin_news/postnews', '', 1, 'admin', 1482662396),
(364, 'admin_news/postnews', '', 1, 'admin', 1482662588),
(365, 'admin_news/postnews', '', 1, 'admin', 1482662603),
(366, 'admin_news/postnews', '', 1, 'admin', 1482662630),
(367, 'admin_news/postnews', '', 1, 'admin', 1482662850),
(368, 'admin_news/postnews', '', 1, 'admin', 1482663210),
(369, 'admin_news/postnews', '', 1, 'admin', 1482663253),
(370, 'admin_news/postnews', '', 1, 'admin', 1482663310),
(371, 'admin_news/postnews', '', 1, 'admin', 1482663326),
(372, 'admin_news/postnews', '', 1, 'admin', 1482663338),
(373, 'admin_news/postnews', '', 1, 'admin', 1482663405),
(374, 'admin_news/newsadd', '', 1, 'admin', 1482666890),
(375, 'admin_news/postnews', '', 1, 'admin', 1482667037),
(376, 'admin_news/postnews', '', 1, 'admin', 1482667290),
(377, 'admin_news/postnews', '', 1, 'admin', 1482667300),
(378, 'admin_news/postnews', '', 1, 'admin', 1482667706),
(379, 'admin_news/postnews', '', 1, 'admin', 1482667775),
(380, 'admin_news/postnews', '', 1, 'admin', 1482667940),
(381, 'admin_news/postnews', '', 1, 'admin', 1482668285),
(382, 'admin_news/newsadd', '', 1, 'admin', 1482668335),
(383, 'admin_news/postnews', '', 1, 'admin', 1482668375),
(384, 'admin_news/postnews', '', 1, 'admin', 1482668646),
(385, 'admin_news/postnews', '', 1, 'admin', 1482668726),
(386, 'admin_news/postnews', '', 1, 'admin', 1482669043),
(387, 'admin_news/postnews', '', 1, 'admin', 1482669047),
(388, 'admin_news/postnews', '', 1, 'admin', 1482669091),
(389, 'admin_news/postnews', '', 1, 'admin', 1482669113),
(390, 'admin_news/postnews', '', 1, 'admin', 1482669173),
(391, 'admin_news/postnews', '', 1, 'admin', 1482669294),
(392, 'admin_news/newsadd', '', 1, 'admin', 1482669673),
(393, '', '', 1, 'admin', 1483194183),
(394, 'admin_main', '', 1, 'admin', 1483194191),
(395, 'admin_main/login', '', 1, 'admin', 1483194193),
(396, 'admin_setting/base', '', 1, 'admin', 1483194255),
(397, 'admin_setting/base', '', 1, 'admin', 1483194260),
(398, '', '', 1, 'admin', 1483194264),
(399, '', '', 1, 'admin', 1483194269),
(400, '', '', 1, 'admin', 1483194366),
(401, '', '', 1, 'admin', 1483194382),
(402, 'user/default', '', 1, 'admin', 1483194390),
(403, '', '', 1, 'admin', 1483194402),
(404, 'question/add', '', 1, 'admin', 1483194405),
(405, 'question/ajaxgetcat', '', 1, 'admin', 1483194406),
(406, 'question/add', '', 1, 'admin', 1483196065),
(407, 'question/ajaxgetcat', '', 1, 'admin', 1483196066),
(408, 'user/default', '', 1, 'admin', 1483196069),
(409, '', '', 1, 'admin', 1483196073),
(410, '', '', 1, 'admin', 1483196164),
(411, '', '', 1, 'admin', 1483196170),
(412, 'user/default', '', 1, 'admin', 1483196176),
(413, '', '', 1, 'admin', 1483196179),
(414, '', '', 1, 'admin', 1483196192),
(415, 'user/default', '', 1, 'admin', 1483196199),
(416, 'user/default', '', 1, 'admin', 1483196260),
(417, '', '', 1, 'admin', 1483196272),
(418, '', '', 1, 'admin', 1483196299),
(419, '', '', 1, 'admin', 1483196349),
(420, '', '', 1, 'admin', 1483274388),
(421, 'admin_main', '', 1, 'admin', 1483274391),
(422, 'admin_main/login', '', 1, 'admin', 1483274395),
(423, 'admin_setting/caiji', '', 1, 'admin', 1483274398),
(424, 'admin_setting/ajaxpostpage', '', 1, 'admin', 1483274403),
(425, 'admin_setting/ajaxpostpage', '', 1, 'admin', 1483274407),
(426, 'admin_setting/ajaxpostpage', '', 1, 'admin', 1483274411),
(427, 'admin_setting/ajaxpostpage', '', 1, 'admin', 1483274427),
(428, '', '', 1, 'admin', 1483321324),
(429, 'admin_main', '', 1, 'admin', 1483321328),
(430, 'admin_main/login', '', 1, 'admin', 1483321330),
(431, 'admin_setting/base', '', 1, 'admin', 1483321334),
(432, 'admin_setting/base', '', 1, 'admin', 1483321341),
(433, '', '', 1, 'admin', 1483321343),
(434, '', '', 1, 'admin', 1483321349),
(435, '', '', 1, 'admin', 1483321466),
(436, 'question/view/407', '', 1, 'admin', 1483321478),
(437, 'category/view/all', '', 1, 'admin', 1483321489),
(438, 'question/view/404', '', 1, 'admin', 1483321494),
(439, 'question/view/404', '', 1, 'admin', 1483321576),
(440, 'index/default/frompc', '', 1, 'admin', 1483321585),
(441, '', '', 1, 'admin', 1483321590),
(442, '', '', 1, 'admin', 1483321599),
(443, 'question/view/71', '', 1, 'admin', 1483321611),
(444, 'user/space/', '', 1, 'admin', 1483321614),
(445, 'question/add/', '', 1, 'admin', 1483321618),
(446, 'category/view/all', '', 1, 'admin', 1483321623),
(447, 'user/logout', '', 1, 'admin', 1483321695),
(448, 'user/login', '', 1, 'admin', 1483321705),
(449, '', '', 1, 'admin', 1483321706),
(450, '', '', 1, 'admin', 1483858323),
(451, 'admin_main', '', 1, 'admin', 1483858525),
(452, 'admin_main/login', '', 1, 'admin', 1483858527),
(453, 'admin_template/default/pc', '', 1, 'admin', 1483858531),
(454, 'admin_template/getpcdir', '', 1, 'admin', 1483858532),
(455, 'admin_template/getpcdirfile', '', 1, 'admin', 1483858533),
(456, 'admin_template/default/pc', '', 1, 'admin', 1483858556),
(457, 'admin_template/getpcdir', '', 1, 'admin', 1483858557),
(458, 'admin_template/getpcdirfile', '', 1, 'admin', 1483858558),
(459, 'admin_template/default/pc', '', 1, 'admin', 1483858581),
(460, 'admin_template/getpcdir', '', 1, 'admin', 1483858582),
(461, 'admin_template/getpcdirfile', '', 1, 'admin', 1483858583),
(462, 'admin_template/default/pc', '', 1, 'admin', 1483858654),
(463, 'admin_template/getpcdir', '', 1, 'admin', 1483858655),
(464, 'admin_template/getpcdirfile', '', 1, 'admin', 1483858656),
(465, 'admin_template/getpcdirfile', '', 1, 'admin', 1483858658),
(466, 'admin_template/default/wap', '', 1, 'admin', 1483858672),
(467, 'admin_template/getwapdir', '', 1, 'admin', 1483858673),
(468, 'admin_template/getpcdirfile', '', 1, 'admin', 1483858674),
(469, 'admin_template/getpcdirfile', '', 1, 'admin', 1483858706),
(470, 'admin_template/getpcdirfile', '', 1, 'admin', 1483858709),
(471, 'admin_template/getpcdirfile', '', 1, 'admin', 1483858716),
(472, 'admin_template/getpcdirfile', '', 1, 'admin', 1483858720),
(473, 'admin_template/getpcdirfile', '', 1, 'admin', 1483858722),
(474, 'admin_template/default/pc', '', 1, 'admin', 1483858727),
(475, 'admin_template/getpcdir', '', 1, 'admin', 1483858728),
(476, 'admin_template/getpcdirfile', '', 1, 'admin', 1483858729),
(477, 'admin_template/editdirfile/zui/404', '', 1, 'admin', 1483858733),
(478, 'admin_template/getpcdirfile', '', 1, 'admin', 1483858738),
(479, 'admin_template/getpcdirfile', '', 1, 'admin', 1483858743),
(480, 'admin_template/getpcdirfile', '', 1, 'admin', 1483858760),
(481, 'admin_template/getpcdirfile', '', 1, 'admin', 1483858865),
(482, 'admin_template/getpcdirfile', '', 1, 'admin', 1483858868),
(483, 'admin_template/getpcdirfile', '', 1, 'admin', 1483858872),
(484, 'admin_template/default/wap', '', 1, 'admin', 1483859077),
(485, 'admin_template/getwapdir', '', 1, 'admin', 1483859078),
(486, 'admin_template/getpcdirfile', '', 1, 'admin', 1483859079),
(487, 'admin_template/getpcdirfile', '', 1, 'admin', 1483859164),
(488, 'admin_template/getpcdirfile', '', 1, 'admin', 1483859166),
(489, 'admin_template/getpcdirfile', '', 1, 'admin', 1483859169),
(490, 'admin_user/add', '', 1, 'admin', 1483859223),
(491, 'admin_user', '', 1, 'admin', 1483859241),
(492, 'admin_template/default/wap', '', 1, 'admin', 1483859523),
(493, 'admin_template/getwapdir', '', 1, 'admin', 1483859524),
(494, 'admin_template/getpcdirfile', '', 1, 'admin', 1483859525),
(495, 'admin_template/getpcdirfile', '', 1, 'admin', 1483859539),
(496, 'admin_template/getpcdirfile', '', 1, 'admin', 1483859543),
(497, 'admin_template/getpcdirfile', '', 1, 'admin', 1483859786),
(498, 'admin_template/getpcdirfile', '', 1, 'admin', 1483859790),
(499, 'admin_template/default/wap', '', 1, 'admin', 1483859813),
(500, 'admin_template/getwapdir', '', 1, 'admin', 1483859814),
(501, 'admin_template/getwapdir', '', 1, 'admin', 1483859815),
(502, 'admin_template/getwapdir', '', 1, 'admin', 1483859819),
(503, 'admin_template/getwapdir', '', 1, 'admin', 1483859822),
(504, 'admin_template/getwapdir', '', 1, 'admin', 1483859823),
(505, 'admin_template/default/wap', '', 1, 'admin', 1483859837),
(506, 'admin_template/getwapdir', '', 1, 'admin', 1483859838),
(507, 'admin_template/getwapdir', '', 1, 'admin', 1483859839),
(508, 'admin_template/default/wap', '', 1, 'admin', 1483859857),
(509, 'admin_template/getwapdir', '', 1, 'admin', 1483859858),
(510, 'admin_template/getwapdir', '', 1, 'admin', 1483859859),
(511, 'admin_template/getwapdir', '', 1, 'admin', 1483860143),
(512, 'admin_template/default/wap', '', 1, 'admin', 1483860148),
(513, 'admin_template/getwapdir', '', 1, 'admin', 1483860150),
(514, 'admin_template/getpcdirfile', '', 1, 'admin', 1483860151),
(515, 'admin_template/getpcdirfile', '', 1, 'admin', 1483860151),
(516, 'admin_template/getpcdirfile', '', 1, 'admin', 1483860154),
(517, 'admin_template/editdirfile/fronzewap/topictag', '', 1, 'admin', 1483860159),
(518, 'admin_template/getpcdirfile', '', 1, 'admin', 1483860162),
(519, 'admin_template/default/wap', '', 1, 'admin', 1483860563),
(520, 'admin_template/getwapdir', '', 1, 'admin', 1483860564),
(521, 'admin_template/getpcdirfile', '', 1, 'admin', 1483860565),
(522, 'admin_template/getpcdirfile', '', 1, 'admin', 1483860571),
(523, 'admin_template/getpcdirfile', '', 1, 'admin', 1483860573),
(524, 'admin_template/default/pc', '', 1, 'admin', 1483860581),
(525, 'admin_template/getpcdir', '', 1, 'admin', 1483860582),
(526, 'admin_template/getpcdirfile', '', 1, 'admin', 1483860583),
(527, 'admin_template/default/pc', '', 1, 'admin', 1483860594),
(528, 'admin_template/getpcdir', '', 1, 'admin', 1483860596),
(529, 'admin_template/getpcdirfile', '', 1, 'admin', 1483860597),
(530, '', '', 1, 'admin', 1483861549),
(531, 'admin_main', '', 1, 'admin', 1483861552),
(532, 'admin_setting/caiji', '', 1, 'admin', 1483861556),
(533, 'admin_setting/caiji', '', 1, 'admin', 1483873561),
(534, 'admin_dashang', '', 1, 'admin', 1483873564),
(535, 'admin_dashang', '', 1, 'admin', 1483873634),
(536, 'admin_dashang', '', 1, 'admin', 1483873690),
(537, 'admin_dashang', '', 1, 'admin', 1483873749),
(538, 'admin_dashang', '', 1, 'admin', 1483873753),
(539, 'admin_dashang', '', 1, 'admin', 1483873824),
(540, 'admin_dashang', '', 1, 'admin', 1483873890),
(541, 'admin_dashang', '', 1, 'admin', 1483874035),
(542, 'admin_dashang', '', 1, 'admin', 1483874099),
(543, 'admin_dashang', '', 1, 'admin', 1483874155),
(544, 'admin_dashang', '', 1, 'admin', 1483874204),
(545, 'admin_dashang', '', 1, 'admin', 1483874227),
(546, 'admin_dashang', '', 1, 'admin', 1483874263),
(547, 'admin_dashang', '', 1, 'admin', 1483874275),
(548, 'admin_setting/cache', '', 1, 'admin', 1483874377),
(549, 'admin_setting/cache', '', 1, 'admin', 1483874379),
(550, 'admin_dashang', '', 1, 'admin', 1483874382),
(551, 'admin_dashang', '', 1, 'admin', 1483874502),
(552, 'admin_dashang', '', 1, 'admin', 1483874587),
(553, 'admin_dashang', '', 1, 'admin', 1483874644),
(554, 'admin_dashang', '', 1, 'admin', 1483874677),
(555, 'admin_dashang', '', 1, 'admin', 1483874828),
(556, 'admin_dashang', '', 1, 'admin', 1483874843),
(557, 'admin_dashang', '', 1, 'admin', 1483874971),
(558, 'admin_dashang', '', 1, 'admin', 1483874980),
(559, 'admin_dashang', '', 1, 'admin', 1483875028),
(560, 'admin_dashang', '', 1, 'admin', 1483875144),
(561, 'admin_dashang', '', 1, 'admin', 1483875199),
(562, 'admin_dashang', '', 1, 'admin', 1483875251),
(563, 'admin_dashang', '', 1, 'admin', 1483875347),
(564, 'admin_dashang', '', 1, 'admin', 1483875349),
(565, 'admin_dashang', '', 1, 'admin', 1483875381),
(566, '', '', 1, 'admin', 1483877248),
(567, '', '', 1, 'admin', 1483877248),
(568, '', '', 1, 'admin', 1483877257),
(569, 'admin_main', '', 1, 'admin', 1483877262),
(570, 'admin_setting/base', '', 1, 'admin', 1483877265),
(571, 'admin_setting/base', '', 1, 'admin', 1483877270),
(572, '', '', 1, 'admin', 1483877272),
(573, '', '', 1, 'admin', 1483877277),
(574, 'question/view/407', '', 1, 'admin', 1483877279),
(575, 'question/view/407', '', 1, 'admin', 1483877295),
(576, 'question/view/407', '', 1, 'admin', 1483877326),
(577, 'question/view/407', '', 1, 'admin', 1483877342),
(578, 'question/view/407', '', 1, 'admin', 1483877370),
(579, 'question/view/407', '', 1, 'admin', 1483877395),
(580, '', '', 1, 'admin', 1483877402),
(581, 'question/view/160', '', 1, 'admin', 1483877404),
(582, 'question/view/129', '', 1, 'admin', 1483877410),
(583, 'question/view/129', '', 1, 'admin', 1483877440),
(584, 'question/view/129', '', 1, 'admin', 1483877494),
(585, 'question/view/129', '', 1, 'admin', 1483877501),
(586, 'admin_dashang', '', 1, 'admin', 1483877644),
(587, '', '', 1, 'admin', 1486205370),
(588, 'question/view/406', '', 1, 'admin', 1486205374),
(589, 'question/view/406', '', 1, 'admin', 1486205438),
(590, 'user/ajaxuserinfo/1', '', 1, 'admin', 1486205439),
(591, 'question/view/406', '', 1, 'admin', 1486205469),
(592, 'user/ajaxuserinfo/1', '', 1, 'admin', 1486205541),
(593, 'question/view/406', '', 1, 'admin', 1486205571),
(594, 'question/view/406', '', 1, 'admin', 1486205589),
(595, 'user/ajaxuserinfo/170', '', 1, 'admin', 1486205620),
(596, 'user/ajaxuserinfo/170', '', 1, 'admin', 1486205621),
(597, 'question/view/406', '', 1, 'admin', 1486205641),
(598, 'user/ajaxuserinfo/302', '', 1, 'admin', 1486205670),
(599, 'user/ajaxuserinfo/170', '', 1, 'admin', 1486205670),
(600, 'question/attentto', '', 1, 'admin', 1486205787),
(601, 'question/attentto', '', 1, 'admin', 1486205790),
(602, 'user/ajaxuserinfo/1', '', 1, 'admin', 1486205847),
(603, 'user/ajaxuserinfo/1', '', 1, 'admin', 1486205848),
(604, 'question/view/406', '', 1, 'admin', 1486205867),
(605, 'question/attentto', '', 1, 'admin', 1486205870),
(606, 'question/attentto', '', 1, 'admin', 1486205873),
(607, 'doing/default', '', 1, 'admin', 1486205883),
(608, 'user/ajaxuserinfo/521', '', 1, 'admin', 1486205886),
(609, 'user/ajaxuserinfo/522', '', 1, 'admin', 1486205887),
(610, 'user/ajaxuserinfo/1', '', 1, 'admin', 1486205887),
(611, 'user/ajaxuserinfo/521', '', 1, 'admin', 1486205887),
(612, 'user/ajaxuserinfo/522', '', 1, 'admin', 1486205888),
(613, 'user/ajaxuserinfo/522', '', 1, 'admin', 1486205889),
(614, 'user/space/522', '', 1, 'admin', 1486205890),
(615, 'user/space/501', '', 1, 'admin', 1486205914),
(616, '', '', 1, 'admin', 1486205923),
(617, 'buy/default', '', 1, 'admin', 1486205933),
(618, '', '', 1, 'admin', 1486205940),
(619, 'topic/default', '', 1, 'admin', 1486205944),
(620, 'topic/getone/447', '', 1, 'admin', 1486205953),
(621, 'topic/getone/447', '', 1, 'admin', 1486206031),
(622, 'topic/getone/447', '', 1, 'admin', 1486206106),
(623, '', '', 1, 'admin', 1486206119),
(624, 'user/ajaxuserinfo/310', '', 1, 'admin', 1486206255),
(625, '', '', 1, 'admin', 1486206297),
(626, 'note/view/2', '', 1, 'admin', 1486206327),
(627, '', '', 1, 'admin', 1486308921),
(628, '', '', 1, 'admin', 1486553769),
(629, 'update', '', 1, 'admin', 1486553836),
(630, '', '', 1, 'admin', 1486553842),
(631, 'admin_main', '', 1, 'admin', 1486553881),
(632, 'admin_main/login', '', 1, 'admin', 1486553886),
(633, 'admin_setting/base', '', 1, 'admin', 1486553890),
(634, 'admin_setting/base', '', 1, 'admin', 1486553895),
(635, '', '', 1, 'admin', 1486553897),
(636, '', '', 1, 'admin', 1486805211),
(637, 'admin_main', '', 1, 'admin', 1486805214),
(638, 'admin_main/login', '', 1, 'admin', 1486805219),
(639, 'admin_user', '', 1, 'admin', 1486805223),
(640, 'admin_user/search', '', 1, 'admin', 1486805228),
(641, 'admin_user/search', '', 1, 'admin', 1486805332),
(642, 'admin_user/search', '', 1, 'admin', 1486805368),
(643, 'admin_user/search', '', 1, 'admin', 1486805375),
(644, 'test/sayhello', '', 1, 'admin', 1486817711),
(645, 'test/sayhello', '', 1, 'admin', 1486817867),
(646, 'test', '', 1, 'admin', 1486819854),
(647, 'test/default', '', 1, 'admin', 1486820065),
(648, 'test/default', '', 1, 'admin', 1486820177),
(649, 'test/default', '', 1, 'admin', 1486820467),
(650, 'test/sayhello', '', 1, 'admin', 1486820480),
(651, 'test/sayhello', '', 1, 'admin', 1486821028),
(652, 'test/sayhello', '', 1, 'admin', 1486821078),
(653, 'test/sayhello', '', 1, 'admin', 1486821420),
(654, 'test/sayhello', '', 1, 'admin', 1486821511),
(655, '', '', 1, 'admin', 1487245576),
(656, 'update', '', 1, 'admin', 1487245599),
(657, '', '', 1, 'admin', 1487379388),
(658, 'update', '', 1, 'admin', 1487379396),
(659, '', '', 1, 'admin', 1487379526),
(660, 'user/logout', '', 1, 'admin', 1487379529),
(661, 'index', '', 1, 'admin', 1487379630),
(662, 'index', '', 1, 'admin', 1487379966),
(663, 'user/logout', '', 1, 'admin', 1487379971),
(664, '', '', 1, 'admin', 1487391009),
(665, '', '', 1, 'admin', 1487391031),
(666, '', '', 1, 'admin', 1487391052),
(667, 'user/ajaxuserinfo/310', '', 1, 'admin', 1487391058),
(668, 'user/ajaxuserinfo/310', '', 1, 'admin', 1487391059),
(669, '', '', 1, 'admin', 1487391081),
(670, '', '', 1, 'admin', 1487391100),
(671, 'user/ajaxuserinfo/310', '', 1, 'admin', 1487391100),
(672, '', '', 1, 'admin', 1487391153),
(673, '', '', 1, 'admin', 1487391163),
(674, '', '', 1, 'admin', 1487391175),
(675, 'user/ajaxuserinfo/310', '', 1, 'admin', 1487391175),
(676, '', '', 1, 'admin', 1487391192),
(677, '', '', 1, 'admin', 1487391256),
(678, '', '', 1, 'admin', 1487391272),
(679, '', '', 1, 'admin', 1487391283),
(680, 'message/system', '', 1, 'admin', 1487391308),
(681, 'message/personal', '', 1, 'admin', 1487391314),
(682, 'message/system', '', 1, 'admin', 1487391318),
(683, 'message/system', '', 1, 'admin', 1487391423),
(684, 'message/system', '', 1, 'admin', 1487391457),
(685, 'message/system', '', 1, 'admin', 1487391471),
(686, 'message/system', '', 1, 'admin', 1487391483),
(687, 'message/system', '', 1, 'admin', 1487391517),
(688, 'message/personal', '', 1, 'admin', 1487391660),
(689, '', '', 1, 'admin', 1487404688),
(690, 'user/ajaxuserinfo/310', '', 1, 'admin', 1487404693),
(691, 'user/ajaxuserinfo/207', '', 1, 'admin', 1487404693),
(692, 'user/ajaxuserinfo/207', '', 1, 'admin', 1487404694),
(693, 'user/ajaxuserinfo/310', '', 1, 'admin', 1487404694),
(694, 'question/add/310', '', 1, 'admin', 1487404697),
(695, 'question/add/310', '', 1, 'admin', 1487404743),
(696, 'question/add/310', '', 1, 'admin', 1487404764),
(697, 'question/add/310', '', 1, 'admin', 1487404819),
(698, 'question/add/310', '', 1, 'admin', 1487404899),
(699, 'question/add/310', '', 1, 'admin', 1487404936),
(700, 'question/add/310', '', 1, 'admin', 1487405012),
(701, 'question/add/310', '', 1, 'admin', 1487405101),
(702, 'question/add/310', '', 1, 'admin', 1487405183),
(703, 'question/add/310', '', 1, 'admin', 1487405249),
(704, 'question/add/310', '', 1, 'admin', 1487405265),
(705, 'question/add/310', '', 1, 'admin', 1487405287),
(706, 'question/add/310', '', 1, 'admin', 1487405319),
(707, 'question/add/310', '', 1, 'admin', 1487405362),
(708, 'question/add/310', '', 1, 'admin', 1487405375),
(709, 'question/add/310', '', 1, 'admin', 1487405397),
(710, 'question/add/310', '', 1, 'admin', 1487405418),
(711, 'question/add/310', '', 1, 'admin', 1487405585),
(712, 'question/add/310', '', 1, 'admin', 1487405612),
(713, 'question/add/310', '', 1, 'admin', 1487405681),
(714, 'question/add/310', '', 1, 'admin', 1487405725),
(715, 'question/add/310', '', 1, 'admin', 1487405784),
(716, 'question/add/310', '', 1, 'admin', 1487405834),
(717, 'question/add/310', '', 1, 'admin', 1487405906),
(718, 'question/add/310', '', 1, 'admin', 1487405939),
(719, 'question/add/310', '', 1, 'admin', 1487405996),
(720, 'question/add/310', '', 1, 'admin', 1487406016),
(721, 'question/add/310', '', 1, 'admin', 1487406070),
(722, 'question/add/310', '', 1, 'admin', 1487406120),
(723, 'question/add/310', '', 1, 'admin', 1487406160),
(724, 'question/add/310', '', 1, 'admin', 1487406226),
(725, 'question/add/310', '', 1, 'admin', 1487406273),
(726, 'question/add/310', '', 1, 'admin', 1487406300),
(727, 'question/add/310', '', 1, 'admin', 1487406318),
(728, 'question/add/310', '', 1, 'admin', 1487406338),
(729, 'question/add/310', '', 1, 'admin', 1487406354),
(730, 'question/add/310', '', 1, 'admin', 1487406405),
(731, 'question/add/310', '', 1, 'admin', 1487406432),
(732, 'question/add/310', '', 1, 'admin', 1487406448),
(733, 'question/add/310', '', 1, 'admin', 1487406555),
(734, 'question/add/310', '', 1, 'admin', 1487406640),
(735, 'question/add/310', '', 1, 'admin', 1487406781),
(736, '', '', 1, 'admin', 1487412775),
(737, '', '', 1, 'admin', 1487412776),
(738, 'user/ajaxuserinfo/1', '', 1, 'admin', 1487412789),
(739, 'user/logout', '', 1, 'admin', 1487412793),
(740, 'index', '', 29, '厉小豆', 1487412847),
(741, 'message/system', '', 29, '厉小豆', 1487412854),
(742, 'message/personal', '', 29, '厉小豆', 1487412864),
(743, '', '', 29, '厉小豆', 1487412877),
(744, 'user/ajaxuserinfo/1', '', 29, '厉小豆', 1487412880),
(745, 'question/add/1', '', 29, '厉小豆', 1487412883),
(746, 'user/default', '', 29, '厉小豆', 1487412894),
(747, 'user/default', '', 29, '厉小豆', 1487412912),
(748, 'user/logout', '', 29, '厉小豆', 1487412916),
(749, 'index', '', 1, 'admin', 1487412931),
(750, 'user/default', '', 1, 'admin', 1487412945),
(751, 'user/profile', '', 1, 'admin', 1487412949),
(752, 'user/mycategory', '', 1, 'admin', 1487412952),
(753, 'user/ajaxsetmypay', '', 1, 'admin', 1487412956),
(754, 'user/mycategory', '', 1, 'admin', 1487412962),
(755, 'update', '', 1, 'admin', 1487412972),
(756, 'user/logout', '', 1, 'admin', 1487412980),
(757, 'index', '', 29, '厉小豆', 1487412996),
(758, 'user/ajaxuserinfo/1', '', 29, '厉小豆', 1487412999),
(759, 'question/add/1', '', 29, '厉小豆', 1487413002),
(760, 'question/ajaxadd', '', 29, '厉小豆', 1487413027),
(761, 'question/ajaxadd', '', 29, '厉小豆', 1487413034),
(762, 'question/ajaxadd', '', 29, '厉小豆', 1487413120),
(763, 'question/view/410', '', 29, '厉小豆', 1487413123),
(764, 'user/default', '', 29, '厉小豆', 1487413177),
(765, 'question/add/310', '', 29, '厉小豆', 1487413274),
(766, '', '', 29, '厉小豆', 1487413282),
(767, 'user/default', '', 29, '厉小豆', 1487413285),
(768, 'user/default', '', 29, '厉小豆', 1487413285),
(769, '', '', 29, '厉小豆', 1487413328),
(770, 'user/default', '', 29, '厉小豆', 1487413330),
(771, '', '', 29, '厉小豆', 1487413343),
(772, 'user/ajaxuserinfo/1', '', 29, '厉小豆', 1487413410),
(773, 'question/add/1', '', 29, '厉小豆', 1487413416),
(774, 'question/ajaxadd', '', 29, '厉小豆', 1487413439),
(775, 'question/ajaxadd', '', 29, '厉小豆', 1487413450),
(776, 'question/view/411', '', 29, '厉小豆', 1487413453),
(777, 'user/ajaxuserinfo/29', '', 29, '厉小豆', 1487413481),
(778, 'question/delete/411', '', 29, '厉小豆', 1487413512),
(779, 'index/default', '', 29, '厉小豆', 1487413515),
(780, 'user/default', '', 29, '厉小豆', 1487413573),
(781, '', '', 29, '厉小豆', 1487413577),
(782, 'user/ajaxuserinfo/1', '', 29, '厉小豆', 1487413579),
(783, 'question/add/1', '', 29, '厉小豆', 1487413582),
(784, 'question/ajaxadd', '', 29, '厉小豆', 1487413613),
(785, 'question/view/412', '', 29, '厉小豆', 1487413615),
(786, 'question/delete/412', '', 29, '厉小豆', 1487413670),
(787, 'index/default', '', 29, '厉小豆', 1487413673),
(788, '', '', 29, '厉小豆', 1487413741),
(789, 'user/default', '', 29, '厉小豆', 1487413745),
(790, '', '', 29, '厉小豆', 1487413749),
(791, 'user/ajaxuserinfo/1', '', 29, '厉小豆', 1487413752),
(792, 'question/add/1', '', 29, '厉小豆', 1487413754),
(793, 'question/ajaxadd', '', 29, '厉小豆', 1487413883),
(794, 'question/ajaxadd', '', 29, '厉小豆', 1487413935),
(795, 'question/ajaxadd', '', 29, '厉小豆', 1487413950),
(796, 'question/add/1', '', 29, '厉小豆', 1487414052),
(797, 'question/ajaxadd', '', 29, '厉小豆', 1487414062),
(798, 'question/ajaxadd', '', 29, '厉小豆', 1487414093),
(799, 'user/logout', '', 29, '厉小豆', 1487414099),
(800, 'index', '', 29, '厉小豆', 1487414124),
(801, 'question/add', '', 29, '厉小豆', 1487414128),
(802, 'question/ajaxadd', '', 29, '厉小豆', 1487414153),
(803, '', '', 29, '厉小豆', 1487414261),
(804, 'user/ajaxuserinfo/1', '', 29, '厉小豆', 1487414263),
(805, 'question/add/1', '', 29, '厉小豆', 1487414265),
(806, 'question/ajaxadd', '', 29, '厉小豆', 1487414321),
(807, 'question/ajaxadd', '', 29, '厉小豆', 1487414425),
(808, '', '', 29, '厉小豆', 1487414458),
(809, '', '', 29, '厉小豆', 1487414458),
(810, 'user/logout', '', 29, '厉小豆', 1487414479),
(811, 'index', '', 1, 'admin', 1487414494),
(812, 'admin_main', '', 1, 'admin', 1487414497),
(813, 'admin_main/login', '', 1, 'admin', 1487414501),
(814, 'admin_usergroup', '', 1, 'admin', 1487414506),
(815, 'admin_usergroup/regular/7', '', 1, 'admin', 1487414509),
(816, 'admin_usergroup/regular/7', '', 1, 'admin', 1487414515),
(817, 'admin_setting/cache', '', 1, 'admin', 1487414518),
(818, 'admin_setting/cache', '', 1, 'admin', 1487414520),
(819, '', '', 1, 'admin', 1487414521),
(820, 'user/logout', '', 1, 'admin', 1487414525),
(821, 'index', '', 29, '厉小豆', 1487414563),
(822, 'user/ajaxuserinfo/1', '', 29, '厉小豆', 1487414566),
(823, 'question/add/1', '', 29, '厉小豆', 1487414573),
(824, 'user/default', '', 29, '厉小豆', 1487414587),
(825, 'question/ajaxadd', '', 29, '厉小豆', 1487414598),
(826, 'question/view/413', '', 29, '厉小豆', 1487414601),
(827, '', '', 29, '厉小豆', 1487414603),
(828, 'category/view/all', '', 29, '厉小豆', 1487414627),
(829, 'user/default', '', 29, '厉小豆', 1487414632),
(830, 'question/view/413', '', 29, '厉小豆', 1487414640),
(831, 'question/delete/413', '', 29, '厉小豆', 1487414836),
(832, 'index/default', '', 29, '厉小豆', 1487414840),
(833, '', '', 29, '厉小豆', 1487414866),
(834, 'user/default', '', 29, '厉小豆', 1487414868),
(835, '', '', 29, '厉小豆', 1487414873),
(836, 'user/ajaxuserinfo/1', '', 29, '厉小豆', 1487414875),
(837, 'question/add/1', '', 29, '厉小豆', 1487414877),
(838, 'question/ajaxadd', '', 29, '厉小豆', 1487414893),
(839, 'question/view/414', '', 29, '厉小豆', 1487414896),
(840, 'user/default', '', 29, '厉小豆', 1487414899),
(841, 'question/view/414', '', 29, '厉小豆', 1487414905),
(842, 'question/delete/414', '', 29, '厉小豆', 1487414911),
(843, 'index/default', '', 29, '厉小豆', 1487414914),
(844, 'user/default', '', 29, '厉小豆', 1487414917),
(845, '', '', 29, '厉小豆', 1487414933),
(846, 'user/ajaxuserinfo/1', '', 29, '厉小豆', 1487414935),
(847, 'user/ajaxuserinfo/1', '', 29, '厉小豆', 1487414936),
(848, 'user/ajaxuserinfo/1', '', 29, '厉小豆', 1487414941),
(849, 'question/add/1', '', 29, '厉小豆', 1487414943),
(850, 'question/ajaxadd', '', 29, '厉小豆', 1487414968),
(851, 'question/view/415', '', 29, '厉小豆', 1487414971),
(852, 'user/logout', '', 29, '厉小豆', 1487414979),
(853, 'index', '', 1, 'admin', 1487414995),
(854, 'category/view/all', '', 1, 'admin', 1487414999),
(855, 'question/view/415', '', 1, 'admin', 1487415001),
(856, 'question/ajaxanswer', '', 1, 'admin', 1487415023),
(857, 'question/view/415', '', 1, 'admin', 1487415025),
(858, '', '', 29, '厉小豆', 1487415144),
(859, 'user/ajaxuserinfo/302', '', 29, '厉小豆', 1487415151),
(860, 'question/view/415', '', 29, '厉小豆', 1487415154),
(861, 'user/ajaxuserinfo/29', '', 1, 'admin', 1487415207),
(862, 'user/default', '', 1, 'admin', 1487415208),
(863, 'question/ajaxadopt', '', 29, '厉小豆', 1487415223),
(864, 'question/view/415', '', 29, '厉小豆', 1487415225),
(865, 'user/default', '', 1, 'admin', 1487415231),
(866, 'user/ajaxuserinfo/1', '', 29, '厉小豆', 1487415290),
(867, 'question/add/1', '', 29, '厉小豆', 1487415293),
(868, 'question/ajaxadd', '', 29, '厉小豆', 1487415338),
(869, 'question/view/416', '', 29, '厉小豆', 1487415341),
(870, 'user/ajaxuserinfo/29', '', 29, '厉小豆', 1487415346),
(871, 'user/default', '', 29, '厉小豆', 1487415347),
(872, 'user/default', '', 1, 'admin', 1487415377),
(873, 'user/logout', '', 1, 'admin', 1487415382),
(874, 'index', '', 24, '孙吴', 1487415400),
(875, 'category/view/all', '', 24, '孙吴', 1487415407),
(876, 'question/view/416', '', 24, '孙吴', 1487415412),
(877, 'question/ajaxanswer', '', 24, '孙吴', 1487415438),
(878, 'question/view/416', '', 24, '孙吴', 1487415441),
(879, 'question/view/416', '', 29, '厉小豆', 1487415454),
(880, 'question/ajaxadopt', '', 29, '厉小豆', 1487415460),
(881, 'question/view/416', '', 29, '厉小豆', 1487415463),
(882, 'user/default', '', 29, '厉小豆', 1487415467),
(883, 'user/ajaxuserinfo/29', '', 24, '孙吴', 1487415472),
(884, 'user/default', '', 24, '孙吴', 1487415473),
(885, 'user/logout', '', 24, '孙吴', 1487415502),
(886, '', '', 1, 'admin', 1487470291),
(887, 'message/system', '', 1, 'admin', 1487470297),
(888, 'message/system', '', 1, 'admin', 1487470384),
(889, 'message/system', '', 1, 'admin', 1487470402),
(890, 'message/system', '', 1, 'admin', 1487470415),
(891, 'message/system', '', 1, 'admin', 1487470457),
(892, 'message/personal', '', 1, 'admin', 1487470621),
(893, 'message/updateunread', '', 1, 'admin', 1487470735),
(894, 'message/personal', '', 1, 'admin', 1487470747),
(895, 'message/personal', '', 1, 'admin', 1487470807),
(896, 'message/updateunread', '', 1, 'admin', 1487470809),
(897, 'message/personal', '', 1, 'admin', 1487470813),
(898, '', '', 1, 'admin', 1487487980),
(899, '', '', 1, 'admin', 1487487981),
(900, '', '', 1, 'admin', 1487487987),
(901, 'user/default', '', 1, 'admin', 1487487990),
(902, 'user/default', '', 1, 'admin', 1487488042),
(903, 'user/default', '', 1, 'admin', 1487488200),
(904, 'user/default', '', 1, 'admin', 1487488221),
(905, 'user/default', '', 1, 'admin', 1487488235),
(906, 'user/default', '', 1, 'admin', 1487488250),
(907, 'user/default', '', 1, 'admin', 1487488286),
(908, 'user/default', '', 1, 'admin', 1487488407),
(909, 'user/default', '', 1, 'admin', 1487488413),
(910, 'user/default', '', 1, 'admin', 1487488444),
(911, 'user/default', '', 1, 'admin', 1487488523),
(912, 'user/default', '', 1, 'admin', 1487488613),
(913, 'user/default', '', 1, 'admin', 1487488634),
(914, 'user/default', '', 1, 'admin', 1487488716),
(915, 'user/default', '', 1, 'admin', 1487488896),
(916, 'user/default', '', 1, 'admin', 1487488925),
(917, 'user/default', '', 1, 'admin', 1487489756),
(918, 'user/recharge', '', 1, 'admin', 1487489760),
(919, 'user/recharge', '', 1, 'admin', 1487489803),
(920, 'user/recharge', '', 1, 'admin', 1487489837),
(921, 'user/recharge', '', 1, 'admin', 1487489896),
(922, 'user/recharge', '', 1, 'admin', 1487494710),
(923, 'admin_main', '', 1, 'admin', 1487494713),
(924, 'admin_main/login', '', 1, 'admin', 1487494716),
(925, '', '', 1, 'admin', 1487502081),
(926, 'user/default', '', 1, 'admin', 1487502083),
(927, 'user/default', '', 1, 'admin', 1487502084),
(928, 'user/profile', '', 1, 'admin', 1487502095),
(929, 'user/editemail', '', 1, 'admin', 1487502100),
(930, 'user/uppass', '', 1, 'admin', 1487502103),
(931, 'user/userbank', '', 1, 'admin', 1487502698),
(932, '', '', 1, 'admin', 1488028545),
(933, 'admin_main', '', 1, 'admin', 1488028549),
(934, 'admin_main/login', '', 1, 'admin', 1488028551),
(935, 'admin_category', '', 1, 'admin', 1488028557),
(936, '', '', 1, 'admin', 1488028574),
(937, 'category/view/3', '', 1, 'admin', 1488028581),
(938, 'category/view/31', '', 1, 'admin', 1488028704);
INSERT INTO `ask_site_log` (`id`, `guize`, `miaoshu`, `uid`, `username`, `time`) VALUES
(939, 'question/view/404', '', 1, 'admin', 1488028716),
(940, 'admin_category/view/31', '', 1, 'admin', 1488028739),
(941, 'admin_category/edit/32', '', 1, 'admin', 1488028754),
(942, 'admin_category/edit', '', 1, 'admin', 1488028774),
(943, 'category/view/31', '', 1, 'admin', 1488028779),
(944, 'category/view/33', '', 1, 'admin', 1488028786),
(945, 'category/view/32', '', 1, 'admin', 1488028792),
(946, 'category/view/32', '', 1, 'admin', 1488028794),
(947, 'category/view/31', '', 1, 'admin', 1488028800),
(948, 'question/view/404', '', 1, 'admin', 1488028810),
(949, 'category/view/32', '', 1, 'admin', 1488028813),
(950, 'category/view/32', '', 1, 'admin', 1488028822),
(951, 'admin_category/view/31', '', 1, 'admin', 1488028829),
(952, 'admin_category/view/33', '', 1, 'admin', 1488028832),
(953, 'admin_category/edit/32', '', 1, 'admin', 1488028835),
(954, 'admin_category/edit', '', 1, 'admin', 1488028840),
(955, 'category/view/33', '', 1, 'admin', 1488028846),
(956, 'category/view/31', '', 1, 'admin', 1488028849),
(957, 'category/view/all', '', 1, 'admin', 1488028855),
(958, 'category/view/31', '', 1, 'admin', 1488028858),
(959, 'admin_category/view/31', '', 1, 'admin', 1488028869),
(960, 'admin_category/view/33', '', 1, 'admin', 1488028875),
(961, 'admin_category/edit/32', '', 1, 'admin', 1488028878),
(962, 'admin_category/edit', '', 1, 'admin', 1488028897),
(963, 'category/view/31', '', 1, 'admin', 1488028903),
(964, 'category/view/32', '', 1, 'admin', 1488028907),
(965, 'admin_category/view/31', '', 1, 'admin', 1488029060),
(966, 'admin_category/edit/32', '', 1, 'admin', 1488029063),
(967, 'admin_category/edit', '', 1, 'admin', 1488029068),
(968, 'category/view/31', '', 1, 'admin', 1488029072),
(969, 'category/view/31', '', 1, 'admin', 1488029082),
(970, 'category/view/33', '', 1, 'admin', 1488029086),
(971, 'category/view/32', '', 1, 'admin', 1488029096),
(972, 'category/view/31', '', 1, 'admin', 1488029101),
(973, 'category/view/32', '', 1, 'admin', 1488029108),
(974, 'category/view/32', '', 1, 'admin', 1488029216),
(975, 'category/view/32', '', 1, 'admin', 1488029306),
(976, 'user/default', '', 523, 'ffffffffff', 1488377017),
(977, 'user/logout', '', 523, 'ffffffffff', 1488377021),
(978, '', '', 1, 'admin', 1488590814),
(979, 'update', '', 1, 'admin', 1488590819),
(980, 'update', '', 1, 'admin', 1488590820),
(981, '', '', 1, 'admin', 1488623842),
(982, '', '', 1, 'admin', 1488623842),
(983, 'message/system', '', 1, 'admin', 1488623847),
(984, 'update', '', 1, 'admin', 1488624059),
(985, '', '', 1, 'admin', 1488624380),
(986, '', '', 1, 'admin', 1488624381),
(987, 'update', '', 1, 'admin', 1488624388),
(988, '', '', 1, 'admin', 1488679439),
(989, '', '', 1, 'admin', 1488680824),
(990, 'update', '', 1, 'admin', 1488709976),
(991, 'update', '', 1, 'admin', 1488710107),
(992, 'update', '', 1, 'admin', 1488710154),
(993, '', '', 1, 'admin', 1488711992),
(994, '', '', 1, 'admin', 1488711993),
(995, 'question/view/117', '', 1, 'admin', 1488711996),
(996, 'question/view/404', '', 1, 'admin', 1488712004),
(997, 'question/view/404/2', '', 1, 'admin', 1488712010),
(998, 'question/view/404/2', '', 1, 'admin', 1488712026),
(999, 'answer/ajaxhassupport/840', '', 1, 'admin', 1488712031),
(1000, 'user/ajaxuserinfo/508', '', 1, 'admin', 1488712600),
(1001, '', '', 1, 'admin', 1488712601),
(1002, 'user/ajaxuserinfo/147', '', 1, 'admin', 1488712851),
(1003, 'user/default', '', 1, 'admin', 1488716525),
(1004, '', '', 1, 'admin', 1489195102),
(1005, 'admin_main', '', 1, 'admin', 1489195108),
(1006, 'admin_main/login', '', 1, 'admin', 1489195110),
(1007, 'admin_setting/cache', '', 1, 'admin', 1489195112),
(1008, 'admin_setting/cache', '', 1, 'admin', 1489195114),
(1009, '', '', 1, 'admin', 1489195120),
(1010, '', '', 1, 'admin', 1489195229),
(1011, 'question/view/152', '', 1, 'admin', 1489195234),
(1012, 'admin_setting/seo', '', 1, 'admin', 1489195243),
(1013, 'admin_setting/seo', '', 1, 'admin', 1489195248),
(1014, 'admin_setting/cache', '', 1, 'admin', 1489195254),
(1015, 'admin_setting/cache', '', 1, 'admin', 1489195257),
(1016, '', '', 1, 'admin', 1489195260),
(1017, 'question/view/132', '', 1, 'admin', 1489195266),
(1018, '', '', 1, 'admin', 1489195459),
(1019, 'question/view/404', '', 1, 'admin', 1489195466),
(1020, 'question/view/404/3', '', 1, 'admin', 1489195472),
(1021, 'question/view/404/2', '', 1, 'admin', 1489195475),
(1022, '', '', 1, 'admin', 1489195522),
(1023, 'admin_setting/cache', '', 1, 'admin', 1489195528),
(1024, 'admin_setting/cache', '', 1, 'admin', 1489195529),
(1025, '', '', 1, 'admin', 1489195532),
(1026, 'question/view/109', '', 1, 'admin', 1489195540),
(1027, 'question/view/153', '', 1, 'admin', 1489195654),
(1028, 'topic/getone/448', '', 1, 'admin', 1489196057),
(1029, '', '', 320, 'bbbbbb', 1489196161),
(1030, 'topic/pushhot/448', '', 320, 'bbbbbb', 1489196165),
(1031, 'user/login', '', 320, 'bbbbbb', 1489196168),
(1032, '', '', 320, 'bbbbbb', 1489196169),
(1033, 'topic/default', '', 1, 'admin', 1489196276),
(1034, 'user/addxinzhi', '', 1, 'admin', 1489196280),
(1035, 'user/default', '', 1, 'admin', 1489197691),
(1036, 'user/level', '', 1, 'admin', 1489197695),
(1037, 'user/level', '', 1, 'admin', 1489199721),
(1038, '', '', 1, 'admin', 1489199834),
(1039, 'user/logout', '', 1, 'admin', 1489199839),
(1040, '', '', 320, 'bbbbbb', 1489199854),
(1041, 'question/view/85', '', 320, 'bbbbbb', 1489199867),
(1042, 'user/default', '', 320, 'bbbbbb', 1489199872),
(1043, '', '', 320, 'bbbbbb', 1489199878),
(1044, 'question/view/128', '', 320, 'bbbbbb', 1489199882),
(1045, 'user/default', '', 320, 'bbbbbb', 1489200063),
(1046, 'user/editimg', '', 320, 'bbbbbb', 1489200067),
(1047, 'user/mycategory', '', 320, 'bbbbbb', 1489200069),
(1048, 'user/', '', 320, 'bbbbbb', 1489200069),
(1049, 'user/editimg', '', 320, 'bbbbbb', 1489200070),
(1050, 'user/mycategory', '', 320, 'bbbbbb', 1489200071),
(1051, 'user/ajaxcategory', '', 320, 'bbbbbb', 1489200077),
(1052, '', '', 320, 'bbbbbb', 1489200079),
(1053, 'user/ajaxuserinfo/78', '', 320, 'bbbbbb', 1489200222),
(1054, 'question/view/77', '', 320, 'bbbbbb', 1489200225),
(1055, '', '', 320, 'bbbbbb', 1489200244),
(1056, 'question/view/add', '', 320, 'bbbbbb', 1489200247),
(1057, '', '', 320, 'bbbbbb', 1489200250),
(1058, 'question/view/add', '', 320, 'bbbbbb', 1489200253),
(1059, '', '', 320, 'bbbbbb', 1489200257),
(1060, 'question/view/add', '', 320, 'bbbbbb', 1489200293),
(1061, '', '', 320, 'bbbbbb', 1489200297),
(1062, 'user/ajaxpoplogin', '', 320, 'bbbbbb', 1489200317),
(1063, 'user/ajaxcode/7vv0', '', 320, 'bbbbbb', 1489200336),
(1064, 'user/login', '', 320, 'bbbbbb', 1489200339),
(1065, '', '', 320, 'bbbbbb', 1489200340),
(1066, '', '', 320, 'bbbbbb', 1489200343),
(1067, 'question/view/add', '', 320, 'bbbbbb', 1489200349),
(1068, '', '', 320, 'bbbbbb', 1489200352),
(1069, 'question/view/add', '', 320, 'bbbbbb', 1489200372),
(1070, '', '', 320, 'bbbbbb', 1489200376),
(1071, 'question/view/add', '', 320, 'bbbbbb', 1489200378),
(1072, '', '', 320, 'bbbbbb', 1489200381),
(1073, '', '', 320, 'bbbbbb', 1489200419),
(1074, 'question/add', '', 320, 'bbbbbb', 1489200424),
(1075, 'question/add', '', 320, 'bbbbbb', 1489201256),
(1076, 'question/ajaxadd', '', 320, 'bbbbbb', 1489201279),
(1077, 'question/view/417', '', 320, 'bbbbbb', 1489201282),
(1078, 'question/supply/417', '', 320, 'bbbbbb', 1489201294),
(1079, 'question/ajaxsupply', '', 320, 'bbbbbb', 1489201299),
(1080, 'question/view/417', '', 320, 'bbbbbb', 1489201301),
(1081, 'question/addscore', '', 320, 'bbbbbb', 1489201308),
(1082, 'question/view/417', '', 320, 'bbbbbb', 1489201311),
(1083, 'question/edittag', '', 320, 'bbbbbb', 1489201321),
(1084, 'question/view/417', '', 320, 'bbbbbb', 1489201324),
(1085, 'user/ajaxuserinfo/320', '', 320, 'bbbbbb', 1489201333),
(1086, 'question/view/css/default/loading', '', 320, 'bbbbbb', 1489201333),
(1087, 'user/logout', '', 320, 'bbbbbb', 1489201336),
(1088, 'index', '', 1, 'admin', 1489201355),
(1089, 'question/add', '', 1, 'admin', 1489201372),
(1090, '', '', 1, 'admin', 1489201377),
(1091, 'admin_main', '', 1, 'admin', 1489201386),
(1092, 'admin_main/login', '', 1, 'admin', 1489201389),
(1093, 'admin_setting/cache', '', 1, 'admin', 1489201391),
(1094, 'admin_setting/cache', '', 1, 'admin', 1489201395),
(1095, '', '', 1, 'admin', 1489201399),
(1096, 'question/view/417', '', 1, 'admin', 1489201402),
(1097, 'question/ajaxanswer', '', 1, 'admin', 1489201408),
(1098, 'question/ajaxanswer', '', 1, 'admin', 1489201411),
(1099, 'question/view/417', '', 1, 'admin', 1489201412),
(1100, '', '', 1, 'admin', 1489201464),
(1101, 'question/view/141', '', 1, 'admin', 1489201467),
(1102, 'admin_question', '', 1, 'admin', 1489201475),
(1103, 'admin_question/nosolve', '', 1, 'admin', 1489201485),
(1104, 'admin_question/searchquestion', '', 1, 'admin', 1489201490),
(1105, 'admin_question/nosolve', '', 1, 'admin', 1489201495),
(1106, 'user/ajaxuserinfo/78', '', 1, 'admin', 1489201500),
(1107, 'user/ajaxuserinfo/78', '', 1, 'admin', 1489201502),
(1108, 'question/view/90', '', 1, 'admin', 1489201502),
(1109, '', '', 1, 'admin', 1489201508),
(1110, 'question/view/86', '', 1, 'admin', 1489201601),
(1111, 'question/view/407', '', 1, 'admin', 1489201610),
(1112, '', '', 1, 'admin', 1489201697),
(1113, 'question/view/90', '', 1, 'admin', 1489201702),
(1114, 'admin_question/searchquestion', '', 1, 'admin', 1489201710),
(1115, 'admin_question/nosolve', '', 1, 'admin', 1489201714),
(1116, 'question/view/90', '', 1, 'admin', 1489201719),
(1117, 'question/ajaxanswer', '', 1, 'admin', 1489201728),
(1118, 'question/view/90', '', 1, 'admin', 1489201730),
(1119, 'question/movecategory', '', 1, 'admin', 1489201784),
(1120, 'question/view/90', '', 1, 'admin', 1489201787),
(1121, '', '', 1, 'admin', 1489201810),
(1122, 'topic/default', '', 1, 'admin', 1489201814),
(1123, 'user/addxinzhi', '', 1, 'admin', 1489201818),
(1124, 'question/view/141', '', 1, 'admin', 1489202400),
(1125, 'topic/getone/448', '', 1, 'admin', 1489202406),
(1126, 'topic/default', '', 1, 'admin', 1489202412),
(1127, 'user/addxinzhi', '', 1, 'admin', 1489202416),
(1128, 'user/addxinzhi', '', 1, 'admin', 1489202499),
(1129, 'topic/getone/452', '', 1, 'admin', 1489202503),
(1130, 'topic/default', '', 1, 'admin', 1489203172),
(1131, 'topic/getone/452', '', 1, 'admin', 1489203186),
(1132, 'question/view/417', '', 1, 'admin', 1489204404),
(1133, 'user/ajaxuserinfo/320', '', 1, 'admin', 1489204408),
(1134, 'question/view/css/default/loading', '', 1, 'admin', 1489204408),
(1135, 'question/view/161', '', 1, 'admin', 1489204410),
(1136, 'category/view/all', '', 1, 'admin', 1489204417),
(1137, 'category/view/all/1', '', 1, 'admin', 1489204421),
(1138, 'question/view/400', '', 1, 'admin', 1489204425),
(1139, 'question/view/400', '', 1, 'admin', 1489204431),
(1140, 'question/ajaxanswer', '', 1, 'admin', 1489204438),
(1141, 'question/view/400', '', 1, 'admin', 1489204441),
(1142, '', '', 1, 'admin', 1489204483),
(1143, 'admin_main', '', 1, 'admin', 1489204824),
(1144, 'admin_main/login', '', 1, 'admin', 1489204826),
(1145, 'admin_main/login', '', 1, 'admin', 1489204830),
(1146, 'admin_main/stat', '', 1, 'admin', 1489204834),
(1147, 'admin_template/default/pc', '', 1, 'admin', 1489205344),
(1148, 'admin_template/getpcdir', '', 1, 'admin', 1489205345),
(1149, 'admin_template/getpcdirfile', '', 1, 'admin', 1489205346),
(1150, 'admin_template/default/pc', '', 1, 'admin', 1489205376),
(1151, 'admin_template/getpcdir', '', 1, 'admin', 1489205377),
(1152, 'admin_template/getpcdirfile', '', 1, 'admin', 1489205378),
(1153, 'admin_template/default/wap', '', 1, 'admin', 1489205381),
(1154, 'admin_template/getwapdir', '', 1, 'admin', 1489205382),
(1155, 'admin_template/getpcdirfile', '', 1, 'admin', 1489205383),
(1156, 'admin_topic', '', 1, 'admin', 1489205433),
(1157, 'admin_question/examine', '', 1, 'admin', 1489205437),
(1158, 'admin_user/add', '', 1, 'admin', 1489205442),
(1159, 'admin_sitelog', '', 1, 'admin', 1489205446),
(1160, '', '', 1, 'admin', 1489205477),
(1161, 'user/default', '', 1, 'admin', 1489205479),
(1162, 'user/default', '', 1, 'admin', 1489205480),
(1163, 'user/default', '', 1, 'admin', 1489205481),
(1164, 'user/profile', '', 1, 'admin', 1489205485),
(1165, 'user/mycategory', '', 1, 'admin', 1489205488),
(1166, 'admin_db/backup', '', 1, 'admin', 1489205529),
(1167, 'admin_db/backup', '', 1, 'admin', 1489205532),
(1168, 'admin_db/backup/full/20170311_7AZRZ9OK/2048/68/0/1/0/1', '', 1, 'admin', 1489205537),
(1169, 'admin_db/backup', '', 1, 'admin', 1489205542),
(1170, 'admin_db/downloadfile/20170311_7AZRZ9OK_1*sql', '', 1, 'admin', 1489205547),
(1171, 'admin_db/import/20170311_7AZRZ9OK_1*sql', '', 1, 'admin', 1489205553),
(1172, 'admin_db/backup', '', 1, 'admin', 1489205557),
(1173, 'admin_db/import/20170311_7AZRZ9OK_1*sql', '', 1, 'admin', 1489205596),
(1174, 'admin_db/backup', '', 1, 'admin', 1489205600),
(1175, 'admin_db/import/20170311_7AZRZ9OK_1*sql', '', 1, 'admin', 1489205651),
(1176, 'admin_db/remove/20170311_7AZRZ9OK_1*sql', '', 1, 'admin', 1489205656),
(1177, 'admin_db/backup', '', 1, 'admin', 1489205660),
(1178, 'admin_db/remove/20160921_HFXvVuIp_1*sql', '', 1, 'admin', 1489205664),
(1179, 'admin_db/backup', '', 1, 'admin', 1489205668),
(1180, 'admin_db/backup', '', 1, 'admin', 1489205682),
(1181, 'admin_db/backup', '', 1, 'admin', 1489205684),
(1182, 'admin_db/import/20170311_p0afCoiN_2*sql/2/sql', '', 1, 'admin', 1489205783),
(1183, 'admin_db/backup', '', 1, 'admin', 1489205787),
(1184, 'admin_db/remove/20170311_p0afCoiN_1*sql', '', 1, 'admin', 1489205796),
(1185, 'admin_db/backup', '', 1, 'admin', 1489205800),
(1186, 'admin_db/backup', '', 1, 'admin', 1489205873),
(1187, 'admin_db/backup', '', 1, 'admin', 1489205875),
(1188, 'admin_db/backup/full/20170311_tPYxIPen/2048/68/0/1/0/1', '', 1, 'admin', 1489205879),
(1189, 'admin_db/backup', '', 1, 'admin', 1489205883),
(1190, 'admin_db/remove/20170311_tPYxIPen_1*sql', '', 1, 'admin', 1489205886),
(1191, 'admin_db/backup', '', 1, 'admin', 1489205890),
(1192, 'admin_db/backup', '', 1, 'admin', 1489205893),
(1193, 'admin_db/backup/full/20170311_bObrxC1a/2048/68/0/1/0/1', '', 1, 'admin', 1489205897),
(1194, 'admin_db/backup', '', 1, 'admin', 1489205901),
(1195, 'admin_db/remove/20170311_bObrxC1a_1*sql', '', 1, 'admin', 1489205905),
(1196, 'admin_db/backup', '', 1, 'admin', 1489205909),
(1197, 'admin_main/regulate', '', 1, 'admin', 1489205967),
(1198, 'admin_datacall/default', '', 1, 'admin', 1489205970),
(1199, 'admin_main/stat', '', 1, 'admin', 1489206046),
(1200, 'admin_main', '', 1, 'admin', 1489206060),
(1201, 'admin_main/login', '', 1, 'admin', 1489206062),
(1202, 'admin_main/login', '', 1, 'admin', 1489206167),
(1203, 'admin_main/login', '', 1, 'admin', 1489206195),
(1204, '', '', 1, 'admin', 1489206196),
(1205, 'admin_main/login', '', 1, 'admin', 1489206220),
(1206, 'admin_main/stat', '', 1, 'admin', 1489206223),
(1207, 'admin_main/login', '', 1, 'admin', 1489206251),
(1208, 'admin_main/stat', '', 1, 'admin', 1489206252),
(1209, 'admin_main/stat', '', 1, 'admin', 1489206285),
(1210, 'admin_setting/cache', '', 1, 'admin', 1489206354),
(1211, 'admin_setting/cache', '', 1, 'admin', 1489206356),
(1212, '', '', 1, 'admin', 1489206358),
(1213, '', '', 1, 'admin', 1489206369),
(1214, 'category/view/2', '', 1, 'admin', 1489206458),
(1215, 'question/view/417', '', 1, 'admin', 1489206463),
(1216, 'topic/default', '', 1, 'admin', 1489206467),
(1217, 'topic/catlist/19', '', 1, 'admin', 1489206472),
(1218, 'topic/default', '', 1, 'admin', 1489206476),
(1219, 'topic/getone/451', '', 1, 'admin', 1489206480),
(1220, '', '', 1, 'admin', 1489206493),
(1221, 'admin_question', '', 1, 'admin', 1489206539),
(1222, 'admin_question/delete', '', 1, 'admin', 1489206724),
(1223, 'admin_question/delete', '', 1, 'admin', 1489206728),
(1224, 'admin_question/delete', '', 1, 'admin', 1489206733),
(1225, 'admin_question/delete', '', 1, 'admin', 1489206738),
(1226, 'admin_question/delete', '', 1, 'admin', 1489206742),
(1227, 'admin_question/delete', '', 1, 'admin', 1489206747),
(1228, 'admin_question/delete', '', 1, 'admin', 1489206752),
(1229, 'admin_question/delete', '', 1, 'admin', 1489206756),
(1230, 'admin_question/delete', '', 1, 'admin', 1489206761),
(1231, 'admin_setting/cache', '', 1, 'admin', 1489206764),
(1232, 'admin_setting/cache', '', 1, 'admin', 1489206764),
(1233, '', '', 1, 'admin', 1489206767),
(1234, '', '', 1, 'admin', 1489206823),
(1235, '', '', 1, 'admin', 1489206961),
(1236, '', '', 1, 'admin', 1489207037),
(1237, '', '', 1, 'admin', 1489207872),
(1238, 'question/view/90', '', 1, 'admin', 1489207883),
(1239, 'admin_main', '', 1, 'admin', 1489207907),
(1240, 'admin_main/login', '', 1, 'admin', 1489207909),
(1241, 'admin_main/stat', '', 1, 'admin', 1489207910),
(1242, 'admin_nav', '', 1, 'admin', 1489207913),
(1243, 'admin_nav/remove/7', '', 1, 'admin', 1489207919),
(1244, 'admin_nav/remove/12', '', 1, 'admin', 1489207930),
(1245, 'admin_nav/remove/13', '', 1, 'admin', 1489207934),
(1246, 'admin_nav/remove/6', '', 1, 'admin', 1489207954);

-- --------------------------------------------------------

--
-- 表的结构 `ask_tid_qid`
--

CREATE TABLE IF NOT EXISTS `ask_tid_qid` (
  `tid` int(10) NOT NULL DEFAULT '0',
  `qid` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tid`,`qid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ask_topic`
--

CREATE TABLE IF NOT EXISTS `ask_topic` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `describtion` text,
  `image` varchar(100) DEFAULT NULL,
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `author` varchar(200) NOT NULL,
  `authorid` int(10) NOT NULL,
  `views` int(10) NOT NULL,
  `articleclassid` int(10) NOT NULL,
  `isphone` int(10) NOT NULL,
  `viewtime` int(10) unsigned NOT NULL,
  `ispc` int(10) NOT NULL DEFAULT '0',
  `articles` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=453 ;

-- --------------------------------------------------------

--
-- 表的结构 `ask_topicclass`
--

CREATE TABLE IF NOT EXISTS `ask_topicclass` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `dir` varchar(200) NOT NULL,
  `pid` int(10) NOT NULL,
  `displayorder` int(10) NOT NULL,
  `articles` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `ask_topic_tag`
--

CREATE TABLE IF NOT EXISTS `ask_topic_tag` (
  `aid` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `time` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ask_user`
--

CREATE TABLE IF NOT EXISTS `ask_user` (
  `uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(18) NOT NULL,
  `password` char(32) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `groupid` tinyint(3) unsigned NOT NULL DEFAULT '7',
  `credits` int(10) NOT NULL DEFAULT '0',
  `credit1` int(10) NOT NULL DEFAULT '0',
  `credit2` int(10) NOT NULL DEFAULT '0',
  `credit3` int(10) NOT NULL DEFAULT '0',
  `regip` char(15) DEFAULT NULL,
  `regtime` int(10) NOT NULL DEFAULT '0',
  `lastlogin` int(10) unsigned NOT NULL DEFAULT '0',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `bday` date DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `qq` varchar(15) DEFAULT NULL,
  `msn` varchar(40) DEFAULT NULL,
  `authstr` varchar(25) DEFAULT NULL,
  `signature` mediumtext,
  `introduction` varchar(200) DEFAULT NULL,
  `questions` int(10) unsigned NOT NULL DEFAULT '0',
  `answers` int(10) unsigned NOT NULL DEFAULT '0',
  `adopts` int(10) unsigned NOT NULL DEFAULT '0',
  `supports` int(10) NOT NULL DEFAULT '0',
  `followers` int(10) NOT NULL DEFAULT '0',
  `attentions` int(10) NOT NULL DEFAULT '0',
  `isnotify` tinyint(1) unsigned NOT NULL DEFAULT '7',
  `elect` int(10) NOT NULL DEFAULT '0',
  `expert` tinyint(2) NOT NULL DEFAULT '0',
  `bankcard` varchar(200) DEFAULT NULL,
  `activecode` varchar(200) DEFAULT NULL,
  `active` int(10) DEFAULT '0',
  `mypay` double DEFAULT '0',
  `isblack` int(10) DEFAULT '0',
  `fromsite` int(10) DEFAULT '0',
  `jine` double DEFAULT '0',
  `articles` int(10) DEFAULT '0',
  `openid` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`uid`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=524 ;

-- --------------------------------------------------------

--
-- 表的结构 `ask_userbank`
--

CREATE TABLE IF NOT EXISTS `ask_userbank` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `fromuid` int(10) NOT NULL,
  `touid` int(10) NOT NULL,
  `operation` varchar(200) NOT NULL,
  `money` int(10) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ask_userbank`
--

INSERT INTO `ask_userbank` (`id`, `fromuid`, `touid`, `operation`, `money`, `time`) VALUES
(1, 2, 1, '22332', 1, 2323232),
(2, 2, 1, '22332', 1, 2323232);

-- --------------------------------------------------------

--
-- 表的结构 `ask_usergroup`
--

CREATE TABLE IF NOT EXISTS `ask_usergroup` (
  `groupid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `level` int(4) NOT NULL DEFAULT '1' COMMENT '用户级别',
  `grouptitle` char(30) NOT NULL DEFAULT '',
  `grouptype` tinyint(1) NOT NULL DEFAULT '2',
  `creditslower` int(10) NOT NULL,
  `creditshigher` int(10) NOT NULL DEFAULT '0',
  `questionlimits` int(10) NOT NULL DEFAULT '0',
  `answerlimits` int(10) NOT NULL DEFAULT '0',
  `credit3limits` int(10) NOT NULL DEFAULT '0',
  `regulars` text NOT NULL,
  `doarticle` int(10) DEFAULT '0',
  `articlelimits` int(10) DEFAULT '1',
  PRIMARY KEY (`groupid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- 转存表中的数据 `ask_usergroup`
--

INSERT INTO `ask_usergroup` (`groupid`, `level`, `grouptitle`, `grouptype`, `creditslower`, `creditshigher`, `questionlimits`, `answerlimits`, `credit3limits`, `regulars`, `doarticle`, `articlelimits`) VALUES
(1, 0, '超级管理员', 1, 0, 1, 0, 0, 0, 'user/qqlogin,user/register,index/default,category/view,category/list,question/view,category/recommend,note/list,note/view,rss/category,rss/list,rss/question,user/space,user/scorelist,question/search,question/add,gift/default,gift/search,gift/add\r\n', 0, 1),
(2, 0, '管理员', 1, 0, 1, 0, 0, 0, 'user/qqlogin,user/register,index/default,category/view,category/list,question/view,category/recommend,note/list,note/view,rss/category,rss/list,rss/question,user/space,user/scorelist,question/search,question/add,gift/default,gift/search,gift/add\r\n,user/sendcheckmail,user/editemail', 0, 1),
(3, 0, '分类员', 1, 0, 1, 0, 0, 0, 'user/qqlogin,user/register,index/default,category/view,category/list,question/view,category/recommend,note/list,note/view,rss/category,rss/list,rss/question,user/space,user/scorelist,question/search,question/add,gift/default,gift/search,gift/add\r\n,user/sendcheckmail,user/editemail', 0, 1),
(6, 0, '游客', 3, 0, 1, 0, 0, 0, 'user/register,user/editimg,index/default,category/view,category/list,question/view,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space', 0, 1),
(7, 1, '抽奖者', 2, 0, 80, 9, 9, 5, 'user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail', 0, 1),
(8, 2, '书生', 2, 80, 400, 5, 5, 8, 'user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail', 0, 1),
(9, 3, '秀才', 2, 400, 800, 10, 10, 10, 'user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail', 0, 1),
(10, 4, '举人', 2, 800, 2000, 15, 15, 12, 'user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail', 0, 1),
(11, 5, '解元', 2, 2000, 4000, 10, 10, 10, 'user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail', 0, 1),
(12, 6, '贡士', 2, 4000, 7000, 15, 15, 20, 'user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail', 0, 1),
(13, 7, '会元', 2, 7000, 10000, 15, 15, 20, 'user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail', 0, 1),
(14, 8, '同进士出身', 2, 10000, 14000, 0, 0, 0, 'user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail', 0, 1),
(15, 9, '大学士', 2, 14000, 18000, 0, 0, 0, 'user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail', 0, 1),
(16, 10, '探花', 2, 18000, 22000, 0, 0, 0, 'user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail', 0, 1),
(17, 11, '榜眼', 2, 22000, 32000, 0, 0, 0, 'user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail', 0, 1),
(18, 12, '状元', 2, 32000, 45000, 0, 0, 0, 'user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail', 0, 1),
(19, 13, '编修', 2, 45000, 60000, 0, 0, 0, 'user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail', 0, 1),
(20, 14, '府丞', 2, 60000, 100000, 0, 0, 0, 'user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail', 0, 1),
(21, 15, '翰林学士', 2, 100000, 150000, 0, 0, 0, 'user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail', 0, 1),
(22, 16, '御史中丞', 2, 150000, 250000, 0, 0, 0, 'user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail', 0, 1),
(23, 17, '詹士', 2, 250000, 400000, 0, 0, 0, 'user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail', 0, 1),
(24, 18, '侍郎', 2, 400000, 700000, 0, 0, 0, 'user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail', 0, 1),
(25, 19, '大学士', 2, 700000, 1000000, 0, 0, 0, 'user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail', 0, 1),
(26, 20, '文曲星', 2, 1000000, 999999999, 0, 0, 0, 'user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail', 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `ask_userlog`
--

CREATE TABLE IF NOT EXISTS `ask_userlog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sid` varchar(10) NOT NULL DEFAULT '',
  `type` enum('login','ask','answer') NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sid` (`sid`),
  KEY `time` (`time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=70 ;

-- --------------------------------------------------------

--
-- 表的结构 `ask_user_attention`
--

CREATE TABLE IF NOT EXISTS `ask_user_attention` (
  `uid` int(10) NOT NULL,
  `followerid` int(10) NOT NULL,
  `follower` char(18) NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`uid`,`followerid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ask_user_category`
--

CREATE TABLE IF NOT EXISTS `ask_user_category` (
  `uid` int(10) NOT NULL,
  `cid` int(4) NOT NULL,
  PRIMARY KEY (`uid`,`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ask_user_readlog`
--

CREATE TABLE IF NOT EXISTS `ask_user_readlog` (
  `uid` int(10) NOT NULL,
  `qid` int(10) NOT NULL,
  PRIMARY KEY (`uid`,`qid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ask_visit`
--

CREATE TABLE IF NOT EXISTS `ask_visit` (
  `ip` varchar(15) NOT NULL,
  `time` int(10) NOT NULL DEFAULT '0',
  KEY `ip` (`ip`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ask__keywords`
--

CREATE TABLE IF NOT EXISTS `ask__keywords` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `find` varchar(200) NOT NULL,
  `replacement` varchar(200) NOT NULL,
  `admin` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
