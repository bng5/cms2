
DROP TABLE IF EXISTS `galerias_atributos`;
CREATE TABLE  `galerias_atributos` (
  `id` tinyint(4) unsigned NOT NULL auto_increment,
  `identificador` varchar(12) character set ascii NOT NULL,
  `orden` tinyint(4) unsigned NOT NULL default '0',
  `sugerido` tinyint(1) NOT NULL default '0',
  `unico` tinyint(1) NOT NULL default '0',
  `tipo` enum('string','date','text','int') character set ascii NOT NULL default 'string',
  `subtipo` tinyint(1) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

