
DROP TABLE IF EXISTS `carrito_pedidos_items`;
CREATE TABLE  `carrito_pedidos_items` (
  `id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `cantidad` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

