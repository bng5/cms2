
DROP TABLE IF EXISTS `archivos_categorias`;
CREATE TABLE  `archivos_categorias` (
  `id` int(11) NOT NULL auto_increment,
  `estado` tinyint(3) unsigned NOT NULL,
  `superior` int(10) unsigned NOT NULL default '0',
  `orden` tinyint(3) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

