/*
 Navicat Premium Data Transfer

 Source Server         : UB-ISMBNC
 Source Server Type    : MySQL
 Source Server Version : 50717
 Source Host           : localhost:3306
 Source Schema         : deneme

 Target Server Type    : MySQL
 Target Server Version : 50717
 File Encoding         : 65001

 Date: 03/02/2021 10:04:45
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for application
-- ----------------------------
DROP TABLE IF EXISTS `application`;
CREATE TABLE `application`  (
  `id` int(11) NOT NULL,
  `ad` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of application
-- ----------------------------
INSERT INTO `application` VALUES (1, 'TeknoWeb');
INSERT INTO `application` VALUES (2, 'AraGelsin');
INSERT INTO `application` VALUES (3, 'ToDoList');
INSERT INTO `application` VALUES (4, 'Zor');

-- ----------------------------
-- Table structure for language
-- ----------------------------
DROP TABLE IF EXISTS `language`;
CREATE TABLE `language`  (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `ad` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `kod` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `durum` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `CODE`(`kod`) USING BTREE,
  INDEX `DURUM`(`durum`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of language
-- ----------------------------
INSERT INTO `language` VALUES (1, 'TÜRKÇE', 'TR', 1);
INSERT INTO `language` VALUES (2, 'FRANSIZCA', 'FR', 1);
INSERT INTO `language` VALUES (3, 'ALMANCA', 'DE', 1);
INSERT INTO `language` VALUES (4, 'RUSÇA', 'RU', 1);

-- ----------------------------
-- Table structure for os
-- ----------------------------
DROP TABLE IF EXISTS `os`;
CREATE TABLE `os`  (
  `id` int(3) NOT NULL,
  `ad` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of os
-- ----------------------------
INSERT INTO `os` VALUES (1, 'Windows');
INSERT INTO `os` VALUES (2, 'IOS');
INSERT INTO `os` VALUES (3, 'Android');
INSERT INTO `os` VALUES (4, 'Pardus');

-- ----------------------------
-- Table structure for purchase
-- ----------------------------
DROP TABLE IF EXISTS `purchase`;
CREATE TABLE `purchase`  (
  `client_token` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `hash` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `durum` tinyint(1) NOT NULL,
  `kayit_zamani` datetime(0) NULL DEFAULT NULL,
  INDEX `hash`(`hash`) USING BTREE,
  INDEX `client_token`(`client_token`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of purchase
-- ----------------------------
INSERT INTO `purchase` VALUES ('1885702a0-ad36-4d8e-b2f9-07350e9424cd', '$2y$10$17xUwGUbb8ZdaOM.GqhGnuzlPsVcshf7k8hj9HfrlaV.z9By27gB1', 1, '2021-02-02 15:55:08');
INSERT INTO `purchase` VALUES ('1885702a0-ad36-4d8e-b2f9-07350e9424cd', '$2y$10$17xUwGUbb8ZdaOM.GqhGnuzlPsVcshf7k8hj9HfrlaV.z9By27gB1', 1, '2021-02-02 15:55:19');
INSERT INTO `purchase` VALUES ('1885702a0-ad36-4d8e-b2f9-07350e9424cd', '$2y$10$17xUwGUbb8ZdaOM.GqhGnuzlPsVcshf7k8hj9HfrlaV.z9By27gB1', 1, '2021-02-03 09:26:41');

-- ----------------------------
-- Table structure for register
-- ----------------------------
DROP TABLE IF EXISTS `register`;
CREATE TABLE `register`  (
  `u_id` int(11) NOT NULL COMMENT 'user id birden fazla app kullanacağı için FK değil',
  `app_id` int(11) NOT NULL,
  `lang_id` tinyint(4) NOT NULL,
  `os_id` int(3) NOT NULL,
  `client_token` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `durum` tinyint(4) NOT NULL,
  `kayit_zamani` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  `guncelleme_zamani` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`u_id`, `app_id`) USING BTREE,
  INDEX `durum`(`durum`) USING BTREE,
  INDEX `app_id`(`app_id`) USING BTREE,
  INDEX `lang_id`(`lang_id`) USING BTREE,
  INDEX `fk_os_id`(`os_id`) USING BTREE,
  INDEX `u_id`(`u_id`) USING BTREE,
  CONSTRAINT `fk_lang_id` FOREIGN KEY (`lang_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `fk_os_id` FOREIGN KEY (`os_id`) REFERENCES `os` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of register
-- ----------------------------
INSERT INTO `register` VALUES (1, 2, 2, 1, '885702a0-ad36-4d8e-b2f9-07350e9424cd', 1, '2021-01-28 15:57:19', NULL);
INSERT INTO `register` VALUES (1, 3, 2, 1, '885702a0-ad36-4d8e-b2f9-07350e9424cd', 1, '2021-01-28 16:13:30', '2021-01-28 18:18:49');
INSERT INTO `register` VALUES (2, 2, 2, 1, '222622fc-a4eb-44c5-90d6-3027a40ef9fb', 1, '2021-01-28 16:13:09', NULL);

-- ----------------------------
-- Table structure for subs_desc
-- ----------------------------
DROP TABLE IF EXISTS `subs_desc`;
CREATE TABLE `subs_desc`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` int(11) NOT NULL,
  `sub_desc` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fiyat` double(8, 2) NOT NULL DEFAULT 0.00,
  `kayit_zamani` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  `guncelleme_zamani` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of subs_desc
-- ----------------------------
INSERT INTO `subs_desc` VALUES (1, 1, '30gunluk', 12.00, '2021-01-28 17:09:21', NULL);
INSERT INTO `subs_desc` VALUES (2, 1, '60gunluk', 20.00, '2021-01-28 17:09:28', NULL);
INSERT INTO `subs_desc` VALUES (3, 2, '30gunluk', 10.00, '2021-01-28 17:09:37', NULL);
INSERT INTO `subs_desc` VALUES (4, 2, '60gunluk', 25.00, '2021-01-28 17:09:45', NULL);

-- ----------------------------
-- Table structure for subscriptions
-- ----------------------------
DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE `subscriptions`  (
  `u_id` int(11) NOT NULL,
  `app_id` int(11) NOT NULL,
  `sub_id` int(11) NOT NULL,
  `basl_tarih` date NOT NULL,
  `bitis_tarih` date NOT NULL,
  `kayit_zamani` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`u_id`, `app_id`, `sub_id`) USING BTREE,
  INDEX `fk_sub_id`(`sub_id`) USING BTREE,
  INDEX `fk_app_id`(`app_id`) USING BTREE,
  CONSTRAINT `fk_app_id` FOREIGN KEY (`app_id`) REFERENCES `application` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_sub_id` FOREIGN KEY (`sub_id`) REFERENCES `subs_desc` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_u_id` FOREIGN KEY (`u_id`) REFERENCES `register` (`u_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of subscriptions
-- ----------------------------
INSERT INTO `subscriptions` VALUES (1, 1, 2, '2021-01-05', '2021-02-28', '2021-01-28 18:11:36');
INSERT INTO `subscriptions` VALUES (2, 1, 2, '2021-01-01', '2021-02-28', '2021-01-28 18:12:06');

-- ----------------------------
-- Triggers structure for table language
-- ----------------------------
DROP TRIGGER IF EXISTS `trg_dil_update`;
delimiter ;;
CREATE TRIGGER `trg_dil_update` BEFORE UPDATE ON `language` FOR EACH ROW BEGIN

	IF (OLD.file_create_date IS NOT NULL && NEW.file_create_date IS NULL) THEN 
		SET NEW.js_cache_date = NULL;
	END IF;

END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
