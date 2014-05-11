
DROP TABLE IF EXISTS `monedas_nombres`;
CREATE TABLE  `monedas_nombres` (
  `id` int(10) unsigned NOT NULL,
  `leng_id` tinyint(3) unsigned NOT NULL,
  `nombre` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`,`leng_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `monedas_nombres`
--

/*!40000 ALTER TABLE `monedas_nombres` DISABLE KEYS */;
LOCK TABLES `monedas_nombres` WRITE;
INSERT INTO `monedas_nombres` VALUES  (1,1,'Pesos Uruguayos');
UNLOCK TABLES;
/*!40000 ALTER TABLE `monedas_nombres` ENABLE KEYS */;

