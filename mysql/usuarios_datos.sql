
DROP TABLE IF EXISTS `usuarios_datos`;
CREATE TABLE  `usuarios_datos` (
  `id` int(10) unsigned NOT NULL,
  `nombre` varchar(50) default NULL,
  `apellido` varchar(50) default NULL,
  `pais_id` int(11) default NULL,
  `estado` varchar(50) default NULL,
  `ciudad` varchar(50) default NULL,
  `direccion` varchar(100) default NULL,
  `telefono` varchar(20) character set ascii default NULL,
  `celular` varchar(20) character set ascii default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usuarios_datos`
--

/*!40000 ALTER TABLE `usuarios_datos` DISABLE KEYS */;
LOCK TABLES `usuarios_datos` WRITE;
INSERT INTO `usuarios_datos` VALUES
 (1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
UNLOCK TABLES;
/*!40000 ALTER TABLE `usuarios_datos` ENABLE KEYS */;

