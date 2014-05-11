
DROP TABLE IF EXISTS `carrito_pedidos`;
CREATE TABLE  `carrito_pedidos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `usuario_id` int(10) unsigned NOT NULL,
  `fecha` datetime NOT NULL,
  `estado_id` tinyint(3) unsigned NOT NULL default '0',
  `fecha_estado` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

