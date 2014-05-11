
DROP TABLE IF EXISTS `categorias_valores`;
CREATE TABLE  `categorias_valores` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `atributo_id` tinyint(3) unsigned NOT NULL,
  `categoria_id` int(10) unsigned default NULL,
  `leng_id` tinyint(3) unsigned default NULL,
  `string` varchar(50) default NULL,
  `date` datetime default NULL,
  `text` text,
  `int` int(10) unsigned default NULL,
  `num` decimal(10,2) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `atributo` (`atributo_id`,`categoria_id`,`leng_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

