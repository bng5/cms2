
DROP TABLE IF EXISTS `galerias_textos`;
CREATE TABLE  `galerias_textos` (
  `galeria_id` int(10) unsigned NOT NULL,
  `leng_id` int(10) unsigned NOT NULL,
  `titulo` varchar(32) NOT NULL default 'Sin título',
  `texto` text,
  PRIMARY KEY  (`galeria_id`),
  FULLTEXT KEY `galeria_texto` (`texto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

