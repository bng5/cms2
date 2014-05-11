
DROP TABLE IF EXISTS `tickets`;
CREATE TABLE  `tickets` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `estado_id` tinyint(3) unsigned NOT NULL default '0',
  `publico` tinyint(1) NOT NULL default '0',
  `categoria_id` tinyint(4) NOT NULL,
  `severidad_id` tinyint(3) unsigned default NULL,
  `resumen` varchar(150) NOT NULL,
  `arch_adjunto` varchar(32) default NULL,
  `usuario_id` int(10) unsigned NOT NULL,
  `abierto` datetime NOT NULL,
  `actualizado` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

