
DROP TABLE IF EXISTS `secciones_a_atributos`;
CREATE TABLE  `secciones_a_atributos` (
  `seccion_id` tinyint(3) unsigned NOT NULL,
  `atributo_id` tinyint(3) unsigned NOT NULL,
  `orden` tinyint(3) unsigned default NULL,
  `por_omision` int(10) unsigned default NULL,
  `salida` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`seccion_id`,`atributo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

