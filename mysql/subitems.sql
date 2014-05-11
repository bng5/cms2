
DROP TABLE IF EXISTS `subitems`;
CREATE TABLE  `subitems` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `item_id` int(10) unsigned NOT NULL,
  `atributo_id` int(10) unsigned NOT NULL,
  `estado_id` tinyint(3) unsigned NOT NULL default '0',
  `codigo` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

