/*
 Navicat Premium Data Transfer

 Source Server         : mysqllocal
 Source Server Type    : MySQL
 Source Server Version : 50733
 Source Host           : localhost:3306
 Source Schema         : db_ci4

 Target Server Type    : MySQL
 Target Server Version : 50733
 File Encoding         : 65001

 Date: 10/11/2022 21:50:37
*/


-- ----------------------------
-- Table structure for ms_menu
-- ----------------------------

CREATE TABLE `ms_menu`  (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_code` char(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `menu_name` varchar(140) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `menu_url` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `menu_parent_id` int(11) NULL DEFAULT NULL,
  `menu_status` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `menu_icon` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `slug` varchar(140) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`menu_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ms_menu
-- ----------------------------
INSERT INTO `ms_menu` VALUES (9, '01', 'BERANDA', 'builder/beranda', 0, 't', 'fa fa-dashboard', NULL);
INSERT INTO `ms_menu` VALUES (10, '02', 'DOKUMENTASI', '#', 0, 't', 'fa fa-book', '');
INSERT INTO `ms_menu` VALUES (11, '02.01', 'FORM BASIC', 'documentation', 10, 't', '', '');
INSERT INTO `ms_menu` VALUES (13, '02.03', 'HTML HELPER', 'documentation/html_helper', 10, 't', '', '');
INSERT INTO `ms_menu` VALUES (14, '02.04', 'DATATA TABLE', 'documentation/datatable_helper', 10, 't', '', '');
INSERT INTO `ms_menu` VALUES (24, '02.02', 'FORM ADVANCE', 'documentation/form_advance', 10, 't', NULL, NULL);
INSERT INTO `ms_menu` VALUES (25, '03', 'BUILDER CRUD', 'builder/builderform', 0, 't', 'fas fa-sync', NULL);


