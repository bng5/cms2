
DROP TABLE IF EXISTS `monedas`;
CREATE TABLE  `monedas` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `codigo` char(3) character set ascii NOT NULL,
  `simbolo_izq` varchar(4) default NULL,
  `simbolo_der` varchar(4) default NULL,
  `decimales` tinyint(3) unsigned NOT NULL default '2',
  `sep_decimales` char(1) NOT NULL default '.',
  `sep_miles` char(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `monedas`
--

/*!40000 ALTER TABLE `monedas` DISABLE KEYS */;
LOCK TABLES `monedas` WRITE;
INSERT INTO `monedas` VALUES  (1,'UYP','$U','-',2,',','\'');
UNLOCK TABLES;
/*!40000 ALTER TABLE `monedas` ENABLE KEYS */;

