
DROP TABLE IF EXISTS `admin_secciones`;
CREATE TABLE  `admin_secciones` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(50) collate utf8_unicode_ci NOT NULL,
  `superior_id` int(10) unsigned NOT NULL default '0',
  `orden` tinyint(2) unsigned default NULL,
  `link` varchar(30) character set ascii NOT NULL default 'listar',
  `link_param` varchar(15) character set ascii default NULL,
  `permiso_max` tinyint(1) unsigned default NULL,
  `tipo` enum('admin','config') character set ascii NOT NULL,
  `sistema` tinyint(1) NOT NULL default '0',
  `identificador` varchar(32) character set ascii NOT NULL,
  `info` tinyint(1) NOT NULL default '0',
  `items` tinyint(1) NOT NULL default '0',
  `categorias` tinyint(1) NOT NULL default '0',
  `rss` tinyint(1) NOT NULL default '0',
  `prof_categorias` tinyint(3) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `nombre` (`nombre`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin_secciones`
--

/*!40000 ALTER TABLE `admin_secciones` DISABLE KEYS */;
LOCK TABLES `admin_secciones` WRITE;
INSERT INTO `admin_secciones` VALUES
 (1,'Idiomas',0,8,'idiomas',NULL,4,'admin',1,'__idiomas',0,0,0,0,NULL),
 (2,'Secciones',0,9,'secciones',NULL,4,'config',1,'__secciones',0,0,0,0,NULL),
 (3,'Administradores',0,10,'administradores',NULL,5,'config',1,'__administradores',0,0,0,0,NULL),
 (4,'Usuarios',0,11,'usuarios',NULL,5,'config',1,'__usuarios',0,0,0,0,NULL),
 (5,'Estadísticas',0,14,'estadisticas',NULL,1,'config',1,'__estadisticas',0,0,0,0,NULL),
 (6,'Monedas',0,12,'monedas',NULL,4,'config',1,'__monedas',0,0,0,0,NULL),
 (7,'Información para buscadores',0,13,'metatags',NULL,4,'admin',1,'__meta',0,0,0,0,NULL),
 (8,'Tickets de soporte',0,15,'tickets',NULL,4,'admin',1,'__tickets',0,0,0,0,NULL);
UNLOCK TABLES;
/*!40000 ALTER TABLE `admin_secciones` ENABLE KEYS */;
