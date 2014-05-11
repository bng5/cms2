
DROP TABLE IF EXISTS `archivos`;
CREATE TABLE  `archivos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `archivo` varchar(32) character set ascii NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `formato` varchar(30) character set ascii NOT NULL,
  `peso` int(10) unsigned NOT NULL,
  `fecha` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `hash` char(32) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

