
DROP TABLE IF EXISTS `galerias_atributos_n`;
CREATE TABLE  `galerias_atributos_n` (
  `id` int(10) unsigned NOT NULL,
  `leng_id` tinyint(3) unsigned NOT NULL,
  `atributo` varchar(30) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`,`leng_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

