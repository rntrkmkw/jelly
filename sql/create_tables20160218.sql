-- MySQL dump 10.13  Distrib 5.6.24, for osx10.8 (x86_64)
--
-- Host: 127.0.0.1    Database: jelly_db
-- ------------------------------------------------------
-- Server version	5.7.10

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `m_event`
--

DROP TABLE IF EXISTS `m_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'イベントリストID',
  `name` varchar(256) NOT NULL COMMENT 'イベント名',
  `start_at` datetime NOT NULL COMMENT '開始日時',
  `end_at` datetime NOT NULL COMMENT '終了日時',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='イベントマスタ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_event`
--

LOCK TABLES `m_event` WRITE;
/*!40000 ALTER TABLE `m_event` DISABLE KEYS */;
INSERT INTO `m_event` VALUES (1,'イベントサンプルA','0000-00-00 00:00:00','2030-12-31 23:59:59','0','2016-01-21 15:00:00','kamikawa','2016-01-21 15:00:00','kamikawa');
/*!40000 ALTER TABLE `m_event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_event_member`
--

DROP TABLE IF EXISTS `m_event_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_event_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'イベントメンバーリストID',
  `m_event_id` int(11) NOT NULL COMMENT 'イベントリストID',
  `member1` int(11) NOT NULL COMMENT 'イベントメンバーのユーザID(1)',
  `member2` int(11) NOT NULL COMMENT 'イベントメンバーのユーザID(2)',
  `member3` int(11) NOT NULL COMMENT 'イベントメンバーのユーザID(3)',
  `member4` int(11) NOT NULL COMMENT 'イベントメンバーのユーザID(4)',
  `member5` int(11) NOT NULL COMMENT 'イベントメンバーのユーザID(5)',
  `member6` int(11) NOT NULL COMMENT 'イベントメンバーのユーザID(6)',
  `member7` int(11) NOT NULL COMMENT 'イベントメンバーのユーザID(7)',
  `member8` int(11) NOT NULL COMMENT 'イベントメンバーのユーザID(8)',
  `member9` int(11) NOT NULL COMMENT 'イベントメンバーのユーザID(9)',
  `member10` int(11) NOT NULL COMMENT 'イベントメンバーのユーザID(10)',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='イベントメンバマスタ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_event_member`
--

LOCK TABLES `m_event_member` WRITE;
/*!40000 ALTER TABLE `m_event_member` DISABLE KEYS */;
INSERT INTO `m_event_member` VALUES (1,1,1,2,3,4,5,6,7,8,9,10,'0','2016-01-21 15:00:00','kamikawa','2016-01-21 15:00:00','kamikawa');
/*!40000 ALTER TABLE `m_event_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_event_reward`
--

DROP TABLE IF EXISTS `m_event_reward`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_event_reward` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'イベント報酬リストID',
  `m_item_id` int(11) NOT NULL COMMENT 'アイテムリストIDもしくは0(=無償ゴールド)',
  `cnt` int(11) NOT NULL COMMENT 'アイテム個数もしくは無償ゴールド数',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='イベント報酬マスタ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_event_reward`
--

LOCK TABLES `m_event_reward` WRITE;
/*!40000 ALTER TABLE `m_event_reward` DISABLE KEYS */;
/*!40000 ALTER TABLE `m_event_reward` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_event_stage`
--

DROP TABLE IF EXISTS `m_event_stage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_event_stage` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'イベントステージリストID',
  `m_event_id` int(11) NOT NULL COMMENT 'イベントリストID',
  `stage1` int(11) NOT NULL COMMENT 'ステージリストID(1)',
  `stage2` int(11) NOT NULL COMMENT 'ステージリストID(2)',
  `stage3` int(11) NOT NULL COMMENT 'ステージリストID(3)',
  `stage4` int(11) NOT NULL COMMENT 'ステージリストID(4)',
  `stage5` int(11) NOT NULL COMMENT 'ステージリストID(5)',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='イベントステージマスタ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_event_stage`
--

LOCK TABLES `m_event_stage` WRITE;
/*!40000 ALTER TABLE `m_event_stage` DISABLE KEYS */;
INSERT INTO `m_event_stage` VALUES (1,1,1,2,3,4,5,'0','2016-01-21 15:00:00','kamikawa','2016-01-21 15:00:00','kamikawa');
/*!40000 ALTER TABLE `m_event_stage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_gold_android`
--

DROP TABLE IF EXISTS `m_gold_android`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_gold_android` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '有償ゴールド購入リスト(Android)ID',
  `product_id` varchar(256) NOT NULL COMMENT 'プロダクトID(Google管理用)',
  `type` char(1) NOT NULL COMMENT 'プロダクト種別(Google管理用)　0:Unmanaged, 1:Managed',
  `publish_flg` char(1) NOT NULL DEFAULT '0' COMMENT 'ストアに掲載するかどうか(Google管理用)　0:Unpublished, 1:Published',
  `language` char(1) NOT NULL COMMENT '言語(Google管理用)　1:日本語, 2:英語',
  `title` varchar(256) NOT NULL COMMENT 'ユーザに表示されるプロダクト名(Google管理用)',
  `description` varchar(256) NOT NULL COMMENT 'ユーザに表示されるプロダクトの説明(Google管理用)',
  `autofill` char(1) NOT NULL COMMENT '為替自動変換(Google管理用)　0:false, 1:true',
  `country` varchar(256) NOT NULL COMMENT '適用する国(Google管理用)',
  `price` int(11) NOT NULL COMMENT '適用する価格(Google管理用)',
  `charge_gold` int(11) NOT NULL COMMENT '有償ゴールド数',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='有償ゴールド購入(Android)マスタ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_gold_android`
--

LOCK TABLES `m_gold_android` WRITE;
/*!40000 ALTER TABLE `m_gold_android` DISABLE KEYS */;
INSERT INTO `m_gold_android` VALUES (1,'aaaaaaaaa','0','1','0','10ゴールド','ゲーム内通貨10ゴールド分','1','',100,10,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(2,'bbbbbbbb','0','1','0','30ゴールド','ゲーム内通貨30ゴールド分','1','',200,30,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(3,'cccccccc','0','1','0','1,000ゴールド','ゲーム内通貨1,000ゴールド分','1','',800,1000,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(4,'dddddddd','0','1','0','5,000ゴールド','ゲーム内通貨5,000ゴールド分','1','',3000,5000,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa');
/*!40000 ALTER TABLE `m_gold_android` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_gold_ios`
--

DROP TABLE IF EXISTS `m_gold_ios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_gold_ios` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '有償ゴールド購入リスト(iOS)ID',
  `apple_id` varchar(256) NOT NULL COMMENT 'Apple_ID(Apple管理用)',
  `reference_name` varchar(256) NOT NULL COMMENT 'リファレンス名(Apple管理用)',
  `product_id` varchar(256) NOT NULL COMMENT 'プロダクトID(Apple管理用)',
  `type` char(1) NOT NULL COMMENT 'プロダクト種別(Apple管理用)　0:Consumable, 1:Non-Consumable',
  `language` char(1) NOT NULL COMMENT '言語(Apple管理用)　1:日本語 2:英語',
  `display_name` varchar(256) NOT NULL COMMENT 'ユーザに表示されるプロダクト名(Apple管理用)',
  `description` varchar(256) NOT NULL COMMENT 'ユーザに表示されるプロダクトの説明',
  `cleared_for_sale` char(1) NOT NULL COMMENT 'プロダクトが購入可能かどうか(Apple管理用)　0:不可能, 1:可能',
  `price_tier` int(11) NOT NULL COMMENT '価格帯(Apple管理用)',
  `effective_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `charge_gold` int(11) NOT NULL COMMENT '有償ゴールド数',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='有償ゴールド購入(iOS)マスタ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_gold_ios`
--

LOCK TABLES `m_gold_ios` WRITE;
/*!40000 ALTER TABLE `m_gold_ios` DISABLE KEYS */;
INSERT INTO `m_gold_ios` VALUES (1,'11111111','10ゴールド','aaaaaaaaa','0','0','10ゴールド','アプリ内通貨10ゴールド分','1',100,'0000-00-00 00:00:00','2030-12-31 23:59:59',10,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(2,'22222222','30ゴールド','BBBBBBBB','0','0','30ゴールド','アプリ内通貨30ゴールド分','1',200,'0000-00-00 00:00:00','2030-12-31 23:59:59',30,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(3,'33333333','1,000ゴールド','CCCCCCCC','0','0','1,000ゴールド','アプリ内通貨1,000ゴールド分','1',800,'0000-00-00 00:00:00','2030-12-31 23:59:59',1000,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(4,'44444444','5,000ゴールド','DDDDDDDD','0','0','5,000ゴールド','アプリ内通貨5,000ゴールド分','1',3000,'0000-00-00 00:00:00','2030-12-31 23:59:59',5000,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa');
/*!40000 ALTER TABLE `m_gold_ios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_item`
--

DROP TABLE IF EXISTS `m_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'アイテムリストID',
  `name` varchar(256) NOT NULL COMMENT 'アイテム名',
  `description` varchar(256) NOT NULL COMMENT 'アイテムの説明',
  `effect_name` varchar(256) NOT NULL COMMENT '効果名',
  `effect_type` varchar(256) NOT NULL COMMENT '効果対象　1:移動回数, 2:時間',
  `effect_value` int(11) NOT NULL COMMENT '効力(効果対象が移動回数なら◯◯回、時間なら◯◯秒)',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='アイテムマスタ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_item`
--

LOCK TABLES `m_item` WRITE;
/*!40000 ALTER TABLE `m_item` DISABLE KEYS */;
INSERT INTO `m_item` VALUES (1,'ロリポップハンマー','キャンディーを粉々に！','アイテム効果サンプルA','1',10,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(2,'ラッピング＆ストラップ','ラッピングとストラップキャンディーを入れてスタート！','アイテム効果サンプルB','1',30,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(3,'カラーボム','カラーボムを入れてスタート！','アイテム効果サンプルC','2',30,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(4,'ココナッツホイール','3列分のキャンディが全部消える、破壊力大のアイテム！','アイテム効果サンプルD','2',60,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(5,'フリースイッチ','隣り合わせにある色違いのキャンディの位置を入れ替える事ができます','アイテム効果サンプルE','2',120,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa');
/*!40000 ALTER TABLE `m_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_item_price`
--

DROP TABLE IF EXISTS `m_item_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_item_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'アイテム価格リストID',
  `m_item_id` int(11) NOT NULL COMMENT 'アイテムリストID',
  `cnt` int(11) NOT NULL COMMENT '個数',
  `price` int(11) NOT NULL COMMENT '必要ゴールド数',
  `start_at` datetime NOT NULL COMMENT '価格適用開始日時',
  `end_at` datetime NOT NULL COMMENT '価格適用終了日時',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='アイテム価格マスタ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_item_price`
--

LOCK TABLES `m_item_price` WRITE;
/*!40000 ALTER TABLE `m_item_price` DISABLE KEYS */;
INSERT INTO `m_item_price` VALUES (1,1,3,19,'0000-00-00 00:00:00','2030-12-31 23:59:59','0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(2,1,9,49,'0000-00-00 00:00:00','2030-12-31 23:59:59','0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(3,1,18,88,'0000-00-00 00:00:00','2030-12-31 23:59:59','0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(4,2,3,19,'0000-00-00 00:00:00','2030-12-31 23:59:59','0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(5,2,9,49,'0000-00-00 00:00:00','2030-12-31 23:59:59','0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(6,2,18,88,'0000-00-00 00:00:00','2030-12-31 23:59:59','0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(7,3,3,19,'0000-00-00 00:00:00','2030-12-31 23:59:59','0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(8,3,9,49,'0000-00-00 00:00:00','2030-12-31 23:59:59','0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(9,3,18,88,'0000-00-00 00:00:00','2030-12-31 23:59:59','0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(10,4,3,19,'0000-00-00 00:00:00','2030-12-31 23:59:59','0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(11,4,9,49,'0000-00-00 00:00:00','2030-12-31 23:59:59','0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(12,4,18,88,'0000-00-00 00:00:00','2030-12-31 23:59:59','0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(13,5,3,19,'0000-00-00 00:00:00','2030-12-31 23:59:59','0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(14,5,9,49,'0000-00-00 00:00:00','2030-12-31 23:59:59','0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(15,5,18,88,'0000-00-00 00:00:00','2030-12-31 23:59:59','0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa');
/*!40000 ALTER TABLE `m_item_price` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_map`
--

DROP TABLE IF EXISTS `m_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'マップリストID',
  `name` varchar(256) NOT NULL COMMENT 'マップ名',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='マップマスタ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_map`
--

LOCK TABLES `m_map` WRITE;
/*!40000 ALTER TABLE `m_map` DISABLE KEYS */;
INSERT INTO `m_map` VALUES (1,'マップサンプルA','0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(2,'マップサンプルB','0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa');
/*!40000 ALTER TABLE `m_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_notice`
--

DROP TABLE IF EXISTS `m_notice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'お知らせリストID',
  `title` varchar(256) NOT NULL COMMENT 'タイトル',
  `contents` text NOT NULL,
  `m_reward_id` int(11) NOT NULL DEFAULT '0' COMMENT '報酬リストIDもしくは0(=報酬なし)',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='お知らせマスタ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_notice`
--

LOCK TABLES `m_notice` WRITE;
/*!40000 ALTER TABLE `m_notice` DISABLE KEYS */;
INSERT INTO `m_notice` VALUES (1,'お知らせサンプルA','AAAAAAAAAAAAAAAAAAAAAAAAAAA',0,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(2,'お知らせサンプルB','BBBBBBBBBBBBBBBBBBBBBBBBBBB',1,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(3,'お知らせサンプルC','CCCCCCCCCCCCCCCCCCCCCCCCCCC',2,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa');
/*!40000 ALTER TABLE `m_notice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_reward`
--

DROP TABLE IF EXISTS `m_reward`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_reward` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '報酬リストID',
  `m_item_id` int(11) NOT NULL COMMENT 'アイテムリストIDもしくは0(=無償ゴールド)',
  `cnt` int(11) NOT NULL COMMENT 'アイテム個数もしくは無償ゴールド数',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='報酬マスタ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_reward`
--

LOCK TABLES `m_reward` WRITE;
/*!40000 ALTER TABLE `m_reward` DISABLE KEYS */;
INSERT INTO `m_reward` VALUES (1,0,10,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(2,1,1,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa');
/*!40000 ALTER TABLE `m_reward` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_stage`
--

DROP TABLE IF EXISTS `m_stage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_stage` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ステージリストID',
  `name` varchar(256) NOT NULL COMMENT 'ステージ名',
  `m_map_id` int(11) NOT NULL COMMENT 'このステージが属するマップリストID',
  `m_reward_id` int(11) NOT NULL DEFAULT '0' COMMENT '報酬リストIDもしくは0(=報酬なし)',
  `event_map_id` int(11) NOT NULL COMMENT 'マップリストID(イベント用)',
  `m_event_reward_id` int(11) NOT NULL DEFAULT '0' COMMENT '報酬リストIDもしくは0(=報酬なし)(イベント用)',
  `level` int(11) NOT NULL COMMENT '難易度',
  `comp_type` char(1) NOT NULL COMMENT 'クリア種別　0:移動回数制限, 1:時間制限',
  `comp_condition` int(11) NOT NULL COMMENT 'クリア種別の制限値',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COMMENT='ステージマスタ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_stage`
--

LOCK TABLES `m_stage` WRITE;
/*!40000 ALTER TABLE `m_stage` DISABLE KEYS */;
INSERT INTO `m_stage` VALUES (1,'ステージサンプルA-1',1,0,0,0,1,'1',5,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(2,'ステージサンプルA-2',1,0,0,0,2,'1',5,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(3,'ステージサンプルA-3',1,0,0,0,3,'1',5,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(4,'ステージサンプルA-4',1,0,0,0,4,'1',5,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(5,'ステージサンプルA-5',1,0,0,0,5,'1',10,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(6,'ステージサンプルA-6',1,0,0,0,6,'1',10,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(7,'ステージサンプルA-7',1,0,0,0,7,'1',10,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(8,'ステージサンプルA-8',1,0,0,0,8,'1',10,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(9,'ステージサンプルA-9',1,0,0,0,9,'1',15,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(10,'ステージサンプルA-10',1,0,0,0,10,'1',15,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(11,'ステージサンプルA-11',1,0,0,0,11,'1',15,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(12,'ステージサンプルA-12',1,0,0,0,12,'1',15,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(13,'ステージサンプルA-13',1,0,0,0,13,'1',20,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(14,'ステージサンプルA-14',1,0,0,0,14,'1',20,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(15,'ステージサンプルA-15',1,0,0,0,15,'1',20,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(16,'ステージサンプルA-16',1,0,0,0,16,'1',20,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(17,'ステージサンプルA-17',1,0,0,0,17,'1',25,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(18,'ステージサンプルA-18',1,0,0,0,18,'1',25,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(19,'ステージサンプルA-19',1,0,0,0,19,'1',25,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(20,'ステージサンプルA-20',1,0,0,0,20,'1',25,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(21,'ステージサンプルB-1',2,0,0,0,11,'2',30,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(22,'ステージサンプルB-2',2,0,0,0,12,'2',30,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(23,'ステージサンプルB-3',2,0,0,0,13,'2',30,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(24,'ステージサンプルB-4',2,0,0,0,14,'2',30,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(25,'ステージサンプルB-5',2,0,0,0,15,'2',45,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(26,'ステージサンプルB-6',2,0,0,0,16,'2',45,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(27,'ステージサンプルB-7',2,0,0,0,17,'2',45,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(28,'ステージサンプルB-8',2,0,0,0,18,'2',45,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(29,'ステージサンプルB-9',2,0,0,0,19,'2',60,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(30,'ステージサンプルB-10',2,0,0,0,20,'2',60,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(31,'ステージサンプルB-11',2,0,0,0,21,'2',60,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(32,'ステージサンプルB-12',2,0,0,0,22,'2',60,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(33,'ステージサンプルB-13',2,0,0,0,23,'2',75,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(34,'ステージサンプルB-14',2,0,0,0,24,'2',75,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(35,'ステージサンプルB-15',2,0,0,0,25,'2',75,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(36,'ステージサンプルB-16',2,0,0,0,26,'2',75,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(37,'ステージサンプルB-17',2,0,0,0,27,'2',90,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(38,'ステージサンプルB-18',2,0,0,0,28,'2',90,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(39,'ステージサンプルB-19',2,0,0,0,29,'2',90,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(40,'ステージサンプルB-20',2,0,0,0,30,'2',90,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa');
/*!40000 ALTER TABLE `m_stage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_stage_detail`
--

DROP TABLE IF EXISTS `m_stage_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_stage_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ステージ詳細リストID',
  `m_stage_id` int(11) NOT NULL COMMENT 'ステージリストID',
  `name` varchar(256) NOT NULL COMMENT 'ステージ詳細名',
  `length_x` int(11) NOT NULL COMMENT '横マスの数',
  `length_y` int(11) NOT NULL COMMENT '縦マスの数',
  `obstacle` int(11) NOT NULL COMMENT '障害物の数',
  `goal` int(11) NOT NULL COMMENT 'ゴールの数',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='ステージ詳細マスタ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_stage_detail`
--

LOCK TABLES `m_stage_detail` WRITE;
/*!40000 ALTER TABLE `m_stage_detail` DISABLE KEYS */;
INSERT INTO `m_stage_detail` VALUES (1,1,'ステージサンプルA-1-1',5,5,0,1,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(2,2,'ステージサンプルA-2-1',9,7,1,1,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(3,3,'ステージサンプルA-3-1',5,5,2,1,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(4,4,'ステージサンプルA-4-1',5,5,3,1,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(5,5,'ステージサンプルA-5-1',5,5,4,1,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(6,6,'ステージサンプルA-6-1',5,5,0,2,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(7,7,'ステージサンプルA-7-1',5,5,1,2,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(8,8,'ステージサンプルA-8-1',5,5,2,2,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(9,9,'ステージサンプルA-9-1',5,5,3,2,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(10,10,'ステージサンプルA-10-1',5,5,4,2,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(11,11,'ステージサンプルA-11-1',5,5,0,3,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(12,12,'ステージサンプルA-12-1',5,5,1,3,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(13,13,'ステージサンプルA-13-1',5,5,2,3,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(14,14,'ステージサンプルA-14-1',5,5,3,3,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(15,15,'ステージサンプルA-15-1',5,5,4,3,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(16,16,'ステージサンプルA-16-1',5,5,0,4,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(17,17,'ステージサンプルA-17-1',5,5,1,4,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(18,18,'ステージサンプルA-18-1',5,5,2,4,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(19,19,'ステージサンプルA-19-1',5,5,3,4,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(20,20,'ステージサンプルA-20-1',5,5,4,4,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa');
/*!40000 ALTER TABLE `m_stage_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_stage_fence`
--

DROP TABLE IF EXISTS `m_stage_fence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_stage_fence` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ステージブロックリストID',
  `m_stage_detail_id` int(11) NOT NULL COMMENT 'ステージ詳細リストID',
  `base_x` int(11) NOT NULL COMMENT 'フェンスの起点のX座標',
  `base_y` int(11) NOT NULL COMMENT 'フェンスの起点のY座標',
  `direction` char(1) NOT NULL COMMENT 'フェンスの向き　0:X方向, 1:Y方向',
  `size` int(11) NOT NULL COMMENT 'フェンスの大きさ',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='ステージブロックマスタ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_stage_fence`
--

LOCK TABLES `m_stage_fence` WRITE;
/*!40000 ALTER TABLE `m_stage_fence` DISABLE KEYS */;
INSERT INTO `m_stage_fence` VALUES (1,1,-2,3,'0',5,'0','2016-02-22 11:00:00','kamikawa','2016-02-22 11:00:00','kamikawa'),(2,1,3,-2,'1',5,'0','2016-02-22 11:00:00','kamikawa','2016-02-22 11:00:00','kamikawa'),(3,1,-2,-3,'0',5,'0','2016-02-22 11:00:00','kamikawa','2016-02-22 11:00:00','kamikawa'),(4,1,-3,-2,'1',5,'0','2016-02-22 11:00:00','kamikawa','2016-02-22 11:00:00','kamikawa'),(5,2,-4,4,'0',9,'0','2016-02-22 11:00:00','kamikawa','2016-02-22 11:00:00','kamikawa'),(6,2,5,-3,'1',7,'0','2016-02-22 11:00:00','kamikawa','2016-02-22 11:00:00','kamikawa'),(7,2,-4,-4,'0',9,'0','2016-02-22 11:00:00','kamikawa','2016-02-22 11:00:00','kamikawa'),(8,2,-5,-3,'1',7,'0','2016-02-22 11:00:00','kamikawa','2016-02-22 11:00:00','kamikawa');
/*!40000 ALTER TABLE `m_stage_fence` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_stage_jelly`
--

DROP TABLE IF EXISTS `m_stage_jelly`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_stage_jelly` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ステージゼリーリストID',
  `m_stage_detail_id` int(11) NOT NULL COMMENT 'ステージ詳細リストID',
  `position_x` int(11) NOT NULL COMMENT 'X座標',
  `position_y` int(11) NOT NULL COMMENT 'Y座標',
  `position_range_x` int(11) NOT NULL COMMENT 'X座標の振幅',
  `position_range_y` int(11) NOT NULL COMMENT 'Y座標の振幅',
  `type` int(11) NOT NULL COMMENT 'ゼリー種別　0:ゴール, 1:白, 2:緑, 3:青, 4:赤',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='ステージゼリーマスタ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_stage_jelly`
--

LOCK TABLES `m_stage_jelly` WRITE;
/*!40000 ALTER TABLE `m_stage_jelly` DISABLE KEYS */;
INSERT INTO `m_stage_jelly` VALUES (1,1,2,2,1,1,0,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(2,1,2,2,2,2,2,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(3,1,2,2,2,2,3,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(4,2,2,2,1,1,0,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(5,2,2,2,2,2,1,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(6,2,2,2,2,2,2,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa'),(7,2,2,2,3,3,3,'0','2016-01-18 11:00:00','kamikawa','2016-01-18 11:00:00','kamikawa');
/*!40000 ALTER TABLE `m_stage_jelly` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_version`
--

DROP TABLE IF EXISTS `m_version`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_version` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'バージョンリストID',
  `app_version` varchar(256) NOT NULL COMMENT 'アプリバージョン',
  `dl_host` varchar(256) NOT NULL COMMENT 'ダウンロード先ホスト名',
  `master_version` int(11) NOT NULL COMMENT 'マスタバージョン',
  `ios_review` char(1) NOT NULL COMMENT '0:通常, 1:レビュー',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='バージョンマスタ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_version`
--

LOCK TABLES `m_version` WRITE;
/*!40000 ALTER TABLE `m_version` DISABLE KEYS */;
INSERT INTO `m_version` VALUES (1,'aaaaaaaa','dddddddd',1,'0','0','2016-01-21 15:00:00','kamikawa','2016-01-21 15:00:00','kamikawa');
/*!40000 ALTER TABLE `m_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_device`
--

DROP TABLE IF EXISTS `t_device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_device` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'デバイスID',
  `uiid` varchar(256) NOT NULL COMMENT '端末識別番号',
  `app_ver` varchar(256) NOT NULL COMMENT 'アプリバージョン',
  `os_type` char(1) NOT NULL COMMENT 'OS種別　0:iOS, 1:Android',
  `os_ver` varchar(256) NOT NULL COMMENT 'OSバージョン',
  `device_ver` varchar(256) NOT NULL COMMENT 'デバイスバージョン',
  `device_token` varchar(256) NOT NULL COMMENT 'プッシュ通知用のトークン',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新者',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_device`
--

LOCK TABLES `t_device` WRITE;
/*!40000 ALTER TABLE `t_device` DISABLE KEYS */;
INSERT INTO `t_device` VALUES (2,'validationtest','','0','','validationtest','validationtest','0','2016-02-18 18:49:58','::1','2016-02-18 18:49:58','::1'),(3,'paramsmodifytest','1.0.0','0','8.1.2','paramsmodifytest','paramsmodifytest','0','2016-02-22 12:09:03','::1','2016-02-22 12:09:03','::1'),(4,'versionvalidationtest','a1.0.0','0','a8.1.2','versionvalidationtest','versionvalidationtest','0','2016-02-22 12:10:18','::1','2016-02-22 12:10:18','::1'),(5,'versiontest','1.0.0','0','8.1.2','versiontest','versiontest','0','2016-02-22 12:13:17','::1','2016-02-22 12:13:17','::1');
/*!40000 ALTER TABLE `t_device` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_event_king`
--

DROP TABLE IF EXISTS `t_event_king`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_event_king` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'イベントキング情報ID',
  `m_event_group_id` int(11) NOT NULL COMMENT 'イベントユーザグループID',
  `user_id` int(11) NOT NULL COMMENT 'ユーザID',
  `success_date` datetime NOT NULL COMMENT 'キング達成日時',
  `m_event_reward_id` int(11) NOT NULL COMMENT 'イベント報酬リストID',
  `dist_flg` char(1) NOT NULL DEFAULT '0' COMMENT '報酬配布フラグ　0:未配布, 1:配布済',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='イベントキング情報';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_event_king`
--

LOCK TABLES `t_event_king` WRITE;
/*!40000 ALTER TABLE `t_event_king` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_event_king` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_event_member`
--

DROP TABLE IF EXISTS `t_event_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_event_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'イベントメンバー情報ID',
  `m_event_member_id` int(11) NOT NULL COMMENT 'イベントメンバーリストID',
  `user_id` int(11) NOT NULL COMMENT 'ユーザID',
  `member_id` int(11) NOT NULL COMMENT '同一グループのユーザID',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='イベントメンバ情報';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_event_member`
--

LOCK TABLES `t_event_member` WRITE;
/*!40000 ALTER TABLE `t_event_member` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_event_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_event_stage`
--

DROP TABLE IF EXISTS `t_event_stage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_event_stage` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'イベントステージ情報ID',
  `m_event_stage_id` int(11) NOT NULL COMMENT 'イベントステージリストID',
  `user_id` int(11) NOT NULL COMMENT 'ユーザID',
  `m_stage_id` int(11) NOT NULL COMMENT 'ステージリストID',
  `status` char(1) NOT NULL DEFAULT '0' COMMENT 'ステータス　0:未トライ, 1:トライ中, 2:クリア済',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='イベントステージ情報';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_event_stage`
--

LOCK TABLES `t_event_stage` WRITE;
/*!40000 ALTER TABLE `t_event_stage` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_event_stage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_friend`
--

DROP TABLE IF EXISTS `t_friend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_friend` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'フレンド情報ID',
  `user_id` int(11) NOT NULL COMMENT 'ユーザID',
  `friend_id` int(11) NOT NULL COMMENT 'フレンド関係にあるユーザID',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='フレンド情報';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_friend`
--

LOCK TABLES `t_friend` WRITE;
/*!40000 ALTER TABLE `t_friend` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_friend` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_gold`
--

DROP TABLE IF EXISTS `t_gold`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_gold` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ユーザ所持ゴールド詳細ID',
  `user_id` int(11) NOT NULL COMMENT 'ユーザID',
  `sum_gold` int(11) NOT NULL DEFAULT '0' COMMENT '合計ゴールド所持数',
  `charge_gold` int(11) NOT NULL DEFAULT '0' COMMENT '有償ゴールド所持数',
  `free_gold` int(11) NOT NULL DEFAULT '0' COMMENT '無償ゴールド所持数',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='ゴールド情報';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_gold`
--

LOCK TABLES `t_gold` WRITE;
/*!40000 ALTER TABLE `t_gold` DISABLE KEYS */;
INSERT INTO `t_gold` VALUES (1,1,998448,900102,98346,'0','2016-01-26 11:00:00','kamikawa','2016-02-22 13:45:13','::1'),(2,2,29,29,0,'0','2016-01-26 11:00:00','kamikawa','2016-01-26 16:29:23','::1'),(3,3,0,0,0,'0','2016-01-29 11:15:57','::1','2016-01-29 11:15:57','::1'),(4,4,10,10,0,'0','2016-01-29 11:30:00','kamikawa','2016-01-29 11:30:00',''),(5,4,0,0,0,'0','2016-01-29 11:28:51','::1','2016-01-29 11:28:51','::1'),(6,5,0,0,0,'0','2016-02-01 18:11:02','::1','2016-02-01 18:11:02','::1'),(7,6,0,0,0,'0','2016-02-02 17:08:43','::1','2016-02-02 17:08:43','::1'),(13,12,0,0,0,'0','2016-02-03 16:34:58','::1','2016-02-03 16:34:58','::1'),(23,22,0,0,0,'0','2016-02-03 17:08:52','::1','2016-02-03 17:08:52','::1'),(24,23,0,0,0,'0','2016-02-08 12:27:06','::1','2016-02-08 12:27:06','::1'),(25,24,0,0,0,'0','2016-02-19 12:31:13','::1','2016-02-19 12:31:13','::1'),(27,26,0,0,0,'0','2016-02-19 12:39:52','::1','2016-02-19 12:39:52','::1'),(28,27,0,0,0,'0','2016-02-19 12:42:26','::1','2016-02-19 12:42:26','::1'),(29,28,100,50,50,'0','2016-02-22 12:14:04','::1','2016-02-22 12:14:04','::1');
/*!40000 ALTER TABLE `t_gold` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_gold_history`
--

DROP TABLE IF EXISTS `t_gold_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_gold_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '有償ゴールド購入詳細ID',
  `device_id` int(11) NOT NULL COMMENT 'デバイスID',
  `user_id` int(11) DEFAULT NULL COMMENT 'ユーザID',
  `os_type` char(1) NOT NULL COMMENT 'OS種別　0:iOS, 1:Android',
  `m_gold_id` int(11) NOT NULL COMMENT '有償ゴールド購入リストID',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='有償ゴールド購入履歴情報';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_gold_history`
--

LOCK TABLES `t_gold_history` WRITE;
/*!40000 ALTER TABLE `t_gold_history` DISABLE KEYS */;
INSERT INTO `t_gold_history` VALUES (3,0,1,'1',1,'0','2016-02-12 16:51:47','::1','2016-02-12 16:51:47','::1'),(4,0,1,'1',1,'0','2016-02-12 16:52:49','::1','2016-02-12 16:52:49','::1'),(5,0,1,'1',1,'0','2016-02-12 16:53:53','::1','2016-02-12 16:53:53','::1'),(6,0,1,'0',1,'0','2016-02-12 17:03:35','::1','2016-02-12 17:03:35','::1'),(7,0,1,'0',1,'0','2016-02-12 17:13:21','::1','2016-02-12 17:13:21','::1'),(8,0,1,'0',1,'0','2016-02-12 17:18:40','::1','2016-02-12 17:18:40','::1'),(9,0,1,'0',1,'0','2016-02-12 17:55:22','::1','2016-02-12 17:55:22','::1'),(10,0,1,'0',1,'0','2016-02-12 17:56:06','::1','2016-02-12 17:56:06','::1'),(11,0,1,'0',1,'0','2016-02-12 17:57:16','::1','2016-02-12 17:57:16','::1'),(12,0,1,'0',1,'0','2016-02-12 17:57:41','::1','2016-02-12 17:57:41','::1'),(13,0,1,'0',1,'0','2016-02-12 18:01:25','::1','2016-02-12 18:01:25','::1'),(14,0,1,'1',1,'0','2016-02-12 18:11:30','::1','2016-02-12 18:11:30','::1'),(15,2,1,'0',1,'0','2016-02-22 13:16:29','::1','2016-02-22 13:16:29','::1'),(16,2,1,'1',1,'0','2016-02-22 13:18:05','::1','2016-02-22 13:18:05','::1'),(17,2,NULL,'1',1,'0','2016-02-22 13:26:27','::1','2016-02-22 13:26:27','::1'),(18,2,NULL,'1',1,'0','2016-02-22 13:32:46','::1','2016-02-22 13:32:46','::1'),(20,2,NULL,'1',1,'0','2016-02-22 13:42:51','::1','2016-02-22 13:42:51','::1'),(22,2,NULL,'0',1,'0','2016-02-22 13:44:13','::1','2016-02-22 13:44:13','::1'),(23,2,NULL,'0',1,'0','2016-02-22 13:45:13','::1','2016-02-22 13:45:13','::1');
/*!40000 ALTER TABLE `t_gold_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_item`
--

DROP TABLE IF EXISTS `t_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ユーザ所持アイテム情報ID',
  `user_id` int(11) NOT NULL COMMENT 'ユーザID',
  `m_item_id` int(11) NOT NULL COMMENT 'アイテムリストID',
  `cnt` int(11) NOT NULL COMMENT '所持数',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='アイテム情報';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_item`
--

LOCK TABLES `t_item` WRITE;
/*!40000 ALTER TABLE `t_item` DISABLE KEYS */;
INSERT INTO `t_item` VALUES (1,1,1,284,'0','2016-01-26 11:00:00','kamikawa','2016-02-22 13:45:13','::1'),(2,1,2,0,'0','2016-01-26 11:00:00','kamikawa','2016-02-08 12:51:46','::1'),(3,1,3,0,'0','2016-01-26 11:00:00','kamikawa','2016-01-26 11:00:00','kamikawa'),(4,1,4,1,'0','2016-01-26 11:00:00','kamikawa','2016-01-26 11:00:00','kamikawa'),(5,1,5,2,'0','2016-01-26 11:00:00','kamikawa','2016-01-26 11:00:00','kamikawa'),(6,2,3,1,'0','2016-01-26 11:00:00','kamikawa','2016-01-26 11:00:00','kamikawa'),(7,2,4,1,'0','2016-01-26 11:00:00','kamikawa','2016-01-26 11:00:00','kamikawa'),(8,2,5,3,'0','2016-01-26 11:00:00','kamikawa','2016-01-26 11:00:00','kamikawa'),(9,2,1,27,'0','2016-01-26 11:53:48','::1','2016-01-26 16:29:23','::1');
/*!40000 ALTER TABLE `t_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_item_history`
--

DROP TABLE IF EXISTS `t_item_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_item_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'アイテム購入詳細ID',
  `device_id` int(11) NOT NULL COMMENT 'デバイスID',
  `user_id` int(11) DEFAULT NULL COMMENT 'ユーザID',
  `m_item_price_id` int(11) NOT NULL COMMENT 'アイテム価格リストID',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8 COMMENT='アイテム購入履歴情報';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_item_history`
--

LOCK TABLES `t_item_history` WRITE;
/*!40000 ALTER TABLE `t_item_history` DISABLE KEYS */;
INSERT INTO `t_item_history` VALUES (1,0,2,1,'0','2016-01-26 16:25:46','::1','2016-01-26 16:25:46','::1'),(2,0,2,1,'0','2016-01-26 16:26:52','::1','2016-01-26 16:26:52','::1'),(3,0,2,1,'0','2016-01-26 16:27:05','::1','2016-01-26 16:27:05','::1'),(4,0,2,1,'0','2016-01-26 16:27:18','::1','2016-01-26 16:27:18','::1'),(5,0,2,1,'0','2016-01-26 16:28:21','::1','2016-01-26 16:28:21','::1'),(6,0,2,1,'0','2016-01-26 16:29:23','::1','2016-01-26 16:29:23','::1'),(7,0,1,1,'0','2016-02-08 12:47:53','::1','2016-02-08 12:47:53','::1'),(8,0,1,1,'0','2016-02-08 12:51:46','::1','2016-02-08 12:51:46','::1'),(9,0,1,1,'0','2016-02-08 12:54:14','::1','2016-02-08 12:54:14','::1'),(10,0,1,1,'0','2016-02-08 13:08:49','::1','2016-02-08 13:08:49','::1'),(11,0,1,1,'0','2016-02-08 13:10:21','::1','2016-02-08 13:10:21','::1'),(12,0,1,1,'0','2016-02-08 13:19:29','::1','2016-02-08 13:19:29','::1'),(13,0,1,1,'0','2016-02-08 13:20:12','::1','2016-02-08 13:20:12','::1'),(14,0,1,1,'0','2016-02-08 13:22:46','::1','2016-02-08 13:22:46','::1'),(15,0,1,1,'0','2016-02-08 13:23:11','::1','2016-02-08 13:23:11','::1'),(16,0,1,1,'0','2016-02-08 13:29:08','::1','2016-02-08 13:29:08','::1'),(17,0,1,1,'0','2016-02-08 13:30:00','::1','2016-02-08 13:30:00','::1'),(18,0,1,1,'0','2016-02-08 13:30:27','::1','2016-02-08 13:30:27','::1'),(19,0,1,1,'0','2016-02-08 13:53:02','::1','2016-02-08 13:53:02','::1'),(20,0,1,1,'0','2016-02-08 14:14:31','::1','2016-02-08 14:14:31','::1'),(21,0,1,1,'0','2016-02-08 14:19:20','::1','2016-02-08 14:19:20','::1'),(22,0,1,1,'0','2016-02-08 14:21:51','::1','2016-02-08 14:21:51','::1'),(23,0,1,1,'0','2016-02-08 16:30:23','::1','2016-02-08 16:30:23','::1'),(24,0,1,1,'0','2016-02-08 16:34:03','::1','2016-02-08 16:34:03','::1'),(25,0,1,1,'0','2016-02-08 16:35:06','::1','2016-02-08 16:35:06','::1'),(26,0,1,1,'0','2016-02-08 16:45:06','::1','2016-02-08 16:45:06','::1'),(27,0,1,1,'0','2016-02-08 16:47:33','::1','2016-02-08 16:47:33','::1'),(28,0,1,1,'0','2016-02-08 17:48:29','::1','2016-02-08 17:48:29','::1'),(29,0,1,1,'0','2016-02-08 18:01:55','::1','2016-02-08 18:01:55','::1'),(30,0,1,1,'0','2016-02-08 18:06:19','::1','2016-02-08 18:06:19','::1'),(31,0,1,1,'0','2016-02-08 18:11:21','::1','2016-02-08 18:11:21','::1'),(32,0,1,1,'0','2016-02-08 18:13:49','::1','2016-02-08 18:13:49','::1'),(33,0,1,1,'0','2016-02-08 18:16:39','::1','2016-02-08 18:16:39','::1'),(34,0,1,1,'0','2016-02-08 18:22:35','::1','2016-02-08 18:22:35','::1'),(35,0,1,1,'0','2016-02-08 18:27:01','::1','2016-02-08 18:27:01','::1'),(36,0,1,1,'0','2016-02-08 18:32:01','::1','2016-02-08 18:32:01','::1'),(37,0,1,1,'0','2016-02-08 18:38:24','::1','2016-02-08 18:38:24','::1'),(38,0,1,1,'0','2016-02-08 18:38:33','::1','2016-02-08 18:38:33','::1'),(39,0,1,1,'0','2016-02-08 18:42:18','::1','2016-02-08 18:42:18','::1'),(40,0,1,1,'0','2016-02-08 18:42:20','::1','2016-02-08 18:42:20','::1'),(41,0,1,1,'0','2016-02-08 18:42:21','::1','2016-02-08 18:42:21','::1'),(42,0,1,1,'0','2016-02-08 18:42:43','::1','2016-02-08 18:42:43','::1'),(43,0,1,1,'0','2016-02-08 18:42:52','::1','2016-02-08 18:42:52','::1'),(44,0,1,1,'0','2016-02-08 18:42:58','::1','2016-02-08 18:42:58','::1'),(45,0,1,1,'0','2016-02-08 18:43:00','::1','2016-02-08 18:43:00','::1'),(46,0,1,1,'0','2016-02-08 18:43:01','::1','2016-02-08 18:43:01','::1'),(47,0,1,1,'0','2016-02-08 18:43:02','::1','2016-02-08 18:43:02','::1'),(48,0,1,1,'0','2016-02-08 18:43:04','::1','2016-02-08 18:43:04','::1'),(49,0,1,1,'0','2016-02-08 18:43:05','::1','2016-02-08 18:43:05','::1'),(50,0,1,1,'0','2016-02-08 18:43:06','::1','2016-02-08 18:43:06','::1'),(51,0,1,1,'0','2016-02-08 18:43:08','::1','2016-02-08 18:43:08','::1'),(52,0,1,1,'0','2016-02-08 18:43:09','::1','2016-02-08 18:43:09','::1'),(53,0,1,1,'0','2016-02-08 18:43:10','::1','2016-02-08 18:43:10','::1'),(55,0,1,1,'0','2016-02-08 18:50:17','::1','2016-02-08 18:50:17','::1'),(56,0,1,1,'0','2016-02-08 18:51:03','::1','2016-02-08 18:51:03','::1'),(57,0,1,1,'0','2016-02-08 18:53:12','::1','2016-02-08 18:53:12','::1'),(58,0,1,1,'0','2016-02-08 18:53:48','::1','2016-02-08 18:53:48','::1'),(59,0,1,1,'0','2016-02-08 19:06:27','::1','2016-02-08 19:06:27','::1'),(60,0,1,1,'0','2016-02-09 13:21:15','::1','2016-02-09 13:21:15','::1'),(61,0,1,1,'0','2016-02-09 13:22:15','::1','2016-02-09 13:22:15','::1'),(62,0,1,1,'0','2016-02-09 13:25:01','::1','2016-02-09 13:25:01','::1'),(63,0,1,1,'0','2016-02-09 16:41:05','::1','2016-02-09 16:41:05','::1'),(64,0,1,1,'0','2016-02-09 16:42:06','::1','2016-02-09 16:42:06','::1'),(65,0,1,1,'0','2016-02-09 16:43:02','::1','2016-02-09 16:43:02','::1'),(66,0,1,1,'0','2016-02-09 16:43:06','::1','2016-02-09 16:43:06','::1'),(67,0,1,1,'0','2016-02-09 16:58:50','::1','2016-02-09 16:58:50','::1'),(68,0,1,1,'0','2016-02-09 16:59:39','::1','2016-02-09 16:59:39','::1'),(69,0,1,1,'0','2016-02-09 17:31:44','::1','2016-02-09 17:31:44','::1'),(70,0,1,1,'0','2016-02-09 17:32:09','::1','2016-02-09 17:32:09','::1'),(71,0,1,1,'0','2016-02-12 16:51:47','::1','2016-02-12 16:51:47','::1'),(72,0,1,1,'0','2016-02-12 16:52:49','::1','2016-02-12 16:52:49','::1'),(73,0,1,1,'0','2016-02-12 16:53:53','::1','2016-02-12 16:53:53','::1'),(74,0,1,1,'0','2016-02-12 17:03:35','::1','2016-02-12 17:03:35','::1'),(75,0,1,1,'0','2016-02-12 17:13:21','::1','2016-02-12 17:13:21','::1'),(76,0,1,1,'0','2016-02-12 17:18:40','::1','2016-02-12 17:18:40','::1'),(77,0,1,1,'0','2016-02-12 17:55:22','::1','2016-02-12 17:55:22','::1'),(78,0,1,1,'0','2016-02-12 17:56:06','::1','2016-02-12 17:56:06','::1'),(79,0,1,1,'0','2016-02-12 17:57:16','::1','2016-02-12 17:57:16','::1'),(80,0,1,1,'0','2016-02-12 17:57:41','::1','2016-02-12 17:57:41','::1'),(81,0,1,1,'0','2016-02-12 18:01:25','::1','2016-02-12 18:01:25','::1'),(82,0,1,1,'0','2016-02-12 18:11:30','::1','2016-02-12 18:11:30','::1'),(83,2,1,1,'0','2016-02-22 12:30:53','::1','2016-02-22 12:30:53','::1'),(84,2,1,1,'0','2016-02-22 12:32:23','::1','2016-02-22 12:32:23','::1'),(85,2,1,1,'0','2016-02-22 12:32:40','::1','2016-02-22 12:32:40','::1'),(86,2,1,1,'0','2016-02-22 12:32:50','::1','2016-02-22 12:32:50','::1'),(87,2,1,1,'0','2016-02-22 12:33:11','::1','2016-02-22 12:33:11','::1'),(88,2,1,1,'0','2016-02-22 12:33:26','::1','2016-02-22 12:33:26','::1'),(89,2,1,1,'0','2016-02-22 12:33:38','::1','2016-02-22 12:33:38','::1'),(90,2,1,1,'0','2016-02-22 12:34:30','::1','2016-02-22 12:34:30','::1'),(91,2,1,1,'0','2016-02-22 12:34:50','::1','2016-02-22 12:34:50','::1'),(93,2,1,1,'0','2016-02-22 12:41:47','::1','2016-02-22 12:41:47','::1'),(94,2,1,1,'0','2016-02-22 12:42:40','::1','2016-02-22 12:42:40','::1'),(95,2,1,1,'0','2016-02-22 13:16:29','::1','2016-02-22 13:16:29','::1'),(96,2,1,1,'0','2016-02-22 13:18:05','::1','2016-02-22 13:18:05','::1'),(97,2,1,1,'0','2016-02-22 13:26:27','::1','2016-02-22 13:26:27','::1'),(98,2,1,1,'0','2016-02-22 13:32:46','::1','2016-02-22 13:32:46','::1'),(99,2,1,1,'0','2016-02-22 13:42:51','::1','2016-02-22 13:42:51','::1'),(100,2,1,1,'0','2016-02-22 13:44:13','::1','2016-02-22 13:44:13','::1'),(101,2,1,1,'0','2016-02-22 13:45:13','::1','2016-02-22 13:45:13','::1');
/*!40000 ALTER TABLE `t_item_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_message`
--

DROP TABLE IF EXISTS `t_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'メッセージ情報',
  `user_id` int(11) NOT NULL COMMENT 'ユーザID',
  `friend_id` int(11) NOT NULL COMMENT 'ライフ要請を受けたユーザID',
  `read_flg` char(1) NOT NULL DEFAULT '0' COMMENT '既読フラグ　0:未読, 1:既読',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='メッセージ情報';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_message`
--

LOCK TABLES `t_message` WRITE;
/*!40000 ALTER TABLE `t_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_notice`
--

DROP TABLE IF EXISTS `t_notice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'お知らせ情報ID',
  `device_id` int(11) NOT NULL COMMENT 'デバイスID',
  `user_id` int(11) DEFAULT NULL COMMENT 'ユーザID',
  `m_notice_id` int(11) NOT NULL COMMENT 'お知らせリストID',
  `read_flg` char(1) NOT NULL DEFAULT '0' COMMENT '既読フラグ　0:未読, 1:既読',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='お知らせ情報';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_notice`
--

LOCK TABLES `t_notice` WRITE;
/*!40000 ALTER TABLE `t_notice` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_notice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_receipt_android`
--

DROP TABLE IF EXISTS `t_receipt_android`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_receipt_android` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '有償ゴールド購入レシート(Android)情報ID',
  `device_id` int(11) NOT NULL COMMENT 'デバイスID',
  `user_id` int(11) DEFAULT NULL COMMENT 'ユーザID',
  `receipt` text NOT NULL COMMENT 'レシート',
  `signature` text NOT NULL COMMENT 'jsonデータ',
  `product_id` varchar(256) NOT NULL DEFAULT '' COMMENT 'プロダクトID(Apple管理)',
  `purchase_token` varchar(256) NOT NULL DEFAULT '' COMMENT 'google purchase_token',
  `order_id` varchar(256) NOT NULL DEFAULT '' COMMENT 'レスポンスオーダーID',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='課金レシート情報(Android)';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_receipt_android`
--

LOCK TABLES `t_receipt_android` WRITE;
/*!40000 ALTER TABLE `t_receipt_android` DISABLE KEYS */;
INSERT INTO `t_receipt_android` VALUES (1,0,1,'receiptreceiptreceipt','xxxxxxxx','aaaaaaaaa','xxxxxxxx','xxxxxxxx','0','2016-02-12 18:11:30','::1','2016-02-12 18:11:30','::1'),(2,2,1,'areceiptreceiptreceipt','xxxxxxxx','aaaaaaaaa','xxxxxxxx','xxxxxxxx','0','2016-02-22 13:18:05','::1','2016-02-22 13:18:05','::1'),(3,2,NULL,'breceiptreceiptreceipt','xxxxxxxx','aaaaaaaaa','xxxxxxxx','xxxxxxxx','0','2016-02-22 13:26:27','::1','2016-02-22 13:26:27','::1'),(4,2,NULL,'creceiptreceiptreceipt','xxxxxxxx','aaaaaaaaa','xxxxxxxx','xxxxxxxx','0','2016-02-22 13:32:46','::1','2016-02-22 13:32:46','::1'),(6,2,NULL,'dreceiptreceiptreceipt','xxxxxxxx','aaaaaaaaa','xxxxxxxx','xxxxxxxx','0','2016-02-22 13:42:51','::1','2016-02-22 13:42:51','::1');
/*!40000 ALTER TABLE `t_receipt_android` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_receipt_ios`
--

DROP TABLE IF EXISTS `t_receipt_ios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_receipt_ios` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '有償ゴールド購入レシート情報(iOS)ID',
  `device_id` int(11) NOT NULL COMMENT 'デバイスID',
  `user_id` int(11) DEFAULT NULL COMMENT 'ユーザID',
  `product_id` varchar(256) NOT NULL DEFAULT '' COMMENT 'レスポンスプロダクトID',
  `receipt` text NOT NULL COMMENT 'レシート',
  `sandbox_flg` char(1) NOT NULL DEFAULT '0' COMMENT 'SandBox判定 0:本番, 1:SandBox',
  `apple_original_purchase_date_pst` varchar(256) NOT NULL DEFAULT '',
  `apple_purchase_date_ms` varchar(256) NOT NULL DEFAULT '',
  `apple_unique_identifier` varchar(256) NOT NULL DEFAULT '',
  `apple_original_transaction_id` varchar(256) NOT NULL DEFAULT '',
  `apple_bvrs` varchar(256) NOT NULL DEFAULT '',
  `apple_quantity` varchar(256) NOT NULL DEFAULT '',
  `apple_transaction_id` varchar(256) NOT NULL DEFAULT '',
  `apple_unique_vendor_identifier` varchar(256) NOT NULL DEFAULT '',
  `apple_item_id` varchar(256) NOT NULL DEFAULT '',
  `apple_product_id` varchar(256) NOT NULL DEFAULT '',
  `apple_purchase_date` varchar(256) NOT NULL DEFAULT '',
  `apple_original_purchase_date` varchar(256) NOT NULL DEFAULT '',
  `apple_purchase_date_pst` varchar(256) NOT NULL DEFAULT '',
  `apple_original_purchase_date_ms` varchar(256) NOT NULL DEFAULT '',
  `apple_bid` varchar(256) NOT NULL DEFAULT '',
  `apple_status` varchar(256) NOT NULL DEFAULT '',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='課金レシート情報(iOS)';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_receipt_ios`
--

LOCK TABLES `t_receipt_ios` WRITE;
/*!40000 ALTER TABLE `t_receipt_ios` DISABLE KEYS */;
INSERT INTO `t_receipt_ios` VALUES (1,0,1,'aaaaaaaaa','receiptreceipt','0','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','0','0','2016-02-12 17:55:22','::1','2016-02-12 17:55:22','::1'),(2,0,1,'aaaaaaaaa','receiptreceipt','0','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','0','0','2016-02-12 17:56:06','::1','2016-02-12 17:56:06','::1'),(3,0,1,'aaaaaaaaa','receiptreceipt','0','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','0','0','2016-02-12 17:57:16','::1','2016-02-12 17:57:16','::1'),(4,0,1,'aaaaaaaaa','receiptreceipt','0','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','0','0','2016-02-12 17:57:41','::1','2016-02-12 17:57:41','::1'),(5,0,1,'aaaaaaaaa','receiptreceiptreceipt','0','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','0','0','2016-02-12 18:01:25','::1','2016-02-12 18:01:25','::1'),(6,2,1,'aaaaaaaaa','areceiptreceiptreceipt','0','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','0','0','2016-02-22 13:16:29','::1','2016-02-22 13:16:29','::1'),(8,2,NULL,'aaaaaaaaa','dreceiptreceiptreceipt','0','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','0','0','2016-02-22 13:44:13','::1','2016-02-22 13:44:13','::1'),(9,2,NULL,'aaaaaaaaa','ereceiptreceiptreceipt','0','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','xxxxxxxxx','0','0','2016-02-22 13:45:13','::1','2016-02-22 13:45:13','::1');
/*!40000 ALTER TABLE `t_receipt_ios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_stage`
--

DROP TABLE IF EXISTS `t_stage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_stage` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ユーザステージ情報ID',
  `user_id` int(11) NOT NULL COMMENT 'ユーザID',
  `m_stage_id` int(11) NOT NULL COMMENT 'ステージ情報ID',
  `status` char(1) NOT NULL DEFAULT '0' COMMENT 'ステータス　0:未トライ, 1:トライ中, 2:クリア済',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT 'スコア',
  `rank` int(11) NOT NULL DEFAULT '0' COMMENT '評価',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='ステージ情報';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_stage`
--

LOCK TABLES `t_stage` WRITE;
/*!40000 ALTER TABLE `t_stage` DISABLE KEYS */;
INSERT INTO `t_stage` VALUES (27,1,2,'2',100000,3,'0','2016-01-22 18:41:32','::1','2016-02-22 12:21:05','::1'),(28,1,3,'2',1000000,3,'0','2016-02-01 12:00:00','kamikawa','2016-02-22 13:45:13','::1'),(29,1,1,'2',99999,2,'0','2016-02-08 13:19:29','::1','2016-02-08 13:30:00','::1');
/*!40000 ALTER TABLE `t_stage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_user`
--

DROP TABLE IF EXISTS `t_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ユーザID',
  `name` varchar(256) NOT NULL COMMENT 'ユーザ名',
  `status` char(1) NOT NULL COMMENT 'ステータス　0:有効, 9:削除',
  `image_url` varchar(256) NOT NULL DEFAULT '' COMMENT 'プロフィール画像URL',
  `auth_token` varchar(256) NOT NULL DEFAULT '' COMMENT 'Facebook連携認証トークン',
  `secret_key` varchar(256) NOT NULL DEFAULT '' COMMENT 'Facebook連携シークレットキー',
  `facebook_id` varchar(256) NOT NULL DEFAULT '' COMMENT 'FacebookユーザID',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='ユーザ情報';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_user`
--

LOCK TABLES `t_user` WRITE;
/*!40000 ALTER TABLE `t_user` DISABLE KEYS */;
INSERT INTO `t_user` VALUES (1,'validationtest','0','/validation/test.img','validationtest','validationtest','validationtest','0','2016-02-01 18:00:00','kamikawa','2016-02-12 18:11:30','::1'),(2,'kamikawa','0','/xxxxx/xxxxx.img','s732g36bdf636v8q','ciw38g63t6c5wy','dbwi38h8t4h3u','0','2016-01-29 00:06:25','::1','2016-02-01 13:40:59','::1'),(3,'kamikawa','0','','','','','0','2016-01-29 11:15:57','::1','2016-01-29 11:15:57','::1'),(4,'','0','','','','','0','2016-01-29 11:28:51','::1','2016-01-29 11:28:51','::1'),(5,'','0','','','','','0','2016-02-01 18:11:02','::1','2016-02-01 18:11:02','::1'),(6,'','0','','','','','0','2016-02-02 17:08:43','::1','2016-02-02 17:08:43','::1'),(12,'','0','','','','','0','2016-02-03 16:34:58','::1','2016-02-03 16:34:58','::1'),(22,'','0','','','','','0','2016-02-03 17:08:52','::1','2016-02-03 17:08:52','::1'),(23,'','0','','','','','0','2016-02-08 12:27:06','::1','2016-02-08 12:27:06','::1'),(24,'logintest','0','/login/test.img','logintest','logintest','logintest','0','2016-02-19 12:31:13','::1','2016-02-19 12:31:13','::1'),(26,'transactiontest','0','/transaction/test.img','transactiontest','transactiontest','transactiontest','0','2016-02-19 12:39:52','::1','2016-02-19 12:39:52','::1'),(27,'emptytest','0','/empty/test.img','emptytest','emptytest','emptytest','0','2016-02-19 12:42:26','::1','2016-02-19 12:42:26','::1'),(28,'paramsmoditest','0','/paramsmodi/test.img','paramsmoditest','paramsmoditest','paramsmoditest','0','2016-02-22 12:14:04','::1','2016-02-22 12:14:04','::1');
/*!40000 ALTER TABLE `t_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_user_device`
--

DROP TABLE IF EXISTS `t_user_device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_user_device` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ユーザ連携ID',
  `device_id` int(11) NOT NULL COMMENT 'デバイスID',
  `user_id` int(11) DEFAULT NULL COMMENT 'ユーザID',
  `del_flg` char(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ　0:off, 1:on',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `created_by` varchar(256) NOT NULL DEFAULT '' COMMENT '作成者',
  `updated_at` datetime NOT NULL COMMENT '更新日時',
  `updated_by` varchar(256) NOT NULL DEFAULT '' COMMENT '更新者',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_user_device`
--

LOCK TABLES `t_user_device` WRITE;
/*!40000 ALTER TABLE `t_user_device` DISABLE KEYS */;
INSERT INTO `t_user_device` VALUES (1,2,NULL,'0','2016-02-19 12:31:13','::1','2016-02-22 13:45:13','::1');
/*!40000 ALTER TABLE `t_user_device` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-22 13:49:25
