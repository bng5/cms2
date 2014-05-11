
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE  `usuarios` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `usuario` varchar(70) collate utf8_unicode_ci NOT NULL,
  `estado_id` tinyint(3) unsigned NOT NULL default '0',
  `nombre_mostrar` varchar(30) character set utf8 NOT NULL,
  `clave` char(40) character set ascii NOT NULL,
  `email` varchar(70) collate utf8_unicode_ci NOT NULL,
  `aut` char(32) character set latin1 default NULL,
  `creado` datetime NOT NULL,
  `creado_por` int(10) unsigned NOT NULL,
  `pase` char(32) character set ascii collate ascii_bin default NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `usuario` (`usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `usuarios`
--

/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
LOCK TABLES `usuarios` WRITE;
INSERT INTO `usuarios` VALUES
 (1,'etdp',1,'etdp','c1d4d94598dff026d8296a019fdd4e51c9180cec','pablobngs@gmail.com','','0000-00-00 00:00:00',0,'fd1df93545f11a2119948b5366cca4af',0),
 (2,'admin',1,'Administrador','7110eda4d09e062aa5e4a390b0a572ac0d2c0220','pablo@bng5.net',NULL,'2008-09-12 13:42:48',1,NULL,0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

