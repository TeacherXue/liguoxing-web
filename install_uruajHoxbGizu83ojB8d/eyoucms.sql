-- ----------------------------------------
-- EyouCms MySQL Data Transfer 
-- 
-- Server         : db_3306
-- Server Version : 8.0.46
-- Host           : db:3306
-- Database       : eyoucms123
-- 
-- Part : #1
-- Version : #v1.7.6
-- Date : 2026-05-13 13:58:10
-- -----------------------------------------

SET FOREIGN_KEY_CHECKS = 0;


-- -----------------------------
-- Table structure for `ey_ad`
-- -----------------------------
DROP TABLE IF EXISTS `ey_ad`;
CREATE TABLE `ey_ad` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '广告id',
  `pid` int unsigned NOT NULL DEFAULT '0' COMMENT '广告位置ID',
  `media_type` tinyint(1) DEFAULT '0' COMMENT '广告类型',
  `title` varchar(60) DEFAULT '' COMMENT '广告名称',
  `links` varchar(255) DEFAULT '' COMMENT '广告链接',
  `litpic` varchar(255) DEFAULT '' COMMENT '图片地址',
  `start_time` int DEFAULT '0' COMMENT '投放时间',
  `end_time` int DEFAULT '0' COMMENT '结束时间',
  `intro` text COMMENT '描述',
  `link_man` varchar(60) DEFAULT '' COMMENT '添加人',
  `link_email` varchar(60) DEFAULT '' COMMENT '添加人邮箱',
  `link_phone` varchar(60) DEFAULT '' COMMENT '添加人联系电话',
  `click` int DEFAULT '0' COMMENT '点击量',
  `bgcolor` varchar(30) DEFAULT '' COMMENT '背景颜色',
  `status` tinyint unsigned DEFAULT '1' COMMENT '1=显示，0=屏蔽',
  `sort_order` int DEFAULT '0' COMMENT '排序',
  `target` varchar(50) DEFAULT '' COMMENT '是否开启浏览器新窗口',
  `admin_id` int DEFAULT '0' COMMENT '管理员ID',
  `is_del` tinyint(1) DEFAULT '0' COMMENT '伪删除，1=是，0=否',
  `lang` varchar(50) DEFAULT 'cn' COMMENT '多语言',
  `add_time` int DEFAULT '0' COMMENT '新增时间',
  `update_time` int DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `position_id` (`pid`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COMMENT='广告表';


-- -----------------------------
-- Table structure for `ey_ad_position`
-- -----------------------------
DROP TABLE IF EXISTS `ey_ad_position`;
CREATE TABLE `ey_ad_position` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL DEFAULT '' COMMENT '广告位置名称',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '广告展示类型，1图片类型，2媒体类型，3HTML代码',
  `width` smallint unsigned NOT NULL DEFAULT '0' COMMENT '广告位宽度',
  `height` smallint unsigned NOT NULL DEFAULT '0' COMMENT '广告位高度',
  `intro` text NOT NULL COMMENT '广告描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0关闭1开启',
  `lang` varchar(50) NOT NULL DEFAULT 'cn' COMMENT '多语言',
  `admin_id` int NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `is_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT '伪删除，1=是，0=否',
  `add_time` int NOT NULL DEFAULT '0' COMMENT '新增时间',
  `update_time` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COMMENT='广告位置表';


-- -----------------------------
-- Table structure for `ey_admin`
-- -----------------------------
DROP TABLE IF EXISTS `ey_admin`;
CREATE TABLE `ey_admin` (
  `admin_id` smallint unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `user_name` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `pen_name` varchar(50) DEFAULT '' COMMENT '笔名（发布文章后显示责任编辑的名字）',
  `true_name` varchar(20) DEFAULT '' COMMENT '真实姓名',
  `mobile` varchar(11) DEFAULT '' COMMENT '手机号码',
  `email` varchar(60) DEFAULT '' COMMENT 'email',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  `head_pic` varchar(255) DEFAULT '' COMMENT '头像',
  `last_login` int DEFAULT '0' COMMENT '最后登录时间',
  `last_ip` varchar(15) DEFAULT '' COMMENT '最后登录ip',
  `login_cnt` int DEFAULT '0' COMMENT '登录次数',
  `session_id` varchar(50) DEFAULT '' COMMENT 'session_id',
  `parent_id` int DEFAULT '0' COMMENT '父管理员ID',
  `role_id` int NOT NULL DEFAULT '-1' COMMENT '角色组ID（-1表示超级管理员）',
  `mark_lang` varchar(50) DEFAULT 'cn' COMMENT '当前语言标识',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态(0=屏蔽，1=正常)',
  `syn_users_id` int DEFAULT '0' COMMENT '同步注册到会员表',
  `desc` varchar(500) DEFAULT '' COMMENT '工作内容',
  `wechat_appid` varchar(50) DEFAULT '' COMMENT '公众号appid',
  `wechat_followed` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '记录是否关注了微信公众号，默认0；0=未关注、1=已关注',
  `wechat_open_id` varchar(50) NOT NULL DEFAULT '' COMMENT 'open_id，关注微信公众号后存入',
  `union_id` varchar(50) DEFAULT '' COMMENT '微信用户的unionId',
  `add_time` int DEFAULT '0' COMMENT '添加时间',
  `update_time` int DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`admin_id`),
  KEY `user_name` (`user_name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COMMENT='管理员表';

-- -----------------------------
-- Records of `ey_admin`
-- -----------------------------
INSERT INTO `ey_admin` VALUES ('1', 'admin', '', 'admin111', '', '', '$2y$11$50aa8aec28361653800a9u4qBLBzcqJGW96E8LdjO7ppNvgvV0Gdu', '', '1778583674', '192.168.65.1', '14', 'd2cb4e1d3411473d8129e2cd89347af9', '0', '-1', 'cn', '1', '1', '', '', '0', '', '', '1778568648', '1778572519');

-- -----------------------------
-- Table structure for `ey_admin_log`
-- -----------------------------
DROP TABLE IF EXISTS `ey_admin_log`;
CREATE TABLE `ey_admin_log` (
  `log_id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '表id',
  `admin_id` int NOT NULL DEFAULT '-1' COMMENT '管理员id',
  `log_info` text COMMENT '日志描述',
  `log_ip` varchar(30) DEFAULT '' COMMENT 'ip地址',
  `log_url` varchar(255) DEFAULT '' COMMENT 'url',
  `log_time` int DEFAULT '0' COMMENT '日志时间',
  PRIMARY KEY (`log_id`),
  KEY `admin_id` (`admin_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3 COMMENT='管理员操作日志表';

-- -----------------------------
-- Records of `ey_admin_log`
-- -----------------------------
INSERT INTO `ey_admin_log` VALUES ('1', '1', '后台登录', '0.0.0.0', '/login.php', '1778568659');
INSERT INTO `ey_admin_log` VALUES ('2', '1', '安装插件：pojie', '127.0.0.1', '/login.php', '1778568696');
INSERT INTO `ey_admin_log` VALUES ('3', '1', '编辑pojie：插件配置', '0.0.0.0', '/login.php', '1778568703');
INSERT INTO `ey_admin_log` VALUES ('4', '1', '后台登录', '192.168.65.1', '/login.php', '1778572567');
INSERT INTO `ey_admin_log` VALUES ('5', '1', '后台登录', '192.168.65.1', '/login.php', '1778572657');
INSERT INTO `ey_admin_log` VALUES ('6', '1', '新增文章：Test', '192.168.65.1', '/login.php', '1778575998');
INSERT INTO `ey_admin_log` VALUES ('7', '1', '后台登录', '192.168.65.1', '/login.php', '1778578042');
INSERT INTO `ey_admin_log` VALUES ('8', '1', '后台登录', '192.168.65.1', '/login.php', '1778578075');
INSERT INTO `ey_admin_log` VALUES ('9', '1', '后台登录', '192.168.65.1', '/login.php', '1778578110');
INSERT INTO `ey_admin_log` VALUES ('10', '1', '后台登录', '192.168.65.1', '/login.php', '1778578205');
INSERT INTO `ey_admin_log` VALUES ('11', '1', '后台登录', '192.168.65.1', '/login.php', '1778578252');
INSERT INTO `ey_admin_log` VALUES ('12', '1', '编辑文章：Test', '192.168.65.1', '/login.php', '1778578796');
INSERT INTO `ey_admin_log` VALUES ('13', '1', '编辑文章：Test', '192.168.65.1', '/login.php', '1778578842');
INSERT INTO `ey_admin_log` VALUES ('14', '1', '编辑文章：Test', '192.168.65.1', '/login.php', '1778580094');
INSERT INTO `ey_admin_log` VALUES ('15', '1', '编辑文章：Test', '192.168.65.1', '/login.php', '1778580187');
INSERT INTO `ey_admin_log` VALUES ('16', '1', '删除文档-id：1,2,3,4,5,6,7', '192.168.65.1', '/login.php', '1778581032');
INSERT INTO `ey_admin_log` VALUES ('17', '1', '后台登录', '192.168.65.1', '/login.php', '1778583521');
INSERT INTO `ey_admin_log` VALUES ('18', '1', '后台登录', '192.168.65.1', '/login.php', '1778583521');
INSERT INTO `ey_admin_log` VALUES ('19', '1', '后台登录', '192.168.65.1', '/login.php', '1778583549');
INSERT INTO `ey_admin_log` VALUES ('20', '1', '后台登录', '192.168.65.1', '/login.php', '1778583573');
INSERT INTO `ey_admin_log` VALUES ('21', '1', '后台登录', '192.168.65.1', '/login.php', '1778583674');
INSERT INTO `ey_admin_log` VALUES ('22', '1', '备份数据库', '192.168.65.1', '/login.php', '1778640046');

-- -----------------------------
-- Table structure for `ey_admin_menu`
-- -----------------------------
DROP TABLE IF EXISTS `ey_admin_menu`;
CREATE TABLE `ey_admin_menu` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int DEFAULT '0',
  `title` varchar(100) DEFAULT '' COMMENT '导航名称',
  `original_title` varchar(100) DEFAULT '' COMMENT '自定义标题',
  `controller_name` varchar(50) DEFAULT '' COMMENT '控制器',
  `action_name` varchar(50) DEFAULT '' COMMENT '方法名',
  `param` varchar(255) DEFAULT '' COMMENT '参数',
  `icon` varchar(50) DEFAULT 'iconfont e-lanmuguanli' COMMENT '图标',
  `is_menu` tinyint(1) DEFAULT '0' COMMENT '是否显示为左侧菜单',
  `is_switch` tinyint(1) DEFAULT '0' COMMENT '是否显示在switch_map页面中',
  `target` varchar(50) DEFAULT 'workspace' COMMENT '链接打开方式',
  `sort_order` int DEFAULT '100' COMMENT '排序号',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态，1=显示，0=隐藏',
  `lang` varchar(20) DEFAULT 'cn' COMMENT '语言标识',
  `add_time` int DEFAULT '0' COMMENT '新增时间',
  `update_time` int DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `menu_id` (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3 COMMENT='外挂功能地图菜单表';

-- -----------------------------
-- Records of `ey_admin_menu`
-- -----------------------------
INSERT INTO `ey_admin_menu` VALUES ('1', '1005', '欢迎页', '欢迎页', 'Index', 'welcome', '', 'fa fa-user', '0', '1', 'workspace', '100', '1', 'cn', '1648864596', '1648864596');
INSERT INTO `ey_admin_menu` VALUES ('2', '1001', '栏目管理', '栏目管理', 'Arctype', 'index', '|mt20|1', 'iconfont e-lanmuguanli', '1', '1', 'workspace', '100', '1', 'cn', '1648864596', '1648864596');
INSERT INTO `ey_admin_menu` VALUES ('3', '1002', '内容管理', '内容管理', 'Archives', 'index', '', 'iconfont e-neirongwendang', '1', '1', 'workspace', '100', '1', 'cn', '1648864596', '1648864596');
INSERT INTO `ey_admin_menu` VALUES ('4', '1004', '待审文档', '待审文档', 'Archives', 'index_draft', '|menu|1', 'iconfont e-tougao', '0', '1', 'workspace', '100', '1', 'cn', '1648864596', '1648864596');
INSERT INTO `ey_admin_menu` VALUES ('5', '1003', '广告管理', '广告管理', 'AdPosition', 'index', '', 'iconfont e-guanggao', '1', '1', 'workspace', '100', '1', 'cn', '1648864596', '1648864596');
INSERT INTO `ey_admin_menu` VALUES ('6', '2001', '基本信息', '基本信息', 'System', 'web', '', 'iconfont e-shezhi', '1', '1', 'workspace', '100', '1', 'cn', '1648864596', '1648864596');
INSERT INTO `ey_admin_menu` VALUES ('7', '2002', '可视编辑', '可视编辑', 'Uiset', 'ui_index', '', 'iconfont e-keshihuabianji', '0', '1', 'workspace', '100', '1', 'cn', '1648864596', '1648864596');
INSERT INTO `ey_admin_menu` VALUES ('8', '2003', 'SEO模块', 'SEO模块', 'Seo', 'seo', '', 'iconfont e-seo', '1', '1', 'workspace', '100', '1', 'cn', '1648864596', '1648864596');
INSERT INTO `ey_admin_menu` VALUES ('9', '2004', '功能地图', '功能地图', 'Index', 'switch_map', '', 'iconfont e-caidangongneng', '1', '0', 'workspace', '10000', '1', 'cn', '1648864596', '1648864596');
INSERT INTO `ey_admin_menu` VALUES ('10', '2005', '插件应用', '插件应用', 'Weapp', 'index', '', 'iconfont e-chajian', '1', '1', 'workspace', '100', '1', 'cn', '1648864596', '1778568665');
INSERT INTO `ey_admin_menu` VALUES ('11', '2006', '会员中心', '会员中心', 'Member', 'users_index', '', 'iconfont e-gerenzhongxin', '0', '1', 'workspace', '100', '1', 'cn', '1648864596', '1648864596');
INSERT INTO `ey_admin_menu` VALUES ('12', '2008', '商城中心', '商城中心', 'Shop', 'home', '', 'iconfont e-shangcheng', '1', '1', 'workspace', '100', '1', 'cn', '1648864596', '1658917491');
INSERT INTO `ey_admin_menu` VALUES ('13', '2009', '可视化小程序', '可视化小程序', 'Diyminipro', 'page_edit', '', 'fa fa-code', '0', '1', 'workspace', '100', '1', 'cn', '1648864596', '1648864596');
INSERT INTO `ey_admin_menu` VALUES ('14', '2004018', '留言中心', '留言中心', 'Form', 'index', '', 'iconfont e-biaodanguanli', '0', '1', 'workspace', '100', '1', 'cn', '1677037793', '1677146423');

-- -----------------------------
-- Table structure for `ey_admin_theme`
-- -----------------------------
DROP TABLE IF EXISTS `ey_admin_theme`;
CREATE TABLE `ey_admin_theme` (
  `theme_id` int unsigned NOT NULL AUTO_INCREMENT,
  `theme_type` tinyint(1) DEFAULT '0' COMMENT '主题类型：1=登录页，2=欢迎页',
  `theme_title` varchar(50) DEFAULT '' COMMENT '主题标题',
  `theme_pic` varchar(255) DEFAULT '' COMMENT '主题效果图',
  `theme_color_model` varchar(10) DEFAULT '' COMMENT '主题颜色模式',
  `theme_main_color` varchar(20) DEFAULT '' COMMENT '主题主色',
  `theme_assist_color` varchar(20) DEFAULT '' COMMENT '主题辅色',
  `login_logo` varchar(255) DEFAULT '' COMMENT '登录图标',
  `login_bgimg_model` varchar(10) DEFAULT '' COMMENT '登录背景图模式',
  `login_bgimg` varchar(255) DEFAULT '' COMMENT '登录背景图',
  `login_tplname` varchar(100) DEFAULT '' COMMENT '登录页自定义模板',
  `admin_logo` varchar(255) DEFAULT '' COMMENT '后台Logo',
  `welcome_tplname` varchar(100) DEFAULT '' COMMENT '欢迎页自定义模板',
  `is_system` tinyint(1) DEFAULT '0' COMMENT '内置主题',
  `sort_order` int DEFAULT '100' COMMENT '排序号',
  `add_time` int DEFAULT '0' COMMENT '新增时间',
  `update_time` int DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`theme_id`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb3 COMMENT='后台主题风格表';

-- -----------------------------
-- Records of `ey_admin_theme`
-- -----------------------------
INSERT INTO `ey_admin_theme` VALUES ('1', '1', '经典蓝主题', '/public/static/admin/images/theme/theme_pic_1.png', '1', '#3398cc', '#2189be', '/public/static/admin/login/login-logo_ey.png', '1', '/public/static/admin/loginbg/login-bg-1.png', '', '/public/static/admin/logo/logo_ey.png', '', '1', '100', '1681200988', '1681200988');
INSERT INTO `ey_admin_theme` VALUES ('2', '1', '易优橙主题', '/public/static/admin/images/theme/theme_pic_2.png', 'custom', '#197971', '#fa921b', '/public/static/admin/login/login-logo.png', '2', '/public/static/admin/loginbg/login-bg-1.png', '', '/public/static/admin/logo/logo.png', '', '1', '100', '1681866512', '1681866512');
INSERT INTO `ey_admin_theme` VALUES ('4', '2', '商城欢迎页', '/public/static/admin/images/theme/theme_pic_4.png', '', '', '', '', '', '', '', '', 'welcome_shop.htm', '1', '100', '1681200988', '1681200988');
INSERT INTO `ey_admin_theme` VALUES ('5', '2', '任务流欢迎页', '/public/static/admin/images/theme/theme_pic_5.png', '', '', '', '', '', '', '', '', 'welcome_taskflow.htm', '1', '100', '1681200988', '1681200988');
INSERT INTO `ey_admin_theme` VALUES ('3', '2', '默认欢迎页', '/public/static/admin/images/theme/theme_pic_default.png', '', '', '', '', '', '', '', '', '', '1', '100', '1681200988', '1681200988');
INSERT INTO `ey_admin_theme` VALUES ('100', '1', '默认主题', '/public/static/admin/images/theme/theme_pic_default.png', '1', '#3398cc', '#2189be', '/public/static/admin/images/login-logo_zy.png', '1', '/public/static/admin/images/login-bg.jpg', '', '/public/static/admin/images/logo.png', '', '0', '100', '1691546792', '1691546792');
INSERT INTO `ey_admin_theme` VALUES ('80', '2', 'AI欢迎页', '/public/static/admin/images/theme/theme_pic_4.png', '', '', '', '', '', '', '', '', 'welcome_ai.htm', '1', '100', '1681200988', '1681200988');

-- -----------------------------
-- Table structure for `ey_admin_wxlogin`
-- -----------------------------
DROP TABLE IF EXISTS `ey_admin_wxlogin`;
CREATE TABLE `ey_admin_wxlogin` (
  `wx_id` int NOT NULL AUTO_INCREMENT,
  `type` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=官方公众号，2=微信应用',
  `admin_id` int NOT NULL DEFAULT '0' COMMENT '用户id',
  `openid` varchar(50) NOT NULL DEFAULT '' COMMENT 'openid',
  `nickname` varchar(100) NOT NULL DEFAULT '' COMMENT '微信昵称',
  `unionid` varchar(200) NOT NULL DEFAULT '' COMMENT 'unionid',
  `headimgurl` varchar(200) NOT NULL DEFAULT '' COMMENT '头像',
  `add_time` int NOT NULL DEFAULT '0' COMMENT '新增时间',
  `update_time` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`wx_id`) USING BTREE,
  KEY `openid` (`openid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COMMENT='后台微信登录记录表';


-- -----------------------------
-- Table structure for `ey_archives`
-- -----------------------------
DROP TABLE IF EXISTS `ey_archives`;
CREATE TABLE `ey_archives` (
  `aid` int NOT NULL AUTO_INCREMENT,
  `typeid` int NOT NULL DEFAULT '0' COMMENT '当前栏目',
  `stypeid` varchar(90) DEFAULT '' COMMENT '副栏目ID集合',
  `channel` int NOT NULL DEFAULT '0' COMMENT '模型ID',
  `is_b` tinyint(1) DEFAULT '0' COMMENT '加粗',
  `title` varchar(500) DEFAULT '' COMMENT '文档标题',
  `subtitle` varchar(500) DEFAULT '' COMMENT '副标题',
  `introduction` varchar(500) DEFAULT '' COMMENT '促销语',
  `litpic` varchar(250) DEFAULT '' COMMENT '封面图片',
  `is_head` tinyint(1) DEFAULT '0' COMMENT '头条（0=否，1=是）',
  `is_special` tinyint(1) DEFAULT '0' COMMENT '特荐（0=否，1=是）',
  `is_top` tinyint(1) DEFAULT '0' COMMENT '置顶（0=否，1=是）',
  `is_recom` tinyint(1) DEFAULT '0' COMMENT '推荐（0=否，1=是）',
  `is_jump` tinyint(1) DEFAULT '0' COMMENT '跳转链接（0=否，1=是）',
  `is_litpic` tinyint(1) DEFAULT '0' COMMENT '图片（0=否，1=是）',
  `is_roll` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '滚动（0=否，1=是）',
  `is_slide` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '幻灯（0=否，1=是）',
  `is_diyattr` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '自定义（0=否，1=是）',
  `origin` varchar(200) DEFAULT '' COMMENT '来源',
  `author` varchar(200) DEFAULT '' COMMENT '作者',
  `click` int DEFAULT '0' COMMENT '点击数',
  `arcrank` int DEFAULT '0' COMMENT '阅读权限：0=开放浏览，-1=待审核稿件',
  `jumplinks` varchar(255) DEFAULT '' COMMENT '跳转网址',
  `ismake` tinyint(1) DEFAULT '0' COMMENT '是否静态页面（0=动态，1=静态）',
  `seo_title` varchar(500) DEFAULT '' COMMENT 'SEO标题',
  `seo_keywords` varchar(500) DEFAULT '' COMMENT 'SEO关键词',
  `seo_description` text COMMENT 'SEO描述',
  `attrlist_id` int unsigned NOT NULL DEFAULT '0' COMMENT '参数列表ID',
  `merchant_id` int unsigned NOT NULL DEFAULT '0' COMMENT '多商家ID',
  `free_shipping` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '商品是否包邮(1包邮(免运费)  0跟随系统)',
  `users_price` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '会员价',
  `crossed_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '商品划线价',
  `users_discount_type` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '产品会员折扣类型(0:系统默认折扣; 1:指定会员级别; 2:不参与折扣;)',
  `users_free` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '是否会员免费，默认0不免费，1为免费',
  `old_price` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '产品旧价',
  `sales_num` int NOT NULL DEFAULT '0' COMMENT '总销售量',
  `virtual_sales` int DEFAULT '0' COMMENT '商品虚拟销售量',
  `sales_all` int DEFAULT '0' COMMENT '虚拟总销量',
  `stock_count` int unsigned NOT NULL DEFAULT '0' COMMENT '商品库存量',
  `stock_show` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '商品库存在产品详情页是否显示，1为显示，0为不显示',
  `prom_type` tinyint unsigned DEFAULT '0' COMMENT '产品类型：0=普通产品，1=虚拟(默认手动发货)，2=虚拟(网盘)，3=虚拟(自定义文本) 4-核销',
  `logistics_type` varchar(100) DEFAULT '1' COMMENT '商品物流支持类型(1: 物流配送; 2: 到店核销)',
  `tempview` varchar(200) DEFAULT '' COMMENT '文档模板',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态(0=屏蔽，1=正常)',
  `sort_order` int DEFAULT '0' COMMENT '排序号',
  `lang` varchar(50) DEFAULT 'cn' COMMENT '语言标识',
  `admin_id` int DEFAULT '0' COMMENT '管理员ID',
  `users_id` int DEFAULT '0' COMMENT '会员ID',
  `arc_level_id` int DEFAULT '0' COMMENT '文档会员权限ID',
  `restric_type` tinyint(1) DEFAULT '0' COMMENT '限制模式，0=免费，1=付费，2=会员专享，3=会员付费，4=会员积分购买',
  `users_score` varchar(20) DEFAULT '' COMMENT 'restric_type=4时，会员可使用积分进行文章订单支付购买',
  `is_del` tinyint(1) DEFAULT '0' COMMENT '伪删除，1=是，0=否',
  `del_method` tinyint(1) DEFAULT '0' COMMENT '伪删除状态，1为主动删除，2为跟随上级栏目被动删除',
  `joinaid` int DEFAULT '0' COMMENT '关联文档ID',
  `downcount` int DEFAULT '0' COMMENT '下载次数',
  `appraise` int DEFAULT '0' COMMENT '评价数',
  `collection` int DEFAULT '0' COMMENT '收藏数',
  `htmlfilename` varchar(500) DEFAULT '' COMMENT '自定义文件名',
  `province_id` int DEFAULT '0' COMMENT '省份',
  `city_id` int DEFAULT '0' COMMENT '所在城市',
  `area_id` int DEFAULT '0' COMMENT '所在区域',
  `add_time` int DEFAULT '0' COMMENT '新增时间',
  `update_time` int DEFAULT '0' COMMENT '更新时间',
  `removal_time` int DEFAULT '0' COMMENT '下架时间（用于自动下架，配合定时发布插件的下架功能）',
  `no_vip_pay` tinyint DEFAULT '0' COMMENT 'restric_type = 2 时,会员专享,非会员可付费使用,0-关闭,1-开启',
  `editor_remote_img_local` tinyint(1) DEFAULT '1' COMMENT '远程图片本地化',
  `editor_img_clear_link` tinyint(1) DEFAULT '1' COMMENT '清除非本站链接',
  `editor_ai_create` tinyint(1) DEFAULT '0' COMMENT 'AI创作声明',
  `reason` text COMMENT '退回原因',
  `stock_code` varchar(100) DEFAULT NULL COMMENT '商品编码',
  PRIMARY KEY (`aid`),
  KEY `add_time` (`add_time`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3 COMMENT='文档主表';

-- -----------------------------
-- Records of `ey_archives`
-- -----------------------------
INSERT INTO `ey_archives` VALUES ('1', '1', '', '1', '0', 'Technical baseline released for BVM-120', '', 'The BVM-120 technical baseline has been organized around max speed, typical production output, sack width, bottom width, and total power.', '/images/banner01.png', '0', '0', '0', '0', '0', '1', '0', '0', '0', '', 'LIGUOXING', '0', '0', '', '0', 'Technical baseline released for BVM-120 | News | LIGUOXING', 'block bottom valve bag making machine, woven valve bag making machine, valve sack production line, industrial bag making machine, woven sack conversion line', 'The BVM-120 technical baseline has been organized around max speed, typical production output, sack width, bottom width, and total power.', '0', '0', '0', '0.00', '0.00', '0', '0', '0.00', '0', '0', '0', '0', '1', '0', '1', 'news_detail.htm', '1', '6', 'cn', '1', '0', '0', '0', '', '1', '1', '0', '0', '0', '0', 'technical-baseline-bvm-120', '0', '0', '0', '1778032800', '1778583460', '0', '0', '1', '1', '0', '', '');
INSERT INTO `ey_archives` VALUES ('2', '1', '', '1', '0', 'Application notes updated for laminated PP workflow', '', 'Application notes for laminated PP tubular fabric, valve patch, and bottom patch process matching have been updated.', '/images/p1.jpg', '0', '0', '0', '0', '0', '1', '0', '0', '0', '', 'LIGUOXING', '0', '0', '', '0', 'Application notes updated for laminated PP workflow | News | LIGUOXING', 'PP woven fabric coating machine, woven fabric lamination line, lamination machine for woven bags, BOPP lamination machine, BOPP laminated woven bag', 'Application notes for laminated PP tubular fabric, valve patch, and bottom patch process matching have been updated.', '0', '0', '0', '0.00', '0.00', '0', '0', '0.00', '0', '0', '0', '0', '1', '0', '1', 'news_detail.htm', '1', '5', 'cn', '1', '0', '0', '0', '', '1', '1', '0', '0', '0', '0', 'application-notes-laminated-pp', '0', '0', '0', '1777341600', '1778583460', '0', '0', '1', '1', '0', '', '');
INSERT INTO `ey_archives` VALUES ('3', '1', '', '1', '0', 'Delivery workflow refined for global installations', '', 'The installation, commissioning, and post-start service workflow has been refined for global customers.', '/images/home.jpg', '0', '0', '0', '0', '0', '1', '0', '0', '0', '', 'LIGUOXING', '0', '0', '', '0', 'Delivery workflow refined for global installations | News | LIGUOXING', 'turnkey woven bag production line, woven packaging machinery, bulk packaging production line, industrial bag making machine, PP woven sack production line', 'The installation, commissioning, and post-start service workflow has been refined for global customers.', '0', '0', '0', '0.00', '0.00', '0', '0', '0.00', '0', '0', '0', '0', '1', '0', '1', 'news_detail.htm', '1', '4', 'cn', '1', '0', '0', '0', '', '1', '1', '0', '0', '0', '0', 'delivery-workflow-global-installations', '0', '0', '0', '1776304800', '1778583460', '0', '0', '1', '1', '0', '', '');
INSERT INTO `ey_archives` VALUES ('4', '1', '', '1', '0', 'Control system diagnostics package upgraded', '', 'HMI monitoring and fault tracking templates have been improved for easier daily operation and maintenance.', '/images/p2.jpg', '0', '0', '0', '0', '0', '1', '0', '0', '0', '', 'LIGUOXING', '0', '0', '', '0', 'Control system diagnostics package upgraded | News | LIGUOXING', 'industrial bag making machine, woven bag production line, PP woven bag conversion machine, woven sack conversion line, turnkey woven bag production line', 'HMI monitoring and fault tracking templates have been improved for easier daily operation and maintenance.', '0', '0', '0', '0.00', '0.00', '0', '0', '0.00', '0', '0', '0', '0', '1', '0', '1', 'news_detail.htm', '1', '3', 'cn', '1', '0', '0', '0', '', '1', '1', '0', '0', '0', '0', 'control-system-diagnostics-upgrade', '0', '0', '0', '1774749600', '1778583460', '0', '0', '1', '1', '0', '', '');
INSERT INTO `ey_archives` VALUES ('5', '1', '', '1', '0', 'Material requirement checklist standardized', '', 'A standardized material checklist now covers fabric, patch, width, and process readiness requirements.', '/images/img01.jpg', '0', '0', '0', '0', '0', '1', '0', '0', '0', '', 'LIGUOXING', '0', '0', '', '0', 'Material requirement checklist standardized | News | LIGUOXING', 'PP woven fabric coating machine, woven sack conversion line, woven bag production line, laminated woven bag machine, industrial bag making machine', 'A standardized material checklist now covers fabric, patch, width, and process readiness requirements.', '0', '0', '0', '0.00', '0.00', '0', '0', '0.00', '0', '0', '0', '0', '1', '0', '1', 'news_detail.htm', '1', '2', 'cn', '1', '0', '0', '0', '', '1', '1', '0', '0', '0', '0', 'material-requirement-checklist', '0', '0', '0', '1772416800', '1778583460', '0', '0', '1', '1', '0', '', '');
INSERT INTO `ey_archives` VALUES ('6', '1', '', '1', '0', 'New case: multi-size open-mouth line deployment', '', 'A new deployment case highlights module reconfiguration for multi-size open-mouth bag production.', '/images/p1.jpg', '0', '0', '0', '0', '0', '1', '0', '0', '0', '', 'LIGUOXING', '0', '0', '', '0', 'New case: multi-size open-mouth line deployment | News | LIGUOXING', 'open mouth bag making machine, woven open mouth bag conversion line, PP open mouth bag machine, sewn open mouth sack machine, open top sack production line', 'A new deployment case highlights module reconfiguration for multi-size open-mouth bag production.', '0', '0', '0', '0.00', '0.00', '0', '0', '0.00', '0', '0', '0', '0', '1', '0', '1', 'news_detail.htm', '1', '1', 'cn', '1', '0', '0', '0', '', '1', '1', '0', '0', '0', '0', 'multi-size-open-mouth-line-deployment', '0', '0', '0', '1771034400', '1778583460', '0', '0', '1', '1', '0', '', '');
INSERT INTO `ey_archives` VALUES ('7', '1', '', '1', '0', 'Test', '时代发生的', '', '/images/p1.jpg', '0', '0', '0', '0', '0', '0', '0', '0', '0', '网络', '小编', '728', '0', '', '0', '', 'woven packaging machinery, PP woven bag making machine, woven bag production line, industrial bag making machine, woven sack manufacturing machine', 'dfsdfsfs', '0', '0', '0', '0.00', '0.00', '0', '0', '0.00', '0', '0', '0', '0', '1', '0', '1', 'news_detail.htm', '1', '100', 'cn', '1', '0', '0', '0', '0', '1', '1', '0', '0', '0', '0', 'test', '0', '0', '0', '1778575994', '1778583460', '0', '0', '0', '0', '0', '', '');
INSERT INTO `ey_archives` VALUES ('8', '3', '', '4', '0', 'Company Brochure (PDF)', '', 'Overview of company capability and product direction.', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', 'LIGUOXING', '0', '0', '', '0', 'Company Brochure (PDF) | Download | LIGUOXING', 'woven packaging machinery, woven bag production line, industrial bag making machine, PP woven sack production line, bulk packaging production line', 'Overview of company capability and product direction.', '0', '0', '0', '0.00', '0.00', '0', '0', '0.00', '0', '0', '0', '0', '1', '0', '1', 'download_detail.htm', '1', '5', 'cn', '1', '0', '0', '0', '', '0', '0', '0', '0', '0', '0', 'liguoxing-brochure', '0', '0', '0', '1777597200', '1778583460', '0', '0', '1', '1', '0', '', '');
INSERT INTO `ey_archives` VALUES ('9', '3', '', '4', '0', 'BVM-120 Technical Profile (PDF)', '', 'Machine profile for block bottom valve bag production.', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', 'LIGUOXING', '0', '0', '', '0', 'BVM-120 Technical Profile (PDF) | Download | LIGUOXING', 'block bottom valve bag making machine, cement valve bag making machine, woven valve bag making machine, valve sack production line, woven sack conversion line', 'Machine profile for block bottom valve bag production.', '0', '0', '0', '0.00', '0.00', '0', '0', '0.00', '0', '0', '0', '0', '1', '0', '1', 'download_detail.htm', '1', '4', 'cn', '1', '0', '0', '0', '', '0', '0', '0', '0', '0', '0', 'bvm-120-technical-profile', '0', '0', '0', '1776992400', '1778583460', '0', '0', '1', '1', '0', '', '');
INSERT INTO `ey_archives` VALUES ('10', '3', '', '4', '0', 'Valve Bag Introduction (PDF)', '', 'General introduction of block bottom valve bag process and application value.', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', 'LIGUOXING', '0', '0', '', '0', 'Valve Bag Introduction (PDF) | Download | LIGUOXING', 'block bottom valve bag, block bottom valve sack, woven valve bag making machine, cement packaging bag machine, valve sack production line', 'General introduction of block bottom valve bag process and application value.', '0', '0', '0', '0.00', '0.00', '0', '0', '0.00', '0', '0', '0', '0', '1', '0', '1', 'download_detail.htm', '1', '3', 'cn', '1', '0', '0', '0', '', '0', '0', '0', '0', '0', '0', 'valve-bag-introduction', '0', '0', '0', '1775782800', '1778583460', '0', '0', '1', '1', '0', '', '');
INSERT INTO `ey_archives` VALUES ('11', '3', '', '4', '0', 'Technical Document (DOCX)', '', 'Detailed technical configuration and module description.', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', 'LIGUOXING', '0', '0', '', '0', 'Technical Document (DOCX) | Download | LIGUOXING', 'block bottom valve bag making machine, PP woven bag conversion machine, woven sack conversion line, industrial bag making machine, turnkey woven bag production line', 'Detailed technical configuration and module description.', '0', '0', '0', '0.00', '0.00', '0', '0', '0.00', '0', '0', '0', '0', '1', '0', '1', 'download_detail.htm', '1', '2', 'cn', '1', '0', '0', '0', '', '0', '0', '0', '0', '0', '0', 'block-bottom-technical-document', '0', '0', '0', '1774659600', '1778583460', '0', '0', '1', '1', '0', '', '');
INSERT INTO `ey_archives` VALUES ('12', '3', '', '4', '0', 'Technical Presentation (PPTX)', '', 'Process explanation slides for project discussions.', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', 'LIGUOXING', '0', '0', '', '0', 'Technical Presentation (PPTX) | Download | LIGUOXING', 'woven packaging machinery, block bottom valve bag making machine, PP woven bag making machine, woven sack conversion line, industrial bag making machine', 'Process explanation slides for project discussions.', '0', '0', '0', '0.00', '0.00', '0', '0', '0.00', '0', '0', '0', '0', '1', '0', '1', 'download_detail.htm', '1', '1', 'cn', '1', '0', '0', '0', '', '0', '0', '0', '0', '0', '0', 'technical-presentation', '0', '0', '0', '1773536400', '1778583460', '0', '0', '1', '1', '0', '', '');
INSERT INTO `ey_archives` VALUES ('13', '4', '', '1', '0', 'LIGUOXING Company Profile', 'Company introduction and factory capability overview.', 'A quick look at LIGUOXING manufacturing capability, workshop resources, and project delivery support.', 'https://img.youtube.com/vi/nhc7cRXHB5g/hqdefault.jpg', '0', '0', '0', '0', '0', '1', '0', '0', '0', '', 'LIGUOXING', '0', '0', 'https://www.youtube.com/watch?v=nhc7cRXHB5g', '0', 'LIGUOXING Company Profile | Video | LIGUOXING', 'woven packaging machinery video, industrial bag making machine video, woven bag production line video, PP woven sack production line video, turnkey woven bag production line', 'A quick look at LIGUOXING manufacturing capability, workshop resources, and project delivery support.', '0', '0', '0', '0.00', '0.00', '0', '0', '0.00', '0', '0', '0', '0', '1', '0', '1', 'video_detail.htm', '1', '2', 'cn', '1', '0', '0', '0', '', '0', '0', '0', '0', '0', '0', 'liguoxing-company-profile', '0', '0', '0', '1778378400', '1778583460', '0', '0', '1', '1', '0', '', '');
INSERT INTO `ey_archives` VALUES ('14', '4', '', '1', '0', 'BVM-120 Running Demonstration', 'Live production view of the block bottom valve bag making line.', 'Production footage of the BVM-120 showing forming, welding, and finished bag output in operation.', 'https://img.youtube.com/vi/12BZUHSFseM/hqdefault.jpg', '0', '0', '0', '0', '0', '1', '0', '0', '0', '', 'LIGUOXING', '0', '0', 'https://www.youtube.com/watch?v=12BZUHSFseM', '0', 'BVM-120 Running Demonstration | Video | LIGUOXING', 'block bottom valve bag making machine video, cement valve bag making machine video, woven valve bag making machine video, valve sack production line video, woven sack conversion line video', 'Production footage of the BVM-120 showing forming, welding, and finished bag output in operation.', '0', '0', '0', '0.00', '0.00', '0', '0', '0.00', '0', '0', '0', '0', '1', '0', '1', 'video_detail.htm', '1', '1', 'cn', '1', '0', '0', '0', '', '0', '0', '0', '0', '0', '0', 'bvm-120-running-demo', '0', '0', '0', '1778205600', '1778583460', '0', '0', '1', '1', '0', '', '');

-- -----------------------------
-- Table structure for `ey_archives_flag`
-- -----------------------------
DROP TABLE IF EXISTS `ey_archives_flag`;
CREATE TABLE `ey_archives_flag` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `flag_name` varchar(255) NOT NULL DEFAULT '' COMMENT '文档属性名称',
  `flag_attr` varchar(10) NOT NULL DEFAULT '' COMMENT '属性值',
  `flag_fieldname` varchar(255) NOT NULL DEFAULT '' COMMENT '字段名',
  `status` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '状态， 1---显示， 0---隐藏',
  `ifsystem` tinyint(1) DEFAULT '0' COMMENT '字段分类，1=系统(不可修改)，0=自定义',
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `lang` varchar(50) DEFAULT 'cn' COMMENT '语言标识',
  `add_time` int DEFAULT '0' COMMENT '新增时间',
  `update_time` int DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `flag_attr` (`flag_attr`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COMMENT='文档属性配置表';

-- -----------------------------
-- Records of `ey_archives_flag`
-- -----------------------------
INSERT INTO `ey_archives_flag` VALUES ('1', '头条', 'h', 'is_head', '1', '1', '1', 'cn', '1606272350', '1606272350');
INSERT INTO `ey_archives_flag` VALUES ('2', '推荐', 'c', 'is_recom', '1', '1', '2', 'cn', '1606272350', '1606272350');
INSERT INTO `ey_archives_flag` VALUES ('3', '加推', 'a', 'is_special', '1', '1', '3', 'cn', '1606272350', '1606272350');
INSERT INTO `ey_archives_flag` VALUES ('4', '标粗', 'b', 'is_b', '1', '1', '4', 'cn', '1606272350', '1606272350');
INSERT INTO `ey_archives_flag` VALUES ('5', '有图', 'p', 'is_litpic', '1', '1', '5', 'cn', '1606272350', '1606272350');
INSERT INTO `ey_archives_flag` VALUES ('6', '外链', 'j', 'is_jump', '1', '1', '6', 'cn', '1606272350', '1606272350');
INSERT INTO `ey_archives_flag` VALUES ('7', '轮播', 's', 'is_slide', '0', '1', '7', 'cn', '1606272350', '1606272350');
INSERT INTO `ey_archives_flag` VALUES ('8', '滚动', 'r', 'is_roll', '0', '1', '8', 'cn', '1606272350', '1606272350');
INSERT INTO `ey_archives_flag` VALUES ('9', '热文', 'd', 'is_diyattr', '0', '1', '9', 'cn', '1606272350', '1606272350');

-- -----------------------------
-- Table structure for `ey_arcmulti`
-- -----------------------------
DROP TABLE IF EXISTS `ey_arcmulti`;
CREATE TABLE `ey_arcmulti` (
  `id` mediumint unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `tagid` varchar(60) NOT NULL DEFAULT '' COMMENT '标签ID',
  `tagname` varchar(60) NOT NULL DEFAULT '' COMMENT '标签名',
  `innertext` text NOT NULL COMMENT '标签模板代码',
  `pagesize` int NOT NULL DEFAULT '0' COMMENT '分页列表',
  `querysql` text NOT NULL COMMENT '完整SQL',
  `ordersql` varchar(200) DEFAULT '' COMMENT '排序SQL',
  `addfieldsSql` varchar(255) DEFAULT '' COMMENT '附加字段SQL',
  `addtableName` varchar(50) DEFAULT '' COMMENT '附加字段的数据表，不包含表前缀',
  `attstr` text COMMENT '属性字符串',
  `add_time` int DEFAULT '0' COMMENT '新增时间',
  `update_time` int DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COMMENT='多页标记存储数据表';


-- -----------------------------
-- Table structure for `ey_arcrank`
-- -----------------------------
DROP TABLE IF EXISTS `ey_arcrank`;
CREATE TABLE `ey_arcrank` (
  `id` smallint unsigned NOT NULL AUTO_INCREMENT COMMENT '权限ID',
  `rank` smallint DEFAULT '0' COMMENT '权限值',
  `name` char(20) DEFAULT '' COMMENT '会员名称',
  `lang` varchar(50) DEFAULT 'cn' COMMENT '语言标识',
  `add_time` int DEFAULT '0' COMMENT '新增时间',
  `update_time` int DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC COMMENT='文档阅读权限表';

-- -----------------------------
-- Records of `ey_arcrank`
-- -----------------------------
INSERT INTO `ey_arcrank` VALUES ('1', '0', '开放浏览', 'cn', '0', '1552376880');
INSERT INTO `ey_arcrank` VALUES ('2', '-1', '待审核稿件', 'cn', '0', '1552376880');

-- -----------------------------
-- Table structure for `ey_arctype`
-- -----------------------------
DROP TABLE IF EXISTS `ey_arctype`;
CREATE TABLE `ey_arctype` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT '栏目ID',
  `channeltype` int DEFAULT '0' COMMENT '栏目顶级模型ID',
  `current_channel` int DEFAULT '0' COMMENT '栏目当前模型ID',
  `parent_id` int DEFAULT '0' COMMENT '栏目上级ID',
  `topid` int DEFAULT '0' COMMENT '顶级栏目ID',
  `typename` varchar(500) DEFAULT '' COMMENT '栏目名称',
  `dirname` varchar(250) DEFAULT '' COMMENT '目录英文名',
  `dirpath` varchar(500) DEFAULT '' COMMENT '目录存放HTML路径',
  `diy_dirpath` varchar(500) DEFAULT '' COMMENT '列表静态文件存放规则',
  `rulelist` varchar(200) DEFAULT '' COMMENT '列表静态文件存放规则',
  `ruleview` varchar(200) DEFAULT '' COMMENT '文档静态文件存放规则',
  `englist_name` varchar(500) DEFAULT '' COMMENT '栏目英文名',
  `grade` tinyint(1) DEFAULT '0' COMMENT '栏目等级',
  `typelink` varchar(500) DEFAULT '' COMMENT '栏目链接',
  `litpic` varchar(500) DEFAULT '' COMMENT '栏目图片',
  `templist` varchar(200) DEFAULT '' COMMENT '列表模板文件名',
  `tempview` varchar(200) DEFAULT '' COMMENT '文档模板文件名',
  `seo_title` varchar(500) DEFAULT '' COMMENT 'SEO标题',
  `seo_keywords` varchar(500) DEFAULT '' COMMENT 'seo关键字',
  `seo_description` text COMMENT 'seo描述',
  `sort_order` int DEFAULT '0' COMMENT '排序号',
  `is_hidden` tinyint(1) DEFAULT '0' COMMENT '是否隐藏栏目：0=显示，1=隐藏',
  `is_part` tinyint(1) DEFAULT '0' COMMENT '栏目属性：0=内容栏目，1=外部链接',
  `admin_id` int DEFAULT '0' COMMENT '管理员ID',
  `is_del` tinyint(1) DEFAULT '0' COMMENT '伪删除，1=是，0=否',
  `del_method` tinyint(1) DEFAULT '0' COMMENT '伪删除状态，1为主动删除，2为跟随上级栏目被动删除',
  `status` tinyint(1) DEFAULT '1' COMMENT '启用 (1=正常，0=屏蔽)',
  `is_release` tinyint(1) DEFAULT '0' COMMENT '栏目是否应用于会员投稿发布，1是，0否',
  `weapp_code` varchar(50) DEFAULT '' COMMENT '插件栏目唯一标识',
  `lang` varchar(50) DEFAULT 'cn' COMMENT '语言标识',
  `add_time` int DEFAULT '0' COMMENT '新增时间',
  `update_time` int DEFAULT '0' COMMENT '更新时间',
  `target` tinyint(1) DEFAULT '0' COMMENT '新窗口打开',
  `nofollow` tinyint(1) DEFAULT '0' COMMENT '防抓取',
  `typearcrank` int DEFAULT '0' COMMENT '阅读权限：0=开放浏览，-1=待审核稿件',
  `empty_logic` tinyint(1) DEFAULT '0' COMMENT '空内容逻辑',
  `page_limit` varchar(10) DEFAULT '0' COMMENT '限制页面 1-栏目页面 0-文档页面',
  `total_arc` int DEFAULT '0' COMMENT '栏目下文档数量',
  PRIMARY KEY (`id`),
  UNIQUE KEY `dirname` (`dirname`,`lang`) USING BTREE,
  KEY `parent_id` (`channeltype`,`parent_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COMMENT='文档栏目表';

-- -----------------------------
-- Records of `ey_arctype`
-- -----------------------------
INSERT INTO `ey_arctype` VALUES ('1', '1', '1', '0', '1', 'News', 'news', '/news', 'news', 'news.htm', 'news/{aid}.htm', '', '1', '', '', 'news.htm', 'news_detail.htm', 'Latest News | LIGUOXING', 'woven packaging machinery, PP woven bag making machine, woven bag production line, industrial bag making machine, turnkey woven bag production line', 'LIGUOXING technical, delivery, application, and service updates for industrial bag making equipment.', '100', '0', '0', '1', '0', '0', '1', '0', '', 'cn', '1778575419', '1778583460', '0', '0', '0', '0', '', '0');
INSERT INTO `ey_arctype` VALUES ('2', '8', '8', '0', '2', 'Message', 'message', '/message', 'message', 'message.htm', '', '', '1', '', '', '', '', 'Message', 'message, inquiry, liguoxing', 'Business inquiry form configuration for LIGUOXING.', '90', '1', '0', '1', '0', '0', '1', '0', '', 'cn', '1778575419', '1778583460', '0', '0', '0', '0', '', '2');
INSERT INTO `ey_arctype` VALUES ('3', '4', '4', '0', '3', 'Download', 'download', '/download', 'download', 'download.htm', 'download/{aid}.htm', '', '1', '', '', 'download.htm', 'download_detail.htm', 'Download | LIGUOXING', 'woven packaging machinery, block bottom valve bag making machine, PP woven bag making machine, woven sack conversion line, PP woven fabric coating machine', 'Download brochures, technical profiles, and process documents for project communication.', '80', '0', '0', '1', '0', '0', '1', '0', '', 'cn', '1778577890', '1778583460', '0', '0', '0', '0', '', '5');
INSERT INTO `ey_arctype` VALUES ('4', '1', '1', '0', '4', 'Video', 'video', '/video', 'video', 'video.htm', 'video/{aid}.htm', '', '1', '', '', 'video.htm', 'video_detail.htm', 'Video | LIGUOXING', 'block bottom valve bag making machine video, woven bag production line video, industrial bag making machine video, PP woven sack production line video, woven packaging machinery video', 'Video list for LIGUOXING equipment demonstrations, factory introductions, and project presentation clips.', '85', '0', '0', '1', '0', '0', '1', '0', '', 'cn', '1778583243', '1778583460', '0', '0', '0', '0', '', '2');

-- -----------------------------
-- Table structure for `ey_article_content`
-- -----------------------------
DROP TABLE IF EXISTS `ey_article_content`;
CREATE TABLE `ey_article_content` (
  `id` int NOT NULL AUTO_INCREMENT,
  `aid` int DEFAULT '0' COMMENT '文档ID',
  `content` longtext COMMENT '内容详情',
  `content_ey_m` longtext COMMENT '手机端内容详情',
  `youtube_url` varchar(500) NOT NULL DEFAULT '',
  `add_time` int DEFAULT '0' COMMENT '新增时间',
  `update_time` int DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `news_id` (`aid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COMMENT='文章附加表';

-- -----------------------------
-- Records of `ey_article_content`
-- -----------------------------
INSERT INTO `ey_article_content` VALUES ('1', '1', '<p class=\"lead\">The updated baseline makes it easier for customers to evaluate whether the BVM-120 matches their block bottom valve bag production plan.</p>\n<p>Key reference data includes up to 120 bags/min maximum speed, 90-115 bags/min typical production range, 350-600 mm sack width, 80-160 mm bottom width, and 120 kW total power.</p>\n<p>The information also helps the sales and engineering teams align quotations, site planning, and technical communication around the same parameter set.</p>\n<div class=\"detail-note\"><h2>What This Means</h2><p>This update helps customers evaluate equipment configuration, process readiness, and service planning with clearer technical context.</p></div>', '', '', '1778032800', '1778032800');
INSERT INTO `ey_article_content` VALUES ('2', '2', '<p class=\"lead\">The updated notes focus on material matching, feeding stability, patch positioning, and sealing reliability.</p>\n<p>For laminated PP workflows, consistent fabric quality and patch preparation are important for stable forming and finished bag strength.</p>\n<p>These notes support early-stage project evaluation before final line configuration and commissioning.</p>\n<div class=\"detail-note\"><h2>What This Means</h2><p>This update helps customers evaluate equipment configuration, process readiness, and service planning with clearer technical context.</p></div>', '', '', '1777341600', '1777341600');
INSERT INTO `ey_article_content` VALUES ('3', '3', '<p class=\"lead\">The delivery workflow now places more emphasis on pre-shipment checks, installation planning, operator training, and early production support.</p>\n<p>This makes each project easier to coordinate from factory acceptance through production start-up.</p>\n<p>The goal is to reduce uncertainty during handover and help customers reach stable output faster.</p>\n<div class=\"detail-note\"><h2>What This Means</h2><p>This update helps customers evaluate equipment configuration, process readiness, and service planning with clearer technical context.</p></div>', '', '', '1776304800', '1776304800');
INSERT INTO `ey_article_content` VALUES ('4', '4', '<p class=\"lead\">The upgraded diagnostics package helps operators identify abnormal conditions faster and supports more consistent maintenance routines.</p>\n<p>HMI visibility is especially useful for coordinated modules such as feeding, forming, patch pressing, counting, and reject control.</p>\n<p>The update supports better communication between operation teams and service engineers.</p>\n<div class=\"detail-note\"><h2>What This Means</h2><p>This update helps customers evaluate equipment configuration, process readiness, and service planning with clearer technical context.</p></div>', '', '', '1774749600', '1774749600');
INSERT INTO `ey_article_content` VALUES ('5', '5', '<p class=\"lead\">Material preparation has a direct impact on forming quality, sealing consistency, and finished bag performance.</p>\n<p>The checklist helps customers prepare key material data before technical evaluation and production trials.</p>\n<p>It also reduces repeated communication during project setup and improves engineering response speed.</p>\n<div class=\"detail-note\"><h2>What This Means</h2><p>This update helps customers evaluate equipment configuration, process readiness, and service planning with clearer technical context.</p></div>', '', '', '1772416800', '1772416800');
INSERT INTO `ey_article_content` VALUES ('6', '6', '<p class=\"lead\">The project focused on flexible changeover, line stability, and consistent output across several bag specifications.</p>\n<p>Module-level adjustment guidance helped the customer move between production plans with less uncertainty.</p>\n<p>This case will be used as a reference for future multi-size industrial packaging projects.</p>\n<div class=\"detail-note\"><h2>What This Means</h2><p>This update helps customers evaluate equipment configuration, process readiness, and service planning with clearer technical context.</p></div>', '', '', '1771034400', '1771034400');
INSERT INTO `ey_article_content` VALUES ('7', '7', '&lt;p&gt;&lt;span style=&quot;color: rgb(31, 73, 125);&quot;&gt;The updated notes focus on material matching, feeding stability, patc&lt;strong&gt;h positioning, and sealing reliability.&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;For laminated PP workflows, consistent fabric quality and patch preparation are important for stable forming and finished bag strength.&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;/uploads/allimg/20260512/1-2605121P129446.png&quot; alt=&quot;flow-1.png&quot;/&gt;&lt;/p&gt;&lt;p&gt;These notes support early-stage project evaluation before final line configuration and commissioning.&lt;/p&gt;', '', '', '1778575998', '1778580187');
INSERT INTO `ey_article_content` VALUES ('8', '13', '<p class=\"lead\">This company profile video introduces the production environment, machining capability, and export-oriented service support behind LIGUOXING equipment.</p>\n<p>It gives customers a quick way to understand factory scale, process control, and the engineering background behind turnkey woven packaging projects.</p>\n<p>The video is useful for early-stage introductions, distributor communication, and customer presentation scenarios.</p>', '', 'https://www.youtube.com/watch?v=nhc7cRXHB5g', '1778378400', '1778378400');
INSERT INTO `ey_article_content` VALUES ('9', '14', '<p class=\"lead\">This running demo focuses on actual machine movement, process coordination, and finished bag output on the BVM-120 platform.</p>\n<p>It helps customers evaluate equipment rhythm, forming stability, and the practical layout of the production section.</p>\n<p>The footage is useful for technical review, proposal support, and internal customer discussions before project confirmation.</p>', '', 'https://www.youtube.com/watch?v=12BZUHSFseM', '1778205600', '1778205600');

-- -----------------------------
-- Table structure for `ey_article_order`
-- -----------------------------
DROP TABLE IF EXISTS `ey_article_order`;
CREATE TABLE `ey_article_order` (
  `order_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '文章订单ID',
  `order_code` varchar(50) NOT NULL DEFAULT '' COMMENT '媒体订单编号',
  `users_id` int unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `order_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单状态：0未付款，1已付款',
  `order_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单应付总金额',
  `order_score` varchar(20) NOT NULL DEFAULT '' COMMENT '订单应付总积分',
  `pay_time` int unsigned NOT NULL DEFAULT '0' COMMENT '支付时间',
  `pay_name` varchar(20) NOT NULL DEFAULT '' COMMENT '支付方式名称',
  `wechat_pay_type` varchar(20) NOT NULL DEFAULT '' COMMENT '微信支付时，标记使用的支付类型（扫码支付，微信内部，微信H5页面）',
  `pay_details` text COMMENT '支付时返回的数据，以serialize序列化后存入，用于后续查询。',
  `product_id` int unsigned NOT NULL DEFAULT '0' COMMENT '视频文档ID',
  `product_name` varchar(100) DEFAULT '' COMMENT '视频文档名称',
  `product_litpic` varchar(500) DEFAULT '' COMMENT '视频文档封面图片',
  `lang` varchar(30) DEFAULT 'cn' COMMENT '语言标识',
  `add_time` int unsigned DEFAULT '0' COMMENT '下单时间',
  `update_time` int unsigned DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_code` (`order_code`) USING BTREE,
  KEY `users_id` (`users_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COMMENT='文章订单表';


-- -----------------------------
-- Table structure for `ey_article_pay`
-- -----------------------------
DROP TABLE IF EXISTS `ey_article_pay`;
CREATE TABLE `ey_article_pay` (
  `id` int NOT NULL AUTO_INCREMENT,
  `aid` int DEFAULT '0',
  `part_free` tinyint(1) DEFAULT '0' COMMENT '是否试看 0-否 1-是',
  `size` varchar(50) DEFAULT '1' COMMENT 'KB',
  `free_content` longtext COMMENT '试看内容',
  `add_time` int DEFAULT '0',
  `update_time` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COMMENT='文章付费预览表';


-- -----------------------------
-- Table structure for `ey_ask`
-- -----------------------------
DROP TABLE IF EXISTS `ey_ask`;
CREATE TABLE `ey_ask` (
  `ask_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `type_id` int unsigned NOT NULL DEFAULT '0' COMMENT '问题栏目ID',
  `users_id` int unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `ask_title` varchar(200) NOT NULL DEFAULT '' COMMENT '问题标题',
  `is_recom` tinyint(1) NOT NULL DEFAULT '0' COMMENT '问题是否推荐',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '问题状态：0未解决，1已解决，2已关闭',
  `click` int unsigned NOT NULL DEFAULT '0' COMMENT '浏览点击量',
  `replies` int unsigned NOT NULL DEFAULT '0' COMMENT '问题回复量',
  `content` text NOT NULL COMMENT '问题内容',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '问题网址',
  `users_ip` varchar(50) NOT NULL DEFAULT '' COMMENT '问题发布时IP地址',
  `is_review` tinyint(1) NOT NULL DEFAULT '1' COMMENT '问题是否审核，1是，0否',
  `follow` tinyint(1) NOT NULL DEFAULT '0' COMMENT '关注问题则表示有回复时发送邮件通知到问题发布人',
  `solve_time` int unsigned NOT NULL DEFAULT '0' COMMENT '解决时间(这个问题存在最佳答案则表示已解决)',
  `bestanswer_id` int unsigned NOT NULL DEFAULT '0' COMMENT '最佳答案',
  `sort_order` int NOT NULL DEFAULT '100' COMMENT '排序号',
  `add_time` int unsigned NOT NULL DEFAULT '0' COMMENT '新增时间',
  `update_time` int unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `money` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '悬赏金额',
  `is_del` tinyint(1) DEFAULT '0' COMMENT '1-删除',
  PRIMARY KEY (`ask_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COMMENT='问题表';


-- -----------------------------
-- Table structure for `ey_ask_answer`
-- -----------------------------
DROP TABLE IF EXISTS `ey_ask_answer`;
CREATE TABLE `ey_ask_answer` (
  `answer_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `ask_id` int unsigned NOT NULL DEFAULT '0' COMMENT '问题ID',
  `is_bestanswer` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否最佳答案，0否，1是',
  `is_review` tinyint(1) NOT NULL DEFAULT '1' COMMENT '问题是否审核，1是，0否',
  `type_id` int unsigned NOT NULL DEFAULT '0' COMMENT '问题栏目ID',
  `users_id` int unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `click_like` int unsigned NOT NULL DEFAULT '0' COMMENT '点赞量',
  `users_ip` varchar(30) NOT NULL DEFAULT '' COMMENT '用户IP地址',
  `content` text NOT NULL COMMENT '内容',
  `ifcheck` tinyint(1) NOT NULL DEFAULT '1',
  `answer_pid` int NOT NULL DEFAULT '0' COMMENT '子答案的父答案',
  `at_users_id` int NOT NULL DEFAULT '0' COMMENT '被@的用户ID',
  `at_answer_id` int NOT NULL DEFAULT '0' COMMENT '@答案ID',
  `add_time` int unsigned NOT NULL DEFAULT '0' COMMENT '新增时间',
  `update_time` int unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1-删除',
  PRIMARY KEY (`answer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COMMENT='答案表';


-- -----------------------------
-- Table structure for `ey_ask_answer_like`
-- -----------------------------
DROP TABLE IF EXISTS `ey_ask_answer_like`;
CREATE TABLE `ey_ask_answer_like` (
  `like_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `ask_id` int unsigned NOT NULL DEFAULT '0' COMMENT '问题ID',
  `answer_id` int NOT NULL DEFAULT '0' COMMENT '答案ID',
  `users_id` int unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `click_like` int unsigned NOT NULL DEFAULT '0' COMMENT '点赞',
  `like_source` tinyint unsigned NOT NULL DEFAULT '2' COMMENT '点赞来源，1=点赞提问(ask_id)，2=点赞评论(answer_id)，3=点赞回复(answer_id)，默认值为2，兼容以前的那些评论数据',
  `users_ip` varchar(30) NOT NULL DEFAULT '' COMMENT '用户IP地址',
  `add_time` int unsigned NOT NULL DEFAULT '0',
  `update_time` int unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`like_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COMMENT='答案点赞表';


-- -----------------------------
-- Table structure for `ey_ask_score_level`
-- -----------------------------
DROP TABLE IF EXISTS `ey_ask_score_level`;
CREATE TABLE `ey_ask_score_level` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(55) DEFAULT '',
  `min` mediumint DEFAULT '0',
  `max` mediumint DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COMMENT='积分等级表';

-- -----------------------------
-- Records of `ey_ask_score_level`
-- -----------------------------
INSERT INTO `ey_ask_score_level` VALUES ('1', '青铜', '0', '1000');
INSERT INTO `ey_ask_score_level` VALUES ('2', '白银', '1001', '5000');
INSERT INTO `ey_ask_score_level` VALUES ('3', '黄金', '5001', '20000');
INSERT INTO `ey_ask_score_level` VALUES ('4', '王者', '20001', '0');

-- -----------------------------
-- Table structure for `ey_ask_type`
-- -----------------------------
DROP TABLE IF EXISTS `ey_ask_type`;
CREATE TABLE `ey_ask_type` (
  `type_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目自增',
  `type_name` varchar(100) NOT NULL DEFAULT '' COMMENT '栏目名称',
  `parent_id` int unsigned NOT NULL DEFAULT '0' COMMENT '上级ID',
  `seo_title` varchar(200) DEFAULT '' COMMENT 'SEO标题',
  `seo_keywords` varchar(200) DEFAULT '' COMMENT 'seo关键字',
  `seo_description` text COMMENT 'seo描述',
  `sort_order` int unsigned NOT NULL DEFAULT '100' COMMENT '排序号',
  `add_time` int unsigned NOT NULL DEFAULT '0' COMMENT '新增时间',
  `update_time` int unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COMMENT='问题栏目分类表';

-- -----------------------------
-- Records of `ey_ask_type`
-- -----------------------------
INSERT INTO `ey_ask_type` VALUES ('1', '问题求助', '0', '', '', '', '100', '1565770890', '1611910466');
INSERT INTO `ey_ask_type` VALUES ('2', '功能建议', '0', '', '', '', '100', '1565770890', '1611910466');
INSERT INTO `ey_ask_type` VALUES ('3', 'BUG反馈', '1', '', '', '', '100', '1565771021', '1611910466');
INSERT INTO `ey_ask_type` VALUES ('4', '其他问题', '1', '', '', '', '100', '1565771021', '1611910466');
INSERT INTO `ey_ask_type` VALUES ('5', '业务咨询', '0', '', '', '', '100', '1611910466', '1611910466');

-- -----------------------------
-- Table structure for `ey_auth_role`
-- -----------------------------
DROP TABLE IF EXISTS `ey_auth_role`;
CREATE TABLE `ey_auth_role` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '' COMMENT '角色名',
  `pid` int DEFAULT '0' COMMENT '父角色ID',
  `remark` text COMMENT '备注信息',
  `grade` smallint unsigned NOT NULL DEFAULT '0' COMMENT '级别',
  `language` text COMMENT '多语言权限',
  `online_update` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '在线升级',
  `switch_map` tinyint(1) DEFAULT '0' COMMENT '功能地图',
  `only_oneself` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '只看自己发布',
  `check_oneself` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '发布文档自动通过审核，1--是，0--否',
  `cud` varchar(255) DEFAULT '' COMMENT '增改删',
  `permission` longtext COMMENT '已允许的权限',
  `built_in` tinyint(1) DEFAULT '0' COMMENT '内置用户组，1表示内置',
  `sort_order` int DEFAULT '0' COMMENT '排序号',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态(1=正常，0=屏蔽)',
  `admin_id` int DEFAULT '0' COMMENT '操作管理员ID',
  `add_time` int DEFAULT '0' COMMENT '新增时间',
  `update_time` int DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COMMENT='管理员角色表';

-- -----------------------------
-- Records of `ey_auth_role`
-- -----------------------------
INSERT INTO `ey_auth_role` VALUES ('1', '优化推广员', '0', '', '0', '', '0', '1', '1', '1', 'a:3:{i:0;s:3:\"add\";i:1;s:4:\"edit\";i:2;s:3:\"del\";}', 'a:2:{s:5:\"rules\";a:8:{i:0;s:1:\"1\";i:1;s:1:\"3\";i:2;s:1:\"4\";i:3;s:1:\"8\";i:4;s:1:\"9\";i:5;s:2:\"10\";i:6;s:2:\"14\";i:7;i:2;}s:7:\"arctype\";a:28:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";i:3;s:1:\"4\";i:4;s:1:\"5\";i:5;s:1:\"6\";i:6;s:2:\"33\";i:7;s:2:\"34\";i:8;s:2:\"35\";i:9;s:1:\"8\";i:10;s:2:\"32\";i:11;s:1:\"9\";i:12;s:2:\"30\";i:13;s:2:\"31\";i:14;s:2:\"11\";i:15;s:2:\"12\";i:16;s:2:\"13\";i:17;s:2:\"23\";i:18;s:2:\"20\";i:19;s:2:\"24\";i:20;s:2:\"25\";i:21;s:2:\"21\";i:22;s:2:\"26\";i:23;s:2:\"22\";i:24;s:2:\"27\";i:25;s:2:\"28\";i:26;s:2:\"29\";i:27;s:1:\"1\";}}', '1', '100', '1', '0', '1541058693', '1541058693');
INSERT INTO `ey_auth_role` VALUES ('2', '内容管理员', '0', '', '0', '', '0', '1', '1', '1', 'a:3:{i:0;s:3:\"add\";i:1;s:4:\"edit\";i:2;s:3:\"del\";}', 'a:2:{s:5:\"rules\";a:4:{i:0;s:1:\"1\";i:1;s:2:\"10\";i:2;s:2:\"14\";i:3;i:2;}s:7:\"arctype\";a:28:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";i:3;s:1:\"4\";i:4;s:1:\"5\";i:5;s:1:\"6\";i:6;s:2:\"33\";i:7;s:2:\"34\";i:8;s:2:\"35\";i:9;s:1:\"8\";i:10;s:2:\"32\";i:11;s:1:\"9\";i:12;s:2:\"30\";i:13;s:2:\"31\";i:14;s:2:\"11\";i:15;s:2:\"12\";i:16;s:2:\"13\";i:17;s:2:\"23\";i:18;s:2:\"20\";i:19;s:2:\"24\";i:20;s:2:\"25\";i:21;s:2:\"21\";i:22;s:2:\"26\";i:23;s:2:\"22\";i:24;s:2:\"27\";i:25;s:2:\"28\";i:26;s:2:\"29\";i:27;s:1:\"1\";}}', '1', '100', '1', '0', '1541059290', '1541059290');

-- -----------------------------
-- Table structure for `ey_channelfield`
-- -----------------------------
DROP TABLE IF EXISTS `ey_channelfield`;
CREATE TABLE `ey_channelfield` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '字段名称',
  `channel_id` int NOT NULL DEFAULT '0' COMMENT '所属文档模型id',
  `title` varchar(250) NOT NULL DEFAULT '' COMMENT '字段标题',
  `dtype` varchar(32) NOT NULL DEFAULT '' COMMENT '字段类型',
  `define` text NOT NULL COMMENT '字段定义',
  `maxlength` int NOT NULL DEFAULT '0' COMMENT '最大长度，文本数据必须填写，大于255为text类型',
  `dfvalue` text NOT NULL COMMENT '默认值',
  `dfvalue_unit` varchar(50) NOT NULL DEFAULT '' COMMENT '数值单位',
  `remark` varchar(256) NOT NULL DEFAULT '' COMMENT '提示说明',
  `is_screening` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否应用于条件筛选',
  `is_release` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否应用于会员投稿发布',
  `ifeditable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否在编辑页显示',
  `ifrequire` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否必填',
  `ifsystem` tinyint(1) NOT NULL DEFAULT '0' COMMENT '字段分类，1=系统(不可修改)，0=自定义',
  `ifmain` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否主表字段',
  `ifcontrol` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，控制该条数据是否允许被控制，1为不允许控制，0为允许控制',
  `sort_order` int NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `add_time` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `set_type` tinyint DEFAULT '0' COMMENT '区域选择时使用是否为三级联动,1-是',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=484 DEFAULT CHARSET=utf8mb3 COMMENT='自定义字段表';

-- -----------------------------
-- Records of `ey_channelfield`
-- -----------------------------
INSERT INTO `ey_channelfield` VALUES ('1', 'add_time', '0', '新增时间', 'datetime', 'int(11)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533091575', '1533091575', '0');
INSERT INTO `ey_channelfield` VALUES ('2', 'update_time', '0', '更新时间', 'datetime', 'int(11)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533091601', '1533091601', '0');
INSERT INTO `ey_channelfield` VALUES ('3', 'aid', '0', '文档ID', 'int', 'int(11)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533091624', '1533091624', '0');
INSERT INTO `ey_channelfield` VALUES ('4', 'typeid', '0', '当前栏目ID', 'int', 'int(11)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533091930', '1533091930', '0');
INSERT INTO `ey_channelfield` VALUES ('5', 'channel', '0', '模型ID', 'int', 'int(11)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533092214', '1533092214', '0');
INSERT INTO `ey_channelfield` VALUES ('6', 'is_b', '0', '是否加粗', 'switch', 'tinyint(1)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533092246', '1533092246', '0');
INSERT INTO `ey_channelfield` VALUES ('7', 'title', '0', '文档标题', 'text', 'varchar(250)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533092381', '1533092381', '0');
INSERT INTO `ey_channelfield` VALUES ('8', 'litpic', '0', '缩略图', 'img', 'varchar(250)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533092398', '1533092398', '0');
INSERT INTO `ey_channelfield` VALUES ('9', 'is_head', '0', '是否头条', 'switch', 'tinyint(1)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533092420', '1533092420', '0');
INSERT INTO `ey_channelfield` VALUES ('10', 'is_special', '0', '是否特荐', 'switch', 'tinyint(1)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533092439', '1533092439', '0');
INSERT INTO `ey_channelfield` VALUES ('11', 'is_top', '0', '是否置顶', 'switch', 'tinyint(1)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533092454', '1533092454', '0');
INSERT INTO `ey_channelfield` VALUES ('12', 'is_recom', '0', '是否推荐', 'switch', 'tinyint(1)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533092468', '1533092468', '0');
INSERT INTO `ey_channelfield` VALUES ('13', 'is_jump', '0', '是否跳转', 'switch', 'tinyint(1)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533092484', '1533092484', '0');
INSERT INTO `ey_channelfield` VALUES ('14', 'author', '0', '作者', 'text', 'varchar(250)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533092498', '1533092498', '0');
INSERT INTO `ey_channelfield` VALUES ('15', 'click', '0', '浏览量', 'int', 'int(11)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533092512', '1533092512', '0');
INSERT INTO `ey_channelfield` VALUES ('16', 'arcrank', '0', '阅读权限', 'select', 'tinyint(1)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533092534', '1533092534', '0');
INSERT INTO `ey_channelfield` VALUES ('17', 'jumplinks', '0', '跳转链接', 'text', 'varchar(250)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533092553', '1533092553', '0');
INSERT INTO `ey_channelfield` VALUES ('18', 'ismake', '0', '是否静态页面', 'switch', 'tinyint(1)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533092698', '1533092698', '0');
INSERT INTO `ey_channelfield` VALUES ('19', 'seo_title', '0', 'SEO标题', 'text', 'varchar(250)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533092713', '1533092713', '0');
INSERT INTO `ey_channelfield` VALUES ('20', 'seo_keywords', '0', 'SEO关键词', 'text', 'varchar(250)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533092725', '1533092725', '0');
INSERT INTO `ey_channelfield` VALUES ('21', 'seo_description', '0', 'SEO描述', 'text', 'varchar(250)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533092739', '1533092739', '0');
INSERT INTO `ey_channelfield` VALUES ('22', 'status', '0', '状态', 'switch', 'tinyint(1)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533092753', '1533092753', '0');
INSERT INTO `ey_channelfield` VALUES ('23', 'sort_order', '0', '排序号', 'int', 'int(11)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533092766', '1533092766', '0');
INSERT INTO `ey_channelfield` VALUES ('24', 'content', '2', '内容详情', 'htmltext', 'longtext', '250', '', '', '', '0', '1', '1', '0', '1', '0', '0', '100', '1', '1533359739', '1533359739', '0');
INSERT INTO `ey_channelfield` VALUES ('25', 'content', '3', '内容详情', 'htmltext', 'longtext', '250', '', '', '', '0', '1', '1', '0', '1', '0', '0', '100', '1', '1533359588', '1533359588', '0');
INSERT INTO `ey_channelfield` VALUES ('26', 'content', '4', '内容详情', 'htmltext', 'longtext', '250', '', '', '', '0', '1', '1', '0', '1', '0', '0', '100', '1', '1533359752', '1533359752', '0');
INSERT INTO `ey_channelfield` VALUES ('27', 'content', '6', '内容详情', 'htmltext', 'longtext', '250', '', '', '', '0', '1', '1', '0', '1', '0', '0', '100', '1', '1533464715', '1533464715', '0');
INSERT INTO `ey_channelfield` VALUES ('29', 'content', '1', '内容详情', 'htmltext', 'longtext', '250', '', '', '', '0', '1', '1', '0', '1', '0', '0', '100', '1', '1533464713', '1533464713', '0');
INSERT INTO `ey_channelfield` VALUES ('30', 'update_time', '-99', '更新时间', 'datetime', 'int(11)', '11', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('31', 'add_time', '-99', '新增时间', 'datetime', 'int(11)', '11', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('32', 'status', '-99', '启用 (1=正常，0=屏蔽)', 'switch', 'tinyint(1)', '1', '1', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('33', 'is_part', '-99', '栏目属性：0=内容栏目，1=外部链接', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('34', 'is_hidden', '-99', '是否隐藏栏目：0=显示，1=隐藏', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('35', 'sort_order', '-99', '排序号', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('36', 'seo_description', '-99', 'seo描述', 'multitext', 'text', '0', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('37', 'seo_keywords', '-99', 'seo关键字', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('38', 'seo_title', '-99', 'SEO标题', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('39', 'tempview', '-99', '文档模板文件名', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('40', 'templist', '-99', '列表模板文件名', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('41', 'litpic', '-99', '栏目图片', 'img', 'varchar(250)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('42', 'typelink', '-99', '栏目链接', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('43', 'grade', '-99', '栏目等级', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('44', 'englist_name', '-99', '栏目英文名', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('45', 'dirpath', '-99', '目录存放HTML路径', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('46', 'dirname', '-99', '目录英文名', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('47', 'typename', '-99', '栏目名称', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('48', 'parent_id', '-99', '栏目上级ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('49', 'current_channel', '-99', '栏目当前模型ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('50', 'channeltype', '-99', '栏目顶级模型ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('51', 'id', '-99', '栏目ID', 'int', 'int(10)', '10', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('52', 'del_method', '-99', '伪删除状态，1为主动删除，2为跟随上级栏目被动删除', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1547890773', '1547890773', '0');
INSERT INTO `ey_channelfield` VALUES ('53', 'is_del', '0', '伪删除，1=是，0=否', 'switch', 'tinyint(1)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1547890773', '1547890773', '0');
INSERT INTO `ey_channelfield` VALUES ('54', 'del_method', '0', '伪删除状态，1为主动删除，2为跟随上级栏目被动删除', 'switch', 'tinyint(1)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1547890773', '1547890773', '0');
INSERT INTO `ey_channelfield` VALUES ('55', 'admin_id', '0', '管理员ID', 'int', 'int(10)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1547890773', '1547890773', '0');
INSERT INTO `ey_channelfield` VALUES ('56', 'lang', '0', '语言标识', 'text', 'varchar(250)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1547890773', '1547890773', '0');
INSERT INTO `ey_channelfield` VALUES ('57', 'prom_type', '0', '产品类型：0普通产品，1虚拟产品', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1557042574', '1557042574', '0');
INSERT INTO `ey_channelfield` VALUES ('58', 'users_price', '0', '价格', 'decimal', 'decimal(10,2)', '10', '0.00', '', '', '0', '0', '1', '0', '1', '1', '0', '100', '1', '1557042574', '1557042574', '0');
INSERT INTO `ey_channelfield` VALUES ('59', 'prom_type', '2', '产品类型：0普通产品，1虚拟产品', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1557042574', '1557042574', '0');
INSERT INTO `ey_channelfield` VALUES ('60', 'users_price', '2', '价格', 'decimal', 'decimal(10,2)', '10', '0.00', '', '', '0', '0', '1', '0', '1', '1', '0', '100', '1', '1557042574', '1557042574', '0');
INSERT INTO `ey_channelfield` VALUES ('61', 'users_id', '0', '会员ID', 'int', 'int(11)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1557042574', '1557042574', '0');
INSERT INTO `ey_channelfield` VALUES ('62', 'arc_level_id', '0', '文档会员权限ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1557042574', '1557042574', '0');
INSERT INTO `ey_channelfield` VALUES ('63', 'arc_level_id', '4', '文档会员权限ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1557042574', '1557042574', '0');
INSERT INTO `ey_channelfield` VALUES ('64', 'weapp_code', '-99', '插件栏目唯一标识', 'text', 'varchar(200)', '200', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1557042574', '1557042574', '0');
INSERT INTO `ey_channelfield` VALUES ('65', 'is_release', '-99', '栏目是否应用于会员投稿发布，1是，0否', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1557042574', '1557042574', '0');
INSERT INTO `ey_channelfield` VALUES ('66', 'old_price', '0', '产品旧价', 'decimal', 'decimal(10,2)', '10', '0.00', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1557042574', '1557042574', '0');
INSERT INTO `ey_channelfield` VALUES ('67', 'stock_count', '0', '商品库存量', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1557042574', '1557042574', '0');
INSERT INTO `ey_channelfield` VALUES ('68', 'stock_show', '0', '商品库存在产品详情页是否显示，1为显示，0为不显示', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1557042574', '1557042574', '0');
INSERT INTO `ey_channelfield` VALUES ('69', 'joinaid', '0', '关联文档ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1557042574', '1557042574', '0');
INSERT INTO `ey_channelfield` VALUES ('70', 'downcount', '0', '下载次数', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1557042574', '1557042574', '0');
INSERT INTO `ey_channelfield` VALUES ('71', 'downcount', '4', '下载次数', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1557042574', '1557042574', '0');
INSERT INTO `ey_channelfield` VALUES ('72', 'htmlfilename', '0', '自定义文件名', 'text', 'varchar(50)', '50', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1557042574', '1557042574', '0');
INSERT INTO `ey_channelfield` VALUES ('73', 'htmlfilename', '1', '自定义文件名', 'text', 'varchar(50)', '50', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1557042574', '1557042574', '0');
INSERT INTO `ey_channelfield` VALUES ('74', 'htmlfilename', '2', '自定义文件名', 'text', 'varchar(50)', '50', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1557042574', '1557042574', '0');
INSERT INTO `ey_channelfield` VALUES ('75', 'htmlfilename', '3', '自定义文件名', 'text', 'varchar(50)', '50', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1557042574', '1557042574', '0');
INSERT INTO `ey_channelfield` VALUES ('76', 'htmlfilename', '4', '自定义文件名', 'text', 'varchar(50)', '50', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1557042574', '1557042574', '0');
INSERT INTO `ey_channelfield` VALUES ('77', 'htmlfilename', '6', '自定义文件名', 'text', 'varchar(50)', '50', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1557042574', '1557042574', '0');
INSERT INTO `ey_channelfield` VALUES ('78', 'attrlist_id', '0', '参数列表ID', 'int', 'int(10) unsigned', '10', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533091930', '1533091930', '0');
INSERT INTO `ey_channelfield` VALUES ('79', 'sales_num', '0', '销售量', 'int', 'int(10) unsigned', '10', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533091930', '1533091930', '0');
INSERT INTO `ey_channelfield` VALUES ('81', 'topid', '-99', '顶级栏目ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1557042574', '1557042574', '0');
INSERT INTO `ey_channelfield` VALUES ('82', 'is_slide', '0', '是否幻灯', 'switch', 'tinyint(1)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533092420', '1533092420', '0');
INSERT INTO `ey_channelfield` VALUES ('83', 'is_roll', '0', '是否幻灯', 'switch', 'tinyint(1)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533092420', '1533092420', '0');
INSERT INTO `ey_channelfield` VALUES ('84', 'is_diyattr', '0', '是否自定义', 'switch', 'tinyint(1)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533092420', '1533092420', '0');
INSERT INTO `ey_channelfield` VALUES ('85', 'update_time', '5', '更新时间', 'datetime', 'int(11)', '11', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('86', 'add_time', '5', '新增时间', 'datetime', 'int(11)', '11', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('87', 'htmlfilename', '5', '自定义文件名', 'text', 'varchar(50)', '50', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('88', 'downcount', '5', '下载次数', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('89', 'joinaid', '5', '关联文档ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('90', 'del_method', '5', '伪删除状态，1为主动删除，2为跟随上级栏目被动删除', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('91', 'is_del', '5', '伪删除，1=是，0=否', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('92', 'arc_level_id', '5', '文档会员权限ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('93', 'users_id', '5', '会员ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('94', 'admin_id', '5', '管理员ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('95', 'lang', '5', '语言标识', 'text', 'varchar(50)', '50', 'cn', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('96', 'sort_order', '5', '排序号', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('97', 'status', '5', '状态(0=屏蔽，1=正常)', 'switch', 'tinyint(1)', '1', '1', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('98', 'tempview', '5', '文档模板文件名', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('99', 'prom_type', '5', '产品类型：0=普通产品，1=虚拟(默认手动发货)，2=虚拟(网盘', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('100', 'stock_show', '5', '商品库存在产品详情页是否显示，1为显示，0为不显示', 'switch', 'tinyint(1) unsigned', '1', '1', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('101', 'stock_count', '5', '商品库存量', 'int', 'int(10) unsigned', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('102', 'sales_num', '5', '销售量', 'int', 'int(10) unsigned', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('103', 'old_price', '5', '产品旧价', 'decimal', 'decimal(10,2)', '10', '0.00', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('104', 'users_free', '5', '是否会员免费，默认0不免费，1为免费', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('105', 'users_price', '5', '会员价', 'decimal', 'decimal(10,2)', '10', '0.00', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('106', 'attrlist_id', '5', '参数列表ID', 'int', 'int(10) unsigned', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('107', 'seo_description', '5', 'SEO描述', 'multitext', 'text', '0', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('108', 'seo_keywords', '5', 'SEO关键词', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('109', 'seo_title', '5', 'SEO标题', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('110', 'ismake', '5', '是否静态页面（0=动态，1=静态）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('111', 'jumplinks', '5', '外链跳转', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('112', 'arcrank', '5', '阅读权限：0=开放浏览，-1=待审核稿件', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('113', 'click', '5', '浏览量', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('114', 'author', '5', '作者', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('115', 'is_diyattr', '5', '自定义（0=否，1=是）', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('116', 'is_slide', '5', '幻灯（0=否，1=是）', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('117', 'is_roll', '5', '滚动（0=否，1=是）', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('118', 'is_litpic', '5', '图片（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('119', 'is_jump', '5', '跳转链接（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('120', 'is_recom', '5', '推荐（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('121', 'is_top', '5', '置顶（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('122', 'is_special', '5', '特荐（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('123', 'is_head', '5', '头条（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('124', 'litpic', '5', '缩略图', 'img', 'varchar(250)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('125', 'title', '5', '标题', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('126', 'is_b', '5', '加粗', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('127', 'channel', '5', '模型ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('128', 'typeid', '5', '当前栏目', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('129', 'aid', '5', 'aid', 'int', 'int(10)', '10', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('130', 'content', '5', '内容详情', 'htmltext', 'longtext', '0', '', '', '', '0', '1', '1', '0', '1', '0', '0', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('131', 'courseware', '5', '课件地址', 'text', 'varchar(200)', '200', '', '', '', '0', '1', '0', '0', '1', '0', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('132', 'courseware_free', '5', '课件收费', 'select', 'enum(\'免费\',\'收费\')', '0', '免费,收费', '', '', '0', '1', '0', '0', '1', '0', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('133', 'total_duration', '5', '视频总时长', 'int', 'int(10)', '10', '0', '', '', '0', '1', '0', '0', '1', '0', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('134', 'total_video', '5', '视频数', 'int', 'int(10)', '10', '0', '', '', '0', '1', '0', '0', '1', '0', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('135', 'update_time', '7', '更新时间', 'datetime', 'int(11)', '11', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('136', 'add_time', '7', '新增时间', 'datetime', 'int(11)', '11', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('137', 'htmlfilename', '7', '自定义文件名', 'text', 'varchar(50)', '50', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('138', 'downcount', '7', '下载次数', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('139', 'joinaid', '7', '关联文档ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('140', 'del_method', '7', '伪删除状态，1为主动删除，2为跟随上级栏目被动删除', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('141', 'is_del', '7', '伪删除，1=是，0=否', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('142', 'arc_level_id', '7', '文档会员权限ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('143', 'users_id', '7', '会员ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('144', 'admin_id', '7', '管理员ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('145', 'lang', '7', '语言标识', 'text', 'varchar(50)', '50', 'cn', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('146', 'sort_order', '7', '排序号', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('147', 'status', '7', '状态(0=屏蔽，1=正常)', 'switch', 'tinyint(1)', '1', '1', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('148', 'tempview', '7', '文档模板文件名', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('149', 'prom_type', '7', '产品类型：0=普通产品，1=虚拟(默认手动发货)，2=虚拟(网盘', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('150', 'stock_show', '7', '商品库存在产品详情页是否显示，1为显示，0为不显示', 'switch', 'tinyint(1) unsigned', '1', '1', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('151', 'stock_count', '7', '商品库存量', 'int', 'int(10) unsigned', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('152', 'sales_num', '7', '销售量', 'int', 'int(10) unsigned', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('153', 'old_price', '7', '产品旧价', 'decimal', 'decimal(10,2)', '10', '0.00', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('154', 'users_free', '7', '是否会员免费，默认0不免费，1为免费', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('155', 'users_price', '7', '会员价', 'decimal', 'decimal(10,2)', '10', '0.00', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('156', 'attrlist_id', '7', '参数列表ID', 'int', 'int(10) unsigned', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('157', 'seo_description', '7', 'SEO描述', 'multitext', 'text', '0', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('158', 'seo_keywords', '7', 'SEO关键词', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('159', 'seo_title', '7', 'SEO标题', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('160', 'ismake', '7', '是否静态页面（0=动态，1=静态）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('161', 'jumplinks', '7', '外链跳转', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('162', 'arcrank', '7', '阅读权限：0=开放浏览，-1=待审核稿件', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('163', 'click', '7', '浏览量', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('164', 'author', '7', '作者', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('165', 'is_diyattr', '7', '自定义（0=否，1=是）', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('166', 'is_slide', '7', '幻灯（0=否，1=是）', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('167', 'is_roll', '7', '滚动（0=否，1=是）', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('168', 'is_litpic', '7', '图片（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('169', 'is_jump', '7', '跳转链接（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('170', 'is_recom', '7', '推荐（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('171', 'is_top', '7', '置顶（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('172', 'is_special', '7', '特荐（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('173', 'is_head', '7', '头条（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('174', 'litpic', '7', '缩略图', 'img', 'varchar(250)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('175', 'title', '7', '标题', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('176', 'is_b', '7', '加粗', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('177', 'channel', '7', '模型ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('178', 'typeid', '7', '当前栏目', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('179', 'aid', '7', 'aid', 'int', 'int(10)', '10', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('180', 'content', '7', '内容详情', 'htmltext', 'longtext', '0', '', '', '', '0', '1', '1', '0', '1', '0', '0', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('181', 'restric_type', '0', '限制模式，0=免费，1=付费，2=会员专享，3=会员付费', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1616293251', '1616293251', '0');
INSERT INTO `ey_channelfield` VALUES ('182', 'diy_dirpath', '-99', '自定义HTML保存路径', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('183', 'rulelist', '-99', '列表静态文件存放规则', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('184', 'ruleview', '-99', '文档静态文件存放规则', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('185', 'subtitle', '0', '副标题', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1636338535', '1636338535', '0');
INSERT INTO `ey_channelfield` VALUES ('186', 'origin', '0', '来源', 'text', 'varchar(30)', '30', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1636338535', '1636338535', '0');
INSERT INTO `ey_channelfield` VALUES ('187', 'stypeid', '0', '副栏目', 'text', 'varchar(90)', '90', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1636338535', '1636338535', '0');
INSERT INTO `ey_channelfield` VALUES ('188', 'update_time', '1', '更新时间', 'datetime', 'int(11)', '11', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('189', 'add_time', '1', '新增时间', 'datetime', 'int(11)', '11', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('190', 'area_id', '1', '所在区域', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('191', 'city_id', '1', '所在城市', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('192', 'province_id', '1', '省份', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('193', 'collection', '1', '收藏数', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('194', 'appraise', '1', '评价数', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('195', 'downcount', '1', '下载次数', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('196', 'joinaid', '1', '关联文档ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('197', 'del_method', '1', '伪删除状态，1为主动删除，2为跟随上级栏目被动删除', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('198', 'is_del', '1', '伪删除，1=是，0=否', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('199', 'restric_type', '1', '限制模式，0=免费，1=付费，2=会员专享，3=会员付费', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('200', 'arc_level_id', '1', '文档会员权限ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('201', 'users_id', '1', '会员ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('202', 'admin_id', '1', '管理员ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('203', 'lang', '1', '语言标识', 'text', 'varchar(50)', '50', 'cn', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('204', 'sort_order', '1', '排序号', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('205', 'status', '1', '状态(0=屏蔽，1=正常)', 'switch', 'tinyint(1)', '1', '1', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('206', 'tempview', '1', '文档模板文件名', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('207', 'prom_type', '1', '产品类型：0=普通产品，1=虚拟(默认手动发货)，2=虚拟(网盘)，3=虚拟(自定义文本)', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('208', 'stock_show', '1', '商品库存在产品详情页是否显示，1为显示，0为不显示', 'switch', 'tinyint(1) unsigned', '1', '1', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('209', 'stock_count', '1', '商品库存量', 'int', 'int(10) unsigned', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('210', 'sales_num', '1', '销售量', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('211', 'old_price', '1', '产品旧价', 'decimal', 'decimal(10,2)', '10', '0.00', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('212', 'users_free', '1', '是否会员免费，默认0不免费，1为免费', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('213', 'users_price', '1', '会员价', 'decimal', 'decimal(10,2)', '10', '0.00', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('214', 'attrlist_id', '1', '参数列表ID', 'int', 'int(10) unsigned', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('215', 'seo_description', '1', 'SEO描述', 'multitext', 'text', '0', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('216', 'seo_keywords', '1', 'SEO关键词', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('217', 'seo_title', '1', 'SEO标题', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('218', 'ismake', '1', '是否静态页面（0=动态，1=静态）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('219', 'jumplinks', '1', '外链跳转', 'text', 'varchar(255)', '255', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('220', 'arcrank', '1', '阅读权限：0=开放浏览，-1=待审核稿件', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('221', 'click', '1', '浏览量', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('222', 'author', '1', '作者', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('223', 'origin', '1', '来源', 'text', 'varchar(30)', '30', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('224', 'is_diyattr', '1', '自定义（0=否，1=是）', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('225', 'is_slide', '1', '幻灯（0=否，1=是）', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('226', 'is_roll', '1', '滚动（0=否，1=是）', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('227', 'is_litpic', '1', '图片（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('228', 'is_jump', '1', '跳转链接（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('229', 'is_recom', '1', '推荐（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('230', 'is_top', '1', '置顶（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('231', 'is_special', '1', '特荐（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('232', 'is_head', '1', '头条（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('233', 'litpic', '1', '缩略图', 'img', 'varchar(250)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('234', 'subtitle', '1', '副标题', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('235', 'title', '1', '标题', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('236', 'is_b', '1', '加粗', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('237', 'channel', '1', '模型ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('238', 'stypeid', '1', '副栏目ID集合', 'text', 'varchar(90)', '90', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('239', 'typeid', '1', '当前栏目', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('240', 'aid', '1', 'aid', 'int', 'int(10)', '10', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862075', '1641862075', '0');
INSERT INTO `ey_channelfield` VALUES ('241', 'update_time', '2', '更新时间', 'datetime', 'int(11)', '11', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('242', 'add_time', '2', '新增时间', 'datetime', 'int(11)', '11', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('243', 'area_id', '2', '所在区域', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('244', 'city_id', '2', '所在城市', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('245', 'province_id', '2', '省份', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('246', 'collection', '2', '收藏数', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('247', 'appraise', '2', '评价数', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('248', 'downcount', '2', '下载次数', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('249', 'joinaid', '2', '关联文档ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('250', 'del_method', '2', '伪删除状态，1为主动删除，2为跟随上级栏目被动删除', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('251', 'is_del', '2', '伪删除，1=是，0=否', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('252', 'restric_type', '2', '限制模式，0=免费，1=付费，2=会员专享，3=会员付费', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('253', 'arc_level_id', '2', '文档会员权限ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('254', 'users_id', '2', '会员ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('255', 'admin_id', '2', '管理员ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('256', 'lang', '2', '语言标识', 'text', 'varchar(50)', '50', 'cn', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('257', 'sort_order', '2', '排序号', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('258', 'status', '2', '状态(0=屏蔽，1=正常)', 'switch', 'tinyint(1)', '1', '1', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('259', 'tempview', '2', '文档模板文件名', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('260', 'stock_show', '2', '商品库存在产品详情页是否显示，1为显示，0为不显示', 'switch', 'tinyint(1) unsigned', '1', '1', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('261', 'stock_count', '2', '商品库存量', 'int', 'int(10) unsigned', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('262', 'sales_num', '2', '销售量', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('263', 'old_price', '2', '产品旧价', 'decimal', 'decimal(10,2)', '10', '0.00', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('264', 'users_free', '2', '是否会员免费，默认0不免费，1为免费', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('265', 'attrlist_id', '2', '参数列表ID', 'int', 'int(10) unsigned', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('266', 'seo_description', '2', 'SEO描述', 'multitext', 'text', '0', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('267', 'seo_keywords', '2', 'SEO关键词', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('268', 'seo_title', '2', 'SEO标题', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('269', 'ismake', '2', '是否静态页面（0=动态，1=静态）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('270', 'jumplinks', '2', '外链跳转', 'text', 'varchar(255)', '255', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('271', 'arcrank', '2', '阅读权限：0=开放浏览，-1=待审核稿件', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('272', 'click', '2', '浏览量', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('273', 'author', '2', '作者', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('274', 'origin', '2', '来源', 'text', 'varchar(30)', '30', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('275', 'is_diyattr', '2', '自定义（0=否，1=是）', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('276', 'is_slide', '2', '幻灯（0=否，1=是）', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('277', 'is_roll', '2', '滚动（0=否，1=是）', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('278', 'is_litpic', '2', '图片（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('279', 'is_jump', '2', '跳转链接（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('280', 'is_recom', '2', '推荐（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('281', 'is_top', '2', '置顶（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('282', 'is_special', '2', '特荐（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('283', 'is_head', '2', '头条（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('284', 'litpic', '2', '缩略图', 'img', 'varchar(250)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('285', 'subtitle', '2', '副标题', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('286', 'title', '2', '标题', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('287', 'is_b', '2', '加粗', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('288', 'channel', '2', '模型ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('289', 'stypeid', '2', '副栏目ID集合', 'text', 'varchar(90)', '90', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('290', 'typeid', '2', '当前栏目', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('291', 'aid', '2', 'aid', 'int', 'int(10)', '10', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862078', '1641862078', '0');
INSERT INTO `ey_channelfield` VALUES ('292', 'update_time', '3', '更新时间', 'datetime', 'int(11)', '11', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('293', 'add_time', '3', '新增时间', 'datetime', 'int(11)', '11', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('294', 'area_id', '3', '所在区域', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('295', 'city_id', '3', '所在城市', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('296', 'province_id', '3', '省份', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('297', 'collection', '3', '收藏数', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('298', 'appraise', '3', '评价数', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('299', 'downcount', '3', '下载次数', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('300', 'joinaid', '3', '关联文档ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('301', 'del_method', '3', '伪删除状态，1为主动删除，2为跟随上级栏目被动删除', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('302', 'is_del', '3', '伪删除，1=是，0=否', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('303', 'restric_type', '3', '限制模式，0=免费，1=付费，2=会员专享，3=会员付费', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('304', 'arc_level_id', '3', '文档会员权限ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('305', 'users_id', '3', '会员ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('306', 'admin_id', '3', '管理员ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('307', 'lang', '3', '语言标识', 'text', 'varchar(50)', '50', 'cn', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('308', 'sort_order', '3', '排序号', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('309', 'status', '3', '状态(0=屏蔽，1=正常)', 'switch', 'tinyint(1)', '1', '1', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('310', 'tempview', '3', '文档模板文件名', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('311', 'prom_type', '3', '产品类型：0=普通产品，1=虚拟(默认手动发货)，2=虚拟(网盘)，3=虚拟(自定义文本)', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('312', 'stock_show', '3', '商品库存在产品详情页是否显示，1为显示，0为不显示', 'switch', 'tinyint(1) unsigned', '1', '1', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('313', 'stock_count', '3', '商品库存量', 'int', 'int(10) unsigned', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('314', 'sales_num', '3', '销售量', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('315', 'old_price', '3', '产品旧价', 'decimal', 'decimal(10,2)', '10', '0.00', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('316', 'users_free', '3', '是否会员免费，默认0不免费，1为免费', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('317', 'users_price', '3', '会员价', 'decimal', 'decimal(10,2)', '10', '0.00', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('318', 'attrlist_id', '3', '参数列表ID', 'int', 'int(10) unsigned', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('319', 'seo_description', '3', 'SEO描述', 'multitext', 'text', '0', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('320', 'seo_keywords', '3', 'SEO关键词', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('321', 'seo_title', '3', 'SEO标题', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('322', 'ismake', '3', '是否静态页面（0=动态，1=静态）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('323', 'jumplinks', '3', '外链跳转', 'text', 'varchar(255)', '255', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('324', 'arcrank', '3', '阅读权限：0=开放浏览，-1=待审核稿件', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('325', 'click', '3', '浏览量', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('326', 'author', '3', '作者', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('327', 'origin', '3', '来源', 'text', 'varchar(30)', '30', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('328', 'is_diyattr', '3', '自定义（0=否，1=是）', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('329', 'is_slide', '3', '幻灯（0=否，1=是）', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('330', 'is_roll', '3', '滚动（0=否，1=是）', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('331', 'is_litpic', '3', '图片（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('332', 'is_jump', '3', '跳转链接（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('333', 'is_recom', '3', '推荐（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('334', 'is_top', '3', '置顶（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('335', 'is_special', '3', '特荐（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('336', 'is_head', '3', '头条（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('337', 'litpic', '3', '缩略图', 'img', 'varchar(250)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('338', 'subtitle', '3', '副标题', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('339', 'title', '3', '标题', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('340', 'is_b', '3', '加粗', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('341', 'channel', '3', '模型ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('342', 'stypeid', '3', '副栏目ID集合', 'text', 'varchar(90)', '90', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('343', 'typeid', '3', '当前栏目', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('344', 'aid', '3', 'aid', 'int', 'int(10)', '10', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862080', '1641862080', '0');
INSERT INTO `ey_channelfield` VALUES ('345', 'update_time', '4', '更新时间', 'datetime', 'int(11)', '11', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('346', 'add_time', '4', '新增时间', 'datetime', 'int(11)', '11', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('347', 'area_id', '4', '所在区域', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('348', 'city_id', '4', '所在城市', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('349', 'province_id', '4', '省份', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('350', 'collection', '4', '收藏数', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('351', 'appraise', '4', '评价数', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('352', 'joinaid', '4', '关联文档ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('353', 'del_method', '4', '伪删除状态，1为主动删除，2为跟随上级栏目被动删除', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('354', 'is_del', '4', '伪删除，1=是，0=否', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('355', 'restric_type', '4', '限制模式，0=免费，1=付费，2=会员专享，3=会员付费', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('356', 'users_id', '4', '会员ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('357', 'admin_id', '4', '管理员ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('358', 'lang', '4', '语言标识', 'text', 'varchar(50)', '50', 'cn', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('359', 'sort_order', '4', '排序号', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('360', 'status', '4', '状态(0=屏蔽，1=正常)', 'switch', 'tinyint(1)', '1', '1', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('361', 'tempview', '4', '文档模板文件名', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('362', 'prom_type', '4', '产品类型：0=普通产品，1=虚拟(默认手动发货)，2=虚拟(网盘)，3=虚拟(自定义文本)', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('363', 'stock_show', '4', '商品库存在产品详情页是否显示，1为显示，0为不显示', 'switch', 'tinyint(1) unsigned', '1', '1', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('364', 'stock_count', '4', '商品库存量', 'int', 'int(10) unsigned', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('365', 'sales_num', '4', '销售量', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('366', 'old_price', '4', '产品旧价', 'decimal', 'decimal(10,2)', '10', '0.00', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('367', 'users_free', '4', '是否会员免费，默认0不免费，1为免费', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('368', 'users_price', '4', '会员价', 'decimal', 'decimal(10,2)', '10', '0.00', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('369', 'attrlist_id', '4', '参数列表ID', 'int', 'int(10) unsigned', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('370', 'seo_description', '4', 'SEO描述', 'multitext', 'text', '0', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('371', 'seo_keywords', '4', 'SEO关键词', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('372', 'seo_title', '4', 'SEO标题', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('373', 'ismake', '4', '是否静态页面（0=动态，1=静态）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('374', 'jumplinks', '4', '外链跳转', 'text', 'varchar(255)', '255', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('375', 'arcrank', '4', '阅读权限：0=开放浏览，-1=待审核稿件', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('376', 'click', '4', '浏览量', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('377', 'author', '4', '作者', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('378', 'origin', '4', '来源', 'text', 'varchar(30)', '30', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('379', 'is_diyattr', '4', '自定义（0=否，1=是）', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('380', 'is_slide', '4', '幻灯（0=否，1=是）', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('381', 'is_roll', '4', '滚动（0=否，1=是）', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('382', 'is_litpic', '4', '图片（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('383', 'is_jump', '4', '跳转链接（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('384', 'is_recom', '4', '推荐（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('385', 'is_top', '4', '置顶（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('386', 'is_special', '4', '特荐（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('387', 'is_head', '4', '头条（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('388', 'litpic', '4', '缩略图', 'img', 'varchar(250)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('389', 'subtitle', '4', '副标题', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('390', 'title', '4', '标题', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('391', 'is_b', '4', '加粗', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('392', 'channel', '4', '模型ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('393', 'stypeid', '4', '副栏目ID集合', 'text', 'varchar(90)', '90', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('394', 'typeid', '4', '当前栏目', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('395', 'aid', '4', 'aid', 'int', 'int(10)', '10', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862083', '1641862083', '0');
INSERT INTO `ey_channelfield` VALUES ('396', 'update_time', '6', '更新时间', 'datetime', 'int(11)', '11', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('397', 'add_time', '6', '新增时间', 'datetime', 'int(11)', '11', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('398', 'area_id', '6', '所在区域', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('399', 'city_id', '6', '所在城市', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('400', 'province_id', '6', '省份', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('401', 'collection', '6', '收藏数', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('402', 'appraise', '6', '评价数', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('403', 'downcount', '6', '下载次数', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('404', 'joinaid', '6', '关联文档ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('405', 'del_method', '6', '伪删除状态，1为主动删除，2为跟随上级栏目被动删除', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('406', 'is_del', '6', '伪删除，1=是，0=否', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('407', 'restric_type', '6', '限制模式，0=免费，1=付费，2=会员专享，3=会员付费', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('408', 'arc_level_id', '6', '文档会员权限ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('409', 'users_id', '6', '会员ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('410', 'admin_id', '6', '管理员ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('411', 'lang', '6', '语言标识', 'text', 'varchar(50)', '50', 'cn', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('412', 'sort_order', '6', '排序号', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('413', 'status', '6', '状态(0=屏蔽，1=正常)', 'switch', 'tinyint(1)', '1', '1', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('414', 'tempview', '6', '文档模板文件名', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('415', 'prom_type', '6', '产品类型：0=普通产品，1=虚拟(默认手动发货)，2=虚拟(网盘)，3=虚拟(自定义文本)', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('416', 'stock_show', '6', '商品库存在产品详情页是否显示，1为显示，0为不显示', 'switch', 'tinyint(1) unsigned', '1', '1', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('417', 'stock_count', '6', '商品库存量', 'int', 'int(10) unsigned', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('418', 'sales_num', '6', '销售量', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('419', 'old_price', '6', '产品旧价', 'decimal', 'decimal(10,2)', '10', '0.00', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('420', 'users_free', '6', '是否会员免费，默认0不免费，1为免费', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('421', 'users_price', '6', '会员价', 'decimal', 'decimal(10,2)', '10', '0.00', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('422', 'attrlist_id', '6', '参数列表ID', 'int', 'int(10) unsigned', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('423', 'seo_description', '6', 'SEO描述', 'multitext', 'text', '0', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('424', 'seo_keywords', '6', 'SEO关键词', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('425', 'seo_title', '6', 'SEO标题', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('426', 'ismake', '6', '是否静态页面（0=动态，1=静态）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('427', 'jumplinks', '6', '外链跳转', 'text', 'varchar(255)', '255', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('428', 'arcrank', '6', '阅读权限：0=开放浏览，-1=待审核稿件', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('429', 'click', '6', '浏览量', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('430', 'author', '6', '作者', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('431', 'origin', '6', '来源', 'text', 'varchar(30)', '30', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('432', 'is_diyattr', '6', '自定义（0=否，1=是）', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('433', 'is_slide', '6', '幻灯（0=否，1=是）', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('434', 'is_roll', '6', '滚动（0=否，1=是）', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('435', 'is_litpic', '6', '图片（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('436', 'is_jump', '6', '跳转链接（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('437', 'is_recom', '6', '推荐（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('438', 'is_top', '6', '置顶（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('439', 'is_special', '6', '特荐（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('440', 'is_head', '6', '头条（0=否，1=是）', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('441', 'litpic', '6', '缩略图', 'img', 'varchar(250)', '250', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('442', 'subtitle', '6', '副标题', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('443', 'title', '6', '标题', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('444', 'is_b', '6', '加粗', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('445', 'channel', '6', '模型ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('446', 'stypeid', '6', '副栏目ID集合', 'text', 'varchar(90)', '90', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('447', 'typeid', '6', '当前栏目', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('448', 'aid', '6', 'aid', 'int', 'int(10)', '10', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862087', '1641862087', '0');
INSERT INTO `ey_channelfield` VALUES ('449', 'area_id', '7', '所在区域', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862089', '1641862089', '0');
INSERT INTO `ey_channelfield` VALUES ('450', 'city_id', '7', '所在城市', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862089', '1641862089', '0');
INSERT INTO `ey_channelfield` VALUES ('451', 'province_id', '7', '省份', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862089', '1641862089', '0');
INSERT INTO `ey_channelfield` VALUES ('452', 'collection', '7', '收藏数', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862089', '1641862089', '0');
INSERT INTO `ey_channelfield` VALUES ('453', 'appraise', '7', '评价数', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862089', '1641862089', '0');
INSERT INTO `ey_channelfield` VALUES ('454', 'restric_type', '7', '限制模式，0=免费，1=付费，2=会员专享，3=会员付费', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862089', '1641862089', '0');
INSERT INTO `ey_channelfield` VALUES ('455', 'origin', '7', '来源', 'text', 'varchar(30)', '30', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862089', '1641862089', '0');
INSERT INTO `ey_channelfield` VALUES ('456', 'subtitle', '7', '副标题', 'text', 'varchar(200)', '200', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862089', '1641862089', '0');
INSERT INTO `ey_channelfield` VALUES ('457', 'stypeid', '7', '副栏目ID集合', 'text', 'varchar(90)', '90', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862089', '1641862089', '0');
INSERT INTO `ey_channelfield` VALUES ('458', 'lang', '-99', '语言标识', 'text', 'varchar(50)', '50', 'cn', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862097', '1641862097', '0');
INSERT INTO `ey_channelfield` VALUES ('459', 'is_del', '-99', '伪删除，1=是，0=否', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862097', '1641862097', '0');
INSERT INTO `ey_channelfield` VALUES ('460', 'admin_id', '-99', '管理员ID', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1641862097', '1641862097', '0');
INSERT INTO `ey_channelfield` VALUES ('461', 'target', '-99', '新窗口打开', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1547890773', '1547890773', '0');
INSERT INTO `ey_channelfield` VALUES ('462', 'nofollow', '-99', '防抓取', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1547890773', '1547890773', '0');
INSERT INTO `ey_channelfield` VALUES ('463', 'content_ey_m', '1', '手机端内容详情', 'htmltext', 'longtext', '250', '', '', '', '0', '1', '1', '0', '1', '0', '0', '100', '1', '1533464713', '1623047123', '0');
INSERT INTO `ey_channelfield` VALUES ('464', 'content_ey_m', '2', '手机端内容详情', 'htmltext', 'longtext', '250', '', '', '', '0', '1', '1', '0', '1', '0', '0', '100', '1', '1645086030', '1645086039', '0');
INSERT INTO `ey_channelfield` VALUES ('465', 'content_ey_m', '3', '手机端内容详情', 'htmltext', 'longtext', '250', '', '', '', '0', '1', '1', '0', '1', '0', '0', '100', '1', '1533359588', '1533359588', '0');
INSERT INTO `ey_channelfield` VALUES ('466', 'content_ey_m', '4', '手机端内容详情', 'htmltext', 'longtext', '250', '', '', '', '0', '1', '1', '0', '1', '0', '0', '100', '1', '1533359752', '1533359752', '0');
INSERT INTO `ey_channelfield` VALUES ('467', 'content_ey_m', '5', '手机端内容详情', 'htmltext', 'longtext', '250', '', '', '', '0', '1', '1', '0', '1', '0', '0', '100', '1', '1591957363', '1591957363', '0');
INSERT INTO `ey_channelfield` VALUES ('468', 'content_ey_m', '6', '手机端内容详情', 'htmltext', 'longtext', '250', '', '', '', '0', '1', '1', '0', '1', '0', '0', '100', '1', '1533464715', '1533464715', '0');
INSERT INTO `ey_channelfield` VALUES ('469', 'content_ey_m', '7', '手机端内容详情', 'htmltext', 'longtext', '250', '', '', '', '0', '1', '1', '0', '1', '0', '0', '100', '1', '1602320145', '1602320145', '0');
INSERT INTO `ey_channelfield` VALUES ('470', 'typearcrank', '-99', '阅读权限：0=开放浏览，-1=待审核稿件', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1547890773', '1547890773', '0');
INSERT INTO `ey_channelfield` VALUES ('471', 'empty_logic', '-99', '空内容逻辑', 'switch', 'tinyint(1)', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1533524780', '1533524780', '0');
INSERT INTO `ey_channelfield` VALUES ('472', 'users_discount_type', '0', '产品会员折扣类型(0:系统默认折扣; 1:指定会员级别; 2:不参与折扣;)', 'switch', 'tinyint(1) unsigned', '1', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1683873488', '1683873488', '0');
INSERT INTO `ey_channelfield` VALUES ('473', 'logistics_type', '0', '商品物流支持类型(1: 物流配送; 2: 到店核销)', 'text', 'varchar(100)', '100', '', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1690364521', '1690364521', '0');
INSERT INTO `ey_channelfield` VALUES ('474', 'total_arc', '-99', '栏目下文档数量', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1711942240', '1711942240', '0');
INSERT INTO `ey_channelfield` VALUES ('475', 'removal_time', '1', '下架时间', 'datetime', 'int(11)', '11', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1574233796', '1574233796', '0');
INSERT INTO `ey_channelfield` VALUES ('476', 'removal_time', '2', '下架时间', 'datetime', 'int(11)', '11', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1574233796', '1574233796', '0');
INSERT INTO `ey_channelfield` VALUES ('477', 'removal_time', '3', '下架时间', 'datetime', 'int(11)', '11', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1574233796', '1574233796', '0');
INSERT INTO `ey_channelfield` VALUES ('478', 'removal_time', '4', '下架时间', 'datetime', 'int(11)', '11', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1574233796', '1574233796', '0');
INSERT INTO `ey_channelfield` VALUES ('479', 'removal_time', '5', '下架时间', 'datetime', 'int(11)', '11', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1574233796', '1574233796', '0');
INSERT INTO `ey_channelfield` VALUES ('480', 'removal_time', '6', '下架时间', 'datetime', 'int(11)', '11', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1574233796', '1574233796', '0');
INSERT INTO `ey_channelfield` VALUES ('481', 'removal_time', '7', '下架时间', 'datetime', 'int(11)', '11', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1574233796', '1574233796', '0');
INSERT INTO `ey_channelfield` VALUES ('482', 'removal_time', '0', '下架时间', 'datetime', 'int(11)', '11', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1574233796', '1574233796', '0');
INSERT INTO `ey_channelfield` VALUES ('483', 'youtube_url', '1', 'YouTube URL', 'text', '', '500', '', '', 'Paste a full YouTube link.', '0', '0', '1', '1', '0', '0', '1', '120', '1', '1778583243', '1778583243', '0');

-- -----------------------------
-- Table structure for `ey_channelfield_bind`
-- -----------------------------
DROP TABLE IF EXISTS `ey_channelfield_bind`;
CREATE TABLE `ey_channelfield_bind` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `typeid` int DEFAULT '0' COMMENT '栏目ID',
  `field_id` int DEFAULT '0' COMMENT '自定义字段ID',
  `add_time` int DEFAULT '0' COMMENT '新增时间',
  `update_time` int DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3 COMMENT='栏目与自定义字段绑定表';

-- -----------------------------
-- Records of `ey_channelfield_bind`
-- -----------------------------
INSERT INTO `ey_channelfield_bind` VALUES ('1', '0', '24', '1641862075', '1641862075');
INSERT INTO `ey_channelfield_bind` VALUES ('2', '0', '25', '1641862075', '1641862075');
INSERT INTO `ey_channelfield_bind` VALUES ('3', '0', '26', '1641862075', '1641862075');
INSERT INTO `ey_channelfield_bind` VALUES ('4', '0', '27', '1641862075', '1641862075');
INSERT INTO `ey_channelfield_bind` VALUES ('5', '0', '29', '1641862075', '1641862075');
INSERT INTO `ey_channelfield_bind` VALUES ('6', '0', '130', '1641862075', '1641862075');
INSERT INTO `ey_channelfield_bind` VALUES ('7', '0', '131', '1641862075', '1641862075');
INSERT INTO `ey_channelfield_bind` VALUES ('8', '0', '132', '1641862075', '1641862075');
INSERT INTO `ey_channelfield_bind` VALUES ('9', '0', '133', '1641862075', '1641862075');
INSERT INTO `ey_channelfield_bind` VALUES ('10', '0', '134', '1641862075', '1641862075');
INSERT INTO `ey_channelfield_bind` VALUES ('11', '0', '180', '1641862075', '1641862075');
