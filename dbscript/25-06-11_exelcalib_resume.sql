/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 50733
 Source Host           : localhost:3306
 Source Schema         : exelcalib

 Target Server Type    : MySQL
 Target Server Version : 50733
 File Encoding         : 65001

 Date: 11/06/2025 10:38:07
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for resume
-- ----------------------------
DROP TABLE IF EXISTS `resume`;
CREATE TABLE `resume`  (
  `id_resume` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_alat` int(11) NULL DEFAULT NULL,
  `no_po` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nama_po` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tanggal_po` date NULL DEFAULT NULL,
  `jumlah` int(11) NULL DEFAULT 0,
  `jumlah_progress` int(11) NULL DEFAULT 0,
  `jumlah_finish` int(11) NULL DEFAULT 0,
  `jumlah_laik` int(11) NULL DEFAULT 0,
  `jumlah_tidak` int(11) NULL DEFAULT NULL,
  `extra` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `id_po` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_resume`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
