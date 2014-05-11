
DROP TABLE IF EXISTS `00_borrar_subitems_valores`;
CREATE TABLE  `00_borrar_subitems_valores` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `area_id` int(10) unsigned NOT NULL,
  `atributo_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned default NULL,
  `leng_id` tinyint(3) unsigned default NULL,
  `string` varchar(50) default NULL,
  `date` datetime default NULL,
  `text` text,
  `int` int(10) unsigned default NULL,
  `num` decimal(10,2) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `00_borrar_subitems_valores`
--

/*!40000 ALTER TABLE `00_borrar_subitems_valores` DISABLE KEYS */;
LOCK TABLES `00_borrar_subitems_valores` WRITE;
INSERT INTO `00_borrar_subitems_valores` VALUES  (1,2,3,6,1,'Título t',NULL,NULL,NULL,NULL);
UNLOCK TABLES;
/*!40000 ALTER TABLE `00_borrar_subitems_valores` ENABLE KEYS */;
