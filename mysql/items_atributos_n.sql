
DROP TABLE IF EXISTS `items_atributos_n`;
CREATE TABLE  `items_atributos_n` (
  `id` int(10) unsigned NOT NULL,
  `leng_id` tinyint(3) unsigned NOT NULL,
  `atributo` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`,`leng_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

