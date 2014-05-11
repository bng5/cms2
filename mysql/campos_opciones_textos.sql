
DROP TABLE IF EXISTS `campos_opciones_textos`;
CREATE TABLE  `campos_opciones_textos` (
  `id` int(10) unsigned NOT NULL,
  `leng_id` tinyint(3) unsigned NOT NULL,
  `texto` varchar(32) NOT NULL,
  PRIMARY KEY  (`id`,`leng_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

