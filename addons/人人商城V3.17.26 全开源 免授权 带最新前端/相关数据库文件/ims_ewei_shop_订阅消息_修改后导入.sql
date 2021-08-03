/*
Navicat MySQL Data Transfer

Source Server         : 开放微擎(共赢2)
Source Server Version : 50641
Source Host           : localhost:3306
Source Database       : www_meishanc_co

Target Server Type    : MYSQL
Target Server Version : 50641
File Encoding         : 65001

Date: 2020-02-27 12:11:43
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ims_ewei_shop_wxapp_subscribe`
-- ----------------------------
DROP TABLE IF EXISTS `ims_ewei_shop_wxapp_subscribe`;
CREATE TABLE `ims_ewei_shop_wxapp_subscribe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `templateid` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_ewei_shop_wxapp_subscribe
-- ----------------------------
INSERT INTO `ims_ewei_shop_wxapp_subscribe` VALUES ('1', '48', 'pay', 'lBPEJ1I7rs-g7BkQ7T04baE7iSGhR0sakjLd7xf_5jI');
INSERT INTO `ims_ewei_shop_wxapp_subscribe` VALUES ('2', '48', 'send', 'XByHQCvKHQ9boBnT9DZ_SH0lH5Za1Zrpjm2Sgzq_m0M');
INSERT INTO `ims_ewei_shop_wxapp_subscribe` VALUES ('3', '48', 'autosend', 'XByHQCvKHQ9boBnT9DZ_SF54yZ-qm3sfdTnIdv91SI8');
INSERT INTO `ims_ewei_shop_wxapp_subscribe` VALUES ('4', '48', 'receive', 'V7PB_po7I8UcdWuLiHYHAlSgaHIXbReLluAV_wfaYVg');
