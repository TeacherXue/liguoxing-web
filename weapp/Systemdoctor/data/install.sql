/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50726
Source Host           : 127.0.0.1:3306
Source Database       : e166

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2023-06-02 11:04:07
*/

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `#@__weapp_systemdoctor`;
CREATE TABLE `#@__weapp_systemdoctor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT '' COMMENT '唯一标识',
  `data` text COMMENT '额外序列化存储数据，简单插件可以不创建表，存储这里即可',
  `add_time` int(11) DEFAULT '0' COMMENT '新增时间',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `code` (`code`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `#@__weapp_systemdoctor` VALUES ('1', 'bom', '{\"is_autoclear\":\"0\",\"is_backup\":\"1\"}', '1679480573', '1679480580');

DROP TABLE IF EXISTS `#@__weapp_systemdoctor_bom_log`;
CREATE TABLE `#@__weapp_systemdoctor_bom_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `md5key` varchar(50) DEFAULT '' COMMENT 'md5值',
  `file_name` varchar(500) DEFAULT '' COMMENT '文件名',
  `file_num` int(10) DEFAULT '0' COMMENT '已扫描数',
  `file_total` int(10) DEFAULT '0' COMMENT '总文件数',
  `file_num_ky` int(10) DEFAULT '0' COMMENT '带bom头部信息的文件数',
  `is_suspicious` tinyint(1) DEFAULT '0' COMMENT '是否带bom头部信息',
  `html` text,
  `add_time` int(11) DEFAULT '0' COMMENT '新增时间',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;