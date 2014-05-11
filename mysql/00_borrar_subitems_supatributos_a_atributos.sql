
DROP TABLE IF EXISTS `00_borrar_subitems_supatributos_a_atributos`;
CREATE TABLE  `00_borrar_subitems_supatributos_a_atributos` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `algo` tinyblob,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `00_borrar_subitems_supatributos_a_atributos` DISABLE KEYS */;
LOCK TABLES `00_borrar_subitems_supatributos_a_atributos` WRITE;
INSERT INTO `00_borrar_subitems_supatributos_a_atributos` VALUES  (2,NULL),
 (3,NULL),
 (4,NULL);
UNLOCK TABLES;
/*!40000 ALTER TABLE `00_borrar_subitems_supatributos_a_atributos` ENABLE KEYS */;

