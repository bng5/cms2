
DROP TABLE IF EXISTS `items_atributos`;
CREATE TABLE  `items_atributos` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `identificador` varchar(17) character set ascii NOT NULL,
  `sugerido` tinyint(1) NOT NULL,
  `unico` tinyint(1) NOT NULL,
  `tipo_id` int(10) unsigned NOT NULL,
  `extra` varchar(250) default NULL,
  `et_xhtml` varchar(10) character set ascii NOT NULL,
  `et_xhtml_id` tinyint(3) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='borrar et_xhtml';

