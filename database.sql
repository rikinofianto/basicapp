/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 10.1.21-MariaDB : Database - yii2basic
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`yii2basic` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `yii2basic`;

/*Table structure for table `allowed` */

DROP TABLE IF EXISTS `allowed`;

CREATE TABLE `allowed` (
  `allowed` varchar(255) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `allowed` */

insert  into `allowed`(`allowed`) values ('admin/asset/clear-asset'),('site/error'),('site/index'),('site/login'),('site/logout'),('site/contact'),('site/about');

/*Table structure for table `audit_trail` */

DROP TABLE IF EXISTS `audit_trail`;

CREATE TABLE `audit_trail` (
  `audit_trail_id` int(11) NOT NULL AUTO_INCREMENT,
  `old_value` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `new_value` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `action` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `field` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `stamp` datetime NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `ip_address` varchar(32) CHARACTER SET latin1 DEFAULT NULL,
  `url_referer` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `browser` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `model_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`audit_trail_id`),
  KEY `idx_audit_trail_user_id` (`user_id`),
  KEY `idx_audit_trail_model_id` (`model_id`),
  KEY `idx_audit_trail_model` (`model`),
  KEY `idx_audit_trail_field` (`field`),
  KEY `idx_audit_trail_action` (`action`),
  KEY `idx_audit_trail_user_name` (`user_name`,`ip_address`,`url_referer`,`browser`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `audit_trail` */

insert  into `audit_trail`(`audit_trail_id`,`old_value`,`new_value`,`action`,`model`,`field`,`stamp`,`user_id`,`user_name`,`ip_address`,`url_referer`,`browser`,`model_id`) values (1,'/site/dashboard','/admin/user/','CHANGE','app\\modules\\admin\\models\\Group','url','2018-09-25 22:19:17','1','superadmin','::1','/admin/group/update?id=super-admin','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36','super-admin'),(2,NULL,NULL,'CREATE','app\\modules\\admin\\models\\Group',NULL,'2018-09-25 22:45:58','1','superadmin','::1','/admin/group/create','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36','admin'),(3,'','admin','SET','app\\modules\\admin\\models\\Group','group_id','2018-09-25 22:45:58','1','superadmin','::1','/admin/group/create','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36','admin'),(4,'','admin','SET','app\\modules\\admin\\models\\Group','name','2018-09-25 22:45:58','1','superadmin','::1','/admin/group/create','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36','admin'),(5,'','master','SET','app\\modules\\admin\\models\\Group','parent_id','2018-09-25 22:45:58','1','superadmin','::1','/admin/group/create','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36','admin'),(6,'','/admin/menu','SET','app\\modules\\admin\\models\\Group','url','2018-09-25 22:45:58','1','superadmin','::1','/admin/group/create','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36','admin'),(7,NULL,NULL,'CREATE','app\\modules\\admin\\models\\User',NULL,'2018-09-25 22:46:39','1','superadmin','::1','/admin/user/create','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36','87428'),(8,'','admin','SET','app\\modules\\admin\\models\\User','username','2018-09-25 22:46:39','1','superadmin','::1','/admin/user/create','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36','87428'),(9,'','DTKhIbvMzEhtY0mDk3RtGhAcqdcMfbsM','SET','app\\modules\\admin\\models\\User','auth_key','2018-09-25 22:46:39','1','superadmin','::1','/admin/user/create','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36','87428'),(10,'','$2y$13$6kVPONTJzn.T1mcAnNKABeUWk47YbpozxQtk7yHcNnkARdagDqSjq','SET','app\\modules\\admin\\models\\User','password_hash','2018-09-25 22:46:39','1','superadmin','::1','/admin/user/create','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36','87428'),(11,'','sefruitstudio@gmail.com','SET','app\\modules\\admin\\models\\User','email','2018-09-25 22:46:39','1','superadmin','::1','/admin/user/create','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36','87428'),(12,NULL,NULL,'CREATE','app\\modules\\admin\\models\\UserGroup',NULL,'2018-09-25 22:46:40','1','superadmin','::1','/admin/user/create','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36','{\"user_id\":87428,\"group_id\":\"admin\"}'),(13,'','admin','SET','app\\modules\\admin\\models\\UserGroup','group_id','2018-09-25 22:46:40','1','superadmin','::1','/admin/user/create','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36','{\"user_id\":87428,\"group_id\":\"admin\"}');

/*Table structure for table `audit_trail_detail` */

DROP TABLE IF EXISTS `audit_trail_detail`;

CREATE TABLE `audit_trail_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `audit_trail_id` int(11) NOT NULL,
  `old_value` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `new_value` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `action` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `field` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `stamp` datetime NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `ip_address` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `url_referer` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `browser` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_audit_trail_user_id` (`user_id`),
  KEY `idx_audit_trail_model_id` (`model_id`),
  KEY `idx_audit_trail_model` (`model`),
  KEY `idx_audit_trail_field` (`field`),
  KEY `idx_audit_trail_action` (`action`),
  KEY `FK_ahu_audit_trail_detail` (`audit_trail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `audit_trail_detail` */

/*Table structure for table `auth_assignment` */

DROP TABLE IF EXISTS `auth_assignment`;

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `auth_assignment` */

insert  into `auth_assignment`(`item_name`,`user_id`,`created_at`) values ('admin-role','admin',1537890552),('superadmin-role','super-admin',1537888662);

/*Table structure for table `auth_item` */

DROP TABLE IF EXISTS `auth_item`;

CREATE TABLE `auth_item` (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `auth_item` */

insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/allowed/assign',2,NULL,NULL,NULL,1537889544,1537889544),('/admin/allowed/create',2,NULL,NULL,NULL,1537886045,1537886045),('/admin/allowed/index',2,NULL,NULL,NULL,1537886045,1537886045),('/admin/allowed/refresh',2,NULL,NULL,NULL,1537886046,1537886046),('/admin/allowed/remove',2,NULL,NULL,NULL,1537886045,1537886045),('/admin/asset/clear-runtime',2,NULL,NULL,NULL,1537886046,1537886046),('/admin/asset/clear-upload',2,NULL,NULL,NULL,1537886046,1537886046),('/admin/assignment/assign',2,NULL,NULL,NULL,1537886046,1537886046),('/admin/assignment/index',2,NULL,NULL,NULL,1537886046,1537886046),('/admin/assignment/revoke',2,NULL,NULL,NULL,1537886046,1537886046),('/admin/assignment/view',2,NULL,NULL,NULL,1537886046,1537886046),('/admin/content-type/delete',2,NULL,NULL,NULL,1537886046,1537886046),('/admin/content-type/fields-delete',2,NULL,NULL,NULL,1537886046,1537886046),('/admin/content-type/fields-update',2,NULL,NULL,NULL,1537886046,1537886046),('/admin/content-type/index',2,NULL,NULL,NULL,1537886046,1537886046),('/admin/content-type/manage-fields',2,NULL,NULL,NULL,1537886046,1537886046),('/admin/content-type/update',2,NULL,NULL,NULL,1537886046,1537886046),('/admin/content-type/view',2,NULL,NULL,NULL,1537886046,1537886046),('/admin/content/create',2,NULL,NULL,NULL,1537886046,1537886046),('/admin/content/delete',2,NULL,NULL,NULL,1537886046,1537886046),('/admin/content/index',2,NULL,NULL,NULL,1537886046,1537886046),('/admin/content/update',2,NULL,NULL,NULL,1537886046,1537886046),('/admin/content/view',2,NULL,NULL,NULL,1537886046,1537886046),('/admin/default/index',2,NULL,NULL,NULL,1537886047,1537886047),('/admin/group/create',2,NULL,NULL,NULL,1537886047,1537886047),('/admin/group/delete',2,NULL,NULL,NULL,1537886047,1537886047),('/admin/group/index',2,NULL,NULL,NULL,1537886047,1537886047),('/admin/group/update',2,NULL,NULL,NULL,1537886047,1537886047),('/admin/group/view',2,NULL,NULL,NULL,1537886047,1537886047),('/admin/media-library/add-content',2,NULL,NULL,NULL,1537886047,1537886047),('/admin/media-library/check-youtube-link-without-api',2,NULL,NULL,NULL,1537886047,1537886047),('/admin/media-library/create',2,NULL,NULL,NULL,1537886047,1537886047),('/admin/media-library/delete',2,NULL,NULL,NULL,1537886047,1537886047),('/admin/media-library/delete-content',2,NULL,NULL,NULL,1537886047,1537886047),('/admin/media-library/index',2,NULL,NULL,NULL,1537886047,1537886047),('/admin/media-library/save-image-url',2,NULL,NULL,NULL,1537886047,1537886047),('/admin/media-library/save-video-url',2,NULL,NULL,NULL,1537886047,1537886047),('/admin/media-library/update',2,NULL,NULL,NULL,1537886047,1537886047),('/admin/media-library/upload',2,NULL,NULL,NULL,1537886047,1537886047),('/admin/media-library/view',2,NULL,NULL,NULL,1537886047,1537886047),('/admin/menu/delete',2,NULL,NULL,NULL,1537886048,1537886048),('/admin/menu/index',2,NULL,NULL,NULL,1537886047,1537886047),('/admin/menu/list-menu',2,NULL,NULL,NULL,1537886047,1537886047),('/admin/message/create',2,NULL,NULL,NULL,1537886048,1537886048),('/admin/message/delete',2,NULL,NULL,NULL,1537886048,1537886048),('/admin/message/delete-message',2,NULL,NULL,NULL,1537886048,1537886048),('/admin/message/delete-message-trash',2,NULL,NULL,NULL,1537886048,1537886048),('/admin/message/destination',2,NULL,NULL,NULL,1537886048,1537886048),('/admin/message/draft',2,NULL,NULL,NULL,1537886048,1537886048),('/admin/message/forward',2,NULL,NULL,NULL,1537886048,1537886048),('/admin/message/index',2,NULL,NULL,NULL,1537886048,1537886048),('/admin/message/reply',2,NULL,NULL,NULL,1537886048,1537886048),('/admin/message/sent',2,NULL,NULL,NULL,1537886048,1537886048),('/admin/message/trash',2,NULL,NULL,NULL,1537886048,1537886048),('/admin/message/update',2,NULL,NULL,NULL,1537886048,1537886048),('/admin/message/view',2,NULL,NULL,NULL,1537886048,1537886048),('/admin/message/view-trash',2,NULL,NULL,NULL,1537886048,1537886048),('/admin/permission/assign',2,NULL,NULL,NULL,1537886049,1537886049),('/admin/permission/create',2,NULL,NULL,NULL,1537886049,1537886049),('/admin/permission/delete',2,NULL,NULL,NULL,1537886049,1537886049),('/admin/permission/index',2,NULL,NULL,NULL,1537886048,1537886048),('/admin/permission/remove',2,NULL,NULL,NULL,1537886049,1537886049),('/admin/permission/update',2,NULL,NULL,NULL,1537886049,1537886049),('/admin/permission/view',2,NULL,NULL,NULL,1537886048,1537886048),('/admin/role/assign',2,NULL,NULL,NULL,1537886049,1537886049),('/admin/role/create',2,NULL,NULL,NULL,1537886049,1537886049),('/admin/role/delete',2,NULL,NULL,NULL,1537886049,1537886049),('/admin/role/index',2,NULL,NULL,NULL,1537886049,1537886049),('/admin/role/remove',2,NULL,NULL,NULL,1537886049,1537886049),('/admin/role/update',2,NULL,NULL,NULL,1537886049,1537886049),('/admin/role/view',2,NULL,NULL,NULL,1537886049,1537886049),('/admin/route/assign',2,NULL,NULL,NULL,1537886050,1537886050),('/admin/route/create',2,NULL,NULL,NULL,1537886049,1537886049),('/admin/route/index',2,NULL,NULL,NULL,1537886049,1537886049),('/admin/route/refresh',2,NULL,NULL,NULL,1537886050,1537886050),('/admin/route/remove',2,NULL,NULL,NULL,1537886050,1537886050),('/admin/rule/create',2,NULL,NULL,NULL,1537886050,1537886050),('/admin/rule/delete',2,NULL,NULL,NULL,1537886050,1537886050),('/admin/rule/index',2,NULL,NULL,NULL,1537886050,1537886050),('/admin/rule/update',2,NULL,NULL,NULL,1537886050,1537886050),('/admin/rule/view',2,NULL,NULL,NULL,1537886050,1537886050),('/admin/user/activate',2,NULL,NULL,NULL,1537886051,1537886051),('/admin/user/change-password',2,NULL,NULL,NULL,1537886051,1537886051),('/admin/user/create',2,NULL,NULL,NULL,1537886050,1537886050),('/admin/user/delete',2,NULL,NULL,NULL,1537886050,1537886050),('/admin/user/index',2,NULL,NULL,NULL,1537886050,1537886050),('/admin/user/login',2,NULL,NULL,NULL,1537886050,1537886050),('/admin/user/logout',2,NULL,NULL,NULL,1537886050,1537886050),('/admin/user/profile-user',2,NULL,NULL,NULL,1537886051,1537886051),('/admin/user/request-password-reset',2,NULL,NULL,NULL,1537886050,1537886050),('/admin/user/reset-password',2,NULL,NULL,NULL,1537886051,1537886051),('/admin/user/setting-profile',2,NULL,NULL,NULL,1537886051,1537886051),('/admin/user/signup',2,NULL,NULL,NULL,1537886050,1537886050),('/admin/user/update',2,NULL,NULL,NULL,1537886050,1537886050),('/admin/user/view',2,NULL,NULL,NULL,1537886050,1537886050),('admin-permission',2,'','',NULL,1537890470,1537890470),('admin-role',1,'','',NULL,1537890540,1537890540),('superadmin-role',1,'','',NULL,1479549312,1537890505),('superuser-permission',2,'','',NULL,1537888616,1537888616);

/*Table structure for table `auth_item_child` */

DROP TABLE IF EXISTS `auth_item_child`;

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `auth_item_child` */

insert  into `auth_item_child`(`parent`,`child`) values ('admin-permission','/admin/menu/index'),('admin-permission','/admin/menu/list-menu'),('admin-role','admin-permission'),('superadmin-role','superuser-permission'),('superuser-permission','/admin/allowed/create'),('superuser-permission','/admin/allowed/index'),('superuser-permission','/admin/allowed/refresh'),('superuser-permission','/admin/allowed/remove'),('superuser-permission','/admin/asset/clear-runtime'),('superuser-permission','/admin/asset/clear-upload'),('superuser-permission','/admin/assignment/assign'),('superuser-permission','/admin/assignment/index'),('superuser-permission','/admin/assignment/revoke'),('superuser-permission','/admin/assignment/view'),('superuser-permission','/admin/content-type/delete'),('superuser-permission','/admin/content-type/fields-delete'),('superuser-permission','/admin/content-type/fields-update'),('superuser-permission','/admin/content-type/index'),('superuser-permission','/admin/content-type/manage-fields'),('superuser-permission','/admin/content-type/update'),('superuser-permission','/admin/content-type/view'),('superuser-permission','/admin/content/create'),('superuser-permission','/admin/content/delete'),('superuser-permission','/admin/content/index'),('superuser-permission','/admin/content/update'),('superuser-permission','/admin/content/view'),('superuser-permission','/admin/default/index'),('superuser-permission','/admin/group/create'),('superuser-permission','/admin/group/delete'),('superuser-permission','/admin/group/index'),('superuser-permission','/admin/group/update'),('superuser-permission','/admin/group/view'),('superuser-permission','/admin/media-library/add-content'),('superuser-permission','/admin/media-library/check-youtube-link-without-api'),('superuser-permission','/admin/media-library/create'),('superuser-permission','/admin/media-library/delete'),('superuser-permission','/admin/media-library/delete-content'),('superuser-permission','/admin/media-library/index'),('superuser-permission','/admin/media-library/save-image-url'),('superuser-permission','/admin/media-library/save-video-url'),('superuser-permission','/admin/media-library/update'),('superuser-permission','/admin/media-library/upload'),('superuser-permission','/admin/media-library/view'),('superuser-permission','/admin/menu/delete'),('superuser-permission','/admin/menu/index'),('superuser-permission','/admin/menu/list-menu'),('superuser-permission','/admin/message/create'),('superuser-permission','/admin/message/delete'),('superuser-permission','/admin/message/delete-message'),('superuser-permission','/admin/message/delete-message-trash'),('superuser-permission','/admin/message/destination'),('superuser-permission','/admin/message/draft'),('superuser-permission','/admin/message/forward'),('superuser-permission','/admin/message/index'),('superuser-permission','/admin/message/reply'),('superuser-permission','/admin/message/sent'),('superuser-permission','/admin/message/trash'),('superuser-permission','/admin/message/update'),('superuser-permission','/admin/message/view'),('superuser-permission','/admin/message/view-trash'),('superuser-permission','/admin/permission/assign'),('superuser-permission','/admin/permission/create'),('superuser-permission','/admin/permission/delete'),('superuser-permission','/admin/permission/index'),('superuser-permission','/admin/permission/remove'),('superuser-permission','/admin/permission/update'),('superuser-permission','/admin/permission/view'),('superuser-permission','/admin/role/assign'),('superuser-permission','/admin/role/create'),('superuser-permission','/admin/role/delete'),('superuser-permission','/admin/role/index'),('superuser-permission','/admin/role/remove'),('superuser-permission','/admin/role/update'),('superuser-permission','/admin/role/view'),('superuser-permission','/admin/route/assign'),('superuser-permission','/admin/route/create'),('superuser-permission','/admin/route/index'),('superuser-permission','/admin/route/refresh'),('superuser-permission','/admin/route/remove'),('superuser-permission','/admin/rule/create'),('superuser-permission','/admin/rule/delete'),('superuser-permission','/admin/rule/index'),('superuser-permission','/admin/rule/update'),('superuser-permission','/admin/rule/view'),('superuser-permission','/admin/user/activate'),('superuser-permission','/admin/user/change-password'),('superuser-permission','/admin/user/create'),('superuser-permission','/admin/user/delete'),('superuser-permission','/admin/user/index'),('superuser-permission','/admin/user/login'),('superuser-permission','/admin/user/logout'),('superuser-permission','/admin/user/profile-user'),('superuser-permission','/admin/user/request-password-reset'),('superuser-permission','/admin/user/reset-password'),('superuser-permission','/admin/user/setting-profile'),('superuser-permission','/admin/user/signup'),('superuser-permission','/admin/user/update'),('superuser-permission','/admin/user/view');

/*Table structure for table `auth_rule` */

DROP TABLE IF EXISTS `auth_rule`;

CREATE TABLE `auth_rule` (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `auth_rule` */

/*Table structure for table `cache_menu` */

DROP TABLE IF EXISTS `cache_menu`;

CREATE TABLE `cache_menu` (
  `cid` varchar(255) NOT NULL,
  `data` longblob,
  `created` int(11) DEFAULT NULL,
  `expired` int(11) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cache_menu` */

insert  into `cache_menu`(`cid`,`data`,`created`,`expired`) values ('backend-menu','a:1:{i:0;a:6:{s:3:\"url\";s:12:\"javascript:;\";s:5:\"label\";s:12:\"Admin Config\";s:4:\"icon\";s:0:\"\";s:7:\"content\";s:0:\"\";s:6:\"assign\";a:1:{i:0;s:11:\"super-admin\";}s:5:\"items\";a:1:{i:0;a:5:{s:3:\"url\";s:23:\"/admin/assignment/index\";s:5:\"label\";s:10:\"Assignment\";s:4:\"icon\";s:0:\"\";s:7:\"content\";s:0:\"\";s:6:\"assign\";a:0:{}}}}}',1537640325,NULL);

/*Table structure for table `group` */

DROP TABLE IF EXISTS `group`;

CREATE TABLE `group` (
  `group_id` varchar(64) CHARACTER SET latin1 NOT NULL,
  `name` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
  `detail` text CHARACTER SET latin1,
  `configuration` text CHARACTER SET latin1,
  `level` smallint(6) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `left` int(11) DEFAULT NULL,
  `right` int(11) DEFAULT NULL,
  `parent_id` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
  `path` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `url` text CHARACTER SET latin1,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `group` */

insert  into `group`(`group_id`,`name`,`detail`,`configuration`,`level`,`order`,`left`,`right`,`parent_id`,`path`,`url`) values ('admin','admin','',NULL,0,NULL,1,2,'master',NULL,'/admin/menu'),('super-admin','Super Admin','',NULL,0,NULL,1,2,'master',NULL,'/admin/user/');

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `menu_id` int(6) NOT NULL AUTO_INCREMENT,
  `label` varchar(225) CHARACTER SET latin1 DEFAULT NULL,
  `description` text CHARACTER SET latin1,
  `menu_custom` enum('0','1') CHARACTER SET latin1 DEFAULT '0',
  `menu_type` varchar(32) NOT NULL,
  `menu_parent` int(6) DEFAULT NULL,
  `menu_order` int(4) DEFAULT NULL,
  `menu_url` text CHARACTER SET latin1,
  `class` varchar(225) CHARACTER SET latin1 DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `level` int(3) DEFAULT NULL,
  PRIMARY KEY (`menu_id`),
  KEY `menu_type` (`menu_type`),
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`menu_type`) REFERENCES `menu_type` (`menu_type`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `menu` */

insert  into `menu`(`menu_id`,`label`,`description`,`menu_custom`,`menu_type`,`menu_parent`,`menu_order`,`menu_url`,`class`,`status`,`level`) values (1,'Admin Config','','1','backend-menu',NULL,NULL,'javascript:;','',NULL,NULL),(2,'Assignment','','1','backend-menu',1,NULL,'/admin/assignment/index','',NULL,NULL);

/*Table structure for table `menu_group` */

DROP TABLE IF EXISTS `menu_group`;

CREATE TABLE `menu_group` (
  `menu_id` int(11) DEFAULT NULL,
  `group_id` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  KEY `menu_id` (`menu_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `menu_group_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `menu_group_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `group` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `menu_group` */

insert  into `menu_group`(`menu_id`,`group_id`) values (1,'super-admin');

/*Table structure for table `menu_type` */

DROP TABLE IF EXISTS `menu_type`;

CREATE TABLE `menu_type` (
  `menu_type` varchar(32) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text,
  PRIMARY KEY (`menu_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `menu_type` */

insert  into `menu_type`(`menu_type`,`title`,`description`) values ('backend-menu','Backend Menu','');

/*Table structure for table `message` */

DROP TABLE IF EXISTS `message`;

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID Pesan',
  `subject` varchar(255) NOT NULL COMMENT 'Subjek',
  `message` text NOT NULL COMMENT 'Isi Pesan',
  `destination_type` enum('user','group') NOT NULL DEFAULT 'user' COMMENT 'Jenis Tujuan (user/group)',
  `destination` varchar(100) NOT NULL COMMENT 'user/group tujuan pesan',
  `is_draft` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Flag untuk draft pesan',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Flag hapus untuk draft',
  `created_by` varchar(50) NOT NULL COMMENT 'Pembuat Pesan',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Tanggal pesan dibuat',
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `message` */

/*Table structure for table `message_box` */

DROP TABLE IF EXISTS `message_box`;

CREATE TABLE `message_box` (
  `message_box_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID Pesan User',
  `message_id` int(11) NOT NULL COMMENT 'ID Pesan',
  `type` enum('in','out') NOT NULL DEFAULT 'in' COMMENT 'Jenis Pesan (Indox, Outbox)',
  `receiver` varchar(100) NOT NULL COMMENT 'Penerima pesan (user/group)',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Tanggal inbox/outbox',
  `is_read` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Flag pesan telah dibaca',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Flag hapus untuk inbox dan outbox',
  PRIMARY KEY (`message_box_id`),
  UNIQUE KEY `message_id` (`message_id`,`type`,`receiver`),
  CONSTRAINT `message_box_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `message` (`message_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `message_box` */

/*Table structure for table `migration` */

DROP TABLE IF EXISTS `migration`;

CREATE TABLE `migration` (
  `version` varchar(180) CHARACTER SET latin1 NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `migration` */

insert  into `migration`(`version`,`apply_time`) values ('m000000_000000_base',1467355263),('m130524_201442_init',1467355268),('m140506_102106_rbac_init',1467364142),('m140602_111327_create_menu_table',1467364040),('m160312_050000_create_user',1467364041);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=87429 DEFAULT CHARSET=utf8;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`auth_key`,`password_hash`,`password_reset_token`,`email`,`status`,`created_at`,`updated_at`) values (1,'superadmin','llGbLxMddz3hb4I6b5U3yn6rfyvFNMW-','$2y$13$7YM0U2buTpJU2sZusb/5X.Uz205IV9H4S6SxCM6.ZPFPnaLswrOkK','vl03mYd6Cwsu5b9Q6K60XxRvKN4xTACs_1493966618','rikinofianto@gmail.com',10,1476419005,1493966618),(87428,'admin','DTKhIbvMzEhtY0mDk3RtGhAcqdcMfbsM','$2y$13$6kVPONTJzn.T1mcAnNKABeUWk47YbpozxQtk7yHcNnkARdagDqSjq',NULL,'sefruitstudio@gmail.com',10,1537890399,1537890399);

/*Table structure for table `user_group` */

DROP TABLE IF EXISTS `user_group`;

CREATE TABLE `user_group` (
  `user_id` int(11) NOT NULL,
  `group_id` varchar(64) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `groupname` (`group_id`),
  CONSTRAINT `groupname` FOREIGN KEY (`group_id`) REFERENCES `group` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `userid` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `user_group` */

insert  into `user_group`(`user_id`,`group_id`) values (1,'super-admin'),(87428,'admin');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
