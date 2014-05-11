
DROP TABLE IF EXISTS `atributos_tipos`;
CREATE TABLE  `atributos_tipos` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `tipo` enum('string','date','text','int','num') character set ascii NOT NULL default 'string',
  `subtipo` tinyint(3) unsigned default NULL,
  `op_listado` tinyint(1) NOT NULL default '0',
  `op_oculto` tinyint(3) unsigned NOT NULL default '0',
  `nodo_tipo` tinyint(3) unsigned default NULL,
  `estado_id` tinyint(3) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='no modificar';

--
-- Dumping data for table `atributos_tipos`
--

/*!40000 ALTER TABLE `atributos_tipos` DISABLE KEYS */;
LOCK TABLES `atributos_tipos` WRITE;
INSERT INTO `atributos_tipos` VALUES  (1,'string',NULL,1,0,1,1),
 (2,'string',1,1,0,1,1),
 (3,'string',2,0,0,1,0),
 (4,'date',NULL,1,0,1,1),
 (5,'date',1,1,0,1,1),
 (6,'int',NULL,1,1,1,1),
 (7,'int',1,1,1,1,1),
 (8,'int',2,1,0,2,1),
 (9,'int',3,1,0,2,1),
 (10,'int',4,0,0,2,1),
 (11,'int',8,1,1,1,1),
 (12,'string',4,1,0,1,1),
 (13,'string',3,1,0,1,0),
 (14,'int',5,1,1,1,1),
 (15,'text',NULL,1,0,1,1),
 (16,'num',NULL,1,1,1,1),
 (17,'num',1,1,1,1,1),
 (18,'int',6,1,0,1,0),
 (19,'int',7,0,0,3,1),
 (20,'string',5,1,0,1,0),
 (21,'string',6,1,0,1,1),
 (22,'text',1,1,0,1,1),
 (23,'int',9,0,0,3,1),
 (24,'text',2,1,0,1,1),
 (25,'num',2,1,1,1,1),
 (26,'text',3,1,0,2,1),
 (27,'string',7,0,0,4,1);
UNLOCK TABLES;
/*!40000 ALTER TABLE `atributos_tipos` ENABLE KEYS */;

