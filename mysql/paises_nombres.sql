
DROP TABLE IF EXISTS `paises_nombres`;
CREATE TABLE  `paises_nombres` (
  `id` mediumint(8) unsigned NOT NULL,
  `leng_id` tinyint(3) unsigned NOT NULL,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`,`leng_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

