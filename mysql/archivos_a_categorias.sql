
DROP TABLE IF EXISTS `archivos_a_categorias`;
CREATE TABLE  `archivos_a_categorias` (
  `archivo_id` int(10) unsigned NOT NULL,
  `categoria_id` int(10) unsigned NOT NULL,
  `obra_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`archivo_id`,`categoria_id`,`obra_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

