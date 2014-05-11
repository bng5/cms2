
DROP TABLE IF EXISTS `paises`;
CREATE TABLE  `paises` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `codigo` varchar(7) character set ascii NOT NULL,
  `estado_id` tinyint(1) NOT NULL default '1',
  `zona_horaria` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

