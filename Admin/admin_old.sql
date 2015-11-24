/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50027
Source Host           : localhost:3306
Source Database       : admin_old

Target Server Type    : MYSQL
Target Server Version : 50027
File Encoding         : 65001

Date: 2013-02-28 22:37:54
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `admin_name` varchar(32) NOT NULL default '',
  `admin_real_name` varchar(32) default NULL,
  `admin_password` varchar(32) NOT NULL default '',
  `admin_rights` tinyint(2) NOT NULL default '0',
  `admin_password_remain_times` int(2) default '15',
  `admin_locked` int(11) default '0',
  `admin_email` varchar(64) default NULL,
  `admin_last_loaded_ip` varchar(15) default NULL,
  `admin_menu_rights` mediumtext,
  `dep` int(2) default NULL,
  `admin_last_loaded_time` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO admin VALUES ('1', 'admin', '孟之杰', '21232f297a57a5a743894a0e4a801fc3', '3', '15', '0', 'roy.urey@gmail.com', '127.0.0.1', null, '1', '1361437349');
INSERT INTO admin VALUES ('3', 'yangchen3161', '张洋', 'fcfaaa5f1bf2bd8ca4dff379e8c99426', '3', '15', '1', '', '172.17.247.140', null, '1', '0');
INSERT INTO admin VALUES ('4', 'irene', '刘莹', 'e10adc3949ba59abbe56e057f20f883e', '1', '15', '1', '', '172.18.11.186', null, '2', '0');
INSERT INTO admin VALUES ('5', 'Fendy', '任永梅', 'e10adc3949ba59abbe56e057f20f883e', '1', '15', '1', '', '202.202.32.38', null, '2', '0');
INSERT INTO admin VALUES ('7', 'zoe01510312', '黄燕', 'e10adc3949ba59abbe56e057f20f883e', '1', '15', '1', '', '211.83.215.53', null, '2', '0');
INSERT INTO admin VALUES ('8', 'dawei', '冯大为', 'e10adc3949ba59abbe56e057f20f883e', '1', '15', '1', '', '172.22.23.111', null, '2', '0');
INSERT INTO admin VALUES ('10', '何宏兵', '何宏兵', 'e10adc3949ba59abbe56e057f20f883e', '2', '15', '1', '', '202.202.32.38', '#21#22#23#', '2', '0');
INSERT INTO admin VALUES ('11', 'fxyhe', '何老师', 'e10adc3949ba59abbe56e057f20f883e', '1', '15', '1', null, '172.22.23.16', '#21#22#23#', '2', '0');
INSERT INTO admin VALUES ('12', 'test', 'test', '21232f297a57a5a743894a0e4a801fc3', '1', '15', '0', null, '127.0.0.1', null, '2', '1351503419');
INSERT INTO admin VALUES ('13', 'kross_test', 'admin', '21232f297a57a5a743894a0e4a801fc3', '1', '15', '0', 'admin', null, null, '1', '0');
INSERT INTO admin VALUES ('14', 'test1', 'admin', '21232f297a57a5a743894a0e4a801fc3', '1', '15', '0', 'admin', null, null, '1', '0');

