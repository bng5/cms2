
DROP TABLE IF EXISTS `secciones_nombres`;
CREATE TABLE  `secciones_nombres` (
  `id` int(10) unsigned NOT NULL,
  `leng_id` tinyint(3) unsigned NOT NULL,
  `titulo` varchar(50) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`,`leng_id`),
  KEY `seccion_titulo` (`titulo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

