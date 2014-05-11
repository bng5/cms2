
DROP TABLE IF EXISTS `usuarios_permisos_areas`;
CREATE TABLE  `usuarios_permisos_areas` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `area` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=ascii;

--
-- Dumping data for table `usuarios_permisos_areas`
--

/*!40000 ALTER TABLE `usuarios_permisos_areas` DISABLE KEYS */;
LOCK TABLES `usuarios_permisos_areas` WRITE;
INSERT INTO `usuarios_permisos_areas` VALUES  (1,'seccion'),
 (2,'admin_seccion'),
 (3,'admin_seccion_c');
UNLOCK TABLES;
/*!40000 ALTER TABLE `usuarios_permisos_areas` ENABLE KEYS */;

