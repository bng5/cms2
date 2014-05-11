
DROP TABLE IF EXISTS `galerias_imagenes`;
CREATE TABLE  `galerias_imagenes` (
  `galeria_id` int(10) unsigned NOT NULL,
  `imagen_id` int(10) unsigned NOT NULL,
  `estado` tinyint(1) NOT NULL default '1',
  `orden` tinyint(2) unsigned default NULL,
  PRIMARY KEY  (`galeria_id`,`imagen_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

