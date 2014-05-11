
DROP TABLE IF EXISTS `permisos_tipos`;
CREATE TABLE  `permisos_tipos` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `leng_id` tinyint(3) unsigned NOT NULL,
  `permiso` varchar(20) character set latin1 NOT NULL,
  PRIMARY KEY  (`id`,`leng_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permisos_tipos`
--

/*!40000 ALTER TABLE `permisos_tipos` DISABLE KEYS */;
LOCK TABLES `permisos_tipos` WRITE;
INSERT INTO `permisos_tipos` VALUES  (1,1,'Listar'),
 (2,1,'Crear'),
 (3,1,'Publicar'),
 (4,1,'Modificar'),
 (5,1,'Configurar');
UNLOCK TABLES;
/*!40000 ALTER TABLE `permisos_tipos` ENABLE KEYS */;

