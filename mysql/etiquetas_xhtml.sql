
DROP TABLE IF EXISTS `etiquetas_xhtml`;
CREATE TABLE  `etiquetas_xhtml` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `etiqueta` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=ascii;

--
-- Dumping data for table `etiquetas_xhtml`
--

/*!40000 ALTER TABLE `etiquetas_xhtml` DISABLE KEYS */;
LOCK TABLES `etiquetas_xhtml` WRITE;
INSERT INTO `etiquetas_xhtml` VALUES  (1,'a'),
 (2,'address'),
 (3,'b'),
 (4,'big'),
 (5,'blockquote'),
 (6,'cite'),
 (7,'code'),
 (8,'del'),
 (9,'dfn'),
 (10,'em'),
 (11,'h1'),
 (12,'h2'),
 (13,'h3'),
 (14,'h4'),
 (15,'h5'),
 (16,'h6'),
 (17,'i'),
 (18,'ins'),
 (19,'kbd'),
 (20,'p'),
 (21,'pre'),
 (22,'q'),
 (23,'samp'),
 (24,'small'),
 (25,'span'),
 (26,'strong'),
 (27,'sub'),
 (28,'sup'),
 (29,'tt'),
 (30,'var');
UNLOCK TABLES;
/*!40000 ALTER TABLE `etiquetas_xhtml` ENABLE KEYS */;

