
DROP TABLE IF EXISTS `tickets_categorias`;
CREATE TABLE  `tickets_categorias` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tickets_categorias`
--

/*!40000 ALTER TABLE `tickets_categorias` DISABLE KEYS */;
LOCK TABLES `tickets_categorias` WRITE;
INSERT INTO `tickets_categorias` VALUES  (1,'Consulta'),
 (2,'Sugerencia'),
 (3,'Error leve'),
 (4,'Error grave');
UNLOCK TABLES;
/*!40000 ALTER TABLE `tickets_categorias` ENABLE KEYS */;

