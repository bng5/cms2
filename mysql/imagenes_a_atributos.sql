
DROP TABLE IF EXISTS `imagenes_a_atributos`;
CREATE TABLE  `imagenes_a_atributos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `imagen_id` int(10) unsigned NOT NULL,
  `atributo_id` int(10) unsigned NOT NULL,
  `ancho` int(4) unsigned NOT NULL,
  `alto` int(4) unsigned NOT NULL,
  `peso` int(10) unsigned NOT NULL,
  `ancho_m` int(4) unsigned NOT NULL,
  `alto_m` int(4) unsigned NOT NULL,
  `peso_m` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