-- ----------------------------
-- Table structure for `adminip`
-- ----------------------------
DROP TABLE IF EXISTS `adminip`;
CREATE TABLE `adminip` (
  `id` int(3) unsigned NOT NULL auto_increment,
  `admin_id` int(3) NOT NULL default '0',
  `admin_ip` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='InnoDB free: 7168 kB';

-- ----------------------------
-- Records of adminip
-- ----------------------------

-- ----------------------------
-- Table structure for `annex`
-- ----------------------------
DROP TABLE IF EXISTS `annex`;
CREATE TABLE `annex` (
  `ann_id` int(5) unsigned NOT NULL auto_increment,
  `ann_title` varchar(50) NOT NULL,
  `ann_source` varchar(32) NOT NULL,
  `ann_type` int(5) unsigned NOT NULL,
  `ann_url` char(255) NOT NULL,
  `ann_show` mediumtext NOT NULL,
  `ann_add_user` int(5) NOT NULL,
  `ann_add_ip` char(15) NOT NULL,
  `ann_article_id` int(5) unsigned NOT NULL default '0',
  `ann_click` int(5) unsigned NOT NULL,
  `ann_lock` enum('yes','no') NOT NULL default 'yes',
  `ann_add_time` int(11) default '0',
  PRIMARY KEY  (`ann_id`,`ann_type`,`ann_add_user`,`ann_article_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of annex
-- ----------------------------
INSERT INTO annex VALUES ('1', 'chromecacheview.zip', 'article', '10', 'upload/mounts/1322292507_1.zip', '文章中的附件', '1', '127.0.0.1', '15', '0', 'no', '0');

-- ----------------------------
-- Table structure for `article`
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `art_id` int(5) unsigned NOT NULL auto_increment COMMENT 'ID',
  `art_title` varchar(50) NOT NULL,
  `art_source` varchar(255) NOT NULL,
  `art_author` varchar(20) NOT NULL,
  `art_dept` varchar(50) default NULL,
  `art_content` mediumtext NOT NULL,
  `art_type` int(2) unsigned default NULL,
  `art_add_user` int(5) unsigned NOT NULL,
  `art_add_ip` char(15) NOT NULL,
  `art_click` int(5) unsigned NOT NULL,
  `art_locked` enum('yes','no') NOT NULL default 'no',
  `art_ismv` int(1) default '0',
  `art_dep` varchar(20) default NULL,
  `art_add_time` int(10) unsigned default '0',
  PRIMARY KEY  (`art_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO article VALUES ('11', '士大夫', '士大夫士大夫', '士大夫士大夫士大夫', '', '士大夫士大夫士大夫士大夫士大dfvdc发的vbfd夫士大夫士大夫士大夫', '13', '1', '127.0.0.1', '67', 'no', '0', '1', '0');
INSERT INTO article VALUES ('12', '各种样式', '各种样式各种样式', '各种样式各种样式各种样式', null, '&lt;ul&gt;&lt;li&gt;各种样式各种样式各种样式各&lt;/li&gt;\r\n&lt;li&gt;&lt;br /&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;\r\n&lt;div&gt;&lt;img src=\\&quot;\\\\&amp;quot;\\\\\\\\&amp;quot;\\\\\\\\\\\\\\\\&amp;quot;http://127.0.0.1:81/WORK/cqe/admin/editor/plugins/emoticons/22.gif\\\\\\\\\\\\\\\\&amp;quot;\\\\\\\\&amp;quot;\\\\&amp;quot;\\&quot; border=\\&quot;\\\\&amp;quot;\\\\\\\\&amp;quot;\\\\\\\\\\\\\\\\&amp;quot;0\\\\\\\\\\\\\\\\&amp;quot;\\\\\\\\&amp;quot;\\\\&amp;quot;\\&quot; alt=\\&quot;\\\\&amp;quot;\\\\\\\\&amp;quot;\\\\\\\\\\\\\\\\&amp;quot;\\\\\\\\\\\\\\\\&amp;quot;\\\\\\\\&amp;quot;\\\\&amp;quot;\\&quot; /&gt;&lt;br /&gt;\r\n&lt;/div&gt;\r\n&lt;div&gt;即合理&lt;span style=\\&quot;\\\\&amp;quot;\\\\\\\\&amp;quot;\\\\\\\\\\\\\\\\&amp;quot;color:#009900;\\\\\\\\\\\\\\\\&amp;quot;\\\\\\\\&amp;quot;\\\\&amp;quot;\\&quot;&gt;开发&lt;/span&gt;&lt;/div&gt;\r\n&lt;ul&gt;&lt;li&gt;&lt;br /&gt;\r\n&lt;/li&gt;\r\n&lt;li&gt;&lt;br /&gt;\r\n&lt;/li&gt;\r\n&lt;li&gt;种样式各种样式&lt;span style=\\&quot;\\\\&amp;quot;\\\\\\\\&amp;quot;\\\\\\\\\\\\\\\\&amp;quot;background-color:#e56600;\\\\\\\\\\\\\\\\&amp;quot;\\\\\\\\&amp;quot;\\\\&amp;quot;\\&quot;&gt;各种样式各&lt;/span&gt;种样&lt;b&gt;式各&lt;/b&gt;种样式各&lt;i&gt;种样式&lt;u&gt;各&lt;/u&gt;&lt;/i&gt;&lt;u&gt;种样式&lt;/u&gt;&lt;/li&gt;\r\n&lt;li&gt;各种样式各种样式&lt;/li&gt;\r\n&lt;/ul&gt;', '1', '1', '127.0.0.1', '11', 'no', '0', '1', '0');
INSERT INTO article VALUES ('13', 'dsf', 'dsfdsf', 'dsfdsfdsf', '', 'dsfdsfdsfdsfdsfdsfdsfdsfdsfdsfdsf', '11', '1', '127.0.0.1', '8', 'no', '0', '1', '0');
INSERT INTO article VALUES ('14', 'jpdd', 'jpddjpdd', 'jpddjpddjpdd', '', 'jpddjpddjpddjpddjpddjpddjpddjpddjpddjpddjpddjpddjpddjpddjpddjpddv', '9', '1', '127.0.0.1', '12', 'no', '0', '1', '0');
INSERT INTO article VALUES ('15', 'fy too longfy too longfy too longfy too longf', 'fyfyfy too longfy too longfy too lon', 'fyfyfyfy', '', 'fyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfy', '10', '1', '127.0.0.1', '24', 'no', '0', '1', '0');
INSERT INTO article VALUES ('16', '士大夫', '士大夫士大夫', '士大夫士大夫士大夫', '', '士大夫士大夫士大夫士大夫士大dfvdc发的vbfd夫士大夫士大夫士大夫', '13', '1', '127.0.0.1', '58', 'no', '0', '1', '0');
INSERT INTO article VALUES ('17', '士大夫', '士大夫士大夫', '士大夫士大夫士大夫', '', '士大夫士大夫士大夫士大夫士大dfvdc发的vbfd夫士大夫士大夫士大夫', '13', '1', '127.0.0.1', '61', 'no', '0', '1', '0');
INSERT INTO article VALUES ('18', '士大夫d', '士大夫士大夫', '士大夫士大夫士大夫', '', '士大夫士大夫士大夫士大夫士大dfvdc发的vbfd夫士大夫士大夫士大夫', '13', '1', '127.0.0.1', '60', 'no', '0', '1', '0');
INSERT INTO article VALUES ('33', '测试文章图片功能', '互联网', 'admin', null, '测试文章图片功能测试文章图片功能测试文章图片功能测试文章图片功能测试文章图片功能测试文章图片功能测试文章图片功能测试文章图片功能测试文章图片功能测试文章图片功能测试文章图片功能&lt;br&nbsp;/&gt;', '1', '1', '127.0.0.1', '0', 'no', '0', '1', '0');
INSERT INTO article VALUES ('20', 'fy too longfy too longfy too longfy too longf', 'fyfyfy too longfy too longfy too lon', 'fyfyfyfy', '', 'fyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfy', '10', '1', '127.0.0.1', '4', 'no', '0', '1', '0');
INSERT INTO article VALUES ('21', '执行日志测试201211121108', 'fyfyfy&nbsp;too&nbsp;longfy&nbsp;too&nbsp;longfy&nbsp;too&nbsp;lon', 'fyfyfyfy', '', '执行日志测试201211121108执行日志测试201211121108执行日志测试201211121108执行日志测试201211121108执行日志测试201211121108执行日志测试201211121108执行日志测试201211121108执行日志测试201211121108', '10', '1', '127.0.0.1', '3', 'no', '0', '1', '0');
INSERT INTO article VALUES ('22', 'fy too longfy too longfy too longfy too longf', 'fyfyfy too longfy too longfy too lon', 'fyfyfyfy士大夫', '', 'fyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfyfy', '10', '1', '127.0.0.1', '3', 'no', '0', '1', '0');
INSERT INTO article VALUES ('23', 'jpdd', 'jpddjpdd', 'jpddjpddjpdd', '', 'jpddjpddjpddjpddjpddjpddjpddjpddjpddjpddjpddjpddjpddjpddjpddjpddv', '9', '1', '127.0.0.1', '21', 'no', '0', '1', '0');
INSERT INTO article VALUES ('24', 'dsf', 'dsfdsf', 'dsfdsfdsf', '', 'dsfdsfdsfdsfdsfdsfdsfdsfdsfdsfdsf', '11', '1', '127.0.0.1', '0', 'no', '0', '1', '0');
INSERT INTO article VALUES ('25', 'dsf', 'dsfdsf', 'dsfdsfdsf', '', 'dsfdsfdsfdsfdsfdsfdsfdsfdsfdsfdsf', '11', '1', '127.0.0.1', '0', 'no', '0', '1', '0');
INSERT INTO article VALUES ('26', 'dsf', 'dsfdsf', 'dsfdsfdsf', '', 'dsfdsfdsfdsfdsfdsfdsfdsfdsfdsfdsf', '11', '1', '127.0.0.1', '4', 'no', '0', '1', '0');
INSERT INTO article VALUES ('27', 'dsf', 'dsfdsf', 'dsfdsfdsf', '', 'dsfdsfdsfdsfdsfdsfdsfdsfdsfdsfdsf士大夫', '11', '1', '127.0.0.1', '5', 'no', '0', '1', '0');
INSERT INTO article VALUES ('28', 'reader', 'readerreader', 'readerreaderreader', null, 'readerreaderreaderreaderreaderreaderreaderreaderreaderreaderreaderreaderreaderreader', '12', '1', '127.0.0.1', '13', 'no', '0', '1', '0');
INSERT INTO article VALUES ('30', '第一次测试', '互联网', 'kross', null, '内容哈哈&lt;br&nbsp;/&gt;', '1', '1', '127.0.0.1', '0', 'no', '0', '1', '0');
INSERT INTO article VALUES ('31', '第二次测试', '互联网', 'Kross', null, '哈哈哈&lt;b&gt;哈哈&lt;/b&gt;&lt;br&nbsp;/&gt;', '1', '1', '127.0.0.1', '0', 'no', '0', '1', '0');
INSERT INTO article VALUES ('32', '第三次测试', '互联网', 'Kross', null, '发的萨芬撒的&lt;b&gt;发生地方&lt;/b&gt;的发的发的&lt;br&nbsp;/&gt;', '10', '1', '127.0.0.1', '0', 'no', '0', '1', '0');
INSERT INTO article VALUES ('34', '添加新文章一枚', '互联网', 'kross', null, '乱打一气发的说法是的发的所发生的分苏打粉苏打粉创新创效发生的发生大幅打三分撒地方生的丰盛的都是&lt;br&nbsp;/&gt;', '1', '1', '127.0.0.1', '0', 'no', '0', '1', '0');
INSERT INTO article VALUES ('35', '我是新闻哈哈哈', '互联网', 'admin', null, '我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈我是新闻哈哈哈&lt;br&nbsp;/&gt;', '1', '1', '127.0.0.1', '0', 'no', '0', '1', '1352967003');

-- ----------------------------
-- Table structure for `dep`
-- ----------------------------
DROP TABLE IF EXISTS `dep`;
CREATE TABLE `dep` (
  `id` int(2) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of dep
-- ----------------------------
INSERT INTO dep VALUES ('1', 'Redrock');
INSERT INTO dep VALUES ('2', '法学院');

-- ----------------------------
-- Table structure for `execlog`
-- ----------------------------
DROP TABLE IF EXISTS `execlog`;
CREATE TABLE `execlog` (
  `id` int(12) unsigned NOT NULL auto_increment,
  `user_id` varchar(3) NOT NULL default '',
  `user_name` varchar(10) NOT NULL default '',
  `exec_url` varchar(100) NOT NULL default '',
  `exec_date` date NOT NULL default '0000-00-00',
  `exec_ip` varchar(15) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=826 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of execlog
-- ----------------------------
INSERT INTO execlog VALUES ('629', '1', '孟之杰', 'admin/index', '2012-12-25', '127.0.0.1');
INSERT INTO execlog VALUES ('630', '1', '孟之杰', 'admin/index', '2012-12-25', '127.0.0.1');
INSERT INTO execlog VALUES ('631', '1', '孟之杰', 'admin/menuAdd', '2012-12-25', '127.0.0.1');
INSERT INTO execlog VALUES ('632', '1', '孟之杰', 'admin/menuManage', '2012-12-25', '127.0.0.1');
INSERT INTO execlog VALUES ('633', '1', '孟之杰', 'admin/basic', '2012-12-25', '127.0.0.1');
INSERT INTO execlog VALUES ('634', '1', '孟之杰', 'admin/adminAdd', '2012-12-25', '127.0.0.1');
INSERT INTO execlog VALUES ('635', '1', '孟之杰', 'admin/depAdd', '2012-12-25', '127.0.0.1');
INSERT INTO execlog VALUES ('636', '1', '孟之杰', 'admin/changePwd', '2012-12-25', '127.0.0.1');
INSERT INTO execlog VALUES ('637', '1', '孟之杰', 'admin/adminIP', '2012-12-25', '127.0.0.1');
INSERT INTO execlog VALUES ('638', '1', '孟之杰', 'article/article_manage', '2012-12-25', '127.0.0.1');
INSERT INTO execlog VALUES ('639', '1', '孟之杰', 'article/article_add', '2012-12-25', '127.0.0.1');
INSERT INTO execlog VALUES ('640', '1', '孟之杰', 'message/msg_manage', '2012-12-25', '127.0.0.1');
INSERT INTO execlog VALUES ('641', '1', '孟之杰', 'message/msg_add', '2012-12-25', '127.0.0.1');
INSERT INTO execlog VALUES ('642', '1', '孟之杰', 'admin/index', '2012-12-26', '127.0.0.1');
INSERT INTO execlog VALUES ('643', '1', '孟之杰', 'admin/menuAdd', '2012-12-26', '127.0.0.1');
INSERT INTO execlog VALUES ('644', '1', '孟之杰', 'admin/menuManage', '2012-12-26', '127.0.0.1');
INSERT INTO execlog VALUES ('645', '1', '孟之杰', 'admin/basic', '2012-12-26', '127.0.0.1');
INSERT INTO execlog VALUES ('646', '1', '孟之杰', 'admin/adminAdd', '2012-12-26', '127.0.0.1');
INSERT INTO execlog VALUES ('647', '1', '孟之杰', 'admin/depAdd', '2012-12-26', '127.0.0.1');
INSERT INTO execlog VALUES ('648', '1', '孟之杰', 'admin/depManage', '2012-12-26', '127.0.0.1');
INSERT INTO execlog VALUES ('649', '1', '孟之杰', 'admin/changePwd', '2012-12-26', '127.0.0.1');
INSERT INTO execlog VALUES ('650', '1', '孟之杰', 'admin/adminIP', '2012-12-26', '127.0.0.1');
INSERT INTO execlog VALUES ('651', '1', '孟之杰', 'admin/index', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('652', '1', '孟之杰', 'admin/index', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('653', '1', '孟之杰', 'admin/index', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('654', '1', '孟之杰', 'admin/index', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('655', '1', '孟之杰', 'admin/index', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('656', '1', '孟之杰', 'admin/index', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('657', '1', '孟之杰', 'admin/index', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('658', '1', '孟之杰', 'admin/index', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('659', '1', '孟之杰', 'admin/quit', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('660', '1', '孟之杰', 'admin/index', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('661', '1', '孟之杰', 'admin/quit', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('662', '1', '孟之杰', 'admin/index', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('663', '1', '孟之杰', 'admin/index', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('664', '1', '孟之杰', 'admin/index', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('665', '1', '孟之杰', 'admin/index', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('666', '1', '孟之杰', 'admin/index', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('667', '1', '孟之杰', 'admin/index', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('668', '1', '孟之杰', 'admin/index', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('669', '1', '孟之杰', 'admin/quit', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('670', '1', '孟之杰', 'admin/index', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('671', '1', '孟之杰', 'admin/menuAdd', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('672', '1', '孟之杰', 'admin/menuManage', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('673', '1', '孟之杰', 'admin/basic', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('674', '1', '孟之杰', 'admin/adminAdd', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('675', '1', '孟之杰', 'admin/adminManage', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('676', '1', '孟之杰', 'admin/depAdd', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('677', '1', '孟之杰', 'admin/depManage', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('678', '1', '孟之杰', 'admin/changePwd', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('679', '1', '孟之杰', 'article/article_add', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('680', '1', '孟之杰', 'article/article_manage', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('681', '1', '孟之杰', 'admin/quit', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('682', '1', '孟之杰', 'admin/index', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('683', '1', '孟之杰', 'admin/depManage', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('684', '1', '孟之杰', 'admin/changePwd', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('685', '1', '孟之杰', 'admin/depManage', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('686', '1', '孟之杰', 'admin/index', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('687', '1', '孟之杰', 'admin/quit', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('688', '1', '孟之杰', 'admin/index', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('689', '1', '孟之杰', 'admin/menuAdd', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('690', '1', '孟之杰', 'admin/menuManage', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('691', '1', '孟之杰', 'admin/basic', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('692', '1', '孟之杰', 'admin/menuManage', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('693', '1', '孟之杰', 'admin/quit', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('694', '1', '孟之杰', 'admin/index', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('695', '1', '孟之杰', 'admin/menuAdd', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('696', '1', '孟之杰', 'admin/menuManage', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('697', '1', '孟之杰', 'admin/basic', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('698', '1', '孟之杰', 'admin/adminAdd', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('699', '1', '孟之杰', 'admin/adminManage', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('700', '1', '孟之杰', 'admin/depManage', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('701', '1', '孟之杰', 'admin/changePwd', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('702', '1', '孟之杰', 'admin/adminIP', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('703', '1', '孟之杰', 'article/article_manage', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('704', '1', '孟之杰', 'article/article_add', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('705', '1', '孟之杰', 'message/msg_manage', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('706', '1', '孟之杰', 'message/msg_add', '2013-01-25', '127.0.0.1');
INSERT INTO execlog VALUES ('707', '1', '孟之杰', 'admin/index', '2013-02-07', '127.0.0.1');
INSERT INTO execlog VALUES ('708', '1', '孟之杰', 'admin/index', '2013-02-07', '127.0.0.1');
INSERT INTO execlog VALUES ('709', '1', '孟之杰', 'admin/menuAdd', '2013-02-07', '127.0.0.1');
INSERT INTO execlog VALUES ('710', '1', '孟之杰', 'admin/menuManage', '2013-02-07', '127.0.0.1');
INSERT INTO execlog VALUES ('711', '1', '孟之杰', 'admin/basic', '2013-02-07', '127.0.0.1');
INSERT INTO execlog VALUES ('712', '1', '孟之杰', 'admin/adminAdd', '2013-02-07', '127.0.0.1');
INSERT INTO execlog VALUES ('713', '1', '孟之杰', 'admin/adminManage', '2013-02-07', '127.0.0.1');
INSERT INTO execlog VALUES ('714', '1', '孟之杰', 'admin/depAdd', '2013-02-07', '127.0.0.1');
INSERT INTO execlog VALUES ('715', '1', '孟之杰', 'admin/depManage', '2013-02-07', '127.0.0.1');
INSERT INTO execlog VALUES ('716', '1', '孟之杰', 'admin/changePwd', '2013-02-07', '127.0.0.1');
INSERT INTO execlog VALUES ('717', '1', '孟之杰', 'admin/adminIP', '2013-02-07', '127.0.0.1');
INSERT INTO execlog VALUES ('718', '1', '孟之杰', 'article/article_add', '2013-02-07', '127.0.0.1');
INSERT INTO execlog VALUES ('719', '1', '孟之杰', 'article/article_manage', '2013-02-07', '127.0.0.1');
INSERT INTO execlog VALUES ('720', '1', '孟之杰', 'article/article_add&do=14', '2013-02-07', '127.0.0.1');
INSERT INTO execlog VALUES ('721', '1', '孟之杰', 'admin/index', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('722', '1', '孟之杰', 'message/msg_manage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('723', '1', '孟之杰', 'admin/adminAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('724', '1', '孟之杰', 'admin/adminAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('725', '1', '孟之杰', 'admin/adminManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('726', '1', '孟之杰', 'admin/depAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('727', '1', '孟之杰', 'admin/depManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('728', '1', '孟之杰', 'admin/adminManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('729', '1', '孟之杰', 'admin/adminAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('730', '1', '孟之杰', 'admin/adminManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('731', '1', '孟之杰', 'admin/depAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('732', '1', '孟之杰', 'admin/adminManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('733', '1', '孟之杰', 'admin/index', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('734', '1', '孟之杰', 'admin/menuAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('735', '1', '孟之杰', 'admin/menuManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('736', '1', '孟之杰', 'admin/basic', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('737', '1', '孟之杰', 'admin/adminAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('738', '1', '孟之杰', 'admin/adminManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('739', '1', '孟之杰', 'admin/depManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('740', '1', '孟之杰', 'admin/index', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('741', '1', '孟之杰', 'admin/index', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('742', '1', '孟之杰', 'admin/menuAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('743', '1', '孟之杰', 'admin/menuAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('744', '1', '孟之杰', 'admin/index', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('745', '1', '孟之杰', 'admin/menuAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('746', '1', '孟之杰', 'admin/menuManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('747', '1', '孟之杰', 'admin/basic', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('748', '1', '孟之杰', 'admin/adminAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('749', '1', '孟之杰', 'admin/adminManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('750', '1', '孟之杰', 'admin/depManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('751', '1', '孟之杰', 'admin/changePwd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('752', '1', '孟之杰', 'admin/adminIP', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('753', '1', '孟之杰', 'admin/depManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('754', '1', '孟之杰', 'admin/adminManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('755', '1', '孟之杰', 'admin/basic', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('756', '1', '孟之杰', 'admin/menuAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('757', '1', '孟之杰', 'admin/adminManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('758', '1', '孟之杰', 'admin/adminAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('759', '1', '孟之杰', 'admin/basic', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('760', '1', '孟之杰', 'admin/menuManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('761', '1', '孟之杰', 'admin/menuAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('762', '1', '孟之杰', 'admin/menuAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('763', '1', '孟之杰', 'admin/menuAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('764', '1', '孟之杰', 'admin/menuManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('765', '1', '孟之杰', 'admin/menuEdit&job=delete&cid=361', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('766', '1', '孟之杰', 'admin/index', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('767', '1', '孟之杰', 'admin/index', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('768', '1', '孟之杰', 'admin/menuAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('769', '1', '孟之杰', 'admin/menuManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('770', '1', '孟之杰', 'admin/basic', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('771', '1', '孟之杰', 'admin/adminAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('772', '1', '孟之杰', 'admin/adminManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('773', '1', '孟之杰', 'admin/depAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('774', '1', '孟之杰', 'admin/depManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('775', '1', '孟之杰', 'admin/changePwd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('776', '1', '孟之杰', 'admin/adminIP', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('777', '1', '孟之杰', 'article/article_add', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('778', '1', '孟之杰', 'article/article_manage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('779', '1', '孟之杰', 'message/msg_manage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('780', '1', '孟之杰', 'message/msg_add', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('781', '1', '孟之杰', 'admin/index', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('782', '1', '孟之杰', 'admin/index', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('783', '1', '孟之杰', 'admin/index', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('784', '1', '孟之杰', 'admin/index', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('785', '1', '孟之杰', 'admin/index', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('786', '1', '孟之杰', 'admin/index', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('787', '1', '孟之杰', 'admin/index', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('788', '1', '孟之杰', 'admin/index', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('789', '1', '孟之杰', 'admin/index', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('790', '1', '孟之杰', 'admin/menuAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('791', '1', '孟之杰', 'admin/menuManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('792', '1', '孟之杰', 'admin/basic', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('793', '1', '孟之杰', 'admin/adminAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('794', '1', '孟之杰', 'admin/adminManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('795', '1', '孟之杰', 'admin/depAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('796', '1', '孟之杰', 'admin/depManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('797', '1', '孟之杰', 'admin/changePwd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('798', '1', '孟之杰', 'admin/adminIP', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('799', '1', '孟之杰', 'article/article_add', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('800', '1', '孟之杰', 'article/article_manage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('801', '1', '孟之杰', 'article/article_add', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('802', '1', '孟之杰', 'article/article_manage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('803', '1', '孟之杰', 'message/msg_manage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('804', '1', '孟之杰', 'admin/index', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('805', '1', '孟之杰', 'admin/index', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('806', '1', '孟之杰', 'admin/index', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('807', '1', '孟之杰', 'admin/index', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('808', '1', '孟之杰', 'admin/menuAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('809', '1', '孟之杰', 'admin/menuManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('810', '1', '孟之杰', 'admin/basic', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('811', '1', '孟之杰', 'admin/adminAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('812', '1', '孟之杰', 'admin/adminManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('813', '1', '孟之杰', 'admin/depAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('814', '1', '孟之杰', 'admin/depManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('815', '1', '孟之杰', 'admin/changePwd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('816', '1', '孟之杰', 'admin/adminIP', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('817', '1', '孟之杰', 'article/article_add', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('818', '1', '孟之杰', 'article/article_manage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('819', '1', '孟之杰', 'message/msg_manage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('820', '1', '孟之杰', 'message/msg_add', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('821', '1', '孟之杰', 'admin/index', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('822', '1', '孟之杰', 'admin/index', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('823', '1', '孟之杰', 'admin/menuAdd', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('824', '1', '孟之杰', 'admin/menuManage', '2013-02-21', '127.0.0.1');
INSERT INTO execlog VALUES ('825', '1', '孟之杰', 'admin/basic', '2013-02-21', '127.0.0.1');

-- ----------------------------
-- Table structure for `menu`
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(40) NOT NULL default '',
  `url` varchar(40) NOT NULL default '#',
  `father_id` int(10) NOT NULL default '0',
  `order` int(10) NOT NULL default '0',
  `rights_level` tinyint(2) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=362 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO menu VALUES ('1', '后台管理', '#', '0', '0', '2');
INSERT INTO menu VALUES ('2', '菜单添加', 'admin/menuAdd', '1', '1', '3');
INSERT INTO menu VALUES ('12', '菜单管理', 'admin/menuManage', '1', '2', '3');
INSERT INTO menu VALUES ('21', '用户管理', '', '0', '1', '3');
INSERT INTO menu VALUES ('22', '用户添加', 'admin/adminAdd', '21', '1', '3');
INSERT INTO menu VALUES ('23', '管理用户', 'admin/adminManage', '21', '2', '3');
INSERT INTO menu VALUES ('51', '修改密码', 'admin/changePwd', '21', '5', '1');
INSERT INTO menu VALUES ('63', '日志记录', 'admin/execLog', '1', '0', '3');
INSERT INTO menu VALUES ('124', '部门添加', 'admin/depAdd', '21', '3', '3');
INSERT INTO menu VALUES ('138', '基本设置', 'admin/basic', '1', '3', '3');
INSERT INTO menu VALUES ('210', '编辑部门', 'admin/depManage', '21', '4', '3');
INSERT INTO menu VALUES ('246', '编辑人员IP', 'admin/adminIP', '21', '6', '3');
INSERT INTO menu VALUES ('349', '文章管理', 'article/', '0', '3', '1');
INSERT INTO menu VALUES ('350', '文章添加', 'article/article_add', '349', '3', '1');
INSERT INTO menu VALUES ('351', '文章管理', 'article/article_manage', '349', '4', '1');
INSERT INTO menu VALUES ('357', '留言管理', '', '0', '4', '2');
INSERT INTO menu VALUES ('358', '留言管理', 'message/msg_manage', '357', '1', '2');
INSERT INTO menu VALUES ('359', '留言编辑', 'message/msg_add', '357', '2', '2');

-- ----------------------------
-- Table structure for `message`
-- ----------------------------
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `mid` int(6) unsigned NOT NULL auto_increment,
  `msg_title` varchar(100) default NULL,
  `msg_content` mediumtext,
  `father_id` int(6) unsigned NOT NULL default '0',
  `is_reply` enum('no','yes') NOT NULL default 'no',
  `is_locked` enum('no','yes') NOT NULL default 'yes',
  `msg_clicked` int(5) unsigned NOT NULL default '0',
  `msg_add_ip` varchar(16) NOT NULL,
  `msg_art_id` int(5) NOT NULL default '0',
  `msg_add_user` int(11) NOT NULL default '0',
  `msg_add_time` int(11) NOT NULL default '0',
  PRIMARY KEY  (`mid`)
) ENGINE=MyISAM AUTO_INCREMENT=741 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of message
-- ----------------------------
INSERT INTO message VALUES ('724', 'm1', null, '0', 'no', 'no', '0', '127.0.0.1', '15', '0', '0');
INSERT INTO message VALUES ('725', 'fdg', 'rgfdg', '0', 'no', 'no', '0', '127.0.0.1', '15', '0', '0');
INSERT INTO message VALUES ('726', 'dsfsdf', 'sd', '0', 'no', 'no', '0', '127.0.0.1', '15', '0', '0');
INSERT INTO message VALUES ('727', 'dg', 'fgdfg', '0', 'no', 'no', '0', '127.0.0.1', '15', '0', '0');
INSERT INTO message VALUES ('728', 'dsf', 'dfadsfsdf', '0', 'no', 'yes', '0', '127.0.0.1', '15', '0', '0');
INSERT INTO message VALUES ('729', 'dfds', 'sfasd', '0', 'no', 'yes', '0', '127.0.0.1', '15', '0', '0');
INSERT INTO message VALUES ('730', 'gg', 'gggggggggggggggggggggggggggggggg', '0', 'no', 'no', '0', '127.0.0.1', '15', '0', '0');
INSERT INTO message VALUES ('731', 'tttttttt', 'dftttttttttttttttt', '0', 'no', 'yes', '0', '127.0.0.1', '14', '1', '0');
INSERT INTO message VALUES ('732', 't2', 'c2c2c2c2c2c2c2c2c2c2c2c2c2c2c2c2c2c2c2c2c2c2c2c2c2c2c2c2c2c2c2c2', '0', 'no', 'yes', '0', '127.0.0.1', '14', '1', '0');
INSERT INTO message VALUES ('733', 't23333333333333333333', 'c3333333333333333', '0', 'no', 'no', '0', '127.0.0.1', '14', '1', '0');
INSERT INTO message VALUES ('734', 'fw', 'fwfwwfwfw', '0', 'no', 'no', '0', '127.0.0.1', '14', '2', '0');
INSERT INTO message VALUES ('735', 'sdf', 'sdfsdf', '0', 'no', 'no', '0', '127.0.0.1', '12', '2', '0');
INSERT INTO message VALUES ('736', 'adsfsd是', 'fsdf的仿盛大倒萨', '0', 'no', 'no', '0', '127.0.0.1', '27', '2', '0');
INSERT INTO message VALUES ('737', '的说法的说法', '都是地方', '0', 'no', 'no', '0', '127.0.0.1', '27', '2', '0');
INSERT INTO message VALUES ('738', '', 'dsafsf', '0', 'no', 'no', '0', '172.30.247.241', '29', '1001517', '0');
INSERT INTO message VALUES ('739', '', 'fffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffv', '0', 'no', 'no', '0', '172.30.247.241', '29', '1001517', '0');
INSERT INTO message VALUES ('740', '发的萨芬', '的负担', '0', 'no', 'yes', '0', '127.0.0.1', '0', '0', '1352710912');

-- ----------------------------
-- Table structure for `pic`
-- ----------------------------
DROP TABLE IF EXISTS `pic`;
CREATE TABLE `pic` (
  `pic_id` int(5) unsigned NOT NULL auto_increment,
  `pic_title` varchar(50) NOT NULL,
  `pic_source` varchar(32) NOT NULL,
  `pic_type` int(5) unsigned NOT NULL,
  `pic_url` char(255) NOT NULL,
  `pic_thumbnail_url` varchar(255) default NULL,
  `pic_show` mediumtext NOT NULL,
  `pic_add_user` int(5) NOT NULL,
  `pic_add_ip` char(15) NOT NULL,
  `pic_article_id` int(5) unsigned NOT NULL default '0',
  `pic_click` int(5) unsigned NOT NULL,
  `pic_locked` enum('yes','no') NOT NULL default 'yes',
  `pic_add_time` int(11) default '0',
  PRIMARY KEY  (`pic_id`,`pic_type`,`pic_add_user`,`pic_article_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pic
-- ----------------------------
INSERT INTO pic VALUES ('5', 'p329120192.jpg', 'article', '13', 'upload/pictures/1322273955_0.jpg', 'upload/thumb/thumb_1322273955_0.jpg', '文章中的图片', '1', '127.0.0.1', '11', '0', 'no', '0');
INSERT INTO pic VALUES ('6', 'photo.jpg', 'article', '1', 'upload/pictures/1322292107_0.jpg', 'upload/thumb/thumb_1322292107_0.jpg', '文章中的图片', '1', '127.0.0.1', '12', '0', 'no', '0');
INSERT INTO pic VALUES ('7', '298.jpg', 'article', '1', 'upload/pictures/1322292119_1.jpg', 'upload/thumb/thumb_1322292119_1.jpg', '文章中的图片', '1', '127.0.0.1', '12', '0', 'no', '0');
INSERT INTO pic VALUES ('8', '下载4.jpg', 'article', '1', 'upload/pictures/1322292139_0.jpg', 'upload/thumb/thumb_1322292139_0.jpg', '文章中的图片', '1', '127.0.0.1', '12', '0', 'no', '0');
INSERT INTO pic VALUES ('9', 'Clouds_Racing_by_BadiB.jpg', 'article', '11', 'upload/pictures/1322292206_0.jpg', 'upload/thumb/thumb_1322292206_0.jpg', '文章中的图片', '1', '127.0.0.1', '13', '0', 'no', '0');
INSERT INTO pic VALUES ('10', 'seagull_and_clouds_by_vabserk-d35kvz0.jpg', 'article', '9', 'upload/pictures/1322292252_0.jpg', 'upload/thumb/thumb_1322292252_0.jpg', '文章中的图片', '1', '127.0.0.1', '14', '0', 'no', '0');
INSERT INTO pic VALUES ('11', '下载 (16).jpg', 'article', '9', 'upload/pictures/1322292252_1.jpg', 'upload/thumb/thumb_1322292252_1.jpg', '文章中的图片', '1', '127.0.0.1', '14', '0', 'no', '0');
INSERT INTO pic VALUES ('12', 'Clouds_by_Blackmoon90.jpg', 'article', '9', 'upload/pictures/1322292253_2.jpg', 'upload/thumb/thumb_1322292253_2.jpg', '文章中的图片', '1', '127.0.0.1', '14', '0', 'no', '0');
INSERT INTO pic VALUES ('13', 'seagull_and_clouds_by_vabserk-d35kvz0.jpg', 'article', '9', 'upload/pictures/1322292254_3.jpg', 'upload/thumb/thumb_1322292254_3.jpg', '文章中的图片', '1', '127.0.0.1', '14', '0', 'no', '0');
INSERT INTO pic VALUES ('14', 'Clouds_over_the_golden_fields_by_WiciaQ.jpg', 'article', '10', 'upload/pictures/1322292506_1.jpg', 'upload/thumb/thumb_1322292506_1.jpg', '文章中的图片', '1', '127.0.0.1', '15', '0', 'no', '0');
INSERT INTO pic VALUES ('15', '4647351315447610.jpg', 'article', '10', 'upload/pictures/1322292506_2.jpg', 'upload/thumb/thumb_1322292506_2.jpg', '文章中的图片', '1', '127.0.0.1', '15', '0', 'no', '0');
INSERT INTO pic VALUES ('16', '下载 (2).jpg', 'article', '10', 'upload/pictures/1322292506_3.jpg', 'upload/thumb/thumb_1322292506_3.jpg', '文章中的图片', '1', '127.0.0.1', '15', '0', 'no', '0');
INSERT INTO pic VALUES ('17', '下载 (7).jpg', 'article', '10', 'upload/pictures/1322292506_4.jpg', 'upload/thumb/thumb_1322292506_4.jpg', '文章中的图片', '1', '127.0.0.1', '15', '0', 'no', '0');
INSERT INTO pic VALUES ('18', '下载4.jpg', 'article', '10', 'upload/pictures/1322292506_5.jpg', 'upload/thumb/thumb_1322292506_5.jpg', '文章中的图片', '1', '127.0.0.1', '15', '0', 'no', '0');
INSERT INTO pic VALUES ('19', 'photo.jpg', 'article', '10', 'upload/pictures/1322292506_6.jpg', 'upload/thumb/thumb_1322292506_6.jpg', '文章中的图片', '1', '127.0.0.1', '15', '0', 'no', '0');
INSERT INTO pic VALUES ('20', '298.jpg', 'article', '10', 'upload/pictures/1322292507_7.jpg', 'upload/thumb/thumb_1322292507_7.jpg', '文章中的图片', '1', '127.0.0.1', '15', '0', 'no', '0');
INSERT INTO pic VALUES ('21', 'to_the_clouds_by_linkineos-d2xtw9e.jpg', 'article', '12', 'upload/pictures/1322415808_0.jpg', 'upload/thumb/thumb_1322415808_0.jpg', '文章中的图片', '1', '127.0.0.1', '28', '0', 'no', '0');
INSERT INTO pic VALUES ('22', 'QQ截图20121102104045.jpg', 'article', '1', 'upload/pictures/1352691528_0.jpg', 'upload/thumb/thumb_1352691528_0.jpg', '文章中的图片', '1', '127.0.0.1', '33', '0', 'no', '0');

-- ----------------------------
-- Table structure for `type`
-- ----------------------------
DROP TABLE IF EXISTS `type`;
CREATE TABLE `type` (
  `typeid` int(5) unsigned NOT NULL auto_increment COMMENT '??ID',
  `fatherid` int(5) unsigned NOT NULL COMMENT '???ID',
  `typedetail` varchar(20) NOT NULL COMMENT '????',
  `type_order` int(3) unsigned NOT NULL default '0',
  `type_hidden` enum('yes','no') NOT NULL default 'no',
  PRIMARY KEY  (`typeid`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of type
-- ----------------------------
INSERT INTO type VALUES ('1', '0', '原貌手机报', '0', 'no');
INSERT INTO type VALUES ('9', '0', '精品导读', '0', 'no');
INSERT INTO type VALUES ('10', '0', '重庆方言', '0', 'no');
INSERT INTO type VALUES ('11', '0', '品读箴言', '0', 'no');
INSERT INTO type VALUES ('12', '0', '读者原地', '0', 'no');
INSERT INTO type VALUES ('13', '0', '服务平台', '0', 'no');
