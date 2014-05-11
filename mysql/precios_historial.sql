
DROP TABLE IF EXISTS `precios_historial`;
CREATE TABLE  `precios_historial` (
  `item_id` int(10) unsigned NOT NULL,
  `fecha` datetime NOT NULL,
  `atributo_id` int(10) unsigned NOT NULL,
  `precio` float(15,2) NOT NULL,
  `moneda_id` tinyint(3) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

