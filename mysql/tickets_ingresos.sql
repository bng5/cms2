
DROP TABLE IF EXISTS `tickets_ingresos`;
CREATE TABLE  `tickets_ingresos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `ticket_id` int(10) unsigned NOT NULL,
  `usuario_id` int(10) unsigned NOT NULL,
  `texto` mediumtext NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

