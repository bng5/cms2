
DROP TABLE IF EXISTS `secciones`;
CREATE TABLE  `secciones` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `superior` int(10) unsigned NOT NULL default '0',
  `orden` tinyint(2) unsigned default NULL,
  `estado` tinyint(1) NOT NULL default '0',
  `tipo` varchar(30) default NULL,
  `icono` varchar(32) default NULL,
  `permiso_min` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=ascii;

