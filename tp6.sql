/*
 Navicat Premium Data Transfer

 Source Server         : mysql
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : tp6

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 26/04/2021 16:33:56
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tp6_admin
-- ----------------------------
DROP TABLE IF EXISTS `tp6_admin`;
CREATE TABLE `tp6_admin`  (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `username` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户名',
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码',
  `salt` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码盐',
  `avatar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '头像',
  `role_id` int(10) NOT NULL DEFAULT 0 COMMENT '角色组id',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` int(10) NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tp6_admin
-- ----------------------------
INSERT INTO `tp6_admin` VALUES (1, 'admin', 'c96716d9fc63e3878adead6272776cba', 'y3peZG', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif', 1, 1, 1619162612, 1619407581);
INSERT INTO `tp6_admin` VALUES (2, 'visit', 'a76fbbd986423b297ca1cfc92a2a7404', '0ZwlC9', 'http://127.0.0.1:8001/storage/topic/20210426\\1f80ba1e5a06630fd147370c337dd2f0.jpg', 2, 1, 1619424226, 1619424226);

-- ----------------------------
-- Table structure for tp6_role
-- ----------------------------
DROP TABLE IF EXISTS `tp6_role`;
CREATE TABLE `tp6_role`  (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '角色组名称',
  `rules` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '可访问路由id（*表示所有权限）',
  `key` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '角色组key值',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '角色组描述',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态：1正常，0禁用',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` int(10) NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tp6_role
-- ----------------------------
INSERT INTO `tp6_role` VALUES (1, '超级管理员', '*', 'admin', '超级管理员组', 1, 1619402057, 1619402057);
INSERT INTO `tp6_role` VALUES (2, '游客组', '1,3', 'visitor', '游客', 1, 1619422236, 1619422236);

-- ----------------------------
-- Table structure for tp6_routes
-- ----------------------------
DROP TABLE IF EXISTS `tp6_routes`;
CREATE TABLE `tp6_routes`  (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `pid` int(10) NOT NULL COMMENT '父id（二级路由）',
  `title` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '路由名称',
  `path` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '路由地址',
  `component` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '组件地址',
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '图标',
  `redirect` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '重定向地址',
  `alwaysShow` tinyint(1) NOT NULL DEFAULT 0 COMMENT '总是显示：1是，0否',
  `hidden` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否隐藏：1是，0否',
  `affix` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否固钉：1是，0否',
  `noCache` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否缓存：1是，0否',
  `sort` int(2) NOT NULL DEFAULT 0 COMMENT '排序：0-99',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` int(19) NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tp6_routes
-- ----------------------------
INSERT INTO `tp6_routes` VALUES (1, 0, '权限管理', '/permission', '#', 'lock', '/permission/admin', 0, 0, 0, 0, 0, 1, 1619337685, 1619341001);
INSERT INTO `tp6_routes` VALUES (2, 1, '路由管理', 'routes', '/permission/routes', '', '', 0, 0, 0, 0, 0, 1, 1619338795, 1619338795);
INSERT INTO `tp6_routes` VALUES (3, 1, '角色组', 'role', '/permission/role', '', '', 0, 0, 0, 0, 0, 1, 1619400341, 1619400341);
INSERT INTO `tp6_routes` VALUES (4, 1, '管理员', 'admin', '/permission/admin', '', '', 0, 0, 0, 0, 0, 1, 1619403548, 1619403548);

SET FOREIGN_KEY_CHECKS = 1;
