
DROP TABLE IF EXISTS `items_categorias`;
CREATE TABLE  `items_categorias` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `seccion_id` int(10) unsigned NOT NULL,
  `superior` int(10) unsigned NOT NULL default '0',
  `estado_id` tinyint(3) unsigned NOT NULL default '0',
  `orden` tinyint(3) unsigned default NULL,
  `propietario` int(10) unsigned default NULL,
  `bloqueado` tinyint(3) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

