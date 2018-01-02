#
# This file is part of oc_blog project
#
# @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
# @since 2017/12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database :  `blogpost`
--
CREATE DATABASE IF NOT EXISTS `blogpost`
  DEFAULT CHARACTER SET utf8
  COLLATE utf8_bin;
USE `blogpost`;


DROP TABLE IF EXISTS `comment_comment`;
DROP TABLE IF EXISTS `comment_thread`;
DROP TABLE IF EXISTS `blogpost_body`;
DROP TABLE IF EXISTS `blogpost_header`;
DROP TABLE IF EXISTS `blogpost_post`;
DROP TABLE IF EXISTS `user_user`;

-- --------------------------------------------------------

--
-- Structure of the table `blogpost_body`
--


CREATE TABLE IF NOT EXISTS `blogpost_body` (
  `id_body` INT(11) UNSIGNED            NOT NULL AUTO_INCREMENT,
  `content` MEDIUMTEXT COLLATE utf8_bin NOT NULL,
  `postID`  CHAR(36) COLLATE utf8_bin   NOT NULL,
  PRIMARY KEY (`id_body`),
  UNIQUE KEY `ind_postID` (`postID`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

-- --------------------------------------------------------

--
-- Structure of the table `blogpost_header`
--


CREATE TABLE IF NOT EXISTS `blogpost_header` (
  `id_header` INT(11) UNSIGNED              NOT NULL AUTO_INCREMENT,
  `title`     VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `brief`     TEXT COLLATE utf8_bin         NOT NULL,
  `postID`    CHAR(36) COLLATE utf8_bin     NOT NULL,
  PRIMARY KEY (`id_header`),
  UNIQUE KEY `ind_postID` (`postID`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

-- --------------------------------------------------------

--
-- Structure of the table `blogpost_post`
--


CREATE TABLE IF NOT EXISTS `blogpost_post` (
  `id_post`   INT(11) UNSIGNED          NOT NULL AUTO_INCREMENT,
  `postID`    CHAR(36) COLLATE utf8_bin NOT NULL,
  `bloggerID` CHAR(36) COLLATE utf8_bin NOT NULL,
  `create_at` DATETIME                  NOT NULL,
  `update_at` DATETIME                  NOT NULL,
  PRIMARY KEY (`id_post`),
  UNIQUE KEY `ind_postID` (`postID`),
  KEY `ind_bloggerID` (`bloggerID`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

-- --------------------------------------------------------

--
-- Structure of the table `comment_comment`
--


CREATE TABLE IF NOT EXISTS `comment_comment` (
  `id_comment` INT(11) UNSIGNED          NOT NULL AUTO_INCREMENT,
  `commentID`  CHAR(36) COLLATE utf8_bin NOT NULL,
  `threadID`   CHAR(36) COLLATE utf8_bin NOT NULL,
  `authorID`   CHAR(36) COLLATE utf8_bin NOT NULL,
  `enabled`    TINYINT(1)                NOT NULL DEFAULT '0',
  `body`       TEXT COLLATE utf8_bin,
  `create_at`  DATETIME                  NOT NULL,
  `update_at`  DATETIME                  NOT NULL,
  PRIMARY KEY (`id_comment`),
  UNIQUE KEY `ind_commentID` (`commentID`),
  KEY `ind_threadID` (`threadID`),
  KEY `ind_authorID` (`authorID`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

-- --------------------------------------------------------

--
-- Structure of the table `comment_thread`
--


CREATE TABLE IF NOT EXISTS `comment_thread` (
  `id_thread`         INT(11) UNSIGNED          NOT NULL AUTO_INCREMENT,
  `threadID`          CHAR(36) COLLATE utf8_bin NOT NULL,
  `postID`            CHAR(36) COLLATE utf8_bin NOT NULL,
  `create_at`         DATETIME                  NOT NULL,
  `update_at`         DATETIME                  NOT NULL,
  `number_of_comment` INT(11) UNSIGNED          NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_thread`),
  UNIQUE KEY `ind_threadID` (`threadID`),
  KEY `ind_postID` (`postID`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

-- --------------------------------------------------------

--
-- Structure of the table `user_user`
--


CREATE TABLE IF NOT EXISTS `user_user` (
  `id_user`        INT(11) UNSIGNED          NOT NULL AUTO_INCREMENT,
  `userID`         CHAR(36) COLLATE utf8_bin NOT NULL,
  `nickname`       VARCHAR(255) COLLATE utf8_bin      DEFAULT NULL,
  `firstname`      VARCHAR(255) COLLATE utf8_bin      DEFAULT NULL,
  `lastname`       VARCHAR(255) COLLATE utf8_bin      DEFAULT NULL,
  `username`       VARCHAR(255) COLLATE utf8_bin      DEFAULT NULL,
  `email`          VARCHAR(255) COLLATE utf8_bin      DEFAULT NULL,
  `enabled`        TINYINT(1)                NOT NULL DEFAULT '1',
  `salt`           VARCHAR(255) COLLATE utf8_bin      DEFAULT NULL,
  `password`       VARCHAR(255) COLLATE utf8_bin      DEFAULT NULL,
  `plain_password` VARCHAR(255) COLLATE utf8_bin      DEFAULT NULL,
  `registered_at`  DATETIME                  NOT NULL,
  `update_at`      DATETIME                  NOT NULL,
  `locked`         TINYINT(1)                NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `ind_userID` (`userID`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

--
-- Constraints
--

--
-- Constraints of the table `blogpost_body`
--
ALTER TABLE `blogpost_body`
  ADD CONSTRAINT `k_blogpost_body_postID` FOREIGN KEY (`postID`) REFERENCES `blogpost_post` (`postID`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

--
-- Constraints of the table `blogpost_header`
--
ALTER TABLE `blogpost_header`
  ADD CONSTRAINT `k_blogpost_header_postID` FOREIGN KEY (`postID`) REFERENCES `blogpost_post` (`postID`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

--
-- Constraints of the table `blogpost_post`
--
ALTER TABLE `blogpost_post`
  ADD CONSTRAINT `k_blogpost_post_userID` FOREIGN KEY (`bloggerID`) REFERENCES `user_user` (`userID`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

--
-- Constraints of the table `comment_comment`
--
ALTER TABLE `comment_comment`
  ADD CONSTRAINT `k_comment_comment_threadID` FOREIGN KEY (`threadID`) REFERENCES `comment_thread` (`threadID`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
  ADD CONSTRAINT `k_comment_comment_userID` FOREIGN KEY (`authorID`) REFERENCES `user_user` (`userID`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

--
-- Constraints of the table `comment_thread`
--
ALTER TABLE `comment_thread`
  ADD CONSTRAINT `k_comment_thread_postID` FOREIGN KEY (`postID`) REFERENCES `blogpost_post` (`postID`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

COMMIT;

