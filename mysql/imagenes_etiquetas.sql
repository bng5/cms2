
DROP TABLE IF EXISTS `imagenes_etiquetas`;
CREATE TABLE  `imagenes_etiquetas` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `etiqueta` varchar(35) NOT NULL,
  `leng_id` tinyint(3) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unico` (`etiqueta`,`leng_id`),
  KEY `new_index` (`etiqueta`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

