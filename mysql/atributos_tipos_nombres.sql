
DROP TABLE IF EXISTS `atributos_tipos_nombres`;
CREATE TABLE  `atributos_tipos_nombres` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `leng_id` tinyint(3) unsigned NOT NULL,
  `nombre` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`,`leng_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='no modificar';

--
-- Dumping data for table `atributos_tipos_nombres`
--

/*!40000 ALTER TABLE `atributos_tipos_nombres` DISABLE KEYS */;
LOCK TABLES `atributos_tipos_nombres` WRITE;
INSERT INTO `atributos_tipos_nombres` VALUES  (1,1,'Campo de texto'),
 (2,1,'Color'),
 (3,1,'Contraseña'),
 (4,1,'Fecha y hora'),
 (5,1,'Fecha'),
 (6,1,'Número natural (ℕ)'),
 (7,1,'Dato externo'),
 (8,1,'Imagen'),
 (9,1,'Archivo'),
 (10,1,'Galería de imágenes'),
 (11,1,'Radio'),
 (12,1,'Checkbox'),
 (13,1,'Selector múltiple'),
 (14,1,'Selector'),
 (15,1,'Texto'),
 (16,1,'Precio'),
 (17,1,'Número entero (ℤ)'),
 (18,1,'Rango'),
 (19,1,'Área'),
 (20,1,'Alineación asociativa'),
 (21,1,'Campo de texto (no leng)'),
 (22,1,'Enlace externo (dato)'),
 (23,1,'Formulario'),
 (24,1,'Texto con formato'),
 (25,1,'Número decimal'),
 (26,1,'Enlace'),
 (27,1,'YouTube Video');
UNLOCK TABLES;
/*!40000 ALTER TABLE `atributos_tipos_nombres` ENABLE KEYS */;

