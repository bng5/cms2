
DROP TABLE IF EXISTS `usuarios_permisos`;
CREATE TABLE  `usuarios_permisos` (
  `usuario_id` int(10) unsigned NOT NULL,
  `area_id` tinyint(3) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `permiso_id` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY  (`usuario_id`,`area_id`,`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=ascii ROW_FORMAT=FIXED;

--
-- Dumping data for table `usuarios_permisos`
--

/*!40000 ALTER TABLE `usuarios_permisos` DISABLE KEYS */;
LOCK TABLES `usuarios_permisos` WRITE;
INSERT INTO `usuarios_permisos` VALUES
 (1,2,1,9),
 (1,2,2,9),
 (1,2,3,9),
 (1,2,4,9),
 (1,2,5,9),
 (1,2,6,9),
 (1,2,7,9),
 (1,2,8,9);
UNLOCK TABLES;
/*!40000 ALTER TABLE `usuarios_permisos` ENABLE KEYS */;

