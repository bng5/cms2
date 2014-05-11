
DROP TABLE IF EXISTS `items_secciones_a_atributos`;
CREATE TABLE  `items_secciones_a_atributos` (
  `seccion_id` tinyint(3) unsigned NOT NULL,
  `atributo_id` tinyint(3) unsigned NOT NULL,
  `orden` tinyint(3) unsigned default NULL,
  `por_omision` int(10) unsigned default NULL,
  `en_listado` tinyint(1) NOT NULL default '0',
  `salida` tinyint(1) NOT NULL default '1',
  `superior` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`seccion_id`,`atributo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

