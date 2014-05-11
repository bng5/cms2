
DROP TABLE IF EXISTS `archivos_categorias_textos`;
CREATE TABLE  `archivos_categorias_textos` (
  `id` int(11) NOT NULL,
  `leng_id` tinyint(4) NOT NULL default '1',
  `titulo` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

