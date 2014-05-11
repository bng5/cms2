
DROP TABLE IF EXISTS `items_a_categorias`;
CREATE TABLE  `items_a_categorias` (
  `categoria_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `orden` int(10) unsigned default NULL,
  PRIMARY KEY  (`categoria_id`,`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

