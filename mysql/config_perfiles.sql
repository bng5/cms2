
CREATE TABLE `config_perfiles` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(30) NOT NULL,
  `info` tinyint(1) NOT NULL default '0',
  `items` tinyint(1) NOT NULL default '0',
  `categorias` tinyint(1) NOT NULL default '0',
  `prof_categorias` tinyint(3) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
