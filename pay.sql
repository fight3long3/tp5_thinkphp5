/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MariaDB
 Source Server Version : 100212
 Source Host           : localhost:3306
 Source Schema         : pay

 Target Server Type    : MariaDB
 Target Server Version : 100212
 File Encoding         : 65001

 Date: 01/02/2018 18:18:10
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for fight_menu
-- ----------------------------
DROP TABLE IF EXISTS `fight_menu`;
CREATE TABLE `fight_menu`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '菜单id',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '菜单名称',
  `parent_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '父菜单id',
  `grade` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1.一级菜单 2.二级菜单 3三级菜单',
  `sequence` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  `url` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '菜单路径',
  `module` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `controller` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `action` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `state` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0=>\'正常\', 1=>\'禁用\'',
  `delete_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 55 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '菜单' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of fight_menu
-- ----------------------------
INSERT INTO `fight_menu` VALUES (1, '后台首页', 0, 1, 10, 'admin', 'admin', '', '', 1492247935, 0, 0, 0);
INSERT INTO `fight_menu` VALUES (2, '系统信息', 1, 2, 20, 'admin/Index/index', 'admin', 'Index', 'index', 1492247935, 0, 0, 0);
INSERT INTO `fight_menu` VALUES (3, '系统设置', 0, 1, 100, 'system', 'system', '', '', 1492247935, 0, 0, 0);
INSERT INTO `fight_menu` VALUES (4, '管理员管理', 3, 2, 10, 'system/User/index', 'system', 'User', 'index', 1492247935, 0, 0, 0);
INSERT INTO `fight_menu` VALUES (5, '添加管理员', 3, 2, 20, 'system/User/create', 'system', 'User', 'create', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (6, '保存添加', 3, 2, 30, 'system/User/save', 'system', 'User', 'save', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (7, '查看管理员', 3, 2, 40, 'system/User/read', 'system', 'User', 'read', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (8, '编辑管理员', 3, 2, 50, 'system/User/edit', 'system', 'User', 'edit', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (9, '更新编辑', 3, 2, 60, 'system/User/update', 'system', 'User', 'update', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (10, '删除管理员', 3, 2, 70, 'system/User/delete', 'system', 'User', 'delete', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (11, '批量删除', 3, 2, 80, 'system/User/deleteItems', 'system', 'User', 'deleteItems', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (12, '更新状态', 3, 2, 80, 'system/User/setState', 'system', 'User', 'setState', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (13, '批量更新', 3, 2, 80, 'system/User/setStates', 'system', 'User', 'setStates', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (14, '角色管理', 3, 2, 30, 'system/Role/index', 'system', 'Role', 'index', 1492247935, 1517469871, 0, 0);
INSERT INTO `fight_menu` VALUES (15, '添加角色', 3, 2, 20, 'system/Role/create', 'system', 'Role', 'create', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (16, '保存添加', 3, 2, 30, 'system/Role/save', 'system', 'Role', 'save', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (17, '查看角色', 3, 2, 40, 'system/Role/read', 'system', 'Role', 'read', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (18, '编辑角色', 3, 2, 50, 'system/Role/edit', 'system', 'Role', 'edit', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (19, '更新编辑', 3, 2, 60, 'system/Role/update', 'system', 'Role', 'update', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (20, '删除角色', 3, 2, 70, 'system/Role/delete', 'system', 'Role', 'delete', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (21, '批量删除', 3, 2, 80, 'system/Role/deleteItems', 'system', 'Role', 'deleteItems', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (22, '更新状态', 3, 2, 80, 'system/Role/setState', 'system', 'Role', 'setState', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (23, '批量更新', 3, 2, 80, 'system/Role/setStates', 'system', 'Role', 'setStates', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (24, '规则管理', 3, 2, 40, 'system/Rule/index', 'system', 'Rule', 'index', 1492247935, 0, 0, 0);
INSERT INTO `fight_menu` VALUES (25, '添加规则', 3, 2, 20, 'system/Rule/create', 'system', 'Rule', 'create', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (26, '保存添加', 3, 2, 30, 'system/Rule/save', 'system', 'Rule', 'save', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (27, '查看规则', 3, 2, 40, 'system/Rule/read', 'system', 'Rule', 'read', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (28, '编辑规则', 3, 2, 50, 'system/Rule/edit', 'system', 'Rule', 'edit', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (29, '更新编辑', 3, 2, 60, 'system/Rule/update', 'system', 'Rule', 'update', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (30, '删除规则', 3, 2, 70, 'system/Rule/delete', 'system', 'Rule', 'delete', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (31, '批量删除', 3, 2, 80, 'system/Rule/deleteItems', 'system', 'Rule', 'deleteItems', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (32, '更新状态', 3, 2, 80, 'system/Rule/setState', 'system', 'Rule', 'setState', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (33, '批量更新', 3, 2, 80, 'system/Rule/setStates', 'system', 'Rule', 'setStates', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (34, '菜单管理', 3, 2, 60, 'system/Menu/index', 'system', 'Menu', 'index', 1492247935, 0, 0, 0);
INSERT INTO `fight_menu` VALUES (35, '添加菜单', 3, 2, 20, 'system/Menu/create', 'system', 'Menu', 'create', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (36, '保存添加', 3, 2, 30, 'system/Menu/save', 'system', 'Menu', 'save', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (37, '查看菜单', 3, 2, 40, 'system/Menu/read', 'system', 'Menu', 'read', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (38, '编辑菜单', 3, 2, 50, 'system/Menu/edit', 'system', 'Menu', 'edit', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (39, '更新编辑', 3, 2, 60, 'system/Menu/update', 'system', 'Menu', 'update', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (40, '删除菜单', 3, 2, 70, 'system/Menu/delete', 'system', 'Menu', 'delete', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (41, '批量删除', 3, 2, 80, 'system/Menu/deleteItems', 'system', 'Menu', 'deleteItems', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (42, '更新状态', 3, 2, 80, 'system/Menu/setState', 'system', 'Menu', 'setState', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (43, '批量更新', 3, 2, 80, 'system/Menu/setStates', 'system', 'Menu', 'setStates', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (44, '商户管理', 0, 1, 80, 'merchant', 'merchant', '', '', 1492247935, 0, 0, 0);
INSERT INTO `fight_menu` VALUES (45, '商户列表', 44, 2, 80, 'merchant/Merchant/index', 'merchant', 'Merchant', 'index', 1492247935, 0, 0, 0);
INSERT INTO `fight_menu` VALUES (46, '添加商户', 44, 2, 30, 'merchant/Merchant/create', 'merchant', 'Merchant', 'create', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (47, '保存添加', 44, 2, 40, 'merchant/Merchant/save', 'merchant', 'Merchant', 'save', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (48, '查看商户', 44, 2, 50, 'merchant/Merchant/read', 'merchant', 'Merchant', 'read', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (49, '编辑商户', 44, 2, 60, 'merchant/Merchant/edit', 'merchant', 'Merchant', 'edit', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (50, '更新编辑', 44, 2, 70, 'merchant/Merchant/update', 'merchant', 'Merchant', 'update', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (51, '删除商户', 44, 2, 80, 'merchant/Merchant/delete', 'merchant', 'Merchant', 'delete', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (52, '批量删除', 44, 2, 80, 'merchant/Merchant/deleteItems', 'system', 'Merchant', 'deleteItems', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (53, '更新状态', 44, 2, 80, 'merchant/Merchant/setState', 'system', 'Merchant', 'setState', 1492247935, 0, 1, 0);
INSERT INTO `fight_menu` VALUES (54, '批量更新', 44, 2, 80, 'merchant/Merchant/setStates', 'system', 'Merchant', 'setStates', 1492247935, 0, 1, 0);

-- ----------------------------
-- Table structure for fight_merchant
-- ----------------------------
DROP TABLE IF EXISTS `fight_merchant`;
CREATE TABLE `fight_merchant`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户账号',
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户密码',
  `user_money` decimal(11, 2) UNSIGNED NOT NULL COMMENT '账户余额',
  `rate` float NOT NULL COMMENT '手续费率',
  `user_tel` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户手机',
  `user_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户姓名',
  `key` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户key',
  `security_remind` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '安全金额提醒',
  `audit_switch` tinyint(1) UNSIGNED NOT NULL COMMENT '大额审核开关 0=>\'开\', 1=>\'关\'',
  `white_list` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '白名单',
  `times` tinyint(3) NOT NULL DEFAULT 0 COMMENT '每人每天最多提现次数（不包含1元）',
  `role_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0' COMMENT '角色ids',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `state` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0=>\'正常\', 1=>\'禁用\'',
  `delete_time` int(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商户' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of fight_merchant
-- ----------------------------
INSERT INTO `fight_merchant` VALUES (1, 'admin', '021c6cd3a69730ac97d0b65576a9004f', 100.00, 0.02, '123', '54', '67568', '789', 0, '789', 127, '0', 1517452535, 0, 0, 0);

-- ----------------------------
-- Table structure for fight_role
-- ----------------------------
DROP TABLE IF EXISTS `fight_role`;
CREATE TABLE `fight_role`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '角色名称',
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  `state` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=>\'正常\', 1=>\'禁用\'',
  `delete_time` int(11) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `fight_role_id_uindex`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '角色' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of fight_role
-- ----------------------------
INSERT INTO `fight_role` VALUES (1, '超级管理员', 1504785661, 1517479710, 0, 0);
INSERT INTO `fight_role` VALUES (2, '客服', 1504785661, 1517479727, 0, 0);

-- ----------------------------
-- Table structure for fight_role_rule
-- ----------------------------
DROP TABLE IF EXISTS `fight_role_rule`;
CREATE TABLE `fight_role_rule`  (
  `role_id` int(11) NOT NULL,
  `rule_id` int(11) NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '角色规则管理' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of fight_role_rule
-- ----------------------------
INSERT INTO `fight_role_rule` VALUES (0, 0);
INSERT INTO `fight_role_rule` VALUES (2, 1);

-- ----------------------------
-- Table structure for fight_rule
-- ----------------------------
DROP TABLE IF EXISTS `fight_rule`;
CREATE TABLE `fight_rule`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '规则id',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '规则名称',
  `rule` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规则',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规则描述',
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  `state` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=>\'正常\', 1=>\'禁用\'',
  `delete_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '规则' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of fight_rule
-- ----------------------------
INSERT INTO `fight_rule` VALUES (1, '商户权限', '{\"name\":\"menu\",\"where\":{\"id\":[\"in\",[\"1\",\"2\",\"44\",\"46\",\"47\",\"48\",\"49\",\"50\",\"53\",\"52\",\"51\",\"45\",\"54\"]]}}', '', 1504785661, 1517477156, 0, 0);
INSERT INTO `fight_rule` VALUES (2, '客服权限', '{\"name\":\"menu\",\"where\":{\"id\":[\"in\",[1]]}}', '', 1504785661, 1504785661, 0, 0);

-- ----------------------------
-- Table structure for fight_user
-- ----------------------------
DROP TABLE IF EXISTS `fight_user`;
CREATE TABLE `fight_user`  (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `password` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `role_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '角色ids',
  `create_time` int(10) NOT NULL DEFAULT 0,
  `update_time` int(10) NOT NULL DEFAULT 0,
  `state` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=>\'正常\', 1=>\'禁用\'',
  `delete_time` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of fight_user
-- ----------------------------
INSERT INTO `fight_user` VALUES (1, 'admin', '021c6cd3a69730ac97d0b65576a9004f', '1', 1513051900, 1517213225, 0, 0);
INSERT INTO `fight_user` VALUES (2, 'fight', '021c6cd3a69730ac97d0b65576a9004f', '2', 1517209779, 1517370398, 0, 0);

SET FOREIGN_KEY_CHECKS = 1;
