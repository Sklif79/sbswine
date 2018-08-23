CREATE TABLE IF NOT EXISTS `b_wdu_fastsql` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ACTIVE` char(1) NOT NULL,
  `SORT` int(11) NOT NULL DEFAULT '100',
  `QUERY` text NOT NULL,
  `DESCRIPTION` text,
  `USER_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
);
CREATE TABLE IF NOT EXISTS `b_wdu_pageprops` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `PROPERTY` varchar(255) NOT NULL,
  `SITE` varchar(2) DEFAULT NULL,
  `TYPE` varchar(255) NOT NULL,
  `DATA` longtext NOT NULL,
  PRIMARY KEY (`ID`)
);
CREATE TABLE IF NOT EXISTS `b_wdu_propsorter` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(255) NOT NULL,
  `VALUE` text NOT NULL,
  PRIMARY KEY (`ID`)
);
CREATE TABLE IF NOT EXISTS `b_wdu_iblock_columns` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IBLOCK_ID` int(11) NOT NULL,
  `DATA` text NOT NULL,
  PRIMARY KEY (`ID`)
);
CREATE TABLE IF NOT EXISTS `b_wdu_dirsize` (
  `TYPE` enum('D','F') NOT NULL DEFAULT 'F',
  `PATH` text NOT NULL,
  `PATH_HASH` varchar(32) NOT NULL,
  `SIZE` bigint(11) unsigned NOT NULL,
  `COUNT` int(11) unsigned NOT NULL,
  `DEPTH` tinyint(11) unsigned NOT NULL,
  UNIQUE KEY `PATH_HASH` (`PATH_HASH`) USING BTREE
);