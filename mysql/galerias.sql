
DROP TABLE IF EXISTS `galerias`;
CREATE TABLE  `galerias` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `categoria_id` int(10) unsigned NOT NULL default '4',
  `estado_id` tinyint(1) NOT NULL default '0',
  `orden` tinyint(2) unsigned default NULL,
  `miniatura` varchar(32) collate latin1_general_ci default NULL,
  `creada` datetime NOT NULL,
  `modificada` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

