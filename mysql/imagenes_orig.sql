
DROP TABLE IF EXISTS `imagenes_orig`;
CREATE TABLE  `imagenes_orig` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `archivo` varchar(32) NOT NULL,
  `ancho` int(4) unsigned NOT NULL,
  `alto` int(4) unsigned NOT NULL,
  `peso` int(10) unsigned NOT NULL,
  `formato` varchar(30) character set ascii NOT NULL,
  `hash` char(32) character set ascii NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `archivo` (`archivo`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

