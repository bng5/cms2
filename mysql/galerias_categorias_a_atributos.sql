
DROP TABLE IF EXISTS `galerias_categorias_a_atributos`;
CREATE TABLE  `galerias_categorias_a_atributos` (
  `categoria_id` tinyint(3) unsigned NOT NULL,
  `atributo_id` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY  (`categoria_id`,`atributo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

