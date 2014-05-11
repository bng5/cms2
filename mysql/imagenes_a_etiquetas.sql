
DROP TABLE IF EXISTS `imagenes_a_etiquetas`;
CREATE TABLE  `imagenes_a_etiquetas` (
  `imagen_id` int(10) unsigned NOT NULL,
  `etiqueta_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`imagen_id`,`etiqueta_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;

